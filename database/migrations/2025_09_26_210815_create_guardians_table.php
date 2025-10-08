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
            $table->foreignUlid('family_id')->constrained('families')->cascadeOnDelete();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('temp_email', 100)->nullable()->unique();
            $table->enum('guardian_type', ['ayah', 'ibu', 'wali']);
            $table->string('guardian_name', 100);
            $table->string('guardian_phone', 500);
            $table->date('guardian_birth_date')->nullable();
            $table->string('guardian_occupation', 100)->nullable();
            $table->string('relationship_with_child', 100)->nullable();
            $table->timestamps();

            $table->index(['family_id'], 'family_id_idx');
            $table->index(['user_id'], 'user_id_idx');
            $table->index(['temp_email'], 'temp_email_idx');
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
