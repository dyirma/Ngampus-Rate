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
        $this->call([TendikSeeder::class]);
        $this->call([PegawaiSeeder::class]);
    }

    private function seedAdminUser(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ngampus.test'],
            [
                'name' => 'Administrator Kampus',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nip' => '123456789',
                'jabatan' => 'Kepala LPM',
                'unit_kerja' => 'Lembaga Penjaminan Mutu',
                'tipe_pegawai' => 'tendik',
            ]
        );
    }

    private function seedDosens(): void
    {
        // Dosens are now users, not evaluated entities. Removed.
    }

    private function seedKuisionerDanPertanyaan(): void
    {
        // 1. Buat Kategori Utama 
        $category = Category::firstOrCreate(
            ['slug' => 'manajemen'],
            [
                'nama_kategori' => 'Survei Dosen terhadap Manajemen di Universitas Sugeng Hartono',
                'deskripsi' => 'Survei ini bertujuan untuk mengumpulkan masukan dan pendapat anda guna membantu kami meningkatkan kualitas Universitas Sugeng Hartono'
            ]
        );

        $kuisionerData = [
            [
                'nama' => 'Tugas Pokok',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Dosen USH mengampu mata kuliah sesuai dengan kualifikasi dan kompetensi.',
                    'Beban Kinerja Dosen antara 12 s.d. 16 SKS setiap semester.',
                    'Dosen diwajibkan untuk menyusun RPS (Rencana Pembelajaran Semester) sesuai dengan mata kuliah yang diampunya.',
                    'Dosen melakukan evaluasi pembelajaran secara objektif dan transparan.',
                    'Dosen diberdayakan untuk menjadi DPA (Dosen Pembimbing Akademik) mahasiswa sesuai ketentuan.',
                    'Dosen diberdayakan untuk menjadi pembimbing dan penguji tugas akhir mahasiswa sesuai ketentuan.',
                    'Dosen diberi kesempatan untuk melakukan penelitian dan pengabdian sesuai dengan keahlian, baik didanai oleh internal USH maupun pihak eksternal.',
                    'Dosen diberi kesempatan untuk menyusun hand out, modul, buku ajar, atau artikel ilmiah.',
                ],
            ],
            [
                'nama' => 'Sarana dan Prasarana',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Tersedia ruangan kelas dengan fasilitas pendukung proses belajar yang lengkap.',
                    'Ruang kelas memadai dan nyaman untuk proses belajar mengajar.',
                    'Tersedia ruang kerja dosen yang memadai.',
                    'Tersedia toilet yang memadai dan higienis.',
                    'Tersedia laboratorium yang memadai untuk menunjang proses pembelajaran dan penelitian.',
                    'Tersedia perpustakaan yang memadai dengan koleksi pustaka yang representatif dan berakses ke perpustakaan digital.',
                    'Tersedia sarana dan fasilitas kesehatan/poliklinik yang memadai.',
                    'Tersedia kantin, toko, area parkir, tempat ibadah, tempat olahraga, ruang berkesenian, ruang pertemuan dan fasilitas publik lain yang memadai.',
                    'Tersedia akses untuk orang berkebutuhan khusus yang lengkap dan fungsional.',
                ],
            ],
            [
                'nama' => 'Sistem Informasi',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Sistem Informasi Akademik (SIAKAD) mudah diakses.',
                    'Sistem Informasi Akademik (SIAKAD) memiliki fitur yang lengkap dan mutakhir untuk kegiatan pelaporan kegiatan belajar dan mengajar.',
                    'Sistem Informasi Akademik (SIAKAD) hanya bisa diakses oleh dosen pengampu mata kuliah.',
                    'Tersedia jaringan internet dengan kapasitas yang mencukupi untuk kegiatan Tridharma.',
                ],
            ],
            [
                'nama' => 'Hak Dosen',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Dosen memperoleh gaji, remunerasi, dan tunjangan sesuai dengan aturan yang berlaku.',
                    'Dosen mendapatkan fasilitas kemudahan dalam mengurus kepangkatan akademik dan meningkatkan jenjang karier.',
                    'Dosen mendapat kesempatan untuk mengikuti kegiatan yang menunjang keprofesionalan (training, seminar, dll).',
                    'Dosen mendapatkan kesempatan untuk melanjutkan studi ke jenjang yang lebih tinggi dengan bantuan pembiayaan dari internal USH atau pihak external.',
                ],
            ],
            [
                'nama' => 'Kepedulian Universitas Sugeng Hartono',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Dosen mendapatkan perlindungan apabila mendapatkan tekanan psikologis di tempat kerja.',
                    'Dosen mendapat bantuan apabila mendapat musibah yang menimpa diri dosen dan atau keluarga.',
                    'Dosen mendapatkan penyelesaian yang baik jika mengalami agau konflik yang berkaitan dengan pekerjaan.',
                ],
            ],
            [
                'nama' => 'Saran dan Masukan',
                'deskripsi' => 'Tuliskan saran konstruktif Anda untuk kemajuan manajemen Universitas Sugeng Hartono.',
                'pertanyaan' => [
                    'Berikan saran dan masukan anda terhadap manajemen di Universitas Sugeng Hartono' // Ini akan dibuat tipe teks di bawah
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
                // Khusus sub-kategori "Saran dan Masukan", kita set tipe jawabannya sebagai "text"
                $tipeJawaban = ($data['nama'] === 'Saran dan Masukan') ? 'text' : 'likert';

                Question::firstOrCreate(
                    ['sub_category_id' => $sub->id, 'teks_pertanyaan' => $pertanyaanText],
                    ['tipe_jawaban' => $tipeJawaban]
                );
            }
        }
    }
}