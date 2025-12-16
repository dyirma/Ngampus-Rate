<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kuisioner;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

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
            [
                'nama' => 'Kualitas Layanan',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Informasi akademik disampaikan tepat waktu melalui kanal resmi kampus.',
                    'Petugas layanan akademik merespons pertanyaan mahasiswa dengan ramah.',
                    'Layanan administrasi (registrasi, surat-menyurat) berlangsung transparan.',
                    'Sarana komunikasi (email, hotline, helpdesk) kampus mudah diakses.',
                    'Kampus menindaklanjuti keluhan mahasiswa dengan solusi yang jelas.',
                ],
            ],
            [
                'nama' => 'Penilaian Dosen dalam Mengajar',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Dosen menguasai materi kuliah dengan sangat baik.',
                    'Materi yang disampaikan relevan dengan perkembangan industri/bidang saat ini.',
                    'Dosen mampu menjelaskan konsep yang sulit menjadi mudah dipahami.',
                    'Dosen menggunakan variasi metode pengajaran (diskusi, studi kasus, praktikum, dll.).',
                    'Dosen memberikan kesempatan yang cukup bagi mahasiswa untuk bertanya dan berpendapat.',
                ],
            ],
            [
                'nama' => 'Fasilitas Kampus Universitas Sugeng Hartono',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Ketersediaan dan kelengkapan buku di perpustakaan memadai.',
                    'Kualitas koneksi Wi-Fi di area kampus sangat baik.',
                    'Kondisi ruang kelas (kebersihan, penerangan, AC/ventilasi) nyaman untuk belajar.',
                    'Laboratorium atau studio menyediakan perangkat dan software yang memadai.',
                    'Kebersihan toilet di area kampus terjaga sepanjang hari.',
                ],
            ],
            [
                'nama' => 'Pelayanan Kampus Universitas Sugeng Hartono',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Staf kampus melayani kebutuhan administratif dengan ramah dan profesional.',
                    'Proses pengurusan dokumen akademik berlangsung cepat dan transparan.',
                    'Informasi prosedur akademik maupun non-akademik mudah diperoleh.',
                    'Unit layanan kampus proaktif memberikan update jika ada perubahan penting.',
                    'Sistem antrian layanan kampus tertib dan adil.',
                ],
            ],
            [
                'nama' => 'Keterkaitan Kurikulum Universitas Sugeng Hartono',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Materi kuliah relevan dengan kebutuhan nyata di pasar kerja saat ini.',
                    'Kurikulum mengintegrasikan studi kasus industri di setiap semester.',
                    'Penugasan kuliah membantu saya mengasah keterampilan praktis.',
                    'Kurikulum diperbarui secara berkala mengikuti perkembangan terbaru.',
                    'Program magang atau proyek akhir didesain selaras dengan dunia kerja.',
                ],
            ],
            [
                'nama' => 'Ketersediaan Konsultasi',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Dosen Pembimbing Akademik mudah ditemui untuk berdiskusi.',
                    'PA memberikan arahan yang jelas mengenai rencana studi tiap semester.',
                    'Jumlah mahasiswa bimbingan per PA masih dalam batas wajar.',
                    'PA memantau perkembangan akademik mahasiswa secara berkala.',
                    'Platform konsultasi daring/luring yang disediakan kampus berjalan efektif.',
                ],
            ],
            [
                'nama' => 'Keseimbangan Tugas Kampus Universitas Sugeng Hartono',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Beban tugas setiap mata kuliah proporsional terhadap bobot SKS.',
                    'Penjadwalan tenggat tugas antar mata kuliah sudah diatur dengan baik.',
                    'Tugas yang diberikan relevan dengan tujuan pembelajaran.',
                    'Kolaborasi tugas kelompok dibimbing dengan panduan yang jelas.',
                    'Saya masih memiliki waktu yang seimbang antara kuliah dan kehidupan pribadi.',
                ],
            ],
            [
                'nama' => 'Inovasi dan Teknologi',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Kampus mendorong penggunaan teknologi inovatif dalam proses belajar.',
                    'Tersedia perangkat pendukung (VR, AI tools, dsb.) untuk praktikum.',
                    'Dosen mencontohkan pemanfaatan teknologi terbaru di kelas.',
                    'Mahasiswa mendapat pelatihan singkat terkait teknologi baru sebelum digunakan.',
                    'Inisiatif teknologi kampus membantu meningkatkan pengalaman belajar.',
                ],
            ],
            [
                'nama' => 'Kesiapan Karir Praktis',
                'deskripsi' => 'Berikan penilaian Anda dengan skala 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju)',
                'pertanyaan' => [
                    'Seminar dan workshop kampus meningkatkan keterampilan lunak (soft skills).',
                    'Materi pelatihan kampus membantu persiapan wawancara kerja.',
                    'Career center kampus aktif memberikan informasi lowongan dan magang.',
                    'Kampus menyediakan mentor atau alumni untuk berbagi pengalaman karir.',
                    'Simulasi rekrutmen (mock interview, assessment) rutin diselenggarakan.',
                ],
            ],
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
            $kuisioner = Kuisioner::firstOrCreate(
                ['nama_kuisioner' => $data['nama']],
                ['deskripsi' => $data['deskripsi']]
            );

            foreach ($data['pertanyaan'] as $pertanyaanText) {
                $kuisioner->pertanyaan()->firstOrCreate(
                    ['teks_pertanyaan' => $pertanyaanText],
                    ['tipe_jawaban' => 'likert']
                );
            }
        }
    }
}
