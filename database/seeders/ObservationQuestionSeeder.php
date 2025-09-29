<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObservationQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('observation_questions')->truncate();

        $questions = [
            //==================
            // Usia Balita
            //==================
            // Perilaku & Emosi (BPE)
            ['question_code' => 'BPE-01', 'age_category' => 'balita', 'question_number' => 1, 'question_text' => 'Hipoaktif atau bergerak tidak bertujuan', 'score' => 3],
            ['question_code' => 'BPE-02', 'age_category' => 'balita', 'question_number' => 2, 'question_text' => 'Hipoaktif atau lamban gerak', 'score' => 3],
            ['question_code' => 'BPE-03', 'age_category' => 'balita', 'question_number' => 3, 'question_text' => 'Tidak mampu mengikuti aturan', 'score' => 2],
            ['question_code' => 'BPE-04', 'age_category' => 'balita', 'question_number' => 4, 'question_text' => 'Menyakiti diri sendiri', 'score' => 3],
            ['question_code' => 'BPE-05', 'age_category' => 'balita', 'question_number' => 5, 'question_text' => 'Menyerang orang lain ketika marah', 'score' => 1],
            ['question_code' => 'BPE-06', 'age_category' => 'balita', 'question_number' => 6, 'question_text' => 'Perilaku repetitif atau berulang-ulang', 'score' => 3],
            ['question_code' => 'BPE-07', 'age_category' => 'balita', 'question_number' => 7, 'question_text' => 'Tidak dapat duduk tenang', 'score' => 1],
            ['question_code' => 'BPE-08', 'age_category' => 'balita', 'question_number' => 8, 'question_text' => 'Anak Jalan jinjit', 'score' => 2],

            // Fisik & Motorik (BFM)
            ['question_code' => 'BFM-01', 'age_category' => 'balita', 'question_number' => 9, 'question_text' => 'Kelainan pada anggota tubuh atau pemakaian alat bantu', 'score' => 1],
            ['question_code' => 'BFM-02', 'age_category' => 'balita', 'question_number' => 10, 'question_text' => 'Tidak mampu melompat', 'score' => 2],
            ['question_code' => 'BFM-03', 'age_category' => 'balita', 'question_number' => 11, 'question_text' => 'Tidak mampu mengikuti contoh gerakan seperti senam', 'score' => 1],
            ['question_code' => 'BFM-04', 'age_category' => 'balita', 'question_number' => 12, 'question_text' => 'Tidak mampu membuat bentuk sederhana dari playdough', 'score' => 2],
            ['question_code' => 'BFM-05', 'age_category' => 'balita', 'question_number' => 13, 'question_text' => 'Tidak mampu merobek kertas', 'score' => 2],

            // Bahasa & Bicara (BBB)
            ['question_code' => 'BBB-01', 'age_category' => 'balita', 'question_number' => 14, 'question_text' => 'Saat ditanya mengulang pertanyaan atau perkataan', 'score' => 1],
            ['question_code' => 'BBB-02', 'age_category' => 'balita', 'question_number' => 15, 'question_text' => 'Tidak mampu memahami perintah/instruksi', 'score' => 2],
            ['question_code' => 'BBB-03', 'age_category' => 'balita', 'question_number' => 16, 'question_text' => 'Tidak mampu berkomunikasi 2 arah/tanya jawab', 'score' => 3],

            // Kognitif & Akademik (BKA)
            ['question_code' => 'BKA-01', 'age_category' => 'balita', 'question_number' => 17, 'question_text' => 'Tidak mampu menyelesaikan aktifitas', 'score' => 2],
            ['question_code' => 'BKA-02', 'age_category' => 'balita', 'question_number' => 18, 'question_text' => 'Tidak mampu mempertahankan atensi dan konsentrasi ketika diberi tugas', 'score' => 2],
            ['question_code' => 'BKA-03', 'age_category' => 'balita', 'question_number' => 19, 'question_text' => 'Tidak mampu menyebutkan identitas diri dan anggota keluarga', 'score' => 3],
            ['question_code' => 'BKA-04', 'age_category' => 'balita', 'question_number' => 20, 'question_text' => 'Tidak mampu menamai benda sekitar', 'score' => 3],
            ['question_code' => 'BKA-05', 'age_category' => 'balita', 'question_number' => 21, 'question_text' => 'Tidak mampu menyebutkan angka 1-5', 'score' => 1],
            ['question_code' => 'BKA-06', 'age_category' => 'balita', 'question_number' => 22, 'question_text' => 'Tidak mampu mengidentifikasi bentuk (minimal 1 bentuk konsisten)', 'score' => 1],
            ['question_code' => 'BKA-07', 'age_category' => 'balita', 'question_number' => 23, 'question_text' => 'Tidak mampu mengidentifikasi warna primer', 'score' => 2],

            // Sosialisasi (BS)
            ['question_code' => 'BS-01', 'age_category' => 'balita', 'question_number' => 24, 'question_text' => 'Tidak ada kontak mata/kontak mata minim saat diajak berbicara', 'score' => 2],
            ['question_code' => 'BS-02', 'age_category' => 'balita', 'question_number' => 25, 'question_text' => 'Suka menyendiri', 'score' => 1],
            ['question_code' => 'BS-03', 'age_category' => 'balita', 'question_number' => 26, 'question_text' => 'Kesulitan beradaptasi dengan lingkungan baru', 'score' => 2],

            //====================
            // Usia Anak-anak
            //====================
            // Perilaku & Emosi (APE)
            ['question_code' => 'APE-01', 'age_category' => 'anak-anak', 'question_number' => 1, 'question_text' => 'Hiperaktif atau bergerak tidak bertujuan', 'score' => 3],
            ['question_code' => 'APE-02', 'age_category' => 'anak-anak', 'question_number' => 2, 'question_text' => 'Hipoaktif atau lamban gerak', 'score' => 3],
            ['question_code' => 'APE-03', 'age_category' => 'anak-anak', 'question_number' => 3, 'question_text' => 'Tidak mampu mengikuti aturan', 'score' => 3],
            ['question_code' => 'APE-04', 'age_category' => 'anak-anak', 'question_number' => 4, 'question_text' => 'Menyakiti diri sendiri atau menyerang orang lain ketika marah', 'score' => 3],
            ['question_code' => 'APE-05', 'age_category' => 'anak-anak', 'question_number' => 5, 'question_text' => 'Perilaku Repetitif atau berulang-ulang', 'score' => 3],
            ['question_code' => 'APE-06', 'age_category' => 'anak-anak', 'question_number' => 6, 'question_text' => 'Tidak dapat duduk tenang', 'score' => 3],

            // Fisik & Motorik (AFM)
            ['question_code' => 'AFM-01', 'age_category' => 'anak-anak', 'question_number' => 7, 'question_text' => 'Kelainan pada anggota tubuh atau pemakaian alat bantu', 'score' => 1],
            ['question_code' => 'AFM-02', 'age_category' => 'anak-anak', 'question_number' => 8, 'question_text' => 'Tidak mampu melompat', 'score' => 1],
            ['question_code' => 'AFM-03', 'age_category' => 'anak-anak', 'question_number' => 9, 'question_text' => 'Tidak mampu mengikuti contoh gerakan seperti senam', 'score' => 2],
            ['question_code' => 'AFM-04', 'age_category' => 'anak-anak', 'question_number' => 10, 'question_text' => 'Tidak mampu menggunting', 'score' => 2],
            ['question_code' => 'AFM-05', 'age_category' => 'anak-anak', 'question_number' => 11, 'question_text' => 'Tidak mampu melipat kertas', 'score' => 2],

            // Bahasa & Bicara (ABB)
            ['question_code' => 'ABB-01', 'age_category' => 'anak-anak', 'question_number' => 12, 'question_text' => 'Saat ditanya Mengulang pertanyaan atau perkataan', 'score' => 1],
            ['question_code' => 'ABB-02', 'age_category' => 'anak-anak', 'question_number' => 13, 'question_text' => 'Tidak mampu memahami perintah/instruksi', 'score' => 2],
            ['question_code' => 'ABB-03', 'age_category' => 'anak-anak', 'question_number' => 14, 'question_text' => 'Tidak mampu berkomunikasi 2 arah/tanya jawab', 'score' => 3],

            // Kognitif & Akademik (AKA)
            ['question_code' => 'AKA-01', 'age_category' => 'anak-anak', 'question_number' => 15, 'question_text' => 'Tidak mampu menyelesaikan tugas', 'score' => 2],
            ['question_code' => 'AKA-02', 'age_category' => 'anak-anak', 'question_number' => 16, 'question_text' => 'Tidak mampu mempertahankan atensi dan konsentrasi ketika diberi tugas', 'score' => 2],
            ['question_code' => 'AKA-03', 'age_category' => 'anak-anak', 'question_number' => 17, 'question_text' => 'Tidak mampu menyebutkan identitas diri dan anggota keluarga', 'score' => 3],
            ['question_code' => 'AKA-04', 'age_category' => 'anak-anak', 'question_number' => 18, 'question_text' => 'Tidak mampu menamai benda sekitar', 'score' => 3],
            ['question_code' => 'AKA-05', 'age_category' => 'anak-anak', 'question_number' => 19, 'question_text' => 'Tidak mampu mengurutkan angka 1-10', 'score' => 1],
            ['question_code' => 'AKA-06', 'age_category' => 'anak-anak', 'question_number' => 20, 'question_text' => 'Tidak mampu mengurutkan abjad A-Z', 'score' => 1],

            // Sosialisasi (AS)
            ['question_code' => 'AS-01', 'age_category' => 'anak-anak', 'question_number' => 21, 'question_text' => 'Tidak ada kontak mata/kontak mata minim saat diajak berbicara', 'score' => 2],
            ['question_code' => 'AS-02', 'age_category' => 'anak-anak', 'question_number' => 22, 'question_text' => 'Suka menyendiri', 'score' => 1],
            ['question_code' => 'AS-03', 'age_category' => 'anak-anak', 'question_number' => 23, 'question_text' => 'Tidak mau berbagi dengan teman/egois', 'score' => 1],
            ['question_code' => 'AS-04', 'age_category' => 'anak-anak', 'question_number' => 24, 'question_text' => 'Kesulitan beradaptasi dengan lingkungan baru', 'score' => 2],

            //==================
            // Usia Remaja
            //==================
            // Perilaku & Emosi (RPE)
            ['question_code' => 'RPE-01', 'age_category' => 'remaja', 'question_number' => 1, 'question_text' => 'Hiperaktif atau bergerak tidak bertujuan', 'score' => 3],
            ['question_code' => 'RPE-02', 'age_category' => 'remaja', 'question_number' => 2, 'question_text' => 'Hipoaktif atau lamban gerak', 'score' => 3],
            ['question_code' => 'RPE-03', 'age_category' => 'remaja', 'question_number' => 3, 'question_text' => 'Tidak mampu mengikuti aturan', 'score' => 3],
            ['question_code' => 'RPE-04', 'age_category' => 'remaja', 'question_number' => 4, 'question_text' => 'Menyakiti diri sendiri atau menyerang orang lain', 'score' => 3],
            ['question_code' => 'RPE-05', 'age_category' => 'remaja', 'question_number' => 5, 'question_text' => 'Perilaku Repetitif atau berulang-ulang', 'score' => 3],
            ['question_code' => 'RPE-06', 'age_category' => 'remaja', 'question_number' => 6, 'question_text' => 'Tidak dapat duduk tenang', 'score' => 3],
            ['question_code' => 'RPE-07', 'age_category' => 'remaja', 'question_number' => 7, 'question_text' => 'Ketertarikan berlebih terhadap lawan jenis', 'score' => 3],
            ['question_code' => 'RPE-08', 'age_category' => 'remaja', 'question_number' => 8, 'question_text' => 'Emosi yang meledak-ledak', 'score' => 3],

            // Fisik & Motorik (RFM)
            ['question_code' => 'RFM-01', 'age_category' => 'remaja', 'question_number' => 9, 'question_text' => 'Kelainan pada anggota tubuh atau pemakaian alat bantu', 'score' => 1],
            ['question_code' => 'RFM-02', 'age_category' => 'remaja', 'question_number' => 10, 'question_text' => 'Tidak mampu menganyam', 'score' => 3],

            // Bahasa & Bicara (RBB)
            ['question_code' => 'RBB-01', 'age_category' => 'remaja', 'question_number' => 11, 'question_text' => 'Saat ditanya mengulang pertanyaan atau perkataan', 'score' => 3],
            ['question_code' => 'RBB-02', 'age_category' => 'remaja', 'question_number' => 12, 'question_text' => 'Tidak mampu memahami perintah/instruksi tiga tahap', 'score' => 3],
            ['question_code' => 'RBB-03', 'age_category' => 'remaja', 'question_number' => 13, 'question_text' => 'Tidak mampu berkomunikasi 2 arah/tanya jawab', 'score' => 3],

            // Kognitif & Akademik (RKA)
            ['question_code' => 'RKA-01', 'age_category' => 'remaja', 'question_number' => 14, 'question_text' => 'Tidak mampu menyelesaikan tugas', 'score' => 3],
            ['question_code' => 'RKA-02', 'age_category' => 'remaja', 'question_number' => 15, 'question_text' => 'Tidak mampu mempertahankan atensi dan konsentrasi ketika diberi tugas', 'score' => 3],
            ['question_code' => 'RKA-03', 'age_category' => 'remaja', 'question_number' => 16, 'question_text' => 'Tidak mampu menceritakan diri sendiri', 'score' => 3],
            ['question_code' => 'RKA-04', 'age_category' => 'remaja', 'question_number' => 17, 'question_text' => 'Tidak mampu operasi hitung sederhana', 'score' => 2],
            ['question_code' => 'RKA-05', 'age_category' => 'remaja', 'question_number' => 18, 'question_text' => 'Tidak mampu membaca paragraf sederhana', 'score' => 2],

            // Sosialisasi (RS)
            ['question_code' => 'RS-01', 'age_category' => 'remaja', 'question_number' => 19, 'question_text' => 'Tidak ada kontak mata/kontak mata minim saat diajak berbicara', 'score' => 3],
            ['question_code' => 'RS-02', 'age_category' => 'remaja', 'question_number' => 20, 'question_text' => 'Suka menyendiri', 'score' => 1],
            ['question_code' => 'RS-03', 'age_category' => 'remaja', 'question_number' => 21, 'question_text' => 'Kesulitan beradaptasi dengan lingkungan baru', 'score' => 2],

            // Kemandirian (RK)
            ['question_code' => 'RK-01', 'age_category' => 'remaja', 'question_number' => 22, 'question_text' => 'Tidak bisa mengancing baju sendiri', 'score' => 3],
            ['question_code' => 'RK-02', 'age_category' => 'remaja', 'question_number' => 23, 'question_text' => 'Tidak bisa toilet training', 'score' => 3],
            ['question_code' => 'RK-03', 'age_category' => 'remaja', 'question_number' => 24, 'question_text' => 'Tidak berpenampilan rapi dan sopan', 'score' => 1],
            ['question_code' => 'RK-04', 'age_category' => 'remaja', 'question_number' => 25, 'question_text' => 'Tidak mengenal mata uang', 'score' => 2],
        ];

        $timestamp = now();
        foreach ($questions as &$question) {
            $question['created_at'] = $timestamp;
            $question['updated_at'] = $timestamp;
        }

        DB::table('observation_questions')->insert($questions);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
