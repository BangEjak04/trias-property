<?php

namespace App\Models;

use App\Enums\AkadStatus;
use App\Enums\ApprovalStatus;
use App\Enums\PaymentMethod;
use App\Enums\PriorityType;
use App\Enums\StatusType;
use Database\Factories\ApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable(
    // Identitas
    'applicant_name',
    'applicant_email',
    'applicant_phone',

    // Status
    'status',
    'priority',

    // Properti
    'developer',
    'property_name',
    'property_type',
    'property_block',
    'property_number',
    'building_area',
    'land_area',
    'price',
    'price_range_from',
    'price_range_to',

    // Kedit & Dokumen
    'payment_method',
    'down_payment_amount',
    'loan_amount',
    'down_payment_date',
    'down_payment_proof',
    'id_card',

    // Persetujuan
    'approval_status',
    'credit_approval',
    'approval_date',
    'bank_name',
    'document_progress',

    // Akad
    'akad_scheduled_at',
    'akad_location',
    'akad_status',

    // Internal
    'notes',
    'marketing_agent',
)]
class Application extends Model
{
    /** @use HasFactory<ApplicationFactory> */
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::created(function (Application $application) {
            $application->statusLogs()->create([
                'from_status' => null,
                'to_status' => $application->status->value ?? 'prospect',
                'reason' => 'Permohonan baru dibuat',
                'changed_by' => auth()->id() ?? 1,
            ]);
        });

        static::updating(function (Application $application) {
            if ($application->isDirty('status')) {
                $application->statusLogs()->create([
                    'from_status' => $application->getOriginal('status') instanceof StatusType
                        ? $application->getOriginal('status')->value
                        : $application->getOriginal('status'),
                    'to_status' => $application->status->value,
                    'reason' => request('reason') ?? request('status_change_reason') ?? null,
                    'changed_by' => auth()->id() ?? 1,
                ]);
            }
        });
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(ApplicationStatusLog::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ApplicationComment::class);
    }

    #[Override]
    protected function casts()
    {
        return [
            // Enums
            'status' => StatusType::class,
            'priority' => PriorityType::class,
            'approval_status' => ApprovalStatus::class,
            'payment_method' => PaymentMethod::class,
            'akad_status' => AkadStatus::class,

            // Date
            'down_payment_date' => 'date',
            'approval_date' => 'date',
            'akad_scheduled_at' => 'datetime',

            // Number
            'price' => 'integer',
            'price_range_from' => 'integer',
            'price_range_to' => 'integer',
            'down_payment_amount' => 'integer',
            'loan_amount' => 'integer',
            'credit_approval' => 'integer',
            'building_area' => 'integer',
            'land_area' => 'integer',
        ];
    }
}
