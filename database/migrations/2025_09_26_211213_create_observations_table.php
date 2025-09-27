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
            $table->foreignUlid('child_id')->constrained('children')->cascadeOnDelete();
            $table->foreignUlid('therapist_id')->nullable()->constrained('therapists')->nullOnDelete();
            $table->date('scheduled_date');
            $table->enum('age_category', ['Balita', 'Anak-anak', 'Remaja', 'Lainya']);
            $table->integer('total_score')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('recommendation')->nullable();
            $table->enum('status', ['Pending', 'Scheduled', 'Completed'])->default('Pending');
            $table->timestamps();
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
