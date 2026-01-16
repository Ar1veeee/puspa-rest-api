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
            $table->id();
            $table->unsignedBigInteger('observation_id');
            $table->char('child_id', 26);
            $table->enum('status', ['pending', 'scheduled', 'completed'])->default('pending');
            $table->dateTime('scheduled_date')->nullable();
            $table->enum('parent_status', ['pending', 'completed'])->default('pending');
            $table->char('report_file', 255)->nullable();
            $table->dateTime('report_uploaded_at')->nullable();
            $table->timestamps();

            $table->foreign('observation_id')->references('id')->on('observations')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

            $table->index('child_id');
            $table->index(['child_id', 'created_at'], 'idx_assessments_child_created');
            $table->index(['status', 'scheduled_date']);
            $table->index('scheduled_date');
            $table->index(['parent_status']);
            $table->index('created_at');
            $table->index('observation_id');
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
