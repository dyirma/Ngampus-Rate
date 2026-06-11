<?php

namespace App\Exports;

use App\Models\Question;
use App\Models\Jawaban;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HasilKuisionerExport implements FromCollection, WithHeadings, WithMapping
{
    protected $categoryId;
    protected $periode;
    protected $rowNumber = 0;

    public function __construct($categoryId, $periode)
    {
        $this->categoryId = $categoryId;
        $this->periode = $periode;
    }

    // Mengambil semua pertanyaan di kategori terpilih
    public function collection()
    {
        return Question::whereHas('subCategory', function ($query) {
            $query->where('category_id', $this->categoryId);
        })
        ->with('subCategory')
        ->get();
    }

    // Menentukan header kolom di Excel
    public function headings(): array
    {
        return [
            'No',
            'Sub-Kategori',
            'Pertanyaan',
            'Tipe Jawaban',
            'Hasil Akhir (Rata-rata Skor / Gabungan Saran)'
        ];
    }

    // Memetakan isi baris demi baris ke Excel
    public function map($question): array
    {
        $this->rowNumber++;

        if ($question->tipe_jawaban === 'likert') {
            // Hitung rata-rata nilai untuk skala Likert
            $avg = Jawaban::where('question_id', $question->id)
                ->where('periode', $this->periode)
                ->avg('nilai_jawaban');
            $hasil = $avg ? round($avg, 2) : '-';
        } else {
            // Gabungkan teks saran menggunakan pemisah garis vertikal |
            $texts = Jawaban::where('question_id', $question->id)
                ->where('periode', $this->periode)
                ->whereNotNull('teks_jawaban')
                ->pluck('teks_jawaban')
                ->toArray();
            $hasil = !empty($texts) ? implode(' | ', $texts) : 'Belum ada saran';
        }

        return [
            $this->rowNumber,
            $question->subCategory->nama_sub,
            $question->teks_pertanyaan,
            $question->tipe_jawaban === 'likert' ? 'Skala Likert (1-5)' : 'Teks Bebas / Saran',
            $hasil
        ];
    }
}
