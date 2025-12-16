<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanPenilaianExport;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Kuisioner;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $kuisioners = Kuisioner::orderBy('id')->get();
        $dosens = Dosen::orderBy('nama')->get();

        $rawScores = DB::table('jawabans')
            ->select(
                'jawabans.dosen_id',
                'kuisioners.id as kuisioner_id',
                DB::raw('AVG(jawabans.nilai_jawaban) as rata_rata')
            )
            ->join('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->join('kuisioners', 'pertanyaans.kuisioner_id', '=', 'kuisioners.id')
            ->whereNotNull('jawabans.dosen_id')
            ->whereNotNull('jawabans.nilai_jawaban')
            ->groupBy('jawabans.dosen_id', 'kuisioners.id')
            ->get();

        $report = [];

        foreach ($rawScores as $row) {
            $report[$row->dosen_id][$row->kuisioner_id] = round($row->rata_rata, 2);
        }

        return view('admin.laporan.index', [
            'kuisioners' => $kuisioners,
            'dosens' => $dosens,
            'report' => $report,
        ]);
    }

    public function export()
    {
        return Excel::download(new LaporanPenilaianExport, 'laporan-penilaian.xlsx');
    }
}
