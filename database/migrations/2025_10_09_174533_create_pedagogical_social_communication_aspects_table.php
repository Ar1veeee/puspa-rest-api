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
        Schema::create('pedagogical_social_communication_aspects', function (Blueprint $table) {
            $table->id();
            $table->text('child_attitude_when_meeting_new_people')->nullable();
            $table->text('child_attitude_when_meeting_friends')->nullable();
            $table->text('child_often_or_never_initiate_conversations')->nullable();
            $table->text('active_when_speak_to_family')->nullable();
            $table->text('attitude_in_uncomfortable_situations')->nullable();
            $table->text('can_share_toys_food_when_playing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_social_communication_aspects');
    }
};
