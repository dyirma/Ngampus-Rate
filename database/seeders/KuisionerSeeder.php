<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuisioner;

class KuisionerSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama_kuisioner' => 'Kuesioner Dosen',
                'deskripsi' => 'Evaluasi proses belajar mengajar dosen.',
                'kategori' => 'dosen'
            ],
            [
                'nama_kuisioner' => 'Kuesioner Staf',
                'deskripsi' => 'Penilaian layanan staf administrasi.',
                'kategori' => 'staf'
            ],
            [
                'nama_kuisioner' => 'Kuesioner Kampus',
                'deskripsi' => 'Fasilitas dan sarana prasarana kampus.',
                'kategori' => 'kampus'
            ],
            [
                'nama_kuisioner' => 'Sistem Siakad',
                'deskripsi' => 'Evaluasi performa dan kemudahan sistem informasi.',
                'kategori' => 'siakad'
            ],
        ];

        foreach ($categories as $cat) {
            Kuisioner::create($cat);
        }
    }
}