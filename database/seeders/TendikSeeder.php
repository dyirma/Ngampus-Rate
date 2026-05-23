<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Question;
use Illuminate\Database\Seeder;

class TendikSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori Utama 
        $category = Category::firstOrCreate(
            ['slug' => 'manajemen-tendik'],
            [
                'nama_kategori' => 'Survei Tenaga Kependidikan Terhadap Manajemen di Universitas Sugeng Hartono',
                'deskripsi' => 'Survei ini bertujuan untuk mengumpulkan masukan dan pendapat anda guna membantu kami meningkatkan kualitas Universitas Sugeng Hartono. Seluruh jawaban yang Anda berikan akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan evaluasi serta pengembangan organisasi.'
            ]
        );

        $kuisionerData = [
            [
                'nama' => 'Kerja dan Suasana Kerja',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Penempatan tenaga kependidikan di USH sudah sesuai dengan kualifikasi dan kompetensi.',
                    'Tersedianya ruang kerja yang nyaman.',
                    'Tersedianya fasilitas kerja (komputer, printer, ATK) dan sistem informasi sebagai penunjang kinerja.',
                    'Dalam menyelesaikan pekerjaan terjalin kerja sama yang baik di antara tenaga kependidikan.',
                ],
            ],
            [
                'nama' => 'Peran Pimpinan',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Membagi pekerjaan kepada tenaga kependidikan secara proporsional.',
                    'Memberikan wewenang kepada tenaga kependidikan untuk melakukan tugas dan membuat pelaporan.',
                    'Memberikan pengarahan kepada tenaga kependidikan dalam melakukan tugasnya.',
                    'Memberikan penghargaan dan sanksi terhadap hasil kerja tenaga kependidikan secara adil.',
                    'Melakukan pengawasan terhadap kinerja tenaga kependidikan.',
                ],
            ],
            [
                'nama' => 'Pengembangan',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'USH memberikan kesempatan pengembangan karier tenaga kependidikan dengan studi lanjut.',
                    'USH mengembangkan kompetensi tenaga kependidikan melalui diklat, lokakarya, seminar dan lainnya.',
                    'USH menerapkan sistem pengembangan tenaga kependidikan dengan mutasi atau rotasi.',
                    'USH menerapkan pengembangan karier tenaga kependidikan dengan peningkatan kesejahteraan yang memadai.',
                ],
            ],
            [
                'nama' => 'Kesejahteraan',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'USH menerapkan sistem penggajian tenaga kependidikan dan memberikan pendapatan lainnya yang memadai.',
                    'USH memberikan jaminan dan fasilitas kesehatan yang memadai.',
                    'USH memberikan akses untuk peningkatan motivasi yang memadai.',
                    'USH memberikan cuti bagi tenaga kependidikan sesuai ketentuan.',
                    'USH memberikan akses bantuan finansial bagi tenaga kependidikan.',
                ],
            ],
            [
                'nama' => 'Saran dan Masukan',
                'deskripsi' => 'Berikan saran dan masukan anda terhadap manajemen di Universitas Sugeng Hartono.',
                'pertanyaan' => [
                    'Berikan saran dan masukan anda terhadap manajemen di Universitas Sugeng Hartono'
                ],
            ],
        ];

        foreach ($kuisionerData as $data) {
            // 2. Simpan sebagai Sub-Kategori
            $sub = SubCategory::firstOrCreate(
                ['category_id' => $category->id, 'nama_sub' => $data['nama']],
                ['deskripsi_sub' => $data['deskripsi']]
            );

            foreach ($data['pertanyaan'] as $index => $pertanyaanText) {
                // 3. Simpan ke tabel Questions
                $tipeJawaban = ($data['nama'] === 'Saran dan Masukan') ? 'text' : 'likert';

                Question::firstOrCreate(
                    ['sub_category_id' => $sub->id, 'teks_pertanyaan' => $pertanyaanText],
                    ['tipe_jawaban' => $tipeJawaban]
                );
            }
        }
    }
}
