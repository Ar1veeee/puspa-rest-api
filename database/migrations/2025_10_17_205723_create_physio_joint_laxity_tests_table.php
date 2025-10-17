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
        Schema::create('physio_joint_laxity_tests', function (Blueprint $table) {
            $table->id();
            $table->text('elbow')->nullable();
            $table->text('wrist')->nullable();
            $table->text('hip')->nullable();
            $table->text('knee')->nullable();
            $table->text('ankle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_joint_laxity_tests');
    }
};
