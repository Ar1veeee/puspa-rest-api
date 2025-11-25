<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentQuestionGroup;

class PhysioAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'A' => [
                'title' => 'Pemeriksaan Umum',
                'section' => 'pemeriksaan_umum',
                'inputType' => 'text',
                'items' => [
                    "Cara Datang",
                    "Kesadaran",
                    "Kooperatif / Tidak Kooperatif",
                    "Tensi",
                    "Nadi",
                    "RR",
                    "Status Gizi",
                    "Suhu",
                    "Lingkar Kepala"
                ]
            ],

            'B' => [
                'title' => 'Anamnesis Sistem',
                'section' => 'anamnesis_sistem',
                'inputType' => 'text',
                'items' => [
                    "Kepala & Leher",
                    "Kardiovaskuler",
                    "Respirasi",
                    "Gastrointestinalis",
                    "Urogenital",
                    "Muskuloskeletal",
                    "Nervorum",
                    "Sensoris",
                    "Motorik Kasar",
                    "Motorik Halus"
                ]
            ],

            'C' => [
                'title' => 'Pemeriksaan Khusus',
                'sections' => [

                    [
                        'section' => 'pemeriksaan_sensoris',
                        'type' => 'checkbox',
                        'options' => ["Hypersensitif", "Hyposensitif", "Seeking"],
                        'questions' => [
                            "Penglihatan (Visual)",
                            "Pendengaran (Auditory)",
                            "Penciuman (Olfactory)",
                            "Pengecapan (Gustatory)",
                            "Peraba / Kulit (Tactile)",
                            "Otot dan Sendi (Proprioseptive)",
                            "Keseimbangan (Vestibular)"
                        ]
                    ],

                    [
                        'section' => 'pemeriksaan_refleks_primitif',
                        'type' => 'radio_with_text',
                        'options' => ["Primitif", "Fungsional", "Patologis", "Integrasi", "Belum Sinkron"],
                        'withText' => true,
                        'questions' => [
                            "Moro", "Galant", "STNR", "Rooting", "Plantar Graps", "Babinsky", "Blinking", "ATNR",
                            "Sucking", "Palmar Graps", "Fleksor Withdrawl", "Righting", "Automatic Gait Reflek",
                            "Landau", "Parachute", "Protective Refleks"
                        ]
                    ],

                    [
                        'section' => 'gross_motor_pola_gerak',
                        'groups' => [

                            [
                                'sub' => 'Posisi Telentang',
                                'questions' => [
                                    ["Head", "gm_telentang_head"],
                                    ["Shoulder", "gm_telentang_shoulder"],
                                    ["Elbow", "gm_telentang_elbow"],
                                    ["Wrist", "gm_telentang_wrist"],
                                    ["Finger", "gm_telentang_finger"],
                                    ["Trunk", "gm_telentang_trunk"],
                                    ["Hip", "gm_telentang_hip"],
                                    ["Knee", "gm_telentang_knee"],
                                    ["Ankle", "gm_telentang_ankle"]
                                ]
                            ],

                            [
                                'sub' => 'Berguling',
                                'questions' => [
                                    ["Handling pada", "gm_rolling_handling"],
                                    ["Berguling via", "gm_rolling_via"],
                                    ["Rotasi trunk", "gm_rolling_trunk"],
                                ]
                            ],

                            [
                                'sub' => 'Posisi Telungkup',
                                'questions' => [
                                    ["Head lifting", "gm_prone_headlifting"],
                                    ["Head control", "gm_prone_headcontrol"],
                                    ["Forearm support", "gm_prone_forearm"],
                                    ["Hand support", "gm_prone_hand"],
                                    ["Hip", "gm_prone_hip"],
                                    ["Knee", "gm_prone_knee"],
                                    ["Ankle", "gm_prone_ankle"],
                                ]
                            ],

                            [
                                'sub' => 'Posisi Duduk',
                                'questions' => [
                                    ["Head lifting", "gm_sitting_headlifting"],
                                    ["Head control", "gm_sitting_headcontrol"],
                                    ["Head support", "gm_sitting_headsupport"],
                                    ["Trunk control", "gm_sitting_trunk"],
                                    ["Sitting balance", "gm_sitting_balance"],
                                    ["Protective reaction", "gm_sitting_protective"],
                                    ["Posisi duduk", "gm_sitting_posisi"],
                                    ["Weight bearing", "gm_sitting_weight"],
                                ]
                            ],

                            [
                                'sub' => 'Posisi Berdiri',
                                'questions' => [
                                    ["Head lifting", "gm_standing_headlifting"],
                                    ["Head control", "gm_standing_headcontrol"],
                                    ["Trunk control", "gm_standing_trunk"],
                                    ["Hip", "gm_standing_hip"],
                                    ["Knee", "gm_standing_knee"],
                                    ["Ankle", "gm_standing_ankle"],
                                    ["Tumpuan", "gm_standing_tumpuan"],

                                    [
                                        "Postural",
                                        "gm_standing_postural",
                                        "type" => "radio",
                                        "options" => ["Good posture", "Bad posture"],
                                        "subInput" => true
                                    ]
                                ]
                            ],

                            [
                                'sub' => 'Berjalan',
                                'questions' => [
                                    ["Pola jalan", "gm_walk_pola"],
                                    ["Keseimbangan", "gm_walk_balance"],
                                    [
                                        "Tipe lutut",
                                        "gm_walk_knee",
                                        "type" => "radio",
                                        "options" => [
                                            "Genu valgum (x)",
                                            "Genu varum (o)",
                                            "Genu recuvartum (hiperekstensi lutut)"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],

                    [
                        'section' => 'test_joint_laxity',
                        'type' => 'text',
                        'questions' => [
                            ["Elbow", "laxity_elbow"],
                            ["Wrist", "laxity_wrist"],
                            ["Hip", "laxity_hip"],
                            ["Knee", "laxity_knee"],
                            ["Ankle", "laxity_ankle"],
                        ]
                    ],

                    [
                        'section' => 'pemeriksaan_spastisitas',
                        'type' => 'radio',
                        'options' => ["0", "1", "2", "3"],
                        'questions' => [
                            ["Kepala & Leher", "spastik_kepala_leher"],
                            ["Trunk (Leher, Punggung, Pinggang)", "spastik_trunk"],
                            ["AGA Dex", "spastik_aga_dex"],
                            ["AGA Sin", "spastik_aga_sin"],
                            ["AGB Dex", "spastik_agb_dex"],
                            ["AGB Sin", "spastik_agb_sin"],
                        ]
                    ],

                    [
                        'section' => 'pemeriksaan_kekuatan_otot',
                        'type' => 'radio',
                        'options' => ["X", "O", "T", "R"],
                        'questions' => [
                            ["Trunk (Leher, Punggung, Pinggang)", "kekuatan_trunk"],
                            ["AGA Dex", "kekuatan_aga_dex"],
                            ["AGA Sin", "kekuatan_aga_sin"],
                            ["AGB Dex", "kekuatan_agb_dex"],
                            ["AGB Sin", "kekuatan_agb_sin"],
                        ]
                    ],

                    [
                        "section" => "palpasi_otot",
                        "title" => "Pemeriksaan Palpasi Otot",
                        "questions" => [
                            [
                                "label" => "Hypertonus (spactic / rigid)",
                                "key" => "palpasi_hypertonus",
                            ],
                            [
                                "label" => "Hypotonus",
                                "key" => "palpasi_hypotonus",
                            ],
                            [
                                "label" => "Fluktuatif",
                                "key" => "palpasi_fluktuatif",
                            ],
                            [
                                "label" => "Normal",
                                "key" => "palpasi_normal",
                            ],
                        ],
                        "answer_type" => "multi_segment",
                        "answer_format" => [
                            "AGA" => ["D", "S"],
                            "AGB" => ["D", "S"],
                            "Perut" => ["value"]
                        ]
                    ],

                    [
                        'section' => 'jenis_spastisitas',
                        'type' => 'text',
                        'questions' => [
                            ["Hemiplegia", "jenis_hemiplegia"],
                            ["Diplegia", "jenis_diplegia"],
                            ["Quadriplegia", "jenis_quadriplegia"],
                            ["Monoplegia", "jenis_monoplegia"],
                            ["Triplegia", "jenis_triplegia"],
                        ]
                    ],

                    [
                        'section' => 'test_fungsi_bermain',
                        'type' => 'text',
                        'questions' => [
                            ["Jenis Permainan", "fungsi_jenis_permainan"],
                            ["Mengikuti Objek", "fungsi_mengikuti_objek"],
                            ["Menikuti Sumber Suara", "fungsi_menikuti_sumber_suara"],
                            ["Meraih Objek", "fungsi_meraih_objek"],
                            ["Menggenggam", "fungsi_menggenggam"],
                            ["Membedakan Warna", "fungsi_membedakan_warna"],
                            ["Atensi Fokus", "fungsi_atensi_fokus"],
                        ]
                    ]
                ]
            ],

            'D' => [
                'title' => 'Diagnosa Fisioterapi',
                'sections' => [
                    [
                        'section' => 'diagnosa_fisioterapi',
                        'type' => 'textarea',
                        'questions' => [
                            [
                                'label' => 'A. Impairment (Keluhan)',
                                'key' => 'impairment_keluhan',
                                'placeholder' => 'Deskripsi keluhan dan impairment yang dialami pasien'
                            ],
                            [
                                'label' => 'B. Functional Limitation (Batasan)',
                                'key' => 'functional_limitation',
                                'placeholder' => 'Batasan fungsional yang dialami pasien dalam aktivitas sehari-hari'
                            ],
                            [
                                'label' => 'C. Participant Restriction (Restriksi)',
                                'key' => 'participant_restriction',
                                'placeholder' => 'Restriksi partisipasi pasien dalam lingkungan sosial dan aktivitas'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $sort = 1;

        foreach ($data as $key => $groupDef) {

            // A & B It's simple
            if ($key === 'A' || $key === 'B') {

                $group = AssessmentQuestionGroup::create([
                    'assessment_type' => 'fisio',
                    'group_title' => $groupDef['title'],
                    'group_key' => $groupDef['section'],
                    'filled_by' => 'assessor',
                    'sort_order' => $sort++,
                ]);

                foreach ($groupDef['items'] as $i => $label) {

                    AssessmentQuestion::create([
                        'group_id' => $group->id,
                        'assessment_type' => 'fisio',
                        'section' => $groupDef['section'],
                        'question_code' => "FS_{$groupDef['section']}_" . ($i + 1),
                        'question_number' => $i + 1,
                        'question_text' => $label,
                        'answer_type' => 'text',
                    ]);
                }

                continue;
            }

            if ($key === 'C') {

                foreach ($groupDef['sections'] as $secIndex => $section) {

                    $group = AssessmentQuestionGroup::create([
                        'assessment_type' => 'fisio',
                        'group_title' => $section['section'],
                        'group_key' => $section['section'],
                        'filled_by' => 'assessor',
                        'sort_order' => $sort++,
                    ]);

                    if ($section['section'] === 'pemeriksaan_refleks_primitif') {

                        foreach ($section['questions'] as $qIndex => $questionText) {

                            AssessmentQuestion::create([
                                'group_id' => $group->id,
                                'assessment_type' => 'fisio',
                                'section' => $section['section'],
                                'question_code' => "FS_{$section['section']}_" . ($qIndex + 1),
                                'question_number' => $qIndex + 1,
                                'question_text' => $questionText,
                                'answer_type' => 'radio_with_text',
                                'answer_options' => json_encode($section['options']),
                                'extra_schema' => json_encode([
                                    'text_placeholder' => 'Keterangan / catatan tambahan...',
                                    'text_required' => false
                                ])
                            ]);
                        }

                        continue;
                    }

                    if ($section['section'] === 'palpasi_otot') {

                        foreach ($section['questions'] as $qIndex => $q) {

                            AssessmentQuestion::create([
                                'group_id' => $group->id,
                                'assessment_type' => 'fisio',
                                'section' => $section['section'],
                                'question_code' => "FS_{$section['section']}_{$q['key']}",
                                'question_number' => $qIndex + 1,
                                'question_text' => $q['label'],
                                'answer_type' => 'multi_segment',
                                'extra_schema' => json_encode([
                                    'answer_format' => $section['answer_format'],
                                    'segment_labels' => [
                                        'AGA' => 'Anggota Gerak Atas',
                                        'AGB' => 'Anggota Gerak Bawah',
                                        'Perut' => 'Perut'
                                    ],
                                    'option_labels' => [
                                        'D' => 'Dextra (Kanan)',
                                        'S' => 'Sinister (Kiri)',
                                        'value' => 'Nilai'
                                    ]
                                ])
                            ]);
                        }

                        continue;
                    }

                    if (isset($section['questions'])) {

                        foreach ($section['questions'] as $qIndex => $q) {

                            $base = [
                                'group_id' => $group->id,
                                'assessment_type' => 'fisio',
                                'section' => $section['section'],
                                'question_code' => "FS_{$section['section']}_" . ($qIndex + 1),
                                'question_number' => $qIndex + 1,
                                'question_text' => is_array($q) ? $q[0] : $q,
                            ];

                            if (!empty($section['type']) && $section['type'] === 'checkbox') {
                                $base['answer_type'] = 'checkbox';
                                $base['answer_options'] = json_encode($section['options']);
                            } elseif (!empty($section['type']) && $section['type'] === 'radio') {
                                $base['answer_type'] = 'radio';
                                $base['answer_options'] = json_encode($section['options']);
                            } else {
                                $base['answer_type'] = $q['type'] ?? 'text';
                            }

                            // Postural special case
                            if (is_array($q) && isset($q['subInput'])) {
                                $base['answer_type'] = 'radio_with_text';
                                $base['answer_options'] = json_encode($q['options']);
                                $base['extra_schema'] = json_encode([
                                    'text_placeholder' => 'kyphosis-lordosis / sway-back / military type / lower cross'
                                ]);
                            }

                            // Radio knee type
                            if (is_array($q) && isset($q['type']) && $q['type'] === 'radio') {
                                $base['answer_type'] = 'radio';
                                $base['answer_options'] = json_encode($q['options']);
                            }

                            AssessmentQuestion::create($base);
                        }

                    }

                    // Gross motor structured groups
                    if (isset($section['groups'])) {

                        foreach ($section['groups'] as $subGroup) {

                            foreach ($subGroup['questions'] as $i => $q) {

                                $label = $q[0];
                                $keyName = $q[1];
                                $type = $q['type'] ?? 'text';

                                $extra = [];

                                $answerType = $type;

                                if ($type === 'radio') {
                                    $extra['answer_options'] = json_encode($q['options']);
                                }

                                if ($type === 'radio' && isset($q['subInput'])) {
                                    $answerType = 'radio_with_text';
                                    $extra['extra_schema'] = json_encode([
                                        'text_placeholder' => $q['subInput']['placeholder'] ?? 'keterangan'
                                    ]);
                                }

                                AssessmentQuestion::create([
                                    'group_id' => $group->id,
                                    'assessment_type' => 'fisio',
                                    'section' => $section['section'],
                                    'question_code' => "FS_{$section['section']}_" . $keyName,
                                    'question_number' => $i + 1,
                                    'question_text' => $label,
                                    'answer_type' => $answerType,
                                    ...$extra
                                ]);
                            }
                        }
                    }
                }
            }

            if ($key === 'D') {

                foreach ($groupDef['sections'] as $secIndex => $section) {

                    $group = AssessmentQuestionGroup::create([
                        'assessment_type' => 'fisio',
                        'group_title' => $groupDef['title'],
                        'group_key' => $section['section'],
                        'filled_by' => 'assessor',
                        'sort_order' => $sort++,
                    ]);

                    foreach ($section['questions'] as $qIndex => $q) {

                        AssessmentQuestion::create([
                            'group_id' => $group->id,
                            'assessment_type' => 'fisio',
                            'section' => $section['section'],
                            'question_code' => "FS_{$section['section']}_{$q['key']}",
                            'question_number' => $qIndex + 1,
                            'question_text' => $q['label'],
                            'answer_type' => 'textarea',
                            'extra_schema' => json_encode([
                                'placeholder' => $q['placeholder'] ?? '',
                                'rows' => 4
                            ])
                        ]);
                    }
                }
            }
        }
    }
}
