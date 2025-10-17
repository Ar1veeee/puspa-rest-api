<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peda_general_knowledge_aspects', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('knows_identity_score');
            $table->text('knows_identity_desc')->nullable();
            $table->tinyInteger('show_body_parts_score');
            $table->text('show_body_parts_desc')->nullable();
            $table->tinyInteger('understand_taste_differences_score');
            $table->text('understand_taste_differences_desc')->nullable();
            $table->tinyInteger('identify_colors_score');
            $table->text('identify_colors_desc')->nullable();
            $table->tinyInteger('understand_sizes_score');
            $table->text('understand_sizes_desc')->nullable();
            $table->tinyInteger('understand_orientation_score');
            $table->text('understand_orientation_desc')->nullable();
            $table->tinyInteger('express_emotions_score');
            $table->text('express_emotions_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peda_general_knowledge_aspects');
    }
};
