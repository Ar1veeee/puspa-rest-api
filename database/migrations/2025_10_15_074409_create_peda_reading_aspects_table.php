<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peda_reading_aspects', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('recognize_letters_score');
            $table->text('recognize_letters_desc')->nullable();
            $table->tinyInteger('recognize_letter_symbols_score');
            $table->text('recognize_letter_symbols_desc')->nullable();
            $table->tinyInteger('say_alphabet_in_order_score');
            $table->text('say_alphabet_in_order_desc')->nullable();
            $table->tinyInteger('pronounce_letters_correctly_score');
            $table->text('pronounce_letters_correctly_desc')->nullable();
            $table->tinyInteger('read_vowels_score');
            $table->text('read_vowels_desc')->nullable();
            $table->tinyInteger('read_consonants_score');
            $table->text('read_consonants_desc')->nullable();
            $table->tinyInteger('read_given_words_score');
            $table->text('read_given_words_desc')->nullable();
            $table->tinyInteger('read_sentences_score');
            $table->text('read_sentences_desc')->nullable();
            $table->tinyInteger('read_quickly_score');
            $table->text('read_quickly_desc')->nullable();
            $table->tinyInteger('read_for_comprehension_score');
            $table->text('read_for_comprehension_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peda_reading_aspects');
    }
};
