<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('physio_general_examinations', function (Blueprint $table) {
            $table->id();
            $table->text('arrival_method')->nullable();
            $table->text('consciousness')->nullable();
            $table->string('cooperation')->nullable();
            $table->string('blood_pressure', 20)->nullable();
            $table->string('pulse', 20)->nullable();
            $table->string('respiratory_rate', 20)->nullable();
            $table->text('nutritional_status')->nullable();
            $table->string('temperature', 20)->nullable();
            $table->decimal('head_circumference', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physio_general_examinations');
    }
};

