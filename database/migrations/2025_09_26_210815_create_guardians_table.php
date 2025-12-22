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
        Schema::create('guardians', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->char('family_id', 26);
            $table->char('user_id', 26)->nullable();
            $table->string('temp_email', 100)->unique()->nullable();
            $table->enum('guardian_type', ['ayah', 'ibu', 'wali']);
            $table->string('guardian_identity_number', 40)->unique()->nullable();
            $table->string('guardian_name', 100);
            $table->binary('guardian_phone', 100);
            $table->date('guardian_birth_date')->nullable();
            $table->string('guardian_occupation', 100)->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('relationship_with_child', 100)->nullable();
            $table->timestamps();

            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('family_id');
            $table->index(['user_id']);
            $table->index(['temp_email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
