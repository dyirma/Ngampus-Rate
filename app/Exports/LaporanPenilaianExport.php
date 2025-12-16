<?php

namespace App\Exports;

use App\Models\Dosen;
use App\Models\Kuisioner;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPenilaianExport implements FromCollection, WithHeadings
{
    // menyiapkan data (baris-baris) yang akan ditulis ke dalam file Excel.
    public function collection()
    {
        // 1. Ambil Data Master:
        // Mengambil semua kategori kuisioner (untuk kolom) dan semua dosen (untuk baris).
        $kuisioners = Kuisioner::orderBy('id')->get();
        $dosens = Dosen::orderBy('nama')->get();

         // 2. Hitung Rata-Rata (Complex Query):
        // Mengambil rata-rata nilai jawaban, dikelompokkan per Dosen dan per Kategori Kuisioner.
        // Menggunakan DB Facade agar query lebih efisien daripada looping model satu per satu.
        $rawScores = DB::table('jawabans')
            ->select(
                'jawabans.dosen_id',
                'kuisioners.id as kuisioner_id',
                DB::raw('AVG(jawabans.nilai_jawaban) as rata_rata')// Fungsi agregat SQL untuk rata-rata
            )
            ->join('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->join('kuisioners', 'pertanyaans.kuisioner_id', '=', 'kuisioners.id')
            ->whereNotNull('jawabans.dosen_id')// Pastikan data valid
            ->whereNotNull('jawabans.nilai_jawaban')// Pastikan ada nilainya
            ->groupBy('jawabans.dosen_id', 'kuisioners.id')// Kelompokkan hasil
            ->get();

        // 3. Restrukturisasi Data (Pivot Manual):
        // Mengubah hasil query database menjadi array asosiatif agar mudah dicari (lookup).
        // Format Array: $scores[ID_DOSEN][ID_KUISIONER] = NILAI_RATA_RATA
        $scores = [];

        foreach ($rawScores as $row) {
            $scores[$row->dosen_id][$row->kuisioner_id] = round($row->rata_rata, 2);
        }

        // 4. Mapping Data ke Baris Excel:
        // Kita meloop setiap dosen untuk membuat satu baris data di Excel.
        return $dosens->map(function ($dosen) use ($kuisioners, $scores) {
            // Kolom Awal (Data Dosen)
            $row = [
                'Dosen' => $dosen->nama,
                'NIP' => $dosen->nip,
            ];

            // Kolom Dinamis (Nilai per Kategori)
            // Meloop setiap kategori kuisioner untuk mengisi kolom nilai di samping nama dosen.
            foreach ($kuisioners as $kuisioner) {
                // Cek di array $scores: Apakah dosen ini punya nilai untuk kategori ini?
                // Jika ada ambil nilainya, jika tidak ada isi dengan tanda strip '-'
                $row[$kuisioner->nama_kuisioner] = $scores[$dosen->id][$kuisioner->id] ?? '-';
            }

            return $row;// Kembalikan baris lengkap untuk 1 dosen
        });
    }

    // untuk mendefinisikan Judul Kolom (Header Row) paling atas di Excel.
    public function headings(): array
    {
        // Ambil nama-nama kategori kuisioner untuk dijadikan judul kolom dinamis
        $kuisionerHeadings = Kuisioner::orderBy('id')->pluck('nama_kuisioner')->toArray();

        // Gabungkan header statis ('Dosen', 'NIP') dengan header dinamis tadi
        return array_merge(['Dosen', 'NIP'], $kuisionerHeadings);
    }
}
