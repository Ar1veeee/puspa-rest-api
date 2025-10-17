<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occu_bodily_self_senses', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('temperament_alertness_score');
            $table->text('temperament_alertness_desc')->nullable();
            $table->tinyInteger('temperament_cooperative_score');
            $table->text('temperament_cooperative_desc')->nullable();
            $table->tinyInteger('temperament_shyness_score');
            $table->text('temperament_shyness_desc')->nullable();
            $table->tinyInteger('temperament_easily_offended_score');
            $table->text('temperament_easily_offended_desc')->nullable();
            $table->tinyInteger('temperament_happiness_score');
            $table->text('temperament_happiness_desc')->nullable();
            $table->tinyInteger('temperament_physically_fit_score');
            $table->text('temperament_physically_fit_desc')->nullable();
            $table->tinyInteger('behavior_active_score');
            $table->text('behavior_active_desc')->nullable();
            $table->tinyInteger('behavior_aggressive_score');
            $table->text('behavior_aggressive_desc')->nullable();
            $table->tinyInteger('behavior_tantrum_score');
            $table->text('behavior_tantrum_desc')->nullable();
            $table->tinyInteger('behavior_self_aware_score');
            $table->text('behavior_self_aware_desc')->nullable();
            $table->tinyInteger('behavior_impulsive_score');
            $table->text('behavior_impulsive_desc')->nullable();
            $table->tinyInteger('identity_nickname_score');
            $table->text('identity_nickname_desc')->nullable();
            $table->tinyInteger('identity_full_name_score');
            $table->text('identity_full_name_desc')->nullable();
            $table->tinyInteger('identity_age_score');
            $table->text('identity_age_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occu_bodily_self_senses');
    }
};
