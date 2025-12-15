<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentQuestionGroup;

class SpeechAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedWicaraOral();
        $this->seedWicaraBahasa();
    }

    private function seedWicaraOral()
    {
        $groups = [
            [
                "key" => "face_eval",
                "title" => "Evaluasi Wajah",
                "questions" => [
                    [
                        "label" => "Kesimetrisan",
                        "options" => ["normal", "turun pada sebelah kanan", "turun pada sebelah kiri"]
                    ],
                    [
                        "label" => "Gerakan abnormal",
                        "options" => ["none", "menyeringai", "kedutan"]
                    ],
                    [
                        "label" => "Pernapasan mulut",
                        "options" => ["ya", "tidak"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ]
                ]
            ],
            [
                "key" => "jaw_eval",
                "title" => "Evaluasi Rahang dan Gigi",
                "questions" => [
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kesimetrisan",
                        "options" => ["normal", "miring ke kanan", "miring ke kiri"]
                    ],
                    [
                        "label" => "Movement",
                        "options" => ["normal", "tersentak-sentak", "groping", "lambat", "tidak simetris"]
                    ],
                    [
                        "label" => "TMJ noises",
                        "options" => ["absent", "kertak gigi", "bermunculan"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ]
                ]
            ],
            [
                "key" => "dental_eval",
                "title" => "Observasi Gigi",
                "questions" => [
                    [
                        "label" => "Oklusi geraham",
                        "options" => [
                            "normal",
                            "neutrocclusion (Class I)",
                            "distroclusion (Class II)",
                            "mesioclusion (Class III)"
                        ]
                    ],
                    [
                        "label" => "Oklusi taring",
                        "options" => ["normal", "overbite", "underbite", "crossbite"]
                    ],
                    [
                        "label" => "Gigi",
                        "options" => ["semua ada", "gigi palsu", "gigi yang hilang (spesifik)"]
                    ],
                    [
                        "label" => "Susunan gigi",
                        "options" => ["normal", "bertumpuk", "beruang", "tidak beraturan"]
                    ],
                    [
                        "label" => "Kebersihan",
                        "options" => ["bersih", "kotor"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ]
                ]
            ],
            [
                "key" => "lip_eval",
                "title" => "Evaluasi Bibir",
                "questions" => [
                    [
                        "label" => "Range of motion (memonyongkan bibir)",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kesimetrisan (memonyongkan bibir)",
                        "options" => [
                            "normal",
                            "turun pada kedua sisi",
                            "turun pada sebelah kanan",
                            "turun pada sebelah kiri"
                        ]
                    ],
                    [
                        "label" => "Kekuatan (melawan tongue spatel)",
                        "options" => ["normal", "lemah"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien tersenyum
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kesimetrisan",
                        "options" => [
                            "normal",
                            "turun pada kedua sisi",
                            "turun pada sebelah kanan",
                            "turun pada sebelah kiri"
                        ]
                    ],
                    [
                        "label" => "Lain-lain",
                    ]
                ]
            ],
            [
                "key" => "tongue_eval",
                "title" => "Evaluasi Lidah",
                "questions" => [
                    [
                        "label" => "Warna lidah",
                        "options" => ["normal", "abnormal (spesifik)"]
                    ],
                    [
                        "label" => "Gerakan abnormal",
                        "options" => ["tidak ada", "tersentak-sentak", "kedutan", "menggeliat", "faskulasi"]
                    ],
                    [
                        "label" => "Size",
                        "options" => ["normal", "kecil", "besar"]
                    ],
                    [
                        "label" => "Frenum",
                        "options" => ["normal", "pendek"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien mengeluarkan lidah
                    [
                        "label" => "Kesimetrisan",
                        "options" => ["normal", "miring ke kanan", "miring ke kiri"]
                    ],
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kecepatan",
                        "options" => ["normal", "lambat"]
                    ],
                    [
                        "label" => "Kekuatan (melawan tongue spatel)",
                        "options" => ["normal", "lemah"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien menarik kembali lidahnya
                    [
                        "label" => "Kesimetrisan",
                        "options" => ["normal", "miring ke kanan", "miring ke kiri"]
                    ],
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kecepatan",
                        "options" => ["normal", "lambat"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien menggerakkan lidah ke kanan
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kecepatan",
                        "options" => ["normal", "lemah"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien menggerakkan lidah ke kiri
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Kecepatan",
                        "options" => ["normal", "lemah"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien menggerakkan lidah ke bawah
                    [
                        "label" => "Gerakan",
                        "options" => ["normal", "lambat"]
                    ],
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien menggerakkan lidah ke atas
                    [
                        "label" => "Gerakan",
                        "options" => ["normal", "lambat"]
                    ],
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "kurang"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien menggerakkan lidah ke kanan-kiri bergantian
                    [
                        "label" => "Pergerakan",
                        "options" => ["normal", "lemah", "menurun bertahap"]
                    ],
                    [
                        "label" => "Range of motion",
                        "options" => ["normal", "berkurang pada sisi kiri", "berkurang pada sisi kanan"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ]
                ]
            ],
            [
                "key" => "pharynx_eval",
                "title" => "Evaluasi Faring",
                "questions" => [
                    [
                        "label" => "Warna",
                        "options" => ["normal", "abnormal"]
                    ],
                    [
                        "label" => "Tonsil",
                        "options" => ["tidak ada", "normal", "membesar"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],
                ]
            ],
            [
                "key" => "palate_eval",
                "title" => "Evaluasi Langit-langit Keras dan Lunak",
                "questions" => [
                    [
                        "label" => "Warna",
                        "options" => ["normal", "abnormal"]
                    ],
                    [
                        "label" => "Rugae",
                        "options" => ["ada", "tidak ada"]
                    ],
                    [
                        "label" => "Tinggi langit-langit",
                        "options" => ["normal", "tinggi", "rendah"]
                    ],
                    [
                        "label" => "Lebar langit-langit",
                        "options" => ["normal", "sempit", "lebar"]
                    ],
                    [
                        "label" => "Growths",
                        "options" => ["ada", "tidak ada"]
                    ],
                    [
                        "label" => "Fistula",
                        "options" => ["ada", "tidak ada"]
                    ],
                    [
                        "label" => "Kesimetrisan saat istirahat",
                        "options" => ["normal", "kanan lebih rendah", "kiri lebih rendah"]
                    ],
                    [
                        "label" => "Tinggi langit-langit lunak",
                        "options" => ["normal", "tidak ada", "hiperensitif", "hiposensitif"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],

                    // Minta klien melakukan fonasi /a/
                    [
                        "label" => "Kesimetrisan gerakan",
                        "options" => ["normal", "miring ke kanan", "miring ke kiri"]
                    ],
                    [
                        "label" => "Gerakan posterior",
                        "options" => ["ada", "tidak ada"]
                    ],
                    [
                        "label" => "Uvula",
                        "options" => ["normal", "bifid", "miring ke kanan", "miring ke kiri"]
                    ],
                    [
                        "label" => "Nasalisasi",
                        "options" => ["tidak ada", "hipernasal"]
                    ],
                    [
                        "label" => "Lain-lain",
                    ],
                ]
            ]
        ];

        foreach ($groups as $gIndex => $g) {

            $group = AssessmentQuestionGroup::create([
                'assessment_type' => 'wicara_oral',
                'group_title' => $g['title'],
                'group_key' => $g['key'],
                'filled_by' => 'assessor',
                'sort_order' => $gIndex + 1,
            ]);

            foreach ($g['questions'] as $qIndex => $q) {

                $isLainLain = isset($q['label'])
                    && trim(strtolower($q['label'])) === 'Lain-lain';

                AssessmentQuestion::create([
                    'group_id'        => $group->id,
                    'assessment_type' => 'wicara_oral',
                    'section'         => $g['key'],
                    'question_code'   => "WO_" . strtoupper($g['key']) . "_" . ($qIndex + 1),
                    'question_number' => $qIndex + 1,
                    'question_text'   => $q['label'],
                    'answer_type'     => $isLainLain ? 'note' : 'select_with_note',
                    'answer_options'  => $isLainLain
                        ? null
                        : json_encode($q['options'] ?? []),
                    'extra_schema'    => $isLainLain
                        ? null
                        : json_encode([
                            "columns" => [
                                ["key" => "value", "label" => "Pilihan",  "type" => "select"],
                                ["key" => "note",  "label" => "Keterangan", "type" => "text"]
                            ]
                        ]),
                    'is_active'       => true,
                ]);
            }
        }
    }

    private function seedWicaraBahasa()
    {
        $groups = [
            [
                "key" => "usia_0_6",
                "title" => "Usia 0-6 Bulan",
                "questions" => [
                    "Mengulangi suara yang sama",
                    "Sering kali membuat suara \"koo\" dan \"gurgles\", serta suara-suara menyenangkan",
                    "Menggunakan tangisan yang berbeda-beda untuk mengutarakan kebutuhan yang berbeda-beda",
                    "Tersenyum bila diajak berbicara",
                    "Mengenali suara manusia",
                    "Melokasikan suara dengan cara menoleh",
                    "Mendengarkan pembicaraan",
                    "Menggunakan konsonan /p/, /b/, /m/ ketika mengoceh",
                    "Menggunakan suara atau isyarat (gesture) untuk memberitahu keinginan"
                ]
            ],
            [
                "key" => "usia_7_12",
                "title" => "Usia 7-12 Bulan",
                "questions" => [
                    "Mengerti arti tidak panas dan panas",
                    "Dapat memberi respon untuk permintaan yang sederhana",
                    "Mengerti dan memberi respon pada namanya sendiri",
                    "Mendengarkan dan meniru beberapa suara",
                    "Mengenali kata untuk benda sehari-hari (misalnya susu, sepatu, cangkir, dll)",
                    "Mengoceh dengan menggunakan suara panjang dan pendek",
                    "Menggunakan intonasi seperti lagu ketika mengoceh",
                    "Menggunakan bermacam-macam suara ketika mengoceh",
                    "Menirukan beberapa suara bicara orang dewasa dan intonasinya",
                    "Menggunakan suara bicara selain tangisan untuk mendapatkan perhatian",
                    "Mendengarkan ketika diajak berbicara",
                    "Menggunakan suara yang mendekati suara yang didengar",
                    "Mulai merubah ocehan ke bahasa bulan (jargon)",
                    "Mulai menggunakan bicara dengan tujuan",
                    "Hanya menggunakan kata benda",
                    "Memiliki pengucapan (ekspresif) kosa kata 1-3 kata",
                    "Mengerti perintah sederhana"
                ]
            ],
            [
                "key" => "usia_13_18",
                "title" => "Usia 13-18 Bulan",
                "questions" => [
                    "Menggunakan intonasi yang mengikuti pola bicara orang dewasa",
                    "Menggunakan echolalia dan bahasa bulan (jargon)",
                    "Tidak mengucapkan beberapa konsonan depan dan hampir seluruh konsonan akhir",
                    "Bicara hampir keseluruhannya tidak dapat dimengerti",
                    "Mengikuti perintah sederhana",
                    "Mengenali 1-3 bagian tubuh",
                    "Memiliki pengucapan (ekspresif) kosa kata 3-20 kata / lebih (kebanyakan kata benda)",
                    "Memadukan vokalisasi dan isyarat",
                    "Membuat permintaan untuk hal-hal yang lebih diinginkan"
                ]
            ],
            [
                "key" => "usia_19_24",
                "title" => "Usia 19-24 Bulan",
                "questions" => [
                    "Lebih sering menggunakan kata daripada bahasa bulan (jargon)",
                    "Memiliki pengucapan (ekspresif) kosa kata 50-100 kata / lebih",
                    "Memiliki pemahaman (reseptif) kosa kata 300 kata / lebih",
                    "Mulai memadu kata benda dan kata kerja",
                    "Mulai menggunakan kata ganti orang",
                    "Kendala suara masih belum stabil",
                    "Menggunakan intonasi yang benar ketika bertanya",
                    "Bicara 25-50% dapat dimengerti orang lain",
                    "Menjawab pertanyaan 'ini apa?'",
                    "Senang mendengarkan cerita",
                    "Mengenali 5 bagian tubuh",
                    "Secara benar dapat menamakan beberapa benda sehari-hari"
                ]
            ],
            [
                "key" => "usia_2_3",
                "title" => "Usia 2-3 Tahun",
                "questions" => [
                    "Bicara 50-75% dapat dipahami orang lain",
                    "Mengerti satu dan semua",
                    "Mengucapkan keinginan untuk ke kamar mandi (sebelum, sedang, atau setelah kejadian)",
                    "Meminta benda dengan menamakannya",
                    "Menunjuk kepada gambar di dalam buku bila diminta",
                    "Mengenali beberapa bagian tubuh",
                    "Mengenali perintah sederhana dan menjawab pertanyaan sederhana",
                    "Senang mendengarkan cerita pendek, lagu dan sajak",
                    "Menanyakan 1-2 kata pertanyaan",
                    "Menggunakan 3-4 kata frase",
                    "Menggunakan preposisi",
                    "Menggunakan kata yang sama dalam konteks",
                    "Menggunakan kata echolalia bila kesulitan berbicara",
                    "Memiliki pengucapan (ekspresif) kosa kata 50-250 kata",
                    "Memiliki pemahaman (reseptif) kosa kata 500-900 kata atau lebih",
                    "Memperlihatkan kesalahan dalam pemakaian tata bahasa",
                    "Mengerti hampir keseluruhannya yang dikatakan kepadanya",
                    "Sering mengulang,terutama pemulaan 'saya'/nama dan suku kata pertama",
                    "Berbicara dengan suara yang keras",
                    "Nada suara mulai meninggi",
                    "Menunggu huruf hidup dengan baik",
                    "Secara konsisten menggunakan konsonan awal (walaupun beberapa masih tidak dapat diucapkan dengan baik)",
                    "Sering menghilangkan konsonan tengah",
                    "Sering menghilangkan atau mengganti konsonan akhir"
                ]
            ],
            [
                "key" => "usia_3_4",
                "title" => "Usia 3-4 Tahun",
                "questions" => [
                    "Mengerti fungsi dari benda",
                    "Mengerti perbedaan arti kata (besar-kecil, di atas-di dalam, berhenti-jalan)",
                    "Mengikuti perintah 2-3 bagian",
                    "Bertanya dan menjawab pertanyaan sederhana (siapa, apa, di mana, kenapa)",
                    "Sering bertanya dan meminta jawaban yang terperinci",
                    "Menggunakan analogi sederhana",
                    "Menggunakan bahasa untuk mengekspresikan emosi",
                    "Menggunakan 4-5 kata dalam kalimat",
                    "Mengulang kalimat 6-13 suku kata secara benar",
                    "Mengenali benda dengan nama",
                    "Memanipulasi orang dewasa dan teman sebaya",
                    "Kadang-kadang echolalia masih digunakan",
                    "Lebih sering menggunakan kata benda dan kata kerja",
                    "Sadar akan waktu yang telah lalu dan yang akan datang",
                    "Memiliki pengucapan (ekspresif) kosa kata 800-1500 kata",
                    "Memiliki pengucapan (reseptif) kosa kata 1200-2000 kata",
                    "Kadang kala mengulang nama, terbata bata, kesulitan mengatur napas, dan meringis",
                    "Berbisik",
                    "Berbicara 80% dapat dipahami",
                    "Walaupun masih banyak kesalahan, tata bahasa sudah membaik",
                    "Dapat menceritakan dua kejadian secara urut",
                    "Dapat bercakap-cakap lebih lama"
                ]
            ],
            [
                "key" => "usia_4_5",
                "title" => "Usia 4-5 Tahun",
                "questions" => [
                    "Mengerti konsep jumlah sampai dengan 3",
                    "Mengerti spatial konsep",
                    "Mengenali 1-3 warna",
                    'Memiliki pemahaman (reseptif) kosa kata 2800 kata atau lebih',
                    'Menghitung sampai 10 secara rote',
                    'Mendengarkan cerita pendek',
                    'Menjawab pertanyaan tentang fungsi',
                    'Menggunakan tata bahasa dalam kalimat yang benar',
                    "Memiliki pemahaman (ekspresif) kosa kata 900-2000 kata atau lebih",
                    "Menggunakan kalimat dengan 4-8 kata",
                    "Menjawab pertanyaan 2 bagian",
                    "Menanyakan arti kata",
                    "Senang akan sajak,ritme dan suku kata tak berarti",
                    "Menggunakan konsonan dengan 30% ketepatan",
                    "Bicara biasanya dapat dimengerti oleh orang lain",
                    "Dapat bercerita tentang pengalaman disekolah, dirumah teman, dll",
                    "Dapat menceritakan kembali cerita panjang",
                    "Memperhatikan bila diceritakan dan menjawab pertanyaan sederhana tentang cerita tersebut"
                ]
            ],
            [
                "key" => "usia_5_6",
                "title" => "Usia 5-6 Tahun",
                "questions" => [
                    "Menamakan 6 warna dasar dan 3 bentuk dasar",
                    "Mengikuti perintah yang diberikan dalam kelompok",
                    "Mengikuti perintah 3 bagian",
                    "Menanyakan pertanyaan 'bagaimana?'",
                    "Menjawab secara verbal pertanyaan 'hai' dan 'apa kabar'",
                    "Menggunakan kata untuk sesuatu yang telah berlalu dan akan datang",
                    "Menggunakan kata penghubung",
                    "Memiliki pengucapan (ekspresif) kosa kata sekitar 13.000 kata",
                    "Menamakan lawan kata",
                    "Secara urut menamakan nama hari",
                    "Menghitung sampai 30 secara mengurutkan (rote)",
                    "Kosa kata meningkat terus",
                    "Panjang kata dalam kalimat menurun hingga 4-6 kata dalam kalimat",
                    "Terkadang mengembalikan suara-suara"
                ]
            ],
            [
                "key" => "usia_6_7",
                "title" => "Usia 6-7 Tahun",
                "questions" => [
                    "Menamakan beberapa huruf,angka dan mata uang",
                    "Mengurutkan angka dan dapat mengucapkan abjad",
                    "Mengerti kanan dan kiri",
                    "Menggunakan makin banyak lagi kata-kata yang lebih kompleks untuk menjelaskan sesuatu dan mampu mengadakan percakapan",
                    "Memiliki pemahaman kosa kata kurang lebih 20.000 kata",
                    "Menggunakan panjang kalimat sampai dengan 6 kata",
                    "Mengerti hampir keseluruhan konsep tentang waktu",
                    "Dapat menghitung sampai dengan 100 secara rote",
                    "Menggunakan hampir seluruh aturan untuk perubahan kata dengan benar",
                    "Menggunakan kalimat pasif dengan benar"
                ]
            ]
        ];

        foreach ($groups as $groupIndex => $g) {

            $group = AssessmentQuestionGroup::create([
                'assessment_type' => 'wicara_bahasa',
                'group_title' => $g['title'],
                'group_key' => $g['key'],
                'filled_by' => 'assessor',
                'sort_order' => 8,
            ]);

            foreach ($g['questions'] as $qIndex => $question) {
                AssessmentQuestion::create([
                    'group_id' => $group->id,
                    'assessment_type' => 'wicara_bahasa',
                    'section' => $g['key'],
                    'question_code' => "WB_" . $g['key'] . "_" . ($qIndex + 1),
                    'question_number' => $qIndex + 1,
                    'question_text' => $question,
                    'answer_type' => 'boolean',
                    'answer_options' => json_encode(["yes", "no"]),
                    'is_active' => true,
                ]);
            }
        }
    }
}
