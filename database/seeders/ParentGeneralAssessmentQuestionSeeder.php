<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestionGroup;
use App\Models\AssessmentQuestion;

class ParentGeneralAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $assessmentType = 'parent_general';

        $sections = [
            // RIWAYAT ANAK: psikososial, kehamilan, kelahiran, setelah kelahiran
            "riwayat_psikososial" => [
                "title" => "Riwayat Psikososial",
                "questions" => [
                    ["id" => "anak_ke", "text" => "Ananda anak ke berapa?", "type" => "number"],
                    ["id" => "saudara", "text" => "Saudara (Nama dan Usia):", "type" => "multi", "extra" => ["fields" => ["Nama", "Usia"]]],
                    ["id" => "tinggal_serumah", "text" => "Orang-orang yang tinggal serumah dengan anak:", "type" => "text", "extra" => ["placeholder" => "Ayah, Ibu"]],
                    ["id" => "status_pernikahan", "text" => "Status pernikahan orang tua terkini:", "type" => "select", "extra" => ["options" => ["Menikah", "Cerai Hidup", "Cerai Mati"]]],
                    ["id" => "bahasa", "text" => "Bahasa sehari-hari:", "type" => "text", "extra" => ["placeholder" => "Indonesia"]],
                ],
            ],

            "riwayat_kehamilan" => [
                "title" => "Riwayat Kehamilan",
                "questions" => [
                    ["id" => "kehamilan_direncanakan", "text" => "Kehamilan diinginkan dan direncanakan", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "kontrol_rutin", "text" => "Kontrol rutin ke dokter atau bidan", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "usia_ibu", "text" => "Usia ibu pada saat hamil", "type" => "number", "extra" => ["suffix" => "Tahun"]],
                    ["id" => "hb_ibu", "text" => "HB saat hamil", "type" => "number", "extra" => ["suffix" => "g/dL"]],
                    ["id" => "lama_kehamilan", "text" => "Lama kehamilan", "type" => "number", "extra" => ["suffix" => "Bulan"]],
                    ["id" => "riwayat_jatuh", "text" => "Riwayat jatuh / pendarahan", "type" => "text", "extra" => ["placeholder" => "Berikan alasan!"]],
                    ["id" => "konsumsi_obat", "text" => "Apakah mengonsumsi obat-obatan tertentu?", "type" => "text", "extra" => ["placeholder" => "Berikan Alasan!"]],
                    ["id" => "komplikasi_kehamilan", "text" => "Komplikasi lainnya selama kehamilan", "type" => "textarea", "extra" => ["placeholder" => "Keterangan!"]],
                ],
            ],

            "riwayat_kelahiran" => [
                "title" => "Riwayat Kelahiran",
                "questions" => [
                    ["id" => "metode_lahir", "text" => "Lahir persalinan normal / operasi caesar / vakum", "type" => "radio", "extra" => ["options" => ["Normal", "Operasi Caesar", "Vakum"]]],
                    ["id" => "posisi_lahir", "text" => "Jika lahir normal posisi lahir kepala dulu / kaki dulu / pantat dulu", "type" => "radio", "extra" => ["options" => ["Kepala dulu", "Kaki dulu", "Pantat dulu"]]],
                    [
                        "id" => "alasan_operasi",
                        "text" => "Alasan lahir dengan persalinan operasi caesar / vakum",
                        "type" => "textarea",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 436,
                                    "operator" => "!=",
                                    "value" => "Normal",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib diisi jika metode lahir bukan normal
                    ["id" => "lahir_menangis", "text" => "Lahir langsung menangis?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "riwayat_bayi", "text" => "Saat lahir ada riwayat bayi biru / kuning / kejang?", "type" => "checkbox", "extra" => ["options" => ["Biru", "Kuning", "Kejang"]]],
                    [
                        "id" => "durasi_riwayat_bayi",
                        "text" => "Jika Ya, berikan informasi berapa lama anak mengalaminya",
                        "type" => "number",
                        "extra" => [
                            "suffix" => "Hari",
                            "conditional_rules" => [
                                [
                                    "when" => 440,
                                    "operator" => "not_empty",
                                    "required" => true
                                ]
                            ],
                        ]
                    ], // wajib diisi jika pernah mengalami biru / kuning / kejang tidak kosong
                    ["id" => "inkubator", "text" => "Pernah masuk inkubator?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    [
                        "id" => "lama_inkubator",
                        "text" => "Jika Ya, berikan informasi berapa lama masuk inkubator",
                        "type" => "number",
                        "extra" => [
                            "suffix" => "Hari",
                            "conditional_rules" => [
                                [
                                    "when" => 442,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib diisi jika pernah masuk inkubator
                    ["id" => "berat", "text" => "Berat Anak (kg)", "type" => "number"],
                    ["id" => "panjang", "text" => "Panjang Anak (cm)", "type" => "number"],
                    ["id" => "lingkar_kepala", "text" => "Lingkar Kepala (cm)", "type" => "number"],
                    ["id" => "komplikasi_kelahiran", "text" => "Komplikasi lainnya ketika kelahiran", "type" => "textarea"],
                    ["id" => "postpartum_depresi", "text" => "Apakah ibu menderita sindrom depresi pasca melahirkan?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                ],
            ],

            "riwayat_setelah_kelahiran" => [
                "title" => "Riwayat Setelah Kelahiran",
                "questions" => [
                    ["id" => "riwayat_biru_kuning", "text" => "Anak mengalami biru / kuning / kejang?", "type" => "checkbox", "extra" => ["options" => ["Biru", "Kuning", "Kejang"]]],
                    [
                        "id" => "lama_biru_kuning",
                        "text" => "Berapa lama mengalaminya?",
                        "type" => "number",
                        "extra" => [
                            "suffix" => "Hari",
                            "conditional_rules" => [
                                [
                                    "when" => 449,
                                    "operator" => "not_empty",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib di isi jika pernah mengalami biru / kuning / kejang tidak kosong
                    [
                        "id" => "usia_saat_mengalami",
                        "text" => "Saat usia berapa?",
                        "type" => "number",
                        "extra" => [
                            "suffix" => "Tahun",
                            "conditional_rules" => [
                                [
                                    "when" => 449,
                                    "operator" => "not_empty",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib di isi jika pernah mengalami biru / kuning / kejang tidak kosong
                    ["id" => "anak_jatuh", "text" => "Anak pernah jatuh / tidak", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    [
                        "id" => "bagian_terbentur",
                        "text" => "Bagian tubuh yang terbentur?",
                        "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 452,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib di isi jika pernah mengalami jatuh
                    [
                        "id" => "usia_saat_jatuh",
                        "text" => "Saat usia berapa?",
                        "type" => "number",
                        "extra" => [
                            "suffix" => "Tahun",
                            "conditional_rules" => [
                                [
                                    "when" => 452,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib di isi jika pernah mengalami jatuh
                    ["id" => "komplikasi_setelah_kelahiran", "text" => "Komplikasi lainnya setelah kelahiran", "type" => "textarea"],

                    // milestone = table
                    ["id" => "milestone", "text" => "Pada bagian ini, diisi dengan usia anak saat mampu melakukannya:", "type" => "table", "extra" => [
                        "rows" => ["Angkat kepala", "Tengkurap", "Berguling", "Duduk mandiri", "Merangkak", "Merambat", "Berdiri mandiri", "Berjalan mandiri"],
                        "columns" => ["usia"],
                        "suffix" => "Bulan"
                    ]],
                    ["id" => "riwayat_imunisasi", "text" => "Bagaimana riwayat imunisasi anak?", "type" => "radio_with_text", "extra" => ["options" => ["Lengkap", "Tidak"]]],
                    [
                        "id" => 'imunisasi_yang_kurang',
                        "text" => "Jika tidak lengkap, sebutkan imunisasi apa yang kurang",
                        "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 457,
                                    "operator" => "==",
                                    "value" => "Tidak",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib di isi jika imunisasi Tidak Lengkap
                    ["id" => "asi_eksklusif", "text" => "Apakah anak mendapat ASI eksklusif?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    [
                        "id" => "usia_asi",
                        "text" => "Jika Ya, sampai usia berapa anak minum ASI",
                        "type" => "number",
                        "extra" => [
                            "suffix" => "Tahun",
                            "conditional_rules" => [
                                [
                                    "when" => 459,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ], // wajib di isi jika pernah diberikan asi ekslusif
                    ["id" => "usia_makan_nasi", "text" => "Sejak usia berapa anak makan nasi tim / nasi biasa", "type" => "number", "extra" => ["suffix" => "Tahun"]],
                ],
            ],

            // RIWAYAT KESEHATAN
            "riwayat_kesehatan" => [
                "title" => "Riwayat Kesehatan",
                "questions" => [
                    ["id" => "riwayat_penyakit", "text" => "Berikan perkiraan usia anak pernah menderita penyakit berikut:", "type" => "table", "extra" => [
                        "columns" => ["penyakit", "tahun"],
                        "rows" => [
                            "Alergi",
                            "Demam",
                            "Infeksi Telinga",
                            "Sakit Kepala",
                            "Mastoiditis",
                            "Sinusitis",
                            "Asma",
                            "Kejang",
                            "Encephalitis",
                            "Demam Tinggi",
                            "Meningitis",
                            "Tonsilitis",
                            "Cacar Air",
                            "Pusing",
                            "Campak / Rubella",
                            "Influensa",
                            "Radang Paru",
                            "Dll."
                        ]
                    ]],
                    ["id" => "family_similar_conditions_detail", "text" => "Apakah dalam anggota keluarga memiliki riwayat penyakit yang sama dengan anak? Mohon ceritakan detailnya.", "type" => "textarea"],
                    ["id" => "family_mental_disorders", "text" => "Apakah dalam anggota keluarga memiliki riwayat gangguan tertentu? seperti stress, depresi, skizofrenia, dll.", "type" => "textarea"],
                    ["id" => "child_surgeries_detail", "text" => "Pernahkah anak melakukan pembedahan? Jika iya, apa jenisnya dan kapan (contohnya tonsillectomy, adenoidectomy, dll)", "type" => "textarea"],
                    ["id" => "special_medical_conditions", "text" => "Apakah anak memiliki riwayat penyakit khusus?", "type" => "textarea"],
                    ["id" => "other_medications_detail", "text" => "Apakah anak menjalani pengobatan lain? Jika iya, sebutkan.", "type" => "textarea"],
                    ["id" => "negative_reactions_detail", "text" => "Apakah ada reaksi negatif dari pengobatan tersebut? Jika iya, identifikasi.", "type" => "textarea"],
                    ["id" => "hospitalization_history", "text" => "Ceritakan riwayat penyakit yang pernah dialami atau rawat inap yang pernah dilakukan.", "type" => "textarea"],
                ],
            ],

            // RIWAYAT PENDIDIKAN
            "riwayat_pendidikan" => [
                "title" => "Riwayat Pendidikan",
                "questions" => [
                    ["id" => "sudah_sekolah", "text" => "Apakah anak anda bersekolah?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    [
                        "id" => "nama_sekolah",
                        "text" => "Dimana sekolahnya?",
                        "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 470,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],
                    [
                        "id" => "kelas_sekolah",
                        "text" => "Kelas berapa?",
                        "type" => "text",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 470,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],
                    ["id" => "long_absence", "text" => "Apakah anak anda pernah tidak bersekolah untuk jangka waktu tertentu?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    [
                        "id" => "long_absence_reason",
                        "text" => "Jika pernah tidak bersekolah, berapa lama dan apa alasan tidak bersekolah?",
                        "type" => "textarea",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 473,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],
                    ["id" => "academic_and_socialization_detail", "text" => "Gambarkan mengenai pencapaian akademis dan performa sosialisasinya:", "type" => "textarea"],
                    ["id" => "special_treatment_detail", "text" => "Apakah anak menerima perlakuan khusus? Jika iya, jelaskan:", "type" => "textarea"],
                    ["id" => "learning_support_program", "text" => "Apakah anak anda mengikuti Program Pendukung Pembelajaran?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    [
                        "id" => "learning_support_detail",
                        "text" => "Jika ya, berikan gambaran tentang tujuan, durasi, frekuensi, di kelas / luar kelas, individual / group, dilaksanakan oleh:",
                        "type" => "textarea",
                        "extra" => [
                            "conditional_rules" => [
                                [
                                    "when" => 477,
                                    "operator" => "==",
                                    "value" => "Ya",
                                    "required" => true
                                ]
                            ]
                        ]
                    ],
                ],
            ],
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

                $answerOptions = null;
                if (isset($q['extra']['options'])) {
                    $answerOptions = json_encode($q['extra']['options']);
                } elseif ($q['type'] === 'checkbox' || $q['type'] === 'select' || $q['type'] === 'radio') {
                    $answerOptions = null;
                }

                $extraSchema = null;
                if (isset($q['extra'])) {
                    $extraSchema = json_encode($q['extra']);
                } else {
                    if ($q['type'] === 'multi' && isset($q['fields'])) {
                        $extraSchema = json_encode(['fields' => $q['fields']]);
                    }
                    if ($q['type'] === 'table' && isset($q['rows'])) {
                        $extraSchema = json_encode(['rows' => $q['rows'], 'columns' => $q['columns'] ?? ['value'], 'suffix' => $q['suffix'] ?? null]);
                    }
                }

                if (isset($q['rows']) && $extraSchema === null) {
                    $extraSchema = json_encode(['rows' => $q['rows'], 'columns' => $q['columns'] ?? ['value'], 'suffix' => $q['suffix'] ?? null]);
                }

                AssessmentQuestion::create([
                    'group_id' => $group->id,
                    'assessment_type' => $assessmentType,
                    'section' => $sectionKey,
                    'question_code' => strtoupper("DG-" . $sectionKey . "-" . $order),
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
