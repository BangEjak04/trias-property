<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Application;
use App\Models\ApplicationComment;
use App\Models\ApplicationStatusLog;
use App\Enums\StatusType;
use App\Enums\PriorityType;
use App\Enums\ApprovalStatus;
use App\Enums\PaymentMethod;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MigrateLegacyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy-data {--fresh : Kosongkan data baru sebelum migrasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengimpor dan memigrasikan database KPR lama dari phpmyadmin SQL dump ke skema baru';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sqlPath = base_path('.dev/u740754933_triashomebase.sql');

        if (!file_exists($sqlPath)) {
            $this->error("File SQL tidak ditemukan di: {$sqlPath}");
            return Command::FAILURE;
        }

        $this->info("Membaca file SQL dari: {$sqlPath}");
        $sql = file_get_contents($sqlPath);

        // Daftar tabel yang ada di dalam dump SQL untuk diprefix dengan legacy_
        $tables = [
            'applications',
            'application_comments',
            'users',
            'sessions',
            'roles',
            'permissions',
            'model_has_roles',
            'model_has_permissions',
            'role_has_permissions',
            'password_reset_tokens',
            'migrations',
            'job_batches',
            'jobs',
            'failed_jobs',
            'cache_locks',
            'cache'
        ];

        $this->info("Menyiapkan tabel legacy di database...");

        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop legacy tables jika sebelumnya sudah ada (agar bersih)
        foreach ($tables as $table) {
            Schema::dropIfExists("legacy_{$table}");
        }

        // Modifikasi isi SQL untuk mengubah nama tabel menjadi legacy_* secara aman menggunakan regex callback
        $modifiedSql = preg_replace_callback('/`([a-zA-Z0-9_]+)`/', function ($matches) use ($tables) {
            $name = $matches[1];
            
            // Cek jika nama tabel cocok secara persis
            if (in_array($name, $tables)) {
                return "`legacy_$name`";
            }
            
            // Cek jika nama identifier diawali dengan nama tabel diikuti underscore (seperti index/constraint)
            foreach ($tables as $table) {
                if (str_starts_with($name, "{$table}_")) {
                    return "`legacy_$name`";
                }
            }
            
            return "`$name`";
        }, $sql);

        // Jalankan SQL dump untuk membuat tabel legacy_* dan mengimpor datanya
        try {
            $this->info("Mengimpor data mentah ke tabel legacy_*...");
            DB::unprepared($modifiedSql);
            $this->info("Impor data mentah sukses.");
        } catch (\Exception $e) {
            $this->error("Gagal mengimpor SQL dump: " . $e->getMessage());
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Command::FAILURE;
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Pengecekan apakah tabel legacy_users dan legacy_applications terbuat
        if (!Schema::hasTable('legacy_users') || !Schema::hasTable('legacy_applications')) {
            $this->error("Tabel legacy_* gagal diinisialisasi secara lengkap.");
            return Command::FAILURE;
        }

        // Opsi --fresh: kosongkan tabel data baru agar tidak bentrok ID
        if ($this->option('fresh') || $this->confirm('Apakah Anda ingin mengosongkan data permohonan, komentar, dan log baru terlebih dahulu sebelum melakukan impor?', true)) {
            $this->info("Mengosongkan tabel-tabel baru...");
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Application::truncate();
            ApplicationComment::truncate();
            ApplicationStatusLog::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->warn("Tabel target telah dikosongkan.");
        }

        // Mulai transaksi database untuk proses migrasi data bersih
        DB::beginTransaction();

        try {
            $this->info("Memulai migrasi data ke skema baru...");

            // 1. Migrasi Pengguna (Users)
            $legacyUsers = DB::table('legacy_users')->get();
            $userMapping = []; // map [legacy_id => new_uuid]
            
            $this->info("Memproses " . $legacyUsers->count() . " pengguna...");
            foreach ($legacyUsers as $lUser) {
                // Periksa apakah user dengan email / username yang sama sudah ada di sistem baru
                $existingUser = User::where('email', $lUser->email)
                    ->orWhere('username', $lUser->username)
                    ->first();

                if ($existingUser) {
                    $userMapping[$lUser->id] = $existingUser->id;
                    $this->line("User '{$lUser->name}' sudah terdaftar, memetakan ke ID baru.");
                } else {
                    $newUuid = Str::uuid()->toString();
                    
                    // Gunakan insert DB secara langsung agar password hash tidak di-hash ulang oleh cast model
                    DB::table('users')->insert([
                        'id' => $newUuid,
                        'name' => $lUser->name,
                        'username' => $lUser->username,
                        'email' => $lUser->email,
                        'password' => $lUser->password,
                        'email_verified_at' => $lUser->email_verified_at,
                        'created_at' => $lUser->created_at ?: now(),
                        'updated_at' => $lUser->updated_at ?: now(),
                    ]);

                    $userModel = User::find($newUuid);
                    if ($userModel) {
                        // Hubungkan dengan role super_admin (sesuai role lama)
                        $userModel->assignRole(Utils::createRole());
                    }

                    $userMapping[$lUser->id] = $newUuid;
                    $this->line("User '{$lUser->name}' berhasil dimigrasikan.");
                }
            }

            // Dapatkan default admin ID sebagai fallback pengubah status
            $defaultAdminId = $userMapping[1] ?? User::first()?->id;
            if (!$defaultAdminId) {
                throw new \Exception("Gagal menentukan user admin default untuk log status.");
            }

            // 2. Migrasi Permohonan (Applications)
            $legacyApps = DB::table('legacy_applications')->get();
            $this->info("Memproses " . $legacyApps->count() . " permohonan KPR...");

            $priorityMap = [
                'low' => PriorityType::LOW,
                'mid' => PriorityType::MEDIUM,
                'medium' => PriorityType::MEDIUM,
                'high' => PriorityType::HIGH,
            ];

            $approvalMap = [
                'accepted' => ApprovalStatus::ACCEPTED,
                'rejected' => ApprovalStatus::REJECTED,
                'pending' => ApprovalStatus::PENDING,
            ];

            $paymentMethodMap = [
                'cash' => PaymentMethod::CASH,
                'home_credit' => PaymentMethod::HOME_CREDIT,
                'inhouse' => PaymentMethod::INHOUSE,
            ];

            foreach ($legacyApps as $legacyApp) {
                // Konversi enum
                $status = StatusType::tryFrom($legacyApp->status) ?? StatusType::PROSPECT;
                $priority = isset($priorityMap[$legacyApp->priority]) ? $priorityMap[$legacyApp->priority] : null;
                $approvalStatus = isset($approvalMap[$legacyApp->approval]) ? $approvalMap[$legacyApp->approval] : null;
                $paymentMethod = isset($paymentMethodMap[$legacyApp->payment_method]) ? $paymentMethodMap[$legacyApp->payment_method] : null;

                $createdAt = $legacyApp->created_at ?: now();
                $updatedAt = $legacyApp->updated_at ?: now();

                // Insert via DB Query Builder langsung untuk melewati proteksi mass-assignment dan model event listeners
                DB::table('applications')->insert([
                    'id' => $legacyApp->id, // Pertahankan ID asli untuk relasi komentar
                    'applicant_name' => $legacyApp->name,
                    'applicant_email' => $legacyApp->email,
                    'applicant_phone' => $legacyApp->phone,
                    'status' => $status->value,
                    'priority' => $priority?->value,
                    'developer' => $legacyApp->developer,
                    'property_name' => $legacyApp->property,
                    'property_type' => $legacyApp->type,
                    'property_block' => $legacyApp->block,
                    'property_number' => $legacyApp->number,
                    'building_area' => $legacyApp->building_area,
                    'land_area' => $legacyApp->land_area,
                    'price' => $legacyApp->price,
                    'price_range_from' => $legacyApp->price_range_from,
                    'price_range_to' => $legacyApp->price_range_to,
                    'payment_method' => $paymentMethod?->value,
                    'down_payment_date' => $legacyApp->down_payment_date,
                    'down_payment_proof' => $legacyApp->payment_proof,
                    'id_card' => $legacyApp->id_card,
                    'approval_status' => $approvalStatus?->value,
                    'credit_approval' => $legacyApp->credit_approval,
                    'approval_date' => $legacyApp->approval_date,
                    'bank_name' => $legacyApp->bank_name,
                    'document_progress' => $legacyApp->document_progress,
                    'marketing_agent' => $legacyApp->marketing_agent,
                    'notes' => $legacyApp->notes,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);

                // Buat log status awal historis secara manual
                DB::table('application_status_logs')->insert([
                    'application_id' => $legacyApp->id,
                    'from_status' => null,
                    'to_status' => $status->value,
                    'reason' => 'Migrasi data awal dari database lama',
                    'changed_by' => $defaultAdminId,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);
            }

            // 3. Migrasi Komentar (Application Comments)
            if (Schema::hasTable('legacy_application_comments')) {
                $legacyComments = DB::table('legacy_application_comments')->get();
                $this->info("Memproses " . $legacyComments->count() . " komentar internal...");

                foreach ($legacyComments as $comment) {
                    // Hubungkan user_id ke UUID baru
                    $newUserId = $userMapping[$comment->user_id] ?? $defaultAdminId;

                    DB::table('application_comments')->insert([
                        'application_id' => $comment->application_id,
                        'user_id' => $newUserId,
                        'body' => $comment->content,
                        'created_at' => $comment->created_at ?: now(),
                        'updated_at' => $comment->updated_at ?: now(),
                    ]);
                }
            }

            DB::commit();

            // Reset auto-increment counter pada table applications agar aman untuk input data baru mendatang
            // Dijalankan di luar transaksi karena DDL di MySQL memicu implicit commit
            $maxId = DB::table('applications')->max('id');
            if ($maxId) {
                $nextAutoIncrement = $maxId + 1;
                DB::statement("ALTER TABLE applications AUTO_INCREMENT = {$nextAutoIncrement}");
            }

            $this->info("Semua data berhasil dimigrasikan dengan sukses!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Gagal melakukan migrasi data: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        } finally {
            // Bersihkan tabel legacy_* agar database tetap rapi
            $this->info("Membersihkan tabel-tabel legacy_*...");
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            foreach ($tables as $table) {
                Schema::dropIfExists("legacy_{$table}");
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info("Pembersihan selesai.");
        }

        return Command::SUCCESS;
    }
}
