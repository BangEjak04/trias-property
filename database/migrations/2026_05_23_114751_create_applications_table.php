<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // ── Identitas Nasabah ──────────────────────────────────
            $table->string('applicant_name');
            $table->string('applicant_email')->nullable();
            $table->string('applicant_phone', 20)->nullable();

            // ── Status ─────────────────────────────────────────────
            $table->string('status', 20)->nullable();
            $table->string('priority', 20)->nullable();

            // ── Informasi Properti ─────────────────────────────────
            $table->string('developer')->nullable();
            $table->string('property_name')->nullable();
            $table->string('property_type')->nullable();
            $table->string('property_block')->nullable();
            $table->string('property_number')->nullable();
            $table->unsignedInteger('building_area')->nullable();
            $table->unsignedInteger('land_area')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('price_range_from')->nullable();
            $table->unsignedBigInteger('price_range_to')->nullable();

            // ── Informasi Kredit ───────────────────────────────────
            $table->string('payment_method', 20)->nullable();
            $table->string('bank_name')->nullable();
            $table->date('down_payment_date')->nullable();

            // ── Persetujuan ────────────────────────────────────────
            $table->string('approval_status')->nullable();
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('credit_approval')->nullable();
            $table->unsignedBigInteger('loan_amount')->nullable();
            $table->unsignedBigInteger('down_payment_amount')->nullable();

            // ── Dokumen ────────────────────────────────────────────
            $table->string('document_progress')->nullable();
            $table->string('id_card')->nullable();
            $table->string('down_payment_proof')->nullable();

            // ── Akad Kredit ────────────────────────────────────────
            $table->dateTime('akad_scheduled_at')->nullable();
            $table->string('akad_location')->nullable();
            $table->string('akad_status')->nullable();

            // ── Internal ───────────────────────────────────────────
            $table->string('marketing_agent')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
