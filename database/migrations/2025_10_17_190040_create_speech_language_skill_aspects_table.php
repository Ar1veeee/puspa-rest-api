<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('speech_language_skill_aspects', function (Blueprint $table) {
            $table->id();
            $table->enum('age_category', [
                '6-7 Tahun', '5-6 Tahun', '4-5 Tahun', '3-4 Tahun', '2-3 Tahun',
                '19-24 Bulan', '13-18 Bulan', '7-12 Bulan', '0-6 Bulan'
            ]);
            $table->json('answers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speech_language_skill_aspects');
    }
};
