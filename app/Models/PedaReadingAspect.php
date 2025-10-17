<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedaReadingAspect extends Model
{
    use HasFactory;

    protected $table = 'peda_reading_aspects';
    public $timestamps = false;

    protected $fillable = [
        'recognize_letters_score',
        'recognize_letters_desc',
        'recognize_letter_symbols_score',
        'recognize_letter_symbols_desc',
        'say_alphabet_in_order_score',
        'say_alphabet_in_order_desc',
        'pronounce_letters_correctly_score',
        'pronounce_letters_correctly_desc',
        'read_vowels_score',
        'read_vowels_desc',
        'read_consonants_score',
        'read_consonants_desc',
        'read_given_words_score',
        'read_given_words_desc',
        'read_sentences_score',
        'read_sentences_desc',
        'read_quickly_score',
        'read_quickly_desc',
        'read_for_comprehension_score',
        'read_for_comprehension_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(PedaAssessmentTherapist::class, 'reading_aspect_id');
    }
}
