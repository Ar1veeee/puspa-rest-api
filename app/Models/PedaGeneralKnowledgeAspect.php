<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedaGeneralKnowledgeAspect extends Model
{
    use HasFactory;

    protected $table = 'peda_general_knowledge_aspects';
    public $timestamps = false;

    protected $fillable = [
        'knows_identity_score',
        'knows_identity_desc',
        'show_body_parts_score',
        'show_body_parts_desc',
        'understand_taste_differences_score',
        'understand_taste_differences_desc',
        'identify_colors_score',
        'identify_colors_desc',
        'understand_sizes_score',
        'understand_sizes_desc',
        'understand_orientation_score',
        'understand_orientation_desc',
        'express_emotions_score',
        'express_emotions_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(PedaAssessmentTherapist::class, 'general_knowledge_aspect_id');
    }
}
