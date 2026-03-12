<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Category;    // Ubah dari Kuisioner ke Category
use App\Models\SubCategory; // Tambahkan ini
use App\Models\Question;    // Tambahkan ini
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdminUser();
        $this->seedDosens();
        $this->seedKuisionerDanPertanyaan();
    }

    private function seedAdminUser(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ngampus.test'],
            [
                'name' => 'Administrator Kampus',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'gender' => 'Laki-laki',
                'status_responden' => 'staf',
                'program_studi' => 'S1 Teknik Informatika',
                'angkatan' => '2005',
            ]
        );
    }

    private function seedDosens(): void
    {
        $dosens = [
            ['nama' => 'Dr. Anita Suryani, M.Kom', 'nip' => '19790101 200501 2 001'],
            ['nama' => 'Drs. Bagus Prasetyo, M.M', 'nip' => '19780312 200412 1 002'],
            ['nama' => 'Ir. Citra Wahyuni, M.T', 'nip' => '19810621 200703 2 003'],
            ['nama' => 'Rini Lestari, S.H., M.H', 'nip' => '19850618 200901 2 004'],
            ['nama' => 'Dr. Teguh Santoso, M.Si', 'nip' => '19791202 200612 1 005'],
            ['nama' => 'Dr. Dwi Pertiwi, M.Keb', 'nip' => '19821130 200803 2 006'],
        ];

        foreach ($dosens as $dosen) {
            Dosen::firstOrCreate(['nip' => $dosen['nip']], $dosen);
        }
    }

    private function seedKuisionerDanPertanyaan(): void
    {
        // 1. Buat Kategori Utama (Misal: Kategori Dosen)
        $category = Category::firstOrCreate(
            ['slug' => 'dosen'],
            [
                'nama_kategori' => 'Kuesioner Dosen',
                'deskripsi' => 'Penilaian kinerja dosen oleh mahasiswa.'
            ]
        );

        $kuisionerData = [
            [
                'nama' => 'Kemudahan Penggunaan',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Sistem SIAKAD mudah diakses dari berbagai perangkat tanpa kendala teknis.',
                    'Menu dan navigasi SIAKAD jelas sehingga saya cepat menemukan informasi akademik.',
                    'Tampilan antarmuka SIAKAD modern dan nyaman digunakan dalam waktu lama.',
                    'Proses pengisian KRS atau administrasi lain di SIAKAD berjalan lancar.',
                    'Notifikasi dan pesan yang muncul di SIAKAD mudah dipahami dan membantu.',
                ],
            ],
            // ... (Data lainnya tetap sama seperti milikmu)
            [
                'nama' => 'Kepuasan Keseluruhan',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Saya merasa puas dengan pengalaman belajar di Universitas Sugeng Hartono.',
                    'Saya bersedia merekomendasikan kampus ini kepada orang lain.',
                    'Lingkungan kampus mendukung pengembangan diri saya.',
                    'Program akademik kampus memenuhi harapan saya.',
                    'Secara keseluruhan, layanan kampus berjalan sesuai standar yang dijanjikan.',
                ],
            ],
        ];

        foreach ($kuisionerData as $data) {
            // 2. Simpan sebagai Sub-Kategori
            $sub = SubCategory::firstOrCreate(
                ['category_id' => $category->id, 'nama_sub' => $data['nama']],
                ['deskripsi_sub' => $data['deskripsi']]
            );

            foreach ($data['pertanyaan'] as $pertanyaanText) {
                // 3. Simpan ke tabel Questions
                Question::firstOrCreate(
                    ['sub_category_id' => $sub->id, 'teks_pertanyaan' => $pertanyaanText],
                    ['tipe_jawaban' => 'likert']
                );
            }
        }
    }
}