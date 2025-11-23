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
        Schema::create('assessment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')
                ->constrained('assessments')
                ->cascadeOnDelete();
            $table->enum('type', [
                'fisio',
                'okupasi',
                'wicara',
                'paedagog'
            ]);
            $table->foreignUlid('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();
            $table->foreignUlid('therapist_id')
                ->nullable()
                ->constrained('therapists')
                ->nullOnDelete();
            $table->enum('status', [
                'pending',
                'scheduled',
                'completed'
            ])->default('pending');
            $table->dateTime('scheduled_date')->nullable();
            $table->time('completed_at')->nullable();
            $table->enum('parent_status', [
                'completed',
                'not_completed'
            ])->default('not_completed');
            $table->time('parent_completed_at')->nullable();
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
