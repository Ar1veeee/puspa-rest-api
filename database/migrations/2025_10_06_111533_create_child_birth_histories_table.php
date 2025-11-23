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
        Schema::create('child_birth_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->enum('birth_type', ['normal', 'operasi caesar', 'vakum']);
            $table->enum('if_normal', ['kepala dulu', 'kaki dulu', 'pantat dulu'])->nullable();
            $table->text('caesar_vacuum_reason')->nullable();
            $table->boolean('crying_immediately');
            $table->enum('birth_condition', ['biru', 'kuning', 'kejang'])->nullable();
            $table->integer('birth_condition_duration')->nullable();
            $table->boolean('incubator_used');
            $table->integer('incubator_duration')->nullable();
            $table->decimal('birth_weight', 4, 2)->nullable();
            $table->integer('birth_length')->nullable();
            $table->decimal('head_circumference', 5, 2)->nullable();
            $table->text('birth_complications_other')->nullable();
            $table->boolean('postpartum_depression');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_birth_histories');
    }
};
