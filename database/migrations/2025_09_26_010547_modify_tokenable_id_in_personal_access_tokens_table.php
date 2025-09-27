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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Ubah tipe kolom tokenable_id menjadi string
            $table->string('tokenable_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Kembalikan ke unsignedBigInteger untuk rollback
            $table->unsignedBigInteger('tokenable_id')->change();
        });
    }
};
