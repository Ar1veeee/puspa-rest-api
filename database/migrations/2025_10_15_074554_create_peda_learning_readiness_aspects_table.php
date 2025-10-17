<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peda_learning_readiness_aspects', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('follow_instructions_score');
            $table->text('follow_instructions_desc')->nullable();
            $table->tinyInteger('sit_calmly_score');
            $table->text('sit_calmly_desc')->nullable();
            $table->tinyInteger('not_hyperactive_score');
            $table->text('not_hyperactive_desc')->nullable();
            $table->tinyInteger('show_initiative_score');
            $table->text('show_initiative_desc')->nullable();
            $table->tinyInteger('is_cooperative_score');
            $table->text('is_cooperative_desc')->nullable();
            $table->tinyInteger('show_enthusiasm_score');
            $table->text('show_enthusiasm_desc')->nullable();
            $table->tinyInteger('complete_tasks_score');
            $table->text('complete_tasks_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peda_learning_readiness_aspects');
    }
};
