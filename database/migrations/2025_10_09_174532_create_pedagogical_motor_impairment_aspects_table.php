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
        Schema::create('pedagogical_motor_impairment_aspects', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_motor_impairment');
            $table->enum('motor_impairment_type', ['Motorik Halus', 'Motorik Kasar'])->nullable();
            $table->text('motor_impairment_form')->nullable();
            $table->boolean('has_independent_mobility_difficulty');
            $table->boolean('has_body_part_weakness');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_motor_impairment_aspects');
    }
};
