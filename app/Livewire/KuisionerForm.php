<?php

namespace App\Livewire;

use App\Models\Dosen;
use App\Models\Jawaban;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class KuisionerForm extends Component
{
    public int $step = 0; 
    public $selectedDosen;
    public $kategori; 
    public $currentCategory;
    public $sub_category_id;

    public array $dataDiri = [
        'name' => '', 'gender' => '', 'status_responden' => '', 
        'program_studi' => '', 'angkatan' => '', 'dosen_id' => null
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

        $this->subCategories = SubCategory::with('questions')
            ->where('category_id', $this->currentCategory->id)
            ->get();

        $this->dosens = Dosen::orderBy('nama')->get();

        $this->dataDiri = [
            'name' => $user->name ?? '',
            'gender' => $user->gender ?? '',
            'status_responden' => $user->status_responden ?? '',
            'program_studi' => $user->program_studi ?? '',
            'angkatan' => $user->angkatan ?? '2026',
            'dosen_id' => null,
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
        $index = $this->step - 2; 
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
    }
    
    // PERBAIKAN: Fungsi Kembali
    public function goToPreviousStep(): void
    {
        if ($this->step > 0) {
            $this->step--;
        }
    }

    // PERBAIKAN: Fungsi Lanjut (Step 1 ke 2)
    public function goToNextStep()
    {
        // 1. Validasi Tahap Data Diri (Step 1)
        if ($this->step === 1 && $this->kategori === 'dosen') {
            $this->validate([
                'selectedDosen' => 'required',
            ], [
                'selectedDosen.required' => 'Wajib memilih dosen sebelum lanjut.',
            ]);
        }

        // 2. Validasi Tahap Pertanyaan (Step > 1)
        if ($this->step > 1 && $this->step < ($this->subCategories->count() + 2)) {
            // Ambil sub-kategori saat ini
            $currentSub = $this->subCategories->values()->get($this->step - 2);
            
            // Ambil semua ID pertanyaan yang ada di sub-kategori ini
            $questionIds = $currentSub->questions->pluck('id')->toArray();

            // Buat aturan validasi dinamis untuk setiap pertanyaan di halaman ini
            $rules = [];
            $messages = [];
            foreach ($questionIds as $id) {
                $rules["answers.{$id}.nilai"] = 'required';
                $messages["answers.{$id}.nilai.required"] = 'Pertanyaan ini wajib dijawab.';
            }

            // Jalankan validasi
            $this->validate($rules, $messages);
        }

        // Jika validasi lolos, baru lanjut ke step berikutnya
        $this->step++;
    }

    public function submit()
    {
        // 1. Validasi: Pastikan semua pertanyaan sudah dijawab
        // (Opsional: Tambahkan logika validasi di sini jika diperlukan)

        try {
            // 2. Simpan setiap jawaban ke tabel 'jawabans'
            foreach ($this->answers as $questionId => $answer) {
                \App\Models\Jawaban::create([
                    'user_id' => auth()->id(), // Mengambil ID dari user yang login
                    'question_id' => $questionId,
                    'dosen_id' => ($this->kategori === 'dosen') ? $this->selectedDosen : null,
                    'nilai_jawaban' => $answer['nilai'] ?? null,
                    'teks_jawaban' => $answer['teks'] ?? null,
                    // Data identitas diambil otomatis dari profil user saat ini
                    'gender' => auth()->user()->gender,
                    'status_responden' => auth()->user()->status_responden,
                    'program_studi' => auth()->user()->program_studi,
                    'angkatan' => auth()->user()->angkatan,
                ]);
            }

            // 3. Tampilkan notifikasi sukses dan kembali ke dashboard
            $this->dispatch('show-toast', message: 'Kuesioner berhasil dikirim!', icon: 'success');
            return redirect()->route('thank-you');

        } catch (\Exception $e) {
            $this->dispatch('show-toast', message: 'Terjadi kesalahan: ' . $e->getMessage(), icon: 'error');
        }
    }

    public function isQuestionStep(): bool 
    { 
        return $this->step >= 2 && $this->step <= ($this->subCategories->count() + 1); 
    }

    public function render()
    {
        return view('livewire.kuisioner-form', [
            'kuisioners' => $this->subCategories,
            'dosens' => $this->dosens,
            'listDosen' => \App\Models\Dosen::all(),
        ])->layout('layouts.app');
    }
}