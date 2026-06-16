<?php

namespace App\Livewire;

use App\Models\Jawaban;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Question;
use App\Models\SurveyHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class KuisionerForm extends Component
{
    public int $step = 0; 
    public $kategori; 
    public $currentCategory;
    public $hasAnswered = false;

    public array $dataDiri = [
        'name' => '', 'nip' => '', 'tipe_pegawai' => '', 
        'jabatan' => '', 'unit_kerja' => ''
    ];

    public array $answers = []; 
    public Collection $subCategories; 
    public Collection $dosens;
    
    public array $likertLabels = [
        1 => 'Sangat Tidak Setuju', 
        2 => 'Tidak Setuju', 
        3 => 'Netral', 
        4 => 'Setuju', 
        5 => 'Sangat Setuju'
    ];

    public function mount($kategori = null): void
    {
        $user = Auth::user();
        $this->kategori = $kategori;

        $this->currentCategory = Category::where('slug', $this->kategori)->first();

        if (!$this->currentCategory) {
            abort(404, 'Kategori kuesioner tidak ditemukan.');
        }

        // Cek apakah user sudah isi tahun ini (Admin selalu bisa akses untuk tes)
        if ($user->role === 'admin') {
            $this->hasAnswered = false;
        } else {
            $this->hasAnswered = SurveyHistory::where('user_id', $user->id)
                ->where('periode', date('Y'))
                ->exists();
        }

        $this->subCategories = SubCategory::with('questions')
            ->where('category_id', $this->currentCategory->id)
            ->get();

        $this->dataDiri = [
            'name' => $user->name ?? '',
            'nip' => $user->nip ?? '',
            'tipe_pegawai' => $user->tipe_pegawai ?? '',
            'jabatan' => $user->jabatan ?? '',
            'unit_kerja' => $user->unit_kerja ?? '',
        ];

        $this->initializeAnswers();
    }

    private function initializeAnswers(): void
    {
        foreach ($this->subCategories as $sub) {
            foreach ($sub->questions as $q) {
                if (!isset($this->answers[$q->id])) {
                    $this->answers[$q->id] = [
                        'nilai' => null,
                        'teks' => ''
                    ];
                }
            }
        }
    }

    #[Computed]
    public function currentSubCategory(): ?SubCategory
    {
        if (! $this->isQuestionStep()) return null;
        $index = $this->step - 1; 
        return $this->subCategories->values()->get($index);
    }

    #[Computed]
    public function summaryData(): array
    {
        $summary = [];
        foreach ($this->subCategories as $sub) {
            $items = [];
            foreach ($sub->questions as $q) {
                $jawaban = $this->answers[$q->id] ?? null;
                
                if ($q->tipe_jawaban === 'likert') {
                    $nilai = $jawaban['nilai'] ?? null;
                    $label = $nilai ? ($this->likertLabels[$nilai] ?? '-') : 'Belum diisi';
                    $teksJawaban = $nilai ? "$nilai - $label" : "Belum diisi";
                } else {
                    $teksJawaban = (!empty($jawaban['teks'])) ? $jawaban['teks'] : 'Tidak ada komentar';
                }

                $items[] = [
                    'pertanyaan' => $q->teks_pertanyaan,
                    'jawaban' => $teksJawaban,
                ];
            }
            if (count($items) > 0) {
                $summary[$sub->nama_sub] = $items;
            }
        }
        return $summary;
    }

    // PERBAIKAN: Fungsi Mulai Sekarang (Step 0 ke 1)
    public function startKuisioner()
    {
        $this->step = 1; 
        $this->js('window.scrollTo({ top: 0, behavior: "smooth" });');
    }
    
    // PERBAIKAN: Fungsi Kembali
    public function goToPreviousStep(): void
    {
        if ($this->step > 0) {
            $this->step--;
            $this->js('window.scrollTo({ top: 0, behavior: "smooth" });');
        }
    }

    // PERBAIKAN: Fungsi Lanjut
    public function goToNextStep()
    {
        // Validasi Tahap Pertanyaan
        if ($this->isQuestionStep()) {
            $currentSub = $this->subCategories->values()->get($this->step - 1);
            $rules = [];
            $messages = [];
            foreach ($currentSub->questions as $q) {
                if ($q->tipe_jawaban === 'likert') {
                    $rules["answers.{$q->id}.nilai"] = 'required';
                    $messages["answers.{$q->id}.nilai.required"] = "Pertanyaan '{$q->teks_pertanyaan}' wajib dijawab.";
                } else {
                    $rules["answers.{$q->id}.teks"] = 'required';
                    $messages["answers.{$q->id}.teks.required"] = 'Tanggapan/saran wajib diisi.';
                }
            }

            $this->validate($rules, $messages);
        }

        $this->step++;
        $this->js('window.scrollTo({ top: 0, behavior: "smooth" });');
    }

    public function submit()
    {
        // 1. Validasi: Pastikan semua pertanyaan sudah dijawab
        // (Opsional: Tambahkan logika validasi di sini jika diperlukan)

        try {
            $currentYear = date('Y');
            
            // 2. Simpan setiap jawaban ke tabel 'jawabans' HANYA jika bukan admin
            if (auth()->user()->role !== 'admin') {
                // Catat bahwa user sudah mengisi periode ini
                $history = SurveyHistory::create([
                    'user_id' => auth()->id(),
                    'periode' => $currentYear
                ]);

                // Simpan setiap jawaban yang terikat pada histori survey ini
                foreach ($this->answers as $questionId => $answer) {
                    \App\Models\Jawaban::create([
                        'periode' => $currentYear,
                        'question_id' => $questionId,
                        'nilai_jawaban' => $answer['nilai'] ?? null,
                        'teks_jawaban' => $answer['teks'] ?? null,
                        'survey_history_id' => $history->id,
                    ]);
                }
            }

            // 4. Tampilkan notifikasi sukses dan arahkan ke Thank You
            $msg = auth()->user()->role === 'admin' ? 'Simulasi pengisian berhasil! (Mode Admin)' : 'Kuesioner berhasil dikirim!';
            $this->dispatch('show-toast', message: $msg, icon: 'success');
            return redirect()->route('thank-you');

        } catch (\Exception $e) {
            $this->dispatch('show-toast', message: 'Terjadi kesalahan: ' . $e->getMessage(), icon: 'error');
        }
    }

    public function isQuestionStep(): bool 
    { 
        return $this->step >= 1 && $this->step <= $this->subCategories->count(); 
    }

    public function render()
    {
        return view('livewire.kuisioner-form', [
            'kuisioners' => $this->subCategories,
        ])->layout('layouts.app');
    }
}