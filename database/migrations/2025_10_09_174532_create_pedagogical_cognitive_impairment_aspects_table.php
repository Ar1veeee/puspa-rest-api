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
        Schema::create('pedagogical_cognitive_impairment_aspects', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_cognitive_impairment');
            $table->boolean('needs_explanation_managing_information');
            $table->boolean('responsive_to_sudden_events');
            $table->string('preferred_activities', 100);
            $table->boolean('interested_in_learning_new_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_cognitive_impairment_aspects');
    }
};
