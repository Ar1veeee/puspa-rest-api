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
            $table->integer('guardian_age')->nullable();
            $table->string('guardian_occupation', 100)->nullable();
            $table->string('relationship_with_child', 100)->nullable();
            $table->timestamps();
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
