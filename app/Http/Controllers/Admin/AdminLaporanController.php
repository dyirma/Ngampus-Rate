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
    public function index() {
        $hasilLaporan = DB::table('jawabans')
            ->join('questions', 'jawabans.question_id', '=', 'questions.id')
            ->join('dosens', 'jawabans.dosen_id', '=', 'dosens.id')
            ->select('dosens.nama', DB::raw('AVG(nilai_jawaban) as rata_rata'))
            ->groupBy('dosens.nama')
            ->get();

        return view('admin.laporan.index', compact('hasilLaporan'));
    }

    // Mengekspor data laporan penilaian ke file Excel (.xlsx).
    public function export()
    {
        // Mendownload file dengan nama 'laporan-penilaian.xlsx'.
        // Logika penyusunan data excel ada di class 'LaporanPenilaianExport'.
        return Excel::download(new LaporanPenilaianExport, 'laporan-penilaian.xlsx');
    }
}
