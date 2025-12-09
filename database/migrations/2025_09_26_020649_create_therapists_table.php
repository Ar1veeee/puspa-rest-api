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
        Schema::create('therapists', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->char('user_id', 26)->nullable(false);
            $table->string('therapist_name', 100)->nullable(false);
            $table->enum('therapist_section', ['okupasi', 'fisio', 'wicara', 'paedagog'])->nullable(false);
            $table->string('therapist_phone', 500)->nullable(false);
            $table->date('therapist_birth_date');
            $table->string('profile_picture')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');
            $table->index('user_id', 'user_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapists');
    }
};
