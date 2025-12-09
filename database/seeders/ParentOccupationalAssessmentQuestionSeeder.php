<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentOccupationalAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $assessmentType = 'parent_okupasi';
        $filledBy = 'parent';
        $radio3 = ["Ya", "Tidak", "Kadang-kadang"];
        $yesOnly = ["Ya"];

        $categories = [
            [
                "key" => "general_auditory_language",
                "title" => "General — Apakah anak anda ...",
                "type" => "yes_only",
                "questions" => [
                    ["g_1", "Terlihat terlalu sensitif terhadap suara?"],
                    ["g_2", "Tidak dapat mengikuti instruksi sederhana?"],
                    ["g_3", "Bingung oleh kata-kata berbunyi sama?"],
                    ["g_4", "Hanya menggunakan bahasa tubuh untuk memperjelas ucapan?"],
                    ["g_5", "Suka menyanyi?"],
                    ["g_6", "Mengalami kesulitan dengan bunyi perkataan?"],
                    ["g_7", "Kelihatan menyimak tetapi tidak mengerti?"],
                    ["g_8", "Ragu-ragu untuk berbicara?"],
                    ["g_9", "Mengerti bahasa tubuh dan ekspresi wajah orang lain?"],
                ]
            ],

            [
                "key" => "gustatory_olfactory",
                "title" => "Tes Gustatori / Olfaktori",
                "type" => "radio3",
                "questions" => [
                    ["go_1", "Bertingkah seakan-akan semua makanan rasanya sama?"],
                    ["go_2", "Mengunyah benda-benda bukan makanan?"],
                    ["go_3", "Memiliki selera yang tidak biasa kepada makanan tertentu?"],
                    ["go_4", "Tidak menyukai makanan bertekstur tertentu?"],
                    ["go_5", "Mengeksplorasi dengan penciuman?"],
                    ["go_6", "Dapat membedakan bau?"],
                    ["go_7", "Bereaksi negatif terhadap bau?"],
                    ["go_8", "Tidak mempedulikan bau-bau yang tidak menyenangkan?"],
                ]
            ],

            [
                "key" => "visual",
                "title" => "Visual",
                "type" => "radio3",
                "questions" => [
                    ["v_1", "Tampak lebih senang gelap?"],
                    ["v_2", "Memungut gambar-gambar / objek dan memperhatikannya dengan detail dan teliti?"],
                    ["v_3", "Menjadi senang ketika ada bermacam-macam objek yang bisa dilihat?"],
                    ["v_4", "Sering berputar?"],
                    ["v_5", "Memakai kacamata?"],
                    ["v_6", "Mengalami kesulitan mengikuti objek yang digulirkan kepadanya?"],
                    ["v_7", "Mengalami kesulitan kontak mata dengan orang lain?"],
                    ["v_8", "Berpaling dari satu sisi ke sisi lain untuk melihat sesuatu?"],
                    ["v_9", "Cenderung menjangkau terlalu jauh ketika bermain, makan, dll"],
                ]
            ],

            [
                "key" => "tactile",
                "title" => "Taktil / Sensori Sentuhan",
                "type" => "radio3",
                "questions" => [
                    ["t_1", "Tidak mau bermain dengan barang 'kotor' (cat, lumpur, pasta, pasir, dll)?"],
                    ["t_2", "Tidak suka ketika wajah dilap / diseka?"],
                    ["t_3", "Kelihatan terganggu dengan tekstur kain tertentu?"],
                    ["t_4", "Tidak suka disentuh?"],
                    ["t_5", "Tidak suka disentuh secara tiba-tiba?"],
                    ["t_6", "Tidak suka dipeluk?"],
                    ["t_7", "Lebih suka menyentuh daripada disentuh?"],
                    ["t_8", "Menghindari menggunakan tangan untuk jangka waktu tertentu?"],
                    ["t_9", "Cenderung membenturkan kepala dengan sengaja dulu / sekarang?"],
                    ["t_10", "Mencubit, menggigit, atau menyakiti diri sendiri / atau orang lain?"],
                    ["t_11", "Memeriksa barang dengan memasukkannya ke dalam mulut?"],
                    ["t_12", "Cenderung untuk merasa sakit lebih dari orang lain?"],
                    ["t_13", "Secara berkala membentur atau mendorong anak lain?"],
                    ["t_14", "Tidak suka dikeramas?"],
                    ["t_15", "Tidak suka dipotong kuku?"],
                ]
            ],

            [
                "key" => "proprioseptif",
                "title" => "Proprioseptif",
                "type" => "radio3",
                "questions" => [
                    ["p_1", "Memegang tangan nya dalam posisi aneh?"],
                    ["p_2", "Memegangi tubuhnya dalam posisi aneh?"],
                    ["p_3", "Memiliki kemampuan baik untuk menirukan hal-hal kecil?"],
                    ["p_4", "Melakukan gerakan-gerakan cepat dan mengejutkan?"],
                    ["p_5", "Kesulitan berpindah dari satu posisi ke posisi lain?"],
                ]
            ],

            [
                "key" => "vestibular",
                "title" => "Vestibular — Keseimbangan & Gerak",
                "type" => "radio3",
                "questions" => [
                    ["vest_1", "Berayun saat duduk?"],
                    ["vest_2", "Banyak melompat?"],
                    ["vest_3", "Senang dilempar ke udara?"],
                    ["vest_4", "Memiliki keseimbangan yang baik?"],
                    ["vest_5", "Kelihatan takut terhadap ruang (misal: naik dan turun tangga, memasukki ruangan kecil tertutup)?"],
                    ["vest_6", "Suka naik komidi putar?"],
                    ["vest_7", "Berputar-putar lebih dari anak lain?"],
                    ["vest_8", "Mabuk kendaraan?"],
                    ["vest_9", "Senang diayun sekarang / ketika bayi?"],
                    ["vest_10", "Tidak takut bergerak/jatuh?"],
                    ["vest_11", "Menjadi gelisah saat perjalanan panjang dengan mobil?"],
                ]
            ],

            [
                "key" => "body_perception_reaction",
                "title" => "Persepsi Tubuh & Reaksi terhadap Lingkungan",
                "type" => "yes_only",
                "questions" => [
                    ["bpr_1", "Terganggu oleh sentuhan fisik dengan orang lain?"],
                    ["bpr_2", "Sangat tidak suka dipotong kukunya?"],
                    ["bpr_3", "Kelihatan takut dalam permainan keseimbangan dan memanjat?"],
                    ["bpr_4", "Berlebihan pada permainan berputar & berayun?"],
                    ["bpr_5", "Pasif saat berada dirumah?"],
                    ["bpr_6", "Sangat suka dipeluk dan dibelai?"],
                    ["bpr_7", "Memasukkan jari-jari / mainan ke mulut?"],
                    ["bpr_8", "Tidak suka tekstur makanan tertentu?"],
                    ["bpr_9", "Terganggu karena suara-sara ribut?"],
                    ["bpr_10", "Sangat suka menyentuh barang?"],
                    ["bpr_11", "Terganggu oleh tekstur tertentu?"],
                    ["bpr_12", "Memiliki ketidaksukaan ekstrem terhadap apapun?"],
                ]
            ],

            [
                "key" => "daily_living_skills",
                "title" => "Kemampuan Aktivitas Sehari-hari",
                "type" => "yes_only",
                "questions" => [
                    ["dls_1", "Mengatur emosi?"],
                    ["dls_2", "Berpakaian / melepas pakaian?"],
                    ["dls_3", "Memakai sepatu / kaos kaki?"],
                    ["dls_4", "Menalikan tali sepatu?"],
                    ["dls_5", "Memasang kancing?"],
                    ["dls_6", "Membersihkan diri (cuci muka, dll)?"],
                    ["dls_7", "Sikat gigi?"],
                    ["dls_8", "Menyisir rambut?"],
                    ["dls_9", "Berdiri di atas satu kaki?"],
                    ["dls_10", "Melompat di tempat?"],
                    ["dls_11", "Lompat tali?"],
                    ["dls_12", "Mengendarai sepeda?"],
                    ["dls_13", "Menggunakan peralatan di taman bermain?"],
                    ["dls_14", "Naik / turun tangga?"],
                ]
            ],

            [
                "key" => "behavior_social_statements",
                "title" => "Pernyataan Umum & Sosialisasi",
                "type" => "checkbox",
                "questions" => [
                    [
                        "bs_1",
                        "Pernyataan yang menggambarkan anak",
                        [
                            "Diam",
                            "Hiperaktif",
                            "Kesulitan memanajemen frustasi",
                            "Impulsif / tidak punya rasa takut terhadap bahaya",
                            "Tergila-gila pada perhatian",
                            "Menarik diri",
                            "Penasaran",
                            "Agresif",
                            "Pemalu",
                            "Bermasalah dengan sikapnya di rumah",
                            "Bermasalah dengan sikapnya di sekolah",
                            "Emosional",
                            "Memiliki ketakutan yang tidak biasa",
                            "Suka mengamuk",
                            "Memliki hubungan baik dengan saudara kandungnya",
                            "Mudah berteman",
                            "Mengerti peraturan permainan",
                            "Mengerti lelucon",
                            "Rigid/Kaku/Tidak fleksibel"
                        ]
                    ],

                    [
                        "bermain_anak",
                        "Bermain dengan anak-anak",
                        ["Lebih tua", "Lebih muda", "Seumuran"]
                    ]
                ]
            ],

            [
                "key" => "frequency_range",
                "title" => "Tingkat Kesesuaian / Frekuensi Perilaku",
                "type" => "slider",
                "questions" => [
                    ["f_1", "Mudah menyerah"],
                    ["f_2", "Mudah teralihkan perhatian"],
                    ["f_3", "Mengalami kesulitan duduk diam di kursi selama lebih dari 5 menit"],
                    ["f_4", "Tidak dapat berkonsentrasi lebih dari 20 menit"],
                    ["f_5", "Ceroboh dan sering menghilangkan barang pribadi"],
                    ["f_6", "Mengamuk tanpa alasan yang jelas"],
                    ["f_7", "Menolak mengikuti perintah walupun tidak mengerti perintah tersebut"],
                    ["f_8", "Tidak sabar menunggu giliran"],
                ]
            ],
        ];

        $order = 1;

        foreach ($categories as $cat) {
            $groupId = DB::table('assessment_question_groups')->insertGetId([
                'assessment_type' => $assessmentType,
                'group_title' => $cat['title'],
                'group_key' => $cat['key'],
                'filled_by' => $filledBy,
                'sort_order' => $order++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $questionNum = 1;

            foreach ($cat['questions'] as $q) {

                $questionCode = $q[0];
                $text = $q[1];

                $type = $cat['type'];

                $options = null;

                if ($type === "radio3") {
                    $options = $radio3;
                } elseif ($type === "yes_only") {
                    $options = $yesOnly;
                } elseif ($type === "checkbox") {
                    $options = $q[2] ?? [];
                }

                DB::table('assessment_questions')->insert([
                    'group_id' => $groupId,
                    'assessment_type' => $assessmentType,
                    'section' => $cat['key'],
                    'question_code' => $questionCode,
                    'question_number' => $questionNum++,
                    'question_text' => $text,
                    'answer_type' => $type,
                    'answer_options' => $options ? json_encode($options) : null,
                    'extra_schema' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
