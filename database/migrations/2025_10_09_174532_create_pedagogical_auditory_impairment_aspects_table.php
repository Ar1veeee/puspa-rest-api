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
        Schema::create('pedagogical_auditory_impairment_aspects', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_auditory_impairment');
            $table->boolean('using_hearing_aid');
            $table->boolean('immediate_response_when_called');
            $table->boolean('prefers_listening_music_or_singing');
            $table->boolean('prefers_quiet_environment_when_studying');
            $table->boolean('responding_to_dislike_by_covering_ears');
            $table->boolean('often_uses_headset');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_auditory_impairment_aspects');
    }
};
