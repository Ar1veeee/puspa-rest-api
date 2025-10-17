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
        Schema::create('physio_physiotherapy_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->text('impairment_1')->nullable();
            $table->text('impairment_2')->nullable();
            $table->text('impairment_3')->nullable();
            $table->text('impairment_4')->nullable();
            $table->text('impairment_5')->nullable();
            $table->text('functional_limitation_1')->nullable();
            $table->text('functional_limitation_2')->nullable();
            $table->text('functional_limitation_3')->nullable();
            $table->text('functional_limitation_4')->nullable();
            $table->text('functional_limitation_5')->nullable();
            $table->text('participant_restriction_1')->nullable();
            $table->text('participant_restriction_2')->nullable();
            $table->text('participant_restriction_3')->nullable();
            $table->text('participant_restriction_4')->nullable();
            $table->text('participant_restriction_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_physiotherapy_diagnoses');
    }
};
