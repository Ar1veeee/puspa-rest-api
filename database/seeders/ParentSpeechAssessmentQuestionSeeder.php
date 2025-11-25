<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestionGroup;
use App\Models\AssessmentQuestion;

class ParentSpeechAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $assessmentType = 'parent_wicara';

        $sections = [

            "wicara_orangtua" => [
                "title" => "Assessment Terapi Wicara",
                "questions" => [

                    // MASALAH DASAR
                    ["id" => "masalah_bahasa", "text" => "Ceritakan masalah bahasa bicara anak", "type" => "textarea"],
                    ["id" => "cara_komunikasi", "text" => "Bagaimana biasanya anak berkomunikasi (gerak tubuh, kata, frasa, kalimat)?", "type" => "textarea"],
                    ["id" => "kapan_diketahui", "text" => "Kapan masalah bahasa dan bicara pertama kali diketahui? Oleh siapa?", "type" => "textarea"],
                    ["id" => "penyebab", "text" => "Apakah penyebab utama dari gangguan tersebut?", "type" => "textarea"],

                    // ANAK PEDULI / REAKSI
                    ["id" => "anak_peduli", "text" => "Apakah anak peduli dengan masalahnya?", "type" => "radio",
                        "extra" => ["options" => ["Ya", "Tidak"]]
                    ],
                    ["id" => "reaksi_anak", "text" => "Jika Ya, bagaimana dia merasakannya?", "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 447,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    // PERNAH DIPERIKSA TERAPI WICARA
                    ["id" => "pernah_diperiksa_wicara", "text" => "Apakah sebelumnya anak sudah diperiksa oleh terapis wicara?",
                        "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]
                    ],

                    ["id" => "pernah_diperiksa_wicara_siapa", "text" => "Siapa yang memeriksa?", "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 449,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    ["id" => "pernah_diperiksa_wicara_kapan", "text" => "Kapan pemeriksaan dilakukan?", "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 449,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    ["id" => "pernah_diperiksa_wicara_kesimpulan", "text" => "Apa kesimpulannya?", "type" => "textarea",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 449,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    // PEMERIKSAAN LAIN (DOKTER / PSIKOLOG DLL)
                    ["id" => "pemeriksaan_lain", "text" => "Apakah ahli lain (dokter, psikolog, ortopedi, dll) yang melakukan pemeriksaan?",
                        "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]
                    ],

                    ["id" => "pemeriksaan_lain_siapa", "text" => "Siapa yang memeriksa?", "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 453,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    ["id" => "pemeriksaan_lain_kapan", "text" => "Kapan pemeriksaan dilakukan?", "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 453,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    ["id" => "pemeriksaan_lain_kesimpulan", "text" => "Apa kesimpulannya dan sarannya?", "type" => "textarea",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 453,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    // RIWAYAT KELUARGA
                    ["id" => "riwayat_keluarga", "text" => "Apakah ada anggota keluarga yang mengalami gangguan bicara, bahasa dan pendengaran?",
                        "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]
                    ],

                    ["id" => "riwayat_keluarga_detail", "text" => "Jika Ya, tolong ceritakan", "type" => "textarea",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 457,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],

                    // MILESTONE BAHASA
                    [
                        "id" => "kemampuan_bahasa",
                        "text" => "Berikan perkiraan usia anak mampu melakukan ini:",
                        "type" => "table",
                        "extra" => [
                            "rows" => [
                                "Mengucapkan kata",
                                "Menggabungkan 2 kata",
                                "Mengucapkan kalimat",
                                "Mengenal huruf",
                                "Membaca kata sederhana"
                            ],
                            "columns" => ["usia"],
                            "suffix" => "Tahun"
                        ]
                    ],

                    // FEEDING
                    [
                        "id" => "feeding",
                        "text" => "Apakah ada masalah dalam feeding (misalnya: menelan, menghisap, drooling, mengunyah)?",
                        "type" => "textarea"
                    ],
                ]
            ]
        ];

        $sort_order = 1;

        foreach ($sections as $sectionKey => $sectionData) {

            $group = AssessmentQuestionGroup::create([
                'assessment_type' => $assessmentType,
                'group_title' => $sectionData['title'],
                'group_key' => $sectionKey,
                'filled_by' => 'parent',
                'sort_order' => $sort_order++,
            ]);

            $order = 1;
            foreach ($sectionData['questions'] as $q) {

                $answerOptions = isset($q['extra']['options'])
                    ? json_encode($q['extra']['options'])
                    : null;

                $extraSchema = isset($q['extra'])
                    ? json_encode($q['extra'])
                    : null;

                AssessmentQuestion::create([
                    'group_id' => $group->id,
                    'assessment_type' => $assessmentType,
                    'section' => $sectionKey,
                    'question_code' => strtoupper("PW-" . $sectionKey . "-" . $order),
                    'question_number' => $order,
                    'question_text' => $q['text'],
                    'answer_type' => $q['type'],
                    'answer_options' => $answerOptions,
                    'extra_schema' => $extraSchema,
                    'is_active' => true,
                ]);

                $order++;
            }
        }
    }
}
