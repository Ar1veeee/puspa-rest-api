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
        Schema::create('child_psychosocial_histories', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->integer('child_order');
            $table->json('siblings')->nullable();
            $table->text('household_members');
            $table->enum('parent_marriage_status', ['menikah', 'cerai', 'lainya']);
            $table->string('daily_language', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_psychosocial_histories');
    }
};
