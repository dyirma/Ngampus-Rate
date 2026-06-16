<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Question;
use App\Models\Jawaban;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HasilKuisionerExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $categoryId;
    protected $periode;

    public function __construct($categoryId, $periode)
    {
        $this->categoryId = $categoryId;
        $this->periode = $periode;
    }

    // Menentukan header kolom di Excel
    public function headings(): array
    {
        $category = Category::with('subCategories.questions')->find($this->categoryId);
        $title = 'LAPORAN HASIL KUESIONER: ' . strtoupper($category->nama_kategori ?? '') . ' (Periode: ' . $this->periode . ')';

        $headerRow = ['No', 'Responden', 'Waktu Submit'];
        
        if ($category) {
            foreach ($category->subCategories as $subIndex => $sub) {
                // Menghilangkan underscore, menggunakan spasi biasa
                $subSlug = strtolower(trim($sub->nama_sub));
                foreach ($sub->questions as $qIndex => $q) {
                    // Jika ini bukan pertanyaan likert (biasanya saran & masukan), jangan berikan nomor indeks
                    if ($q->tipe_jawaban !== 'likert') {
                        $headerRow[] = $subSlug;
                    } else {
                        $headerRow[] = $subSlug . " " . ($qIndex + 1);
                    }
                }
            }
        }

        return [
            [$title], // Baris 1: Judul
            [''],     // Baris 2: Kosong (Spasi)
            $headerRow // Baris 3: Header Tabel
        ];
    }

    // Mengisi baris data (seperti Google Forms)
    public function array(): array
    {
        $category = Category::with('subCategories.questions')->find($this->categoryId);
        
        if (!$category) return [];

        $questionIds = [];
        $orderedQuestions = [];
        foreach ($category->subCategories as $sub) {
            foreach ($sub->questions as $q) {
                $questionIds[] = $q->id;
                $orderedQuestions[] = $q;
            }
        }

        // Ambil semua jawaban untuk kategori ini
        $allJawabans = Jawaban::with('surveyHistory')
            ->whereIn('question_id', $questionIds)
            ->where('periode', $this->periode)
            ->get();

        // Kelompokkan jawaban berdasarkan 1 responden (1 riwayat survei)
        $groupedJawabans = $allJawabans->groupBy('survey_history_id');
        
        $data = [];
        $counter = 1;

        foreach ($groupedJawabans as $historyId => $jawabansGroup) {
            if (!$historyId) continue; // Abaikan data lama yang tidak punya history ID

            $history = $jawabansGroup->first()->surveyHistory;
            
            $row = [
                $counter,
                'Responden ' . $counter,
                $history ? $history->created_at->format('d/m/Y H:i:s') : 'Unknown'
            ];

            // Petakan jawaban berdasarkan ID pertanyaan
            $mappedAnswers = [];
            foreach ($jawabansGroup as $j) {
                if ($j->nilai_jawaban !== null) {
                    $mappedAnswers[$j->question_id] = $j->nilai_jawaban;
                } else {
                    $mappedAnswers[$j->question_id] = $j->teks_jawaban;
                }
            }

            // Susun jawaban ke dalam baris sesuai urutan pertanyaan di Header
            foreach ($orderedQuestions as $q) {
                $row[] = $mappedAnswers[$q->id] ?? '-';
            }

            $data[] = $row;
            $counter++;
        }

        // --- TAMBAHAN: Baris Rata-rata di Paling Bawah ---
        // $counter saat ini menunjukkan jumlah responden aktual + 1
        if ($counter > 1) { // Hanya tambahkan rata-rata jika ada data
            $avgRow = ['', 'RATA-RATA KESELURUHAN', ''];
            
            foreach ($orderedQuestions as $q) {
                if ($q->tipe_jawaban == 'likert') {
                    $avg = Jawaban::where('question_id', $q->id)
                        ->where('periode', $this->periode)
                        ->avg('nilai_jawaban');
                    $avgRow[] = $avg ? round($avg, 2) : '-';
                } else {
                    $avgRow[] = '-'; // Teks bebas tidak punya rata-rata
                }
            }
            $data[] = $avgRow;
        }

        return $data;
    }

    // Mengatur styling Excel
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Gabungkan judul di baris 1 agar tidak mengacaukan lebar Kolom A
        $sheet->mergeCells('A1:' . $highestColumn . '1');

        // Set Font Global ke Angsana New ukuran 12
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Angsana New')->setSize(12);

        $styles = [
            // Baris 1: Judul Utama
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FF333333']],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
            // Baris 3: Header Tabel (Warna biru soft identik sistem)
            3 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FF1E3A8A']], // Teks Biru Gelap
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEBF5FF'] // Warna Biru Soft (Tailwind blue-50)
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ],
            ],
        ];

        // Rata tengah semua cell (opsional, agar rapi)
        $sheet->getStyle('A4:' . $highestColumn . ($highestRow - 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ]);

        // Style untuk baris terakhir (Rata-Rata)
        if ($highestRow > 3) {
            $sheet->getStyle('A' . $highestRow . ':' . $highestColumn . $highestRow)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2E8F0'] // Warna abu-abu terang
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ]);
        }

        // Atur lebar kolom: No (A) Kunci di 5, Responden (B) Auto, Waktu Submit (C) Kunci di 20
        $sheet->getColumnDimension('A')->setAutoSize(false);
        $sheet->getColumnDimension('A')->setWidth(5);
        
        $sheet->getColumnDimension('B')->setAutoSize(true);
        
        $sheet->getColumnDimension('C')->setAutoSize(false);
        $sheet->getColumnDimension('C')->setWidth(20);

        // Atur lebar kolom untuk pertanyaan (dimulai dari D)
        $col = 'D';
        $lastCol = $highestColumn;
        
        // Menggunakan string increment agar D sampai AE (dan seterusnya) terbaca dengan benar
        while ($col !== $lastCol) {
            $sheet->getColumnDimension($col)->setAutoSize(false);
            $sheet->getColumnDimension($col)->setWidth(17); // Lebar sama semua
            $col++;
        }
        
        // Kolom paling terakhir (saran) dilebarkan 3x lipat
        $sheet->getColumnDimension($lastCol)->setAutoSize(false);
        $sheet->getColumnDimension($lastCol)->setWidth(45);

        return $styles;
    }
}
