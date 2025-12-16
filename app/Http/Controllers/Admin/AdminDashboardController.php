<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jawaban;
use App\Models\Kuisioner;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // Fungsi utama yang dijalankan saat admin membuka dashboard.
    // Tujuannya: Mengumpulkan statistik ringkas dan data analisis untuk ditampilkan.
    public function index()
    {
        // 1. MENGHITUNG TOTAL STATISTIK (KARTU ATAS)
        // Menghitung jumlah mahasiswa (user) unik yang sudah pernah mengisi setidaknya satu jawaban.
        // 'distinct()' memastikan jika satu user mengisi 10 jawaban, tetap dihitung 1 orang.
        $totalResponses = Jawaban::select('user_id')->distinct()->count();

        // Menghitung total data Dosen yang terdaftar di sistem.
        $totalDosen = Dosen::count();

        // Menghitung total data Pengguna (User) yang terdaftar di sistem.
        $totalUsers = User::count();

        // 2. MENGHITUNG RATA-RATA SKOR PER KATEGORI KUISIONER (GRAFIK BAWAH)
        // Mengambil rata-rata nilai jawaban, dikelompokkan per Kategori Kuisioner.
        // Menggunakan DB Facade agar query lebih efisien daripada looping model satu per satu.
        $averagePerKuisioner = Jawaban::select(
                'kuisioners.nama_kuisioner', // Kolom untuk nama kategori   
                DB::raw('AVG(jawabans.nilai_jawaban) as rata_rata') // Fungsi agregat SQL untuk rata-rata
            )
            // Menggabungkan tabel jawaban dengan pertanyaan dan kategori kuisioner.
            ->join('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->join('kuisioners', 'pertanyaans.kuisioner_id', '=', 'kuisioners.id')
            ->whereNotNull('jawabans.nilai_jawaban') // Pastikan ada nilainya   
            ->groupBy('kuisioners.id', 'kuisioners.nama_kuisioner') // Kelompukan hasil per kategori kuisioner
            ->orderBy('kuisioners.id')
            ->get();

        // 3. MENGEMBALIKAN VIEW DASHBOARD DENGAN DATA STATISTIK YANG DIHITUNG
        // Menampilkan view 'admin.dashboard' dengan data statistik yang sudah dihitung.
            return view('admin.dashboard', [
            'totalResponses' => $totalResponses, // Total jawaban unik  
            'totalDosen' => $totalDosen, // Total dosen
            'totalUsers' => $totalUsers, // Total pengguna
            'averagePerKuisioner' => $averagePerKuisioner, // Rata-rata skor per kategori kuisioner 
        ]);
    }
}
