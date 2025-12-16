<?php

namespace App\Livewire;

use App\Models\Dosen;
use App\Models\Jawaban;
use App\Models\Kuisioner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

// Component ini menangani logika formulir kuisioner bertahap (Multi-Step Form)
class KuisionerForm extends Component
{
    // Menyimpan posisi langkah saat ini (0 = Landing, 1 = Data Diri, dst)
    public int $step = 0;

    // Array untuk menampung input data diri responden sementara
    public array $dataDiri = [
        'name' => '',
        'gender' => '',
        'status_responden' => '',
        'program_studi' => '',
        'angkatan' => '',
        'dosen_id' => null,
    ];

    // Array untuk menampung jawaban kuesioner per pertanyaan
    // Format: [pertanyaan_id => ['nilai' => ..., 'teks' => ...]]
    public array $answers = [];

    // Koleksi data master (Kategori Kuisioner & Daftar Dosen)
    public Collection $kuisioners;
    public Collection $dosens;

    // Label untuk skala Likert (1-5) agar mudah dibaca di View
    public array $likertLabels = [
        1 => 'Sangat Tidak Setuju',
        2 => 'Tidak Setuju',
        3 => 'Netral',
        4 => 'Setuju',
        5 => 'Sangat Setuju',
    ];

    /**
     * Method yang dijalankan pertama kali saat component dimuat.
     * Digunakan untuk inisialisasi data awal.
     */
    public function mount(): void
    {
        $user = Auth::user();

        // Ambil semua kategori kuisioner beserta pertanyaannya
        $this->kuisioners = Kuisioner::with('pertanyaan')->orderBy('id')->get();
        // Ambil daftar dosen untuk dropdown
        $this->dosens = Dosen::orderBy('nama')->get();

        // Ambil daftar dosen untuk dropdown
        $this->dataDiri = [
            'name' => $user->name,
            'gender' => $user->gender ?? '',
            'status_responden' => $user->status_responden ?? '',
            'program_studi' => $user->program_studi ?? '',
            'angkatan' => $user->angkatan ?? '',
            'dosen_id' => null, // Dosen harus dipilih manual
        ];

        // Siapkan array kosong untuk menampung jawaban nanti
        $this->initializeAnswers();
    }

    //Memulai kuisioner (Pindah dari Landing Page ke Step 1)
    public function start(): void
    {
        $this->step = 1;
    }

    //Mundur satu langkah ke belakang
    public function goToPreviousStep(): void
    {
        if ($this->step > 0) {
            $this->step--;
        }
    }

    //Maju satu langkah ke depan (dengan Validasi)
    public function goToNextStep(): void
    {
        // Jika di Landing Page, langsung mulai
        if ($this->step === 0) {
            $this->start();
            return;
        }

        // Validasi Data Diri sebelum lanjut ke pertanyaan
        if ($this->step === 1) {
            $this->validateDataDiri();

        // Validasi Pertanyaan pada halaman saat ini sebelum lanjut ke halaman berikutnya
        } elseif ($this->isQuestionStep()) {
            $this->validateCurrentQuestions();
        }

        // Jika belum mencapai langkah terakhir, lanjut
        if ($this->step < $this->totalSteps() - 1) {
            $this->step++;
        }
    }

    // Proses Final: Menyimpan semua data ke database.
    public function submit(): mixed
    {
        //Proses Final: Menyimpan semua data ke database.
        $this->validateDataDiri();
        $this->validateAllQuestions();

        $user = Auth::user();

        // Gunakan Transaksi Database agar data konsisten (Rollback jika ada error)
        DB::transaction(function () use ($user) {
            // 1. Update data profil user dengan data terbaru dari form
            $user->update([
                'name' => $this->dataDiri['name'],
                'gender' => $this->dataDiri['gender'],
                'status_responden' => $this->dataDiri['status_responden'],
                'program_studi' => $this->dataDiri['program_studi'],
                'angkatan' => $this->dataDiri['angkatan'],
            ]);

            // 2. Hapus jawaban lama user ini (jika ada) agar tidak duplikat
            // (Opsional: Tergantung kebijakan, apakah boleh ngisi berkali-kali atau ditimpa)
            $user->jawaban()->delete();

            // 3. Simpan setiap jawaban ke tabel 'jawabans'
            foreach ($this->answers as $pertanyaanId => $jawaban) {
                Jawaban::create([
                    'user_id' => $user->id,
                    'dosen_id' => $this->dataDiri['dosen_id'],
                    'pertanyaan_id' => $pertanyaanId,
                    'nilai_jawaban' => $jawaban['nilai'] ?? null, // Untuk tipe Likert
                    'teks_jawaban' => $jawaban['teks'] ?? null, // Untuk tipe Esai
                ]);
            }
        });

        // Beri sinyal sukses ke session
        session()->flash('kuisioner_submitted', true);
        // Redirect ke halaman Terima Kasih
        return redirect()->route('thank-you');
    }

    /**
     * Property Terhitung: Mendapatkan Kategori Kuisioner yang sedang aktif ditampilkan.
     * Berguna untuk menampilkan Judul & Deskripsi Kategori di halaman pertanyaan.
     */
    #[Computed]
    public function currentKuisioner(): ?Kuisioner
    {
        if (! $this->isQuestionStep()) {
            return null;
        }

        // Hitung index array berdasarkan step (dikurangi halaman landing & data diri)
        $index = $this->step - 2;

        return $this->kuisioners->values()->get($index);
    }

    /**
     * Property Terhitung: Menyiapkan ringkasan jawaban untuk halaman Review (Step Terakhir).
     */
    #[Computed]
    public function summaryData(): array
    {
        $summary = [];

        foreach ($this->kuisioners as $kuisioner) {
            // Mapping setiap pertanyaan dengan jawaban yang sudah diisi user
            $summary[$kuisioner->nama_kuisioner] = $kuisioner->pertanyaan->map(function ($pertanyaan) {
                $jawaban = $this->answers[$pertanyaan->id] ?? ['nilai' => null, 'teks' => null];

                return [
                    'pertanyaan' => $pertanyaan->teks_pertanyaan,
                    // Format tampilan jawaban (Angka + Label atau Teks Esai)
                    'jawaban' => $pertanyaan->tipe_jawaban === 'likert'
                        ? ($jawaban['nilai'] ? "{$jawaban['nilai']} - {$this->likertLabels[$jawaban['nilai']]}" : 'Belum diisi')
                        : ($jawaban['teks'] ?: 'Belum diisi'),
                ];
            })->toArray();
        }

        return $summary;
    }

    public function render()
    {
        return view('livewire.kuisioner-form')
        ->layout('layouts.app');
    }

    // --- FUNGSI BANTUAN (HELPER) ---

    /**
     * Menyiapkan struktur array jawaban kosong saat inisialisasi.
     */
    private function initializeAnswers(): void
    {
        foreach ($this->kuisioners as $kuisioner) {
            foreach ($kuisioner->pertanyaan as $pertanyaan) {
                $this->answers[$pertanyaan->id] = [
                    'nilai' => null,
                    'teks' => '',
                ];
            }
        }
    }

    /**
     * Validasi khusus Step 1 (Data Diri).
     */
    private function validateDataDiri(): void
    {
        $this->validate([
            'dataDiri.name' => ['required', 'min:3'],
            'dataDiri.gender' => ['required', 'in:Laki-laki,Perempuan'],
            'dataDiri.status_responden' => ['required', 'in:mahasiswa,dosen,staf'],
            'dataDiri.program_studi' => ['required'],
            'dataDiri.angkatan' => ['required'],
            'dataDiri.dosen_id' => ['required', 'exists:dosens,id'],
        ], [], [
            // Custom attribute names agar pesan error lebih manusiawi
            'dataDiri.name' => 'Nama Lengkap',
            'dataDiri.gender' => 'Jenis Kelamin',
            'dataDiri.status_responden' => 'Status',
            'dataDiri.program_studi' => 'Fakultas/Jurusan',
            'dataDiri.angkatan' => 'Angkatan',
            'dataDiri.dosen_id' => 'Dosen',
        ]);
    }

    /**
     * Validasi pertanyaan HANYA pada halaman yang sedang aktif.
     */
    private function validateCurrentQuestions(): void
    {
        $kuisioner = $this->currentKuisioner();

        if (! $kuisioner) {
            return;
        }

        $rules = [];

        foreach ($kuisioner->pertanyaan as $pertanyaan) {
            if ($pertanyaan->tipe_jawaban === 'likert') {
                // Validasi Likert: Wajib diisi, harus angka 1-5
                $rules["answers.{$pertanyaan->id}.nilai"] = ['required', 'integer', 'between:1,5'];
            } elseif ($pertanyaan->tipe_jawaban === 'text') {
                // Validasi Esai: Wajib diisi, minimal 3 huruf
                $rules["answers.{$pertanyaan->id}.teks"] = ['required', 'string', 'min:3'];
            } else {
                $rules["answers.{$pertanyaan->id}.nilai"] = ['required'];
            }
        }

        $this->validate($rules);
    }

    /**
     * Validasi semua pertanyaan sekaligus (untuk keamanan sebelum submit).
     */
    private function validateAllQuestions(): void
    {
        foreach ($this->kuisioners as $kuisioner) {
            foreach ($kuisioner->pertanyaan as $pertanyaan) {
                if ($pertanyaan->tipe_jawaban === 'likert') {
                    $this->validate([
                        "answers.{$pertanyaan->id}.nilai" => ['required', 'integer', 'between:1,5'],
                    ]);
                } elseif ($pertanyaan->tipe_jawaban === 'text') {
                    $this->validate([
                        "answers.{$pertanyaan->id}.teks" => ['required', 'string', 'min:3'],
                    ]);
                }
            }
        }
    }

    /**
     * Cek apakah step saat ini adalah halaman pertanyaan.
     */
    private function isQuestionStep(): bool
    {
        return $this->step > 1 && $this->step <= ($this->kuisioners->count() + 1);
    }

    private function totalSteps(): int
    {
        return $this->kuisioners->count() + 3;
    }
}
