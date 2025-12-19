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
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->char('child_id', 26);
            $table->char('admin_id', 26)->nullable();
            $table->char('therapist_id', 26)->nullable();
            $table->dateTime('scheduled_date')->nullable();
            $table->enum('age_category', ['balita', 'anak-anak', 'remaja', 'lainya']);
            $table->integer('total_score')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('recommendation')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'completed'])->default('pending');
            $table->time('completed_at')->nullable();
            $table->boolean('is_continued_to_assessment')->default(false);
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('therapist_id')->references('id')->on('therapists')->onDelete('set null');

            $table->index(['child_id', 'status']);
            $table->index(['status', 'scheduled_date']);
            $table->index('scheduled_date');
            $table->index('created_at');
            $table->index('therapist_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
