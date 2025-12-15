<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestionGroup;
use App\Models\AssessmentQuestion;

class ParentPedagogicalAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $assessmentType = 'parent_paedagog';

        $sections = [

            // ============================================================
            // 1. ASPEK AKADEMIS
            // ============================================================
            "akademis" => [
                "title" => "Aspek Akademis",
                "questions" => [
                    ["id" => "pengukuran_iq", "text" => "Apakah pernah melakukan pengukuran IQ anak", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "jam_tambahan", "text" => "Apakah anak mengikuti jam tambahan yang bersifat akademis di sekolah?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],

                    ["id" => "skor_iq", "text" => "Jika Ya, berapa skor IQ", "type" => "text",
                        "extra" => [
                            "conditional_rules" => [[
                                "when" => 598,
                                "operator" => "==",
                                "value" => "Ya",
                                "required" => true
                            ]]
                        ]
                    ],

                    ["id" => "punya_gpk", "text" => "Apakah anak mempunyai Guru Pendamping Khusus (GPK) di sekolah?", "type" => "radio",
                        "extra" => ["options" => ["Ya", "Tidak"]]
                    ],
                    ["id" => "modifikasi_kurikulum", "text" => "Apakah ada modifikasi kurikulum dan materi yang dilakukan oleh GPK?", "type" => "radio",
                        "extra" => ["options" => ["Ya", "Tidak"]]
                    ],

                    ["id" => "posisi_duduk", "text" => "Dimana posisi tempat duduk anak di dalam kelas", "type" => "text"],
                    ["id" => "hobi", "text" => "Apa hobi anak?", "type" => "text"],

                    ["id" => "ikut_nonakademis", "text" => "Apakah anak mengikuti kegiatan non akademis guna mengembangkan bakatnya (beladiri, renang, sepak bola, dll)", "type" => "text",
                    ],

                    ["id" => "lokasi_nonakademis", "text" => "Dimana kegiatan pengembangan diri tersebut dilakukan?", "type" => "text"],
                    ["id" => "jadwal_nonakademis", "text" => "Kapan pengembangan diri tersebut dilakukan?", "type" => "text"],

                    ["id" => "fokus", "text" => "Apakah anak mampu fokus dalam pembelajaran?", "type" => "text"],
                    ["id" => "durasi_fokus", "text" => "Berapa lama ketahanan fokus anak?", "type" => "text"],
                    ["id" => "penarik_fokus", "text" => "Adakah ketertarikan anak terhadap benda-benda untuk menarik fokus kembali?", "type" => "text"],

                    ["id" => "belajar_rumah", "text" => "Apakah anak rutin belajar dirumah setiap hari?", "type" => "text"],
                    ["id" => "waktu_belajar", "text" => "Kapan waktu belajar anak dirumah?", "type" => "text"],
                    ["id" => "pendamping_belajar", "text" => "Siapa pendamping anak ketika belajar dirumah?", "type" => "text"],
                    ["id" => "suasana_belajar", "text" => "Bagaimana pengkondisian tempat dan suasana anak ketika belajar?", "type" => "text"],

                    ["id" => "mapel_suka", "text" => "Apa mata pelajaran yang disenangi anak?", "type" => "text"],
                    ["id" => "mapel_tidak_suka", "text" => "Apa mata pelajaran yang kurang disenangi anak?", "type" => "text"],
                ]
            ],

            // ============================================================
            // 2. ASPEK KETUNAAN → DIPECAH JADI GROUP TERPISAH
            // ============================================================

            "ketunaan_visual" => [
                "title" => "Aspek Ketunaan - Visual",
                "questions" => [
                    ["id" => "v1", "text" => "Apakah anak anda mengalami gangguan visual?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "v2", "text" => "Apakah anak pernah/sedang memakai kacamata baca?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "v3", "text" => "Apakah anak nyaman bila membaca sambil duduk?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "v4", "text" => "Apakah anak nyaman bila membaca sambil berbaring/tengkurap/tiduran?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "v5", "text" => "Apakah anak tertarik dengan kegiatan belajar atau memperoleh informasi baru?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "v6", "text" => "Berapa lama anak mengeksplore gadget? (per hari)", "type" => "text", "extra" => ["placeholder" => "/Hari"]],
                ]
            ],

            "ketunaan_auditori" => [
                "title" => "Aspek Ketunaan - Auditori",
                "questions" => [
                    ["id" => "a1", "text" => "Apakah anak mengalami gangguan auditori?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "a2", "text" => "Apakah anak sedang/pernah memakai alat bantu dengar (ABD)?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "a3", "text" => "Apakah anak langsung merespon jika namanya dipanggil?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "a4", "text" => "Apakah anak lebih suka mendengar musik / menyanyi?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "a5", "text" => "Apakah anak lebih menyukai suasana yang tenang ketika belajar?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "a6", "text" => "Apakah anak pernah/sering menunjukkan respon ketidaksukaannya dengan menutup telinga?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "a7", "text" => "Apakah anak sering memakai headset?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                ]
            ],

            "ketunaan_motorik" => [
                "title" => "Aspek Ketunaan - Motorik",
                "questions" => [
                    ["id" => "m1", "text" => "Apakah anak mengalami gangguan motorik?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "m2", "text" => "Jika YA bagian yang mengalami gangguan?", "type" => "radio", "extra" => ["options" => ["Motorik Halus", "Motorik Kasar"]]],
                    ["id" => "m3", "text" => "Bentuk gangguan berupa?", "type" => "text"],
                    ["id" => "m4", "text" => "Apakah anak mengalami kesulitan dalam mobilisasi secara mandiri?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "m5", "text" => "Apakah anak mengalami kekakuan / kelayuan pada bagian tubuh tertentu?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                ]
            ],

            "ketunaan_kognitif" => [
                "title" => "Aspek Ketunaan - Kognitif",
                "questions" => [
                    ["id" => "k1", "text" => "Apakah anak mengalami gangguan kognitif?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "k2", "text" => "Apakah anak perlu penjabaran dalam mengelola informasi?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "k3", "text" => "Apakah anak tanggap terhadap sesuatu yang tiba-tiba terjadi?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "k4", "text" => "Kegiatan yang paling diminati anak?", "type" => "radio", "extra" => ["options" => ["Membaca", "Menulis", "Berhitung"]]],
                    ["id" => "k5", "text" => "Apakah anak tertarik dengan kegiatan belajar atau memperoleh informasi baru?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                ]
            ],

            "ketunaan_perilaku" => [
                "title" => "Aspek Ketunaan - Perilaku",
                "questions" => [
                    ["id" => "p1", "text" => "Apakah anak mengalami masalah perilaku?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "p2", "text" => "Apakah anak mudah berteman dengan teman sebayanya?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "p3", "text" => "Apakah anak mengalami perubahan mood / “mood swing” yang cepat?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "p4", "text" => "Apakah anak suka kekerasan dalam melampiaskan emosinya?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "p5", "text" => "Apakah anak cenderung nyaman menyendiri?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                    ["id" => "p6", "text" => "Apakah anak enggan menyapa / tersenyum terlebih dahulu dengan orang lain?", "type" => "radio", "extra" => ["options" => ["Ya", "Tidak"]]],
                ]
            ],

            // ============================================================
            // 3. ASPEK SOSIALISASI
            // ============================================================
            "sosialisasi" => [
                "title" => "Aspek Sosialisasi",
                "questions" => [
                    ["id" => "s1", "text" => "Bagaimana sikap anak ketika bertemu dengan orang-orang baru?", "type" => "text"],
                    ["id" => "s2", "text" => "Bagaimana sikap anak ketika berteman dengan teman-teman yang biasa ditemuinya?", "type" => "text"],
                    ["id" => "s3", "text" => "Apakah anak sering / tidak pernah mengawali pembicaraan?", "type" => "text"],
                    ["id" => "s4", "text" => "Apakah anak aktif ketika diajak bicara dengan orangtua atau anggota keluarga yang lain?", "type" => "text"],
                    ["id" => "s5", "text" => "Bagaimana sikap anak ketika ditempatkan pada situasi yang membuatnya kurang nyaman?", "type" => "text"],
                    ["id" => "s6", "text" => "Apakah anak bisa berbagi mainan/makanan ketika sedang bersama teman-teman?", "type" => "text"],
                ]
            ]

        ];

        $sort = 1;

        foreach ($sections as $key => $section) {

            $group = AssessmentQuestionGroup::create([
                'assessment_type' => $assessmentType,
                'group_title' => $section['title'],
                'group_key' => $key,
                'filled_by' => 'parent',
                'sort_order' => $sort++,
            ]);

            $order = 1;

            foreach ($section['questions'] as $q) {

                $answerOptions = isset($q['extra']['options'])
                    ? json_encode($q['extra']['options'])
                    : null;

                $extraSchema = isset($q['extra'])
                    ? json_encode($q['extra'])
                    : null;

                AssessmentQuestion::create([
                    'group_id' => $group->id,
                    'assessment_type' => $assessmentType,
                    'section' => $key,
                    'question_code' => strtoupper("PPD-" . $key . "-" . $order),
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
