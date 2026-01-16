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
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('parent_completed_at')->nullable();
            $table->timestamps();

            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('therapist_id')->references('id')->on('therapists')->onDelete('set null');

            $table->index('assessment_id');
            $table->index(['type', 'completed_at']);
            $table->unique(['assessment_id', 'type'], 'unique_assessment_detail_type');
            $table->index(['assessment_id', 'completed_at'], 'idx_details_status_check');
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
