<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanPenilaianExport;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Kuisioner;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

// Controller ini bertugas mengelola halaman Laporan Penilaian Dosen.
// Fitur utamanya adalah menampilkan matriks nilai rata-rata per dosen dan export ke Excel.
class AdminLaporanController extends Controller
{
    //Menampilkan halaman utama laporan (Tabel Matriks Nilai).
    public function index()
    {
        // 1. Ambil Data Master
        // Mengambil daftar Kategori Kuisioner (sebagai Header Kolom tabel).
        $kuisioners = Kuisioner::orderBy('id')->get();
        // Mengambil daftar Dosen (sebagai Header Baris tabel).
        $dosens = Dosen::orderBy('nama')->get();

        // 2. Hitung Rata-Rata Nilai (Core Logic)
        // Menggunakan Query Builder untuk performa tinggi (lebih cepat daripada Eloquent loop).
        // Kita menghitung rata-rata nilai jawaban, dikelompokkan per Dosen dan per Kategori.
        $rawScores = DB::table('jawabans')
            ->select(
                'jawabans.dosen_id',
                'kuisioners.id as kuisioner_id',
                // Fungsi agregat SQL 'AVG' untuk menghitung rata-rata nilai
                DB::raw('AVG(jawabans.nilai_jawaban) as rata_rata')
            )
            // Melakukan JOIN tabel untuk menghubungkan Jawaban -> Pertanyaan -> Kategori
            ->join('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->join('kuisioners', 'pertanyaans.kuisioner_id', '=', 'kuisioners.id')
            // Filter data sampah (null) agar perhitungan akurat
            ->whereNotNull('jawabans.dosen_id')
            ->whereNotNull('jawabans.nilai_jawaban')
            // Kelompokkan hasil agar mendapat 1 nilai rata-rata per pasangan Dosen-Kategori
            ->groupBy('jawabans.dosen_id', 'kuisioners.id')
            ->get();

        // 3. Susun Ulang Data (Re-mapping)
        // Mengubah hasil database menjadi array asosiatif 2 dimensi agar mudah dipanggil di View.
        // Format: $report[ID_DOSEN][ID_KATEGORI] = NILAI
        $report = [];

        foreach ($rawScores as $row) {
            // Membulatkan nilai rata-rata menjadi 2 angka di belakang koma
            $report[$row->dosen_id][$row->kuisioner_id] = round($row->rata_rata, 2);
        }

        // 4. Tampilkan View
        // Mengirimkan data yang sudah disiapkan ke file blade 'admin.laporan.index'.
        return view('admin.laporan.index', [
            'kuisioners' => $kuisioners,
            'dosens' => $dosens,
            'report' => $report,
        ]);
    }

    // Mengekspor data laporan penilaian ke file Excel (.xlsx).
    public function export()
    {
        // Mendownload file dengan nama 'laporan-penilaian.xlsx'.
        // Logika penyusunan data excel ada di class 'LaporanPenilaianExport'.
        return Excel::download(new LaporanPenilaianExport, 'laporan-penilaian.xlsx');
    }
}
