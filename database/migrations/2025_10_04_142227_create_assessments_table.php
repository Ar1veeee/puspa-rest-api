<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('observation_id')->constrained('observations')->cascadeOnDelete();
            $table->foreignUlid('child_id')->constrained('children')->cascadeOnDelete();
            $table->string('report_file')->nullable();
            $table->datetime('report_uploaded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
