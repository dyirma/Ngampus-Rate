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

class KuisionerForm extends Component
{
    public int $step = 0;

    public array $dataDiri = [
        'name' => '',
        'gender' => '',
        'status_responden' => '',
        'program_studi' => '',
        'angkatan' => '',
        'dosen_id' => null,
    ];

    public array $answers = [];

    public Collection $kuisioners;

    public Collection $dosens;

    public array $likertLabels = [
        1 => 'Sangat Tidak Setuju',
        2 => 'Tidak Setuju',
        3 => 'Netral',
        4 => 'Setuju',
        5 => 'Sangat Setuju',
    ];

    public function mount(): void
    {
        $user = Auth::user();

        $this->kuisioners = Kuisioner::with('pertanyaan')->orderBy('id')->get();
        $this->dosens = Dosen::orderBy('nama')->get();

        $this->dataDiri = [
            'name' => $user->name,
            'gender' => $user->gender ?? '',
            'status_responden' => $user->status_responden ?? '',
            'program_studi' => $user->program_studi ?? '',
            'angkatan' => $user->angkatan ?? '',
            'dosen_id' => null,
        ];

        $this->initializeAnswers();
    }

    public function start(): void
    {
        $this->step = 1;
    }

    public function goToPreviousStep(): void
    {
        if ($this->step > 0) {
            $this->step--;
        }
    }

    public function goToNextStep(): void
    {
        if ($this->step === 0) {
            $this->start();
            return;
        }

        if ($this->step === 1) {
            $this->validateDataDiri();
        } elseif ($this->isQuestionStep()) {
            $this->validateCurrentQuestions();
        }

        if ($this->step < $this->totalSteps() - 1) {
            $this->step++;
        }
    }

    public function submit(): mixed
    {
        $this->validateDataDiri();
        $this->validateAllQuestions();

        $user = Auth::user();

        DB::transaction(function () use ($user) {
            $user->update([
                'name' => $this->dataDiri['name'],
                'gender' => $this->dataDiri['gender'],
                'status_responden' => $this->dataDiri['status_responden'],
                'program_studi' => $this->dataDiri['program_studi'],
                'angkatan' => $this->dataDiri['angkatan'],
            ]);

            $user->jawaban()->delete();

            foreach ($this->answers as $pertanyaanId => $jawaban) {
                Jawaban::create([
                    'user_id' => $user->id,
                    'dosen_id' => $this->dataDiri['dosen_id'],
                    'pertanyaan_id' => $pertanyaanId,
                    'nilai_jawaban' => $jawaban['nilai'] ?? null,
                    'teks_jawaban' => $jawaban['teks'] ?? null,
                ]);
            }
        });

        session()->flash('kuisioner_submitted', true);

        return redirect()->route('thank-you');
    }

    #[Computed]
    public function currentKuisioner(): ?Kuisioner
    {
        if (! $this->isQuestionStep()) {
            return null;
        }

        $index = $this->step - 2;

        return $this->kuisioners->values()->get($index);
    }

    #[Computed]
    public function summaryData(): array
    {
        $summary = [];

        foreach ($this->kuisioners as $kuisioner) {
            $summary[$kuisioner->nama_kuisioner] = $kuisioner->pertanyaan->map(function ($pertanyaan) {
                $jawaban = $this->answers[$pertanyaan->id] ?? ['nilai' => null, 'teks' => null];

                return [
                    'pertanyaan' => $pertanyaan->teks_pertanyaan,
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
            'dataDiri.name' => 'Nama Lengkap',
            'dataDiri.gender' => 'Jenis Kelamin',
            'dataDiri.status_responden' => 'Status',
            'dataDiri.program_studi' => 'Fakultas/Jurusan',
            'dataDiri.angkatan' => 'Angkatan',
            'dataDiri.dosen_id' => 'Dosen',
        ]);
    }

    private function validateCurrentQuestions(): void
    {
        $kuisioner = $this->currentKuisioner();

        if (! $kuisioner) {
            return;
        }

        $rules = [];

        foreach ($kuisioner->pertanyaan as $pertanyaan) {
            if ($pertanyaan->tipe_jawaban === 'likert') {
                $rules["answers.{$pertanyaan->id}.nilai"] = ['required', 'integer', 'between:1,5'];
            } elseif ($pertanyaan->tipe_jawaban === 'text') {
                $rules["answers.{$pertanyaan->id}.teks"] = ['required', 'string', 'min:3'];
            } else {
                $rules["answers.{$pertanyaan->id}.nilai"] = ['required'];
            }
        }

        $this->validate($rules);
    }

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

    private function isQuestionStep(): bool
    {
        return $this->step > 1 && $this->step <= ($this->kuisioners->count() + 1);
    }

    private function totalSteps(): int
    {
        return $this->kuisioners->count() + 3;
    }
}
