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
            $table->unsignedBigInteger('assessment_id');
            $table->enum('type', ['umum', 'fisio', 'okupasi', 'wicara', 'paedagog']);
            $table->char('admin_id', 26)->nullable();
            $table->char('therapist_id', 26)->nullable();
            $table->enum('status', ['pending', 'scheduled', 'completed'])->default('pending');
            $table->dateTime('scheduled_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('parent_completed_status', ['pending', 'completed'])->default('pending');
            $table->timestamp('parent_completed_at')->nullable();
            $table->timestamps();

            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('therapist_id')->references('id')->on('therapists')->onDelete('set null');

            $table->index('assessment_id');
            $table->index(['status', 'scheduled_date']);
            $table->index('scheduled_date');
            $table->index(['parent_completed_status', 'scheduled_date']);
            $table->index(['type', 'status']);
            $table->index('created_at');
            $table->index('completed_at');
            $table->index('therapist_id');
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
