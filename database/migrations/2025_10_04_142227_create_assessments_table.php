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
            $table->foreignUlid('child_id')->constrained('children')->cascadeOnDelete();
            $table->foreignUlid('therapist_id')->constrained('therapists')->nullOnDelete()();
            $table->boolean('fisio')->nullable()->default(false);
            $table->boolean('wicara')->nullable()->default(false);
            $table->boolean('paedagog')->nullable()->default(false);
            $table->boolean('okupasi')->nullable()->default(false);
            $table->date('scheduled_date')->nullable()->default(null);
            $table->enum('status', ['pending', 'scheduled', 'completed'])->default('pending');
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
