<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Question;

class KuisionerBaruSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT KATEGORI UTAMA
        $dosen = Category::create([
            'nama_kategori' => 'Dosen',
            'slug' => 'dosen',
            'deskripsi' => 'Evaluasi kinerja dosen dalam proses belajar mengajar.'
        ]);

        // 2. BUAT SUB-KATEGORI (Level 2)
        $sub1 = SubCategory::create([
            'category_id' => $dosen->id,
            'nama_sub' => 'Kemudahan Penggunaan',
            'deskripsi_sub' => 'Menilai kemudahan interaksi dengan dosen.'
        ]);

        $sub2 = SubCategory::create([
            'category_id' => $dosen->id,
            'nama_sub' => 'Kualitas Pengajaran',
            'deskripsi_sub' => 'Menilai penguasaan materi oleh dosen.'
        ]);

        // 3. BUAT BUTIR PERTANYAAN (Level 3)
        Question::create([
            'sub_category_id' => $sub1->id,
            'teks_pertanyaan' => 'Apakah dosen mudah ditemui untuk berkonsultasi?',
            'tipe_jawaban' => 'likert'
        ]);

        Question::create([
            'sub_category_id' => $sub2->id,
            'teks_pertanyaan' => 'Apakah materi yang disampaikan dosen mudah dipahami?',
            'tipe_jawaban' => 'likert'
        ]);
        
        Question::create([
            'sub_category_id' => $sub2->id,
            'teks_pertanyaan' => 'Berikan saran Anda untuk dosen ini.',
            'tipe_jawaban' => 'text'
        ]);
    }
}