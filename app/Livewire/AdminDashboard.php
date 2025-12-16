<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Kuisioner;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class AdminDashboard extends Component
{
    use WithPagination;

    public $activeTab = 'responden';

    // --- 1. VARIABEL UNTUK MODAL (Wajib Ada) ---
    public $showModal = false;
    public $modalType = ''; 
    public $isEdit = false;
    public $editId = null;

    // Data Form Kategori
    public $nama_kuisioner;
    public $deskripsi_kuisioner;

    // Data Form Pertanyaan
    public $pertanyaan_text;
    public $pertanyaan_kategori_id;
    public $pertanyaan_tipe = 'likert'; 

    // --- 2. KEAMANAN ---
    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Halaman ini khusus Administrator.');
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    // --- 3. LOGIKA MODAL (BUKA/TUTUP/RESET) ---
    public function openModal($type, $id = null)
    {
        $this->resetValidation();
        $this->reset(['nama_kuisioner', 'deskripsi_kuisioner', 'pertanyaan_text', 'pertanyaan_kategori_id', 'pertanyaan_tipe']);
        
        $this->modalType = $type;
        $this->showModal = true;
        $this->isEdit = false;

        // Jika Edit Pertanyaan
        if ($type === 'pertanyaan' && $id) {
            $this->isEdit = true;
            $this->editId = $id;
            $q = Pertanyaan::find($id);
            $this->pertanyaan_text = $q->teks_pertanyaan;
            $this->pertanyaan_kategori_id = $q->kuisioner_id;
            $this->pertanyaan_tipe = $q->tipe_jawaban;
        }
        // Jika Edit Kategori
        if ($type === 'kategori' && $id) {
            $this->isEdit = true;
            $this->editId = $id;
            $k = Kuisioner::find($id);
            $this->nama_kuisioner = $k->nama_kuisioner;
            $this->deskripsi_kuisioner = $k->deskripsi;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    // --- 4. LOGIKA SIMPAN DATA ---
    public function saveKategori()
    {
        $this->validate([
            'nama_kuisioner' => 'required|min:3',
            'deskripsi_kuisioner' => 'required|min:5',
        ]);

        if ($this->isEdit) {
            Kuisioner::find($this->editId)->update([
                'nama_kuisioner' => $this->nama_kuisioner,
                'deskripsi' => $this->deskripsi_kuisioner,
            ]);
            $msg = 'Kategori berhasil diperbarui.';
        } else {
            Kuisioner::create([
                'nama_kuisioner' => $this->nama_kuisioner,
                'deskripsi' => $this->deskripsi_kuisioner,
            ]);
            $msg = 'Kategori baru berhasil ditambahkan.';
        }

        $this->closeModal();
        $this->dispatch('show-toast', message: $msg, icon: 'success');
    }

    public function savePertanyaan()
    {
        $this->validate([
            'pertanyaan_text' => 'required|min:5',
            'pertanyaan_kategori_id' => 'required|exists:kuisioners,id',
            'pertanyaan_tipe' => 'required|in:likert,text',
        ]);

        if ($this->isEdit) {
            Pertanyaan::find($this->editId)->update([
                'teks_pertanyaan' => $this->pertanyaan_text,
                'kuisioner_id' => $this->pertanyaan_kategori_id,
                'tipe_jawaban' => $this->pertanyaan_tipe,
            ]);
            $msg = 'Pertanyaan berhasil diperbarui.';
        } else {
            Pertanyaan::create([
                'teks_pertanyaan' => $this->pertanyaan_text,
                'kuisioner_id' => $this->pertanyaan_kategori_id,
                'tipe_jawaban' => $this->pertanyaan_tipe,
            ]);
            $msg = 'Pertanyaan baru berhasil ditambahkan.';
        }

        $this->closeModal();
        $this->dispatch('show-toast', message: $msg, icon: 'success');
    }

    // --- 5. LOGIKA HAPUS (SWEETALERT) ---
    
    // Trigger Popup Konfirmasi Responden
    public function confirmDeleteResponden($id)
    {
        $this->dispatch('show-delete-confirmation', type: 'responden', id: $id);
    }

    // Eksekusi Hapus Responden
    #[On('delete-responden-confirmed')] 
    public function deleteResponden($id)
    {
        Jawaban::where('user_id', $id)->delete();
        $this->dispatch('show-toast', message: 'Data responden berhasil dihapus.', icon: 'success');
    }

    // Trigger Popup Konfirmasi Pertanyaan
    public function confirmDeletePertanyaan($id)
    {
        $this->dispatch('show-delete-confirmation', type: 'pertanyaan', id: $id);
    }

    // Eksekusi Hapus Pertanyaan
    #[On('delete-pertanyaan-confirmed')]
    public function deletePertanyaan($id)
    {
        Pertanyaan::find($id)->delete();
        Jawaban::where('pertanyaan_id', $id)->delete();
        $this->dispatch('show-toast', message: 'Pertanyaan berhasil dihapus.', icon: 'success');
    }

    public function render()
    {
        $userIds = Jawaban::distinct()->pluck('user_id');
        
        $respondents = User::whereIn('id', $userIds)
            ->where('role', '!=', 'admin')
            ->latest()
            ->paginate(10);

        $grouped_questions = Kuisioner::with(['pertanyaan' => function($q) {
            $q->orderBy('id'); 
        }])->get();

        $all_categories = Kuisioner::all(); 

        $stats = [
            'total_responden' => $userIds->count(),
            'total_pertanyaan' => Pertanyaan::count(),
            'total_jawaban_masuk' => Jawaban::count(),
        ];

        return view('livewire.admin-dashboard', [
            'respondents' => $respondents,
            'grouped_questions' => $grouped_questions,
            'all_categories' => $all_categories,
            'stats' => $stats
        ])->layout('layouts.app');
    }
}