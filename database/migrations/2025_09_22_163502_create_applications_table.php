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

            $table->string('status');
            $table->string('priority')->nullable();
            $table->string('approval')->nullable();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('developer')->nullable();
            $table->string('location')->nullable();
            $table->double('price_range_from')->nullable();
            $table->double('price_range_to')->nullable();
            $table->text('notes')->nullable();

            $table->string('property')->nullable();
            $table->string('type')->nullable();
            $table->string('block')->nullable();
            $table->string('number')->nullable();
            $table->integer('land_area')->nullable();
            $table->integer('building_area')->nullable();
            $table->double('price')->nullable();
            $table->double('credit_approval')->nullable();
            $table->date('down_payment_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('id_card')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('marketing_agent')->nullable();
            $table->string('document_progress')->nullable();

            $table->timestamps();
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
