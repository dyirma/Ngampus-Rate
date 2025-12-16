<?php

namespace App\Exports;

use App\Models\Dosen;
use App\Models\Kuisioner;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPenilaianExport implements FromCollection, WithHeadings
{
    public function collection()
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

        $scores = [];

        foreach ($rawScores as $row) {
            $scores[$row->dosen_id][$row->kuisioner_id] = round($row->rata_rata, 2);
        }

        return $dosens->map(function ($dosen) use ($kuisioners, $scores) {
            $row = [
                'Dosen' => $dosen->nama,
                'NIP' => $dosen->nip,
            ];

            foreach ($kuisioners as $kuisioner) {
                $row[$kuisioner->nama_kuisioner] = $scores[$dosen->id][$kuisioner->id] ?? '-';
            }

            return $row;
        });
    }

    public function headings(): array
    {
        $kuisionerHeadings = Kuisioner::orderBy('id')->pluck('nama_kuisioner')->toArray();

        return array_merge(['Dosen', 'NIP'], $kuisionerHeadings);
    }
}
