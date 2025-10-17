<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccuMotoricPlanning extends Model
{
    use HasFactory;

    protected $table = 'occu_motoric_plannings';
    public $timestamps = false;

    protected $fillable = [
        'bilateral_skill_stringing_beads_score',
        'bilateral_skill_stringing_beads_desc',
        'bilateral_skill_flipping_pages_score',
        'bilateral_skill_flipping_pages_desc',
        'bilateral_skill_sewing_score',
        'bilateral_skill_sewing_desc',
        'cutting_no_line_score',
        'cutting_no_line_desc',
        'cutting_straight_line_score',
        'cutting_straight_line_desc',
        'cutting_zigzag_line_score',
        'cutting_zigzag_line_desc',
        'cutting_wave_line_score',
        'cutting_wave_line_desc',
        'cutting_box_shape_score',
        'cutting_box_shape_desc',
        'memory_recall_objects_score',
        'memory_recall_objects_desc',
        'memory_singing_score',
        'memory_singing_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(OccuAssessmentTherapist::class, 'motoric_planning_id');
    }
}
