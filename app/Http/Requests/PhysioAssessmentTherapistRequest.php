<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PhysioAssessmentTherapistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'terapis';
    }

    public function rules(): array
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

                // Walking
                'walking_bad_posture' => ['nullable', 'string', 'max:500'],
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

    public function messages(): array
    {
        return [
            'required' => 'Field :attribute wajib diisi.',
            'string' => 'Field :attribute harus berupa teks.',
            'boolean' => 'Field :attribute harus berupa boolean (true/false).',
            'integer' => 'Field :attribute harus berupa angka.',
            'numeric' => 'Field :attribute harus berupa angka.',
            'in' => 'Nilai yang dipilih untuk :attribute tidak valid.',
            'between' => 'Field :attribute harus bernilai antara :min dan :max.',
            'max' => 'Field :attribute maksimal :max karakter.',
            'array' => 'Field :attribute harus berupa array.',

            // Custom messages for specific fields
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
        ];
    }
}
