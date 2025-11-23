<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssessmentTherapistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'asesor';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $type = $this->input('type');

        $baseRules = [
            'type' => ['required', 'string', 'in:fisio,wicara,okupasi,paedagog'],
        ];

        $typeSpecificRules = match ($type) {
            'fisio' => $this->getPhysioRules(),
            'okupasi' => $this->getOccupationalRules(),
            'wicara' => $this->getSpeechRules(),
            'paedagog' => $this->getPedagogicalRules(),
            default => [],
        };

        return array_merge($baseRules, $typeSpecificRules);
    }

    private function getPhysioRules(): array
    {
        // Options
        $sensoryOptions = ['Normal', 'Hipo', 'Hiper'];
        $muscleStrengthOptions = ['X', 'O', 'T', 'R'];
        $spasticityScoreOptions = [0, 1, 2, 3];
        $postureOptions = ['Good Posture', 'Poor Posture'];

        // Generate reflex fields
        $reflexFields = [];
        $reflexes = [
            'moro', 'blinking', 'galant', 'atnr', 'stnr', 'sucking', 'rooting',
            'palmar_grasps', 'plantar_grasps', 'flexor_withdrawal', 'babinsky',
            'righting', 'automatic_gait_reflex', 'parachute', 'landau', 'protective_reflex'
        ];

        foreach ($reflexes as $reflex) {
            $reflexFields["{$reflex}_result"] = ['nullable', 'string', 'max:500'];
            $reflexFields["{$reflex}_primitive"] = ['nullable', 'boolean'];
            $reflexFields["{$reflex}_functional"] = ['nullable', 'boolean'];
            $reflexFields["{$reflex}_pathological"] = ['nullable', 'boolean'];
            $reflexFields["{$reflex}_integration"] = ['nullable', 'boolean'];
            $reflexFields["{$reflex}_not_synchronous"] = ['nullable', 'boolean'];
        }

        return array_merge(
        // 1. physio_general_examinations
            [
                'arrival_method' => ['nullable', 'string', 'max:500'],
                'consciousness' => ['nullable', 'string', 'max:500'],
                'cooperation' => ['nullable', 'string', 'max:500'],
                'blood_pressure' => ['nullable', 'string', 'max:20'],
                'pulse' => ['nullable', 'string', 'max:20'],
                'respiratory_rate' => ['nullable', 'string', 'max:20'],
                'nutritional_status' => ['nullable', 'string', 'max:500'],
                'temperature' => ['nullable', 'string', 'max:20'],
                'head_circumference' => ['nullable', 'numeric', 'between:0,100'],
            ],

            // 2. physio_system_anamnesis
            [
                'head_and_neck' => ['nullable', 'string'],
                'cardiovascular' => ['nullable', 'string'],
                'respiratory' => ['nullable', 'string'],
                'gastrointestinal' => ['nullable', 'string'],
                'urogenital' => ['nullable', 'string'],
                'musculoskeletal' => ['nullable', 'string'],
                'nervous_system' => ['nullable', 'string'],
                'sensory' => ['nullable', 'string'],
                'motoric' => ['nullable', 'string'],
            ],

            // 3. physio_sensory_examinations
            [
                'visual' => ['required', 'string', Rule::in($sensoryOptions)],
                'auditory' => ['required', 'string', Rule::in($sensoryOptions)],
                'olfactory' => ['required', 'string', Rule::in($sensoryOptions)],
                'gustatory' => ['required', 'string', Rule::in($sensoryOptions)],
                'tactile' => ['required', 'string', Rule::in($sensoryOptions)],
                'proprioceptive' => ['required', 'string', Rule::in($sensoryOptions)],
                'vestibular' => ['required', 'string', Rule::in($sensoryOptions)],
            ],

            // 4. physio_reflex_examinations
            $reflexFields,

            // 5. physio_muscle_strength_examinations
            [
                'str_trunk_score' => ['required', 'string', Rule::in($muscleStrengthOptions)],
                'str_aga_dex_score' => ['required', 'string', Rule::in($muscleStrengthOptions)],
                'str_aga_sin_score' => ['required', 'string', Rule::in($muscleStrengthOptions)],
                'str_agb_dex_score' => ['required', 'string', Rule::in($muscleStrengthOptions)],
                'str_agb_sin_score' => ['required', 'string', Rule::in($muscleStrengthOptions)],
            ],

            // 6. physio_spasticity_examinations
            [
                'spas_head_neck_score' => ['required', 'integer', Rule::in($spasticityScoreOptions)],
                'spas_trunk_score' => ['required', 'integer', Rule::in($spasticityScoreOptions)],
                'spas_aga_dex_score' => ['required', 'integer', Rule::in($spasticityScoreOptions)],
                'spas_aga_sin_score' => ['required', 'integer', Rule::in($spasticityScoreOptions)],
                'spas_agb_dex_score' => ['required', 'integer', Rule::in($spasticityScoreOptions)],
                'spas_agb_sin_score' => ['required', 'integer', Rule::in($spasticityScoreOptions)],
            ],

            // 7. physio_joint_laxity_tests
            [
                'elbow' => ['nullable', 'string', 'max:500'],
                'wrist' => ['nullable', 'string', 'max:500'],
                'hip' => ['nullable', 'string', 'max:500'],
                'knee' => ['nullable', 'string', 'max:500'],
                'ankle' => ['nullable', 'string', 'max:500'],
            ],

            // 8. physio_gross_motor_examinations
            [
                // Supine
                'supine_head' => ['nullable', 'string', 'max:500'],
                'supine_shoulder' => ['nullable', 'string', 'max:500'],
                'supine_elbow' => ['nullable', 'string', 'max:500'],
                'supine_wrist' => ['nullable', 'string', 'max:500'],
                'supine_finger' => ['nullable', 'string', 'max:500'],
                'supine_trunk' => ['nullable', 'string', 'max:500'],
                'supine_hip' => ['nullable', 'string', 'max:500'],
                'supine_knee' => ['nullable', 'string', 'max:500'],
                'supine_ankle' => ['nullable', 'string', 'max:500'],

                // Rolling
                'rolling_handling' => ['nullable', 'string', 'max:500'],
                'rolling_rolling_via' => ['nullable', 'string', 'max:500'],
                'rolling_trunk_rotation' => ['nullable', 'string', 'max:500'],

                // Prone
                'prone_head_lifting' => ['nullable', 'string', 'max:500'],
                'prone_head_control' => ['nullable', 'string', 'max:500'],
                'prone_forearm_support' => ['nullable', 'string', 'max:500'],
                'prone_hand_support' => ['nullable', 'string', 'max:500'],
                'prone_hip' => ['nullable', 'string', 'max:500'],
                'prone_knee' => ['nullable', 'string', 'max:500'],
                'prone_ankle' => ['nullable', 'string', 'max:500'],

                // Sitting
                'sitting_head_lifting' => ['nullable', 'string', 'max:500'],
                'sitting_head_control' => ['nullable', 'string', 'max:500'],
                'sitting_head_support' => ['nullable', 'string', 'max:500'],
                'sitting_trunk_control' => ['nullable', 'string', 'max:500'],
                'sitting_balance' => ['nullable', 'string', 'max:500'],
                'sitting_protective_reaction' => ['nullable', 'string', 'max:500'],
                'sitting_position' => ['nullable', 'string', 'max:500'],
                'sitting_weight_bearing' => ['nullable', 'string', 'max:500'],

                // Standing
                'standing_head_lifting' => ['nullable', 'string', 'max:500'],
                'standing_head_control' => ['nullable', 'string', 'max:500'],
                'standing_trunk_control' => ['nullable', 'string', 'max:500'],
                'standing_hip' => ['nullable', 'string', 'max:500'],
                'standing_knee' => ['nullable', 'string', 'max:500'],
                'standing_ankle' => ['nullable', 'string', 'max:500'],
                'standing_support' => ['nullable', 'string', 'max:500'],
                'standing_posture' => ['nullable', 'string', Rule::in($postureOptions)],
                'standing_posture_note' => ['nullable', 'string', 'max:200'],

                // Walking
                'walking_gait_pattern' => ['nullable', 'string', 'max:500'],
                'walking_balance' => ['nullable', 'string', 'max:500'],
                'walking_knee_type' => ['nullable', 'string', 'max:500'],
            ],

            // 9. physio_muscle_palpations
            [
                'hypertonus_aga_d' => ['nullable', 'string', 'max:500'],
                'hypertonus_aga_s' => ['nullable', 'string', 'max:500'],
                'hypertonus_agb_d' => ['nullable', 'string', 'max:500'],
                'hypertonus_agb_s' => ['nullable', 'string', 'max:500'],
                'hypertonus_perut' => ['nullable', 'string', 'max:500'],

                'hypotonus_aga_d' => ['nullable', 'string', 'max:500'],
                'hypotonus_aga_s' => ['nullable', 'string', 'max:500'],
                'hypotonus_agb_d' => ['nullable', 'string', 'max:500'],
                'hypotonus_agb_s' => ['nullable', 'string', 'max:500'],
                'hypotonus_perut' => ['nullable', 'string', 'max:500'],

                'flyktuatif_aga_d' => ['nullable', 'string', 'max:500'],
                'flyktuatif_aga_s' => ['nullable', 'string', 'max:500'],
                'flyktuatif_agb_d' => ['nullable', 'string', 'max:500'],
                'flyktuatif_agb_s' => ['nullable', 'string', 'max:500'],
                'flyktuatif_perut' => ['nullable', 'string', 'max:500'],

                'normal_aga_d' => ['nullable', 'string', 'max:500'],
                'normal_aga_s' => ['nullable', 'string', 'max:500'],
                'normal_agb_d' => ['nullable', 'string', 'max:500'],
                'normal_agb_s' => ['nullable', 'string', 'max:500'],
                'normal_perut' => ['nullable', 'string', 'max:500'],
            ],

            // 10. physio_spasticity_types
            [
                'hemiplegia' => ['nullable', 'string', 'max:500'],
                'diplegia' => ['nullable', 'string', 'max:500'],
                'quadriplegia' => ['nullable', 'string', 'max:500'],
                'monoplegia' => ['nullable', 'string', 'max:500'],
                'triplegia' => ['nullable', 'string', 'max:500'],
            ],

            // 11. physio_play_function_tests
            [
                'play_type' => ['nullable', 'string', 'max:500'],
                'follow_object' => ['nullable', 'string', 'max:500'],
                'follow_sound' => ['nullable', 'string', 'max:500'],
                'reach_object' => ['nullable', 'string', 'max:500'],
                'grasping' => ['nullable', 'string', 'max:500'],
                'differentiate_color' => ['nullable', 'string', 'max:500'],
                'focus_attention' => ['nullable', 'string', 'max:500'],
            ],

            // 12. physio_physiotherapy_diagnoses
            [
                'impairments' => ['nullable', 'array'],
                'impairments.*' => ['string', 'max:1000'],

                'functional_limitations' => ['nullable', 'array'],
                'functional_limitations.*' => ['string', 'max:1000'],

                'participant_restrictions' => ['nullable', 'array'],
                'participant_restrictions.*' => ['string', 'max:1000'],
            ]
        );
    }

    private function getOccupationalRules(): array
    {
        $scoreRules = ['required', 'integer', 'between:0,3'];
        $descRules = ['nullable', 'string'];

        return [
            // Section I: Sense of Bodily Self
            'temperament_alertness_score' => $scoreRules,
            'temperament_alertness_desc' => $descRules,
            'temperament_cooperative_score' => $scoreRules,
            'temperament_cooperative_desc' => $descRules,
            'temperament_shyness_score' => $scoreRules,
            'temperament_shyness_desc' => $descRules,
            'temperament_easily_offended_score' => $scoreRules,
            'temperament_easily_offended_desc' => $descRules,
            'temperament_happiness_score' => $scoreRules,
            'temperament_happiness_desc' => $descRules,
            'temperament_physically_fit_score' => $scoreRules,
            'temperament_physically_fit_desc' => $descRules,
            'behavior_active_score' => $scoreRules,
            'behavior_active_desc' => $descRules,
            'behavior_aggressive_score' => $scoreRules,
            'behavior_aggressive_desc' => $descRules,
            'behavior_tantrum_score' => $scoreRules,
            'behavior_tantrum_desc' => $descRules,
            'behavior_self_aware_score' => $scoreRules,
            'behavior_self_aware_desc' => $descRules,
            'behavior_impulsive_score' => $scoreRules,
            'behavior_impulsive_desc' => $descRules,
            'identity_nickname_score' => $scoreRules,
            'identity_nickname_desc' => $descRules,
            'identity_full_name_score' => $scoreRules,
            'identity_full_name_desc' => $descRules,
            'identity_age_score' => $scoreRules,
            'identity_age_desc' => $descRules,

            // Section A: Balance & Coordination
            'left_right_use_shoes_score' => $scoreRules,
            'left_right_use_shoes_desc' => $descRules,
            'left_right_identify_score' => $scoreRules,
            'left_right_identify_desc' => $descRules,
            'spatial_position_up_down_score' => $scoreRules,
            'spatial_position_up_down_desc' => $descRules,
            'spatial_position_out_in_score' => $scoreRules,
            'spatial_position_out_in_desc' => $descRules,
            'spatial_position_front_back_score' => $scoreRules,
            'spatial_position_front_back_desc' => $descRules,
            'spatial_position_middle_edge_score' => $scoreRules,
            'spatial_position_middle_edge_desc' => $descRules,
            'gross_motor_walk_forward_score' => $scoreRules,
            'gross_motor_walk_forward_desc' => $descRules,
            'gross_motor_walk_backward_score' => $scoreRules,
            'gross_motor_walk_backward_desc' => $descRules,
            'gross_motor_walk_sideways_score' => $scoreRules,
            'gross_motor_walk_sideways_desc' => $descRules,
            'gross_motor_tiptoe_score' => $scoreRules,
            'gross_motor_tiptoe_desc' => $descRules,
            'gross_motor_running_score' => $scoreRules,
            'gross_motor_running_desc' => $descRules,
            'gross_motor_stand_one_foot_score' => $scoreRules,
            'gross_motor_stand_one_foot_desc' => $descRules,
            'gross_motor_jump_one_foot_score' => $scoreRules,
            'gross_motor_jump_one_foot_desc' => $descRules,

            // Section B: Concentration & Problem Solving
            'concentration_2_commands_score' => $scoreRules,
            'concentration_2_commands_desc' => $descRules,
            'concentration_3_commands_score' => $scoreRules,
            'concentration_3_commands_desc' => $descRules,
            'concentration_4_commands_score' => $scoreRules,
            'concentration_4_commands_desc' => $descRules,
            'concentration_find_in_picture_score' => $scoreRules,
            'concentration_find_in_picture_desc' => $descRules,
            'problem_solving_puzzle_score' => $scoreRules,
            'problem_solving_puzzle_desc' => $descRules,
            'problem_solving_story_score' => $scoreRules,
            'problem_solving_story_desc' => $descRules,
            'size_comprehension_big_small_score' => $scoreRules,
            'size_comprehension_big_small_desc' => $descRules,
            'size_comprehension_tall_short_score' => $scoreRules,
            'size_comprehension_tall_short_desc' => $descRules,
            'size_comprehension_many_few_score' => $scoreRules,
            'size_comprehension_many_few_desc' => $descRules,
            'size_comprehension_long_short_score' => $scoreRules,
            'size_comprehension_long_short_desc' => $descRules,
            'number_recognition_count_forward_score' => $scoreRules,
            'number_recognition_count_forward_desc' => $descRules,
            'number_recognition_count_backward_score' => $scoreRules,
            'number_recognition_count_backward_desc' => $descRules,
            'number_recognition_symbol_score' => $scoreRules,
            'number_recognition_symbol_desc' => $descRules,
            'number_recognition_concept_score' => $scoreRules,
            'number_recognition_concept_desc' => $descRules,

            // Section C: Concept Knowledge
            'letter_recognition_pointing_score' => $scoreRules,
            'letter_recognition_pointing_desc' => $descRules,
            'letter_recognition_reading_score' => $scoreRules,
            'letter_recognition_reading_desc' => $descRules,
            'letter_recognition_writing_score' => $scoreRules,
            'letter_recognition_writing_desc' => $descRules,
            'letter_recognition_write_on_board_score' => $scoreRules,
            'letter_recognition_write_on_board_desc' => $descRules,
            'letter_recognition_write_in_order_score' => $scoreRules,
            'letter_recognition_write_in_order_desc' => $descRules,
            'color_comprehension_pointing_score' => $scoreRules,
            'color_comprehension_pointing_desc' => $descRules,
            'color_comprehension_differentiating_score' => $scoreRules,
            'color_comprehension_differentiating_desc' => $descRules,
            'body_awareness_mentioning_score' => $scoreRules,
            'body_awareness_mentioning_desc' => $descRules,
            'body_awareness_pointing_score' => $scoreRules,
            'body_awareness_pointing_desc' => $descRules,
            'time_orientation_day_night_score' => $scoreRules,
            'time_orientation_day_night_desc' => $descRules,
            'time_orientation_days_score' => $scoreRules,
            'time_orientation_days_desc' => $descRules,
            'time_orientation_date_month_year_score' => $scoreRules,
            'time_orientation_date_month_year_desc' => $descRules,

            // Section D: Motoric Planning
            'bilateral_skill_stringing_beads_score' => $scoreRules,
            'bilateral_skill_stringing_beads_desc' => $descRules,
            'bilateral_skill_flipping_pages_score' => $scoreRules,
            'bilateral_skill_flipping_pages_desc' => $descRules,
            'bilateral_skill_sewing_score' => $scoreRules,
            'bilateral_skill_sewing_desc' => $descRules,
            'cutting_no_line_score' => $scoreRules,
            'cutting_no_line_desc' => $descRules,
            'cutting_straight_line_score' => $scoreRules,
            'cutting_straight_line_desc' => $descRules,
            'cutting_zigzag_line_score' => $scoreRules,
            'cutting_zigzag_line_desc' => $descRules,
            'cutting_wave_line_score' => $scoreRules,
            'cutting_wave_line_desc' => $descRules,
            'cutting_box_shape_score' => $scoreRules,
            'cutting_box_shape_desc' => $descRules,
            'memory_recall_objects_score' => $scoreRules,
            'memory_recall_objects_desc' => $descRules,
            'memory_singing_score' => $scoreRules,
            'memory_singing_desc' => $descRules,

            // Final Summary Fields
            'note' => ['nullable', 'string'],
            'assessment_result' => ['nullable', 'string'],
            'therapy_recommendation' => ['nullable', 'string'],
        ];
    }

    private function getSpeechRules(): array
    {
        $normalKurang = ['normal', 'kurang'];
        $normalLemah = ['normal', 'lemah'];
        $normalAbnormal = ['normal', 'abnormal'];
        $simetrisMiring = ['normal', 'miring ke kanan', 'miring ke kiri'];
        $normalLambat = ['normal', 'lambat'];
        $adaTidakAda = ['ada', 'tidak ada'];
        $yaTidak = ['ya', 'tidak'];
        $noneAbnormal = ['none', 'menyeringai', 'kedutan'];

        return [
            // === BAGIAN ASPEK KEMAMPUAN BAHASA ===
            'age_category' => ['required', Rule::in([
                '6-7 Tahun', '5-6 Tahun', '4-5 Tahun', '3-4 Tahun', '2-3 Tahun',
                '19-24 Bulan', '13-18 Bulan', '7-12 Bulan', '0-6 Bulan'
            ])],
            'answers' => ['required', 'array'],
            'answers.*.skill' => ['required', 'string'],
            'answers.*.checked' => ['required', 'boolean'],

            // === ASPEK ORAL FASIAL ===

            // === WAJAH ===
            'face_symmetry' => ['nullable', Rule::in(['normal', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])],
            'face_symmetry_note' => ['nullable', 'string'],
            'face_abnormal_movement' => ['nullable', Rule::in($noneAbnormal)],
            'face_abnormal_movement_note' => ['nullable', 'string'],
            'face_muscle_flexation' => ['nullable', Rule::in($yaTidak)],
            'face_muscle_flexation_note' => ['nullable', 'string'],

            // === RAHANG & TMJ ===
            'jaw_range_of_motion' => ['required', Rule::in($normalKurang)],
            'jaw_range_of_motion_note' => ['nullable', 'string'],
            'jaw_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'jaw_symmetry_note' => ['nullable', 'string'],
            'jaw_movement' => ['nullable', Rule::in(['normal', 'tersentak-sentak', 'groping', 'lambat', 'tidak simetris'])],
            'jaw_movement_note' => ['nullable', 'string'],
            'jaw_tmj_noises' => ['nullable', Rule::in(['absent', 'kresek gigi', 'bermunculan'])],
            'jaw_tmj_noises_note' => ['nullable', 'string'],

            // === GIGI & OKLUSI ===
            'dental_occlusion' => ['nullable', Rule::in([
                'normal',
                'neutrocclusion (Class I)',
                'distrocclusion (Class II)',
                'mesiocclusion (Class III)'
            ])],
            'dental_occlusion_note' => ['nullable', 'string'],

            'dental_occlusion_taring' => ['nullable', Rule::in(['normal', 'overbite', 'underbite', 'crossbite'])],
            'dental_occlusion_taring_note' => ['nullable', 'string'],

            'dental_teeth' => ['nullable', Rule::in(['semua ada', 'gigi palsu', 'gigi yang hilang (spesifik)'])],
            'dental_teeth_note' => ['nullable', 'string'],

            'dental_arrangement' => ['nullable', Rule::in(['normal', 'bertumpuk', 'beruang', 'tidak beraturan'])],
            'dental_arrangement_note' => ['nullable', 'string'],

            'dental_cleanliness' => ['nullable', Rule::in(['bersih', 'kurang bersih', 'kotor'])],
            'dental_cleanliness_note' => ['nullable', 'string'],

            // === BIBIR - MEMONYONGKAN ===
            'lip_pouting_range_of_motion' => ['required', Rule::in($normalKurang)],
            'lip_pouting_range_of_motion_note' => ['nullable', 'string'],
            'lip_pouting_symmetry' => ['nullable', Rule::in(['normal', 'turun pada kedua sisi', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])],
            'lip_pouting_symmetry_note' => ['nullable', 'string'],
            'lip_pouting_tongue_strength' => ['nullable', Rule::in($normalLemah)],
            'lip_pouting_tongue_strength_note' => ['nullable', 'string'],
            'lip_pouting_other_note' => ['nullable', 'string'],

            // === BIBIR - TERSENYUM ===
            'lip_smilling_range_of_motion' => ['required', Rule::in($normalKurang)],
            'lip_smilling_range_of_motion_note' => ['nullable', 'string'],
            'lip_smilling_symmetry' => ['nullable', Rule::in(['normal', 'turun pada kedua sisi', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])],
            'lip_smilling_symmetry_note' => ['nullable', 'string'],
            'lip_smilling_other_note' => ['nullable', 'string'],

            // === LIDAH - WARNA & GERAKAN UMUM ===
            'tongue_color' => ['required', Rule::in($normalAbnormal)],
            'tongue_color_note' => ['nullable', 'string'],
            'tongue_abnormal_movement' => ['nullable', Rule::in(['tidak ada', 'tersentak-sentak', 'kekuan', 'menggeliat', 'fasikulasi'])],
            'tongue_abnormal_movement_note' => ['nullable', 'string'],
            'tongue_size' => ['nullable', Rule::in(['normal', 'kecil', 'besar'])],
            'tongue_size_note' => ['nullable', 'string'],
            'tongue_frenulum' => ['nullable', Rule::in(['normal', 'pendek'])],
            'tongue_frenulum_note' => ['nullable', 'string'],
            'tongue_other_note' => ['nullable', 'string'],

            // === LIDAH - KELUARKAN LIDAH (Protrusion) ===
            'tongue_out_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'tongue_out_symmetry_note' => ['nullable', 'string'],
            'tongue_out_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_out_range_of_motion_note' => ['nullable', 'string'],
            'tongue_out_speed' => ['nullable', Rule::in($normalLambat)],
            'tongue_out_speed_note' => ['nullable', 'string'],
            'tongue_out_strength' => ['nullable', Rule::in($normalLemah)],
            'tongue_out_strength_note' => ['nullable', 'string'],
            'tongue_out_other_note' => ['nullable', 'string'],

            // === LIDAH - MENARIK LIDAH KE DALAM ===
            'tongue_pull_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'tongue_pull_symmetry_note' => ['nullable', 'string'],
            'tongue_pull_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_pull_range_of_motion_note' => ['nullable', 'string'],
            'tongue_pull_speed' => ['nullable', Rule::in($normalLambat)],
            'tongue_pull_speed_note' => ['nullable', 'string'],
            'tongue_pull_other_note' => ['nullable', 'string'],

            // === LIDAH - KE KANAN ===
            'tongue_to_right_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_to_right_range_of_motion_note' => ['nullable', 'string'],
            'tongue_to_right_strength' => ['nullable', Rule::in($normalLemah)],
            'tongue_to_right_strength_note' => ['nullable', 'string'],
            'tongue_to_right_other_note' => ['nullable', 'string'],

            // === LIDAH - KE KIRI ===
            'tongue_to_left_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_to_left_range_of_motion_note' => ['nullable', 'string'],
            'tongue_to_left_strength' => ['nullable', Rule::in($normalLemah)],
            'tongue_to_left_strength_note' => ['nullable', 'string'],
            'tongue_to_left_other_note' => ['nullable', 'string'],

            // === LIDAH - KE BAWAH ===
            'tongue_to_bottom_movement' => ['nullable', Rule::in($normalLambat)],
            'tongue_to_bottom_movement_note' => ['nullable', 'string'],
            'tongue_to_bottom_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_to_bottom_range_of_motion_note' => ['nullable', 'string'],
            'tongue_to_bottom_other_note' => ['nullable', 'string'],

            // === LIDAH - KE ATAS ===
            'tongue_to_upper_movement' => ['nullable', Rule::in($normalLambat)],
            'tongue_to_upper_movement_note' => ['nullable', 'string'],
            'tongue_to_upper_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_to_upper_range_of_motion_note' => ['nullable', 'string'],
            'tongue_to_upper_other_note' => ['nullable', 'string'],

            // === LIDAH - KANAN KIRI BERGANTIAN ===
            'tongue_to_left_right_movement' => ['nullable', Rule::in(['normal', 'lemah', 'menurun bertahap'])],
            'tongue_to_left_right_movement_note' => ['nullable', 'string'],
            'tongue_to_left_right_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_to_left_right_range_of_motion_note' => ['nullable', 'string'],
            'tongue_to_left_right_other_note' => ['nullable', 'string'],

            // === FARING ===
            'pharynx_color' => ['nullable', Rule::in($normalAbnormal)],
            'pharynx_color_note' => ['nullable', 'string'],
            'pharynx_tonsil' => ['nullable', Rule::in(['tidak ada', 'normal', 'membesar'])],
            'pharynx_tonsil_note' => ['nullable', 'string'],
            'pharynx_other_note' => ['nullable', 'string'],

            // === LANGIT-LANGIT KERAS & LUNAK ===
            'palate_color' => ['nullable', Rule::in($normalAbnormal)],
            'palate_color_note' => ['nullable', 'string'],

            'palate_rugae' => ['nullable', Rule::in($adaTidakAda)],
            'palate_rugae_note' => ['nullable', 'string'],

            'palate_hard_height' => ['nullable', Rule::in(['normal', 'tinggi', 'rendah'])],
            'palate_hard_height_note' => ['nullable', 'string'],

            'palate_hard_width' => ['nullable', Rule::in(['normal', 'sempit', 'lebar'])],
            'palate_hard_width_note' => ['nullable', 'string'],

            'palate_growths' => ['nullable', Rule::in($adaTidakAda)],
            'palate_growths_note' => ['nullable', 'string'],

            'palate_fistula' => ['nullable', Rule::in($adaTidakAda)],
            'palate_fistula_note' => ['nullable', 'string'],

            'palate_soft_symmetry_at_rest' => ['nullable', Rule::in(['normal', 'kanan lebih rendah', 'kiri lebih rendah'])],
            'palate_soft_symmetry_at_rest_note' => ['nullable', 'string'],

            'palate_gag_reflex' => ['nullable', Rule::in(['normal', 'tidak ada', 'hipersensitif', 'hiposensitif'])],
            'palate_gag_reflex_note' => ['nullable', 'string'],
            'palate_other_note' => ['nullable', 'string'],

            // === FONASI / GERAKAN LANGIT-LANGIT ===
            'palate_phonation_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'palate_phonation_symmetry_note' => ['nullable', 'string'],

            'palate_posterior_movement' => ['nullable', Rule::in($adaTidakAda)],
            'palate_posterior_movement_note' => ['nullable', 'string'],

            'palate_uvula_position' => ['nullable', Rule::in(['normal', 'bifid', 'miring ke kanan', 'miring ke kiri'])],
            'palate_uvula_position_note' => ['nullable', 'string'],

            'palate_nasal_leak' => ['nullable', Rule::in(['tidak ada', 'hipernasal'])],
            'palate_nasal_leak_note' => ['nullable', 'string'],

            'palate_phonation_other_note' => ['nullable', 'string'],
        ];
    }

    private function getPedagogicalRules(): array
    {
        $scoreRules = ['required', 'integer', 'between:0,3'];
        $descRules = ['nullable', 'string'];

        return [
            // Aspek Membaca (peda_reading_aspects)
            'recognize_letters_score' => $scoreRules,
            'recognize_letters_desc' => $descRules,
            'recognize_letter_symbols_score' => $scoreRules,
            'recognize_letter_symbols_desc' => $descRules,
            'say_alphabet_in_order_score' => $scoreRules,
            'say_alphabet_in_order_desc' => $descRules,
            'pronounce_letters_correctly_score' => $scoreRules,
            'pronounce_letters_correctly_desc' => $descRules,
            'read_vowels_score' => $scoreRules,
            'read_vowels_desc' => $descRules,
            'read_consonants_score' => $scoreRules,
            'read_consonants_desc' => $descRules,
            'read_given_words_score' => $scoreRules,
            'read_given_words_desc' => $descRules,
            'read_sentences_score' => $scoreRules,
            'read_sentences_desc' => $descRules,
            'read_quickly_score' => $scoreRules,
            'read_quickly_desc' => $descRules,
            'read_for_comprehension_score' => $scoreRules,
            'read_for_comprehension_desc' => $descRules,

            // Aspek Menulis (peda_writing_aspects)
            'hold_writing_tool_score' => $scoreRules,
            'hold_writing_tool_desc' => $descRules,
            'write_straight_down_score' => $scoreRules,
            'write_straight_down_desc' => $descRules,
            'write_straight_side_score' => $scoreRules,
            'write_straight_side_desc' => $descRules,
            'write_curved_line_score' => $scoreRules,
            'write_curved_line_desc' => $descRules,
            'write_letters_straight_score' => $scoreRules,
            'write_letters_straight_desc' => $descRules,
            'copy_letters_score' => $scoreRules,
            'copy_letters_desc' => $descRules,
            'write_own_name_score' => $scoreRules,
            'write_own_name_desc' => $descRules,
            'recognize_and_write_words_score' => $scoreRules,
            'recognize_and_write_words_desc' => $descRules,
            'write_upper_lower_case_score' => $scoreRules,
            'write_upper_lower_case_desc' => $descRules,
            'differentiate_similar_letters_score' => $scoreRules,
            'differentiate_similar_letters_desc' => $descRules,
            'write_simple_sentences_score' => $scoreRules,
            'write_simple_sentences_desc' => $descRules,
            'write_story_from_picture_score' => $scoreRules,
            'write_story_from_picture_desc' => $descRules,

            // Aspek Berhitung (peda_counting_aspects)
            'recognize_numbers_1_10_score' => $scoreRules,
            'recognize_numbers_1_10_desc' => $descRules,
            'count_concrete_objects_score' => $scoreRules,
            'count_concrete_objects_desc' => $descRules,
            'compare_quantities_score' => $scoreRules,
            'compare_quantities_desc' => $descRules,
            'recognize_math_symbols_score' => $scoreRules,
            'recognize_math_symbols_desc' => $descRules,
            'operate_addition_subtraction_score' => $scoreRules,
            'operate_addition_subtraction_desc' => $descRules,
            'operate_multiplication_division_score' => $scoreRules,
            'operate_multiplication_division_desc' => $descRules,
            'use_counting_tools_score' => $scoreRules,
            'use_counting_tools_desc' => $descRules,

            // Aspek Kesiapan Belajar (peda_learning_readiness_aspects)
            'follow_instructions_score' => $scoreRules,
            'follow_instructions_desc' => $descRules,
            'sit_calmly_score' => $scoreRules,
            'sit_calmly_desc' => $descRules,
            'not_hyperactive_score' => $scoreRules,
            'not_hyperactive_desc' => $descRules,
            'show_initiative_score' => $scoreRules,
            'show_initiative_desc' => $descRules,
            'is_cooperative_score' => $scoreRules,
            'is_cooperative_desc' => $descRules,
            'show_enthusiasm_score' => $scoreRules,
            'show_enthusiasm_desc' => $descRules,
            'complete_tasks_score' => $scoreRules,
            'complete_tasks_desc' => $descRules,

            // Aspek Pengetahuan Umum (peda_general_knowledge_aspects)
            'knows_identity_score' => $scoreRules,
            'knows_identity_desc' => $descRules,
            'show_body_parts_score' => $scoreRules,
            'show_body_parts_desc' => $descRules,
            'understand_taste_differences_score' => $scoreRules,
            'understand_taste_differences_desc' => $descRules,
            'identify_colors_score' => $scoreRules,
            'identify_colors_desc' => $descRules,
            'understand_sizes_score' => $scoreRules,
            'understand_sizes_desc' => $descRules,
            'understand_orientation_score' => $scoreRules,
            'understand_orientation_desc' => $descRules,
            'express_emotions_score' => $scoreRules,
            'express_emotions_desc' => $descRules,

            'summary' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // Physio
            'required' => 'Field :attribute wajib diisi.',
            'string' => 'Field :attribute harus berupa teks.',
            'integer' => 'Field :attribute harus berupa angka.',
            'numeric' => 'Field :attribute harus berupa angka.',
            'in' => 'Nilai yang dipilih untuk :attribute tidak valid.',
            'between' => 'Field :attribute harus bernilai antara :min dan :max.',
            'max' => 'Field :attribute maksimal :max karakter.',
            'array' => 'Field :attribute harus berupa array.',

            'visual.required' => 'Pemeriksaan visual wajib diisi.',
            'auditory.required' => 'Pemeriksaan auditory wajib diisi.',
            'olfactory.required' => 'Pemeriksaan olfactory wajib diisi.',
            'gustatory.required' => 'Pemeriksaan gustatory wajib diisi.',
            'tactile.required' => 'Pemeriksaan tactile wajib diisi.',
            'proprioceptive.required' => 'Pemeriksaan proprioceptive wajib diisi.',
            'vestibular.required' => 'Pemeriksaan vestibular wajib diisi.',

            'muscle_strength_trunk_score.required' => 'Skor kekuatan otot trunk wajib diisi.',
            'aga_dex_score.required' => 'Skor AGA dextra wajib diisi.',
            'aga_sin_score.required' => 'Skor AGA sinistra wajib diisi.',
            'agb_dex_score.required' => 'Skor AGB dextra wajib diisi.',
            'agb_sin_score.required' => 'Skor AGB sinistra wajib diisi.',

            'spasticity_head_neck_score.required' => 'Skor spastisitas kepala-leher wajib diisi.',
            'spasticity_trunk_score.required' => 'Skor spastisitas trunk wajib diisi.',
            'spasticity_aga_dex_score.required' => 'Skor spastisitas AGA dextra wajib diisi.',
            'spasticity_aga_sin_score.required' => 'Skor spastisitas AGA sinistra wajib diisi.',
            'spasticity_agb_dex_score.required' => 'Skor spastisitas AGB dextra wajib diisi.',
            'spasticity_agb_sin_score.required' => 'Skor spastisitas AGB sinistra wajib diisi.',

            // Speech
            'answers.*.skill.required' => 'Setiap item kemampuan bahasa harus memiliki teks skill.',
            'answers.*.checked.required' => 'Setiap item kemampuan bahasa harus memiliki status (dicentang/tidak).',
            'answers.*.checked.boolean' => 'Status centang harus bernilai true atau false.',
        ];
    }
}
