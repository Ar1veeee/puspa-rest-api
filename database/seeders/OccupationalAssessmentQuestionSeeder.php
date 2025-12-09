<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentQuestionGroup;

class OccupationalAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $scoreOptions = [0, 1, 2, 3];

        $groups = [
            'A' => [
                'title' => 'Mengukur kemampuan sense of bodily self',
                'root'  => 'bodily_self_sense',
                'items' => [
                    ['no' => 1, 'aspect' => 'State & Temperamen', 'key' => 'temperament', 'subs' => [
                        ['label' => 'Kesiapan', 'key' => 'alertness'],
                        ['label' => 'Kooperatif', 'key' => 'cooperative'],
                        ['label' => 'Pemalu (Shyness)', 'key' => 'shyness'],
                        ['label' => 'Mudah Tersinggung', 'key' => 'easily_offended'],
                        ['label' => 'Happiness', 'key' => 'happiness'],
                        ['label' => 'Physically Fit', 'key' => 'physically_fit'],
                    ]],
                    ['no' => 2, 'aspect' => 'Perilaku', 'key' => 'behavior', 'subs' => [
                        ['label' => 'Aktif/Normal', 'key' => 'active'],
                        ['label' => 'Agresif/Melawan', 'key' => 'aggressive'],
                        ['label' => 'Temper Tantrum', 'key' => 'tantrum'],
                        ['label' => 'Mengasingkan Diri', 'key' => 'self_aware'],
                        ['label' => 'Impulsif', 'key' => 'impulsive'],
                    ]],
                    ['no' => 3, 'aspect' => 'Identitas', 'key' => 'identity', 'subs' => [
                        ['label' => 'Nama Panggilan', 'key' => 'nickname'],
                        ['label' => 'Nama Lengkap', 'key' => 'full_name'],
                        ['label' => 'Usia', 'key' => 'age'],
                    ]],
                ]
            ],

            'B' => [
                'title' => 'Keseimbangan diri, posisi ruang, perencanaan gerak',
                'root'  => 'balance_coordination',
                'items' => [
                    ['no' => 1, 'aspect' => 'Diskriminasi kanan/kiri', 'key' => 'right_left', 'subs' => [
                        ['label' => 'Memakai sepatu / sandal', 'key' => 'shoe_wear'],
                        ['label' => 'Identifikasi kanan/kiri', 'key' => 'identify_left_right'],
                    ]],
                    ['no' => 2, 'aspect' => 'Posisi dalam ruang', 'key' => 'spatial_position', 'subs' => [
                        ['label' => 'Atas-bawah', 'key' => 'up_down'],
                        ['label' => 'Luar-dalam', 'key' => 'out_in'],
                        ['label' => 'Depan-belakang', 'key' => 'front_back'],
                        ['label' => 'Tengah', 'key' => 'middle_side'],
                        ['label' => 'Pinggir', 'key' => 'edge_side'],
                    ]],
                    ['no' => 3, 'aspect' => 'Motorik Kasar', 'key' => 'gross_motor', 'subs' => [
                        ['label' => 'Berjalan ke depan', 'key' => 'walk_forward'],
                        ['label' => 'Berjalan ke belakang', 'key' => 'walk_backward'],
                        ['label' => 'Berjalan menyamping', 'key' => 'walk_sideways'],
                        ['label' => 'Meniti', 'key' => 'tiptoe'],
                        ['label' => 'Berlari', 'key' => 'running'],
                        ['label' => 'Berdiri satu kaki', 'key' => 'stand_one_foot'],
                        ['label' => 'Melompat satu kaki', 'key' => 'jump_one_foot'],
                    ]],
                ]
            ],

            'C' => [
                'title' => 'Konsentrasi, instruksi, problem solving',
                'root'  => 'concentration_problem_solving',
                'items' => [
                    ['no' => 1, 'aspect' => 'Konsentrasi & Atensi', 'key' => 'attention', 'subs' => [
                        ['label' => 'Mengikuti perintah', 'key' => 'follow_commands'],
                        ['label' => '2 perintah', 'key' => 'two_commands'],
                        ['label' => '3 perintah', 'key' => 'three_commands'],
                        ['label' => '4 perintah', 'key' => 'four_commands'],
                        ['label' => 'Mencari kelonggaran gambar', 'key' => 'visual_search'],
                    ]],
                    ['no' => 2, 'aspect' => 'Problem Solving', 'key' => 'problem_solving', 'subs' => [
                        ['label' => 'Puzzle matching 4,8,12', 'key' => 'puzzle'],
                        ['label' => 'Soal cerita', 'key' => 'story_question'],
                    ]],
                    ['no' => 3, 'aspect' => 'Pemahaman ukuran', 'key' => 'size_comprehension', 'subs' => [
                        ['label' => 'Besar/kecil', 'key' => 'big_small'],
                        ['label' => 'Tinggi/rendah', 'key' => 'tall_short'],
                        ['label' => 'Banyak/sedikit', 'key' => 'many_few'],
                        ['label' => 'Panjang/pendek', 'key' => 'long_short'],
                    ]],
                    ['no' => 4, 'aspect' => 'Pengenalan angka', 'key' => 'number_recognition', 'subs' => [
                        ['label' => 'Menghitung maju', 'key' => 'count_forward'],
                        ['label' => 'Menghitung mundur', 'key' => 'count_backward'],
                        ['label' => 'Pengenalan simbol', 'key' => 'symbol'],
                        ['label' => 'Pengenalan konsep', 'key' => 'concept'],
                    ]],
                ]
            ],

            'D' => [
                'title' => 'Konsep huruf, warna, anggota tubuh, orientasi waktu',
                'root'  => 'concepts_orientation',
                'items' => [
                    ['no' => 1, 'aspect' => 'Pengenalan huruf', 'key' => 'letter_recognition', 'subs' => [
                        ['label' => 'Menunjukan huruf', 'key' => 'show_letter'],
                        ['label' => 'Membaca', 'key' => 'reading'],
                        ['label' => 'Menulis', 'key' => 'writing'],
                        ['label' => 'Menulis nama di blangko', 'key' => 'write_name_form'],
                        ['label' => 'Menuli abjad dengan urut', 'key' => 'write_alphabet'],
                    ]],
                    ['no' => 2, 'aspect' => 'Pemahaman warna', 'key' => 'color_comprehension', 'subs' => [
                        ['label' => 'Menunjuk', 'key' => 'pointing'],
                        ['label' => 'Membedakan', 'key' => 'differentiating'],
                    ]],
                    ['no' => 3, 'aspect' => 'Body awareness', 'key' => 'body_awareness', 'subs' => [
                        ['label' => 'Menyebutkan bagian wajah', 'key' => 'face_parts'],
                        ['label' => 'Anggota tubuh', 'key' => 'body_parts'],
                    ]],
                    ['no' => 4, 'aspect' => 'Orientasi waktu', 'key' => 'time_orientation', 'subs' => [
                        ['label' => 'Siang / malam', 'key' => 'day_night'],
                        ['label' => 'Mengetahui hari', 'key' => 'know_day'],
                        ['label' => 'Tanggal / bulan / tahun', 'key' => 'date_month_year'],
                    ]],
                ]
            ],

            'E' => [
                'title' => 'Motoric Planning, Bilateral, Menggunting, Memori',
                'root'  => 'motoric_planning',
                'items' => [
                    ['no' => 1, 'aspect' => 'Bilateral skill', 'key' => 'bilateral_skill', 'subs' => [
                        ['label' => 'Meronce manik-manik', 'key' => 'stringing_beads'],
                        ['label' => 'Membalik halaman buku', 'key' => 'flipping_pages'],
                        ['label' => 'Menjahit', 'key' => 'sewing'],
                    ]],
                    ['no' => 2, 'aspect' => 'Menggunting', 'key' => 'cutting', 'subs' => [
                        ['label' => 'Tanpa pola', 'key' => 'no_line'],
                        ['label' => 'Garis lurus', 'key' => 'straight_line'],
                        ['label' => 'Zig-zag', 'key' => 'zigzag_line'],
                        ['label' => 'Ombak', 'key' => 'wave_line'],
                        ['label' => 'Kotak', 'key' => 'box_shape'],
                    ]],
                    ['no' => 3, 'aspect' => 'Memori', 'key' => 'memory', 'subs' => [
                        ['label' => 'Mengingat 3–5 objek', 'key' => 'recall_objects'],
                        ['label' => 'Menyanyi', 'key' => 'singing'],
                    ]],
                ]
            ],

            'F' => [
                'title' => 'Laporan Akhir Okupasi',
                'root'  => 'final_report',
                'items' => [
                    [
                        'label' => 'Catatan',
                        'key'   => 'notes',
                        'type'  => 'textarea'
                    ],
                    [
                        'label' => 'Hasil Assessment',
                        'key'   => 'assessment_result',
                        'type'  => 'textarea'
                    ],
                    [
                        'label' => 'Rekomendasi Terapi',
                        'key'   => 'recommendation',
                        'type'  => 'checkbox',
                        'options' => [
                            'paedagog',
                            'okupasi',
                            'wicara',
                            'fisio'
                        ]
                    ]
                ]
            ]
        ];

        $sortOrder = 1;

        foreach ($groups as $groupDef) {

            $group = AssessmentQuestionGroup::create([
                'assessment_type' => 'okupasi',
                'group_title'     => $groupDef['title'],
                'group_key'       => $groupDef['root'],
                'filled_by'       => 'assessor',
                'sort_order'      => $sortOrder++,
            ]);

            if (isset($groupDef['items'][0]['subs'])) {

                foreach ($groupDef['items'] as $item) {

                    foreach ($item['subs'] as $index => $sub) {

                        AssessmentQuestion::create([
                            'group_id'        => $group->id,
                            'assessment_type' => 'okupasi',
                            'section'         => $groupDef['root'],
                            'question_code'   => "OT_{$groupDef['root']}_{$item['key']}_{$sub['key']}",
                            'question_number' => ($item['no'] * 100) + ($index + 1),
                            'question_text'   => $item['aspect'] . ' — ' . $sub['label'],
                            'answer_type'     => 'score_with_note',
                            'answer_options'  => json_encode($scoreOptions),
                            'extra_schema'    => json_encode([
                                "columns" => [
                                    ["key" => "score", "label" => "Penilaian", "type" => "select"],
                                    ["key" => "note",  "label" => "Keterangan", "type" => "text"]
                                ]
                            ]),
                            'is_active'       => true,
                        ]);
                    }
                }

                continue;
            }

            foreach ($groupDef['items'] as $order => $question) {

                AssessmentQuestion::create([
                    'group_id'        => $group->id,
                    'assessment_type' => 'okupasi',
                    'section'         => $groupDef['root'],
                    'question_code'   => "OT_{$groupDef['root']}_" . strtoupper($question['key']),
                    'question_number' => $order + 1,
                    'question_text'   => $question['label'],
                    'answer_type'     => $question['type'],
                    'answer_options'  => isset($question['options'])
                        ? json_encode($question['options'])
                        : null,
                    'extra_schema' => null,
                    'is_active' => true
                ]);
            }
        }
    }
}
