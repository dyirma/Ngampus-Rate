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
    public function index()
    {
        $totalResponses = Jawaban::select('user_id')->distinct()->count();
        $totalDosen = Dosen::count();
        $totalUsers = User::count();

        $averagePerKuisioner = Jawaban::select(
                'kuisioners.nama_kuisioner',
                DB::raw('AVG(jawabans.nilai_jawaban) as rata_rata')
            )
            ->join('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->join('kuisioners', 'pertanyaans.kuisioner_id', '=', 'kuisioners.id')
            ->whereNotNull('jawabans.nilai_jawaban')
            ->groupBy('kuisioners.id', 'kuisioners.nama_kuisioner')
            ->orderBy('kuisioners.id')
            ->get();

        return view('admin.dashboard', [
            'totalResponses' => $totalResponses,
            'totalDosen' => $totalDosen,
            'totalUsers' => $totalUsers,
            'averagePerKuisioner' => $averagePerKuisioner,
        ]);
    }
}
