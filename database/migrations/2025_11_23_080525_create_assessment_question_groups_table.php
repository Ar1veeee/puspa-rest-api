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
            $table->string('assessment_type')->index();
            $table->string('group_title');
            $table->string('group_key')->index();
            $table->enum('filled_by', ['parent', 'assessor'])->default('assessor');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
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
