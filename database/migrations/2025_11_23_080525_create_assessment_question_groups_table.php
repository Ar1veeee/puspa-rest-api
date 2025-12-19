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
        Schema::create('assessment_question_groups', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_type', 255);
            $table->string('group_title', 255);
            $table->string('group_key', 255);
            $table->enum('filled_by', ['parent', 'assessor'])->default('assessor');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('assessment_type');
            $table->index('group_key');
            $table->index('sort_order');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_question_groups');
    }
};
