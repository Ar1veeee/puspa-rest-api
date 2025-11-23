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
        Schema::create('child_post_birth_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->enum('postbirth_condition', ['biru', 'kuning', 'kejang'])->nullable();
            $table->integer('postbirth_condition_duration')->nullable();
            $table->integer('postbirth_condition_age')->nullable();
            $table->boolean('has_ever_fallen');
            $table->string('injured_body_part', 100)->nullable();
            $table->integer('age_at_fall')->nullable();
            $table->text('other_postbirth_complications')->nullable();
            $table->integer('head_lift_age')->nullable();
            $table->integer('prone_age')->nullable();
            $table->integer('roll_over_age')->nullable();
            $table->integer('sitting_age')->nullable();
            $table->integer('crawling_age')->nullable();
            $table->integer('climbing_age')->nullable();
            $table->integer('standing_age')->nullable();
            $table->integer('walking_age')->nullable();
            $table->boolean('complete_immunization');
            $table->text('uncompleted_immunization_detail')->nullable();
            $table->boolean('exclusive_breastfeeding');
            $table->integer('exclusive_breastfeeding_until_age')->nullable();
            $table->integer('rice_intake_age')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_post_birth_histories');
    }
};
