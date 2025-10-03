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
        Schema::create('users', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->string('username', 100)->nullable(false)->unique('users_username_unique');
            $table->string('email', 100)->nullable(false)->unique('users_email_unique');
            $table->string('password', 100)->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['owner', 'admin', 'terapis', 'user'])->nullable(false)->default('user');
            $table->boolean('is_active')->nullable(false)->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->index(['username', 'email'], 'username_email_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
