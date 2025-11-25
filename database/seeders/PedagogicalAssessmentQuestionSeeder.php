<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentQuestionGroup;

class PedagogicalAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['key' => 'reading', 'title' => 'Membaca', 'questions' => [
                "Anak mampu mengenal huruf",
                "Anak mampu mengenal simbol huruf",
                "Anak mampu menyebutkan huruf A-Z secara berurutan",
                "Anak mampu mengucapkan huruf yang tepat dan benar",
                "Anak mampu membaca bunyi vokal (a,i,u,e,o)",
                "Anak mampu membaca bunyi konsonan",
                "Anak mampu membaca kata yang diminta",
                "Anak mampu membaca kalimat",
                "Anak mampu membaca sepintas/cepat",
                "Anak mampu membaca isi bacaan",
            ]],
            ['key' => 'writing', 'title' => 'Menulis', 'questions' => [
                "Anak mampu memegang alat tulis",
                "Anak mampu menulis garis lurus keatas kebawah",
                "Anak mampu menulis garis lurus kekanan kekiri",
                "Anak mampu menulis garis melingkar",
                "Anak mampu menulis huruf dengan lurus",
                "Anak mampu menyalin huruf",
                "Anak mampu menulis namanya sendiri",
                "Anak mampu mengenal dan menulis kata atau kalimat yang diminta",
                "Anak mampu mengenal dan menulis huruf besar atau huruf kecil alfabet",
                "Anak mampu membedakan huruf dengan kesamaan bentuk (b,d,p,q atau m,n,w)",
                "Anak mampu membuat kalimat sederhana",
                "Anak mampu menulis cerita berdasarkan gambar",
            ]],
            ['key' => 'counting', 'title' => 'Berhitung', 'questions' => [
                "Anak mampu mengenal bentuk angka 1-10 dengan urut",
                "Anak mampu menghitung benda konkret (1-50)",
                "Anak mampu memahami perbandingan banyak sedikit angka",
                "Anak mampu mengenal tanda operasi hitung bilangan (+,-,x,:)",
                "Anak mampu mengoperasikan penjumlahan dan pengurangan",
                "Anak mampu mengoperasikan perkalian dan pembagian",
                "Anak mampu mengoperasikan alat bantu hitung",
            ]],
            ['key' => 'readiness', 'title' => 'Kesiapan Belajar', 'questions' => [
                "Anak mampu mengikuti instruksi (konsentrasi)",
                "Anak mampu duduk dalam waktu yang ditentukan untuk mengikuti instruksi guru",
                "Anak bergerak aktif tidak dapat duduk tenang",
                "Anak menunjukkan inisiasi (tidak pasif) dalam belajar",
                "Anak bersikap kooperatif",
                "Anak menunjukkan sikap antusias (mood) dalam belajar",
                "Anak mampu menyelesaikan tugas sampai tuntas",
            ]],
            ['key' => 'general', 'title' => 'Pengetahuan Umum', 'questions' => [
                "Anak mengetahui identitas diri",
                "Anak menunjukkan anggota tubuh",
                "Anak memiliki pemahaman perbedaan rasa pada indera pengecapan",
                "Anak mampu mengidentifikasikan warna",
                "Anak mampu memahami besar kecil, berat ringan, luas sempit",
                "Anak mampu memahami orientasi waktu (pagi, siang, malam, jam, hari, bulan, tahun)",
                "Anak mampu mengekspresikan wajah (emosi)",
            ]],
        ];

        $defaultOptions = [1, 2, 3, 4, 5];

        foreach ($groups as $gIndex => $g) {

            $group = AssessmentQuestionGroup::create([
                'assessment_type' => 'paedagog',
                'group_title'     => $g['title'],
                'group_key'       => $g['key'],
                'filled_by'       => 'assessor',
                'sort_order'      => $gIndex + 1,
            ]);

            foreach ($g['questions'] as $qIndex => $text) {

                AssessmentQuestion::create([
                    'group_id'        => $group->id,
                    'assessment_type' => 'paedagog',
                    'section'         => $g['key'],
                    'question_code'   => 'PDG_' . strtoupper($g['key']) . '_' . ($qIndex + 1),
                    'question_number' => $qIndex + 1,
                    'question_text'   => $text,
                    'answer_type'     => 'score_with_note',
                    'answer_options'  => json_encode($defaultOptions),
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
    }
}
