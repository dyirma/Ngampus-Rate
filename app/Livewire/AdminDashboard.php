<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Jawaban;
use App\Models\Category;    
use App\Models\SubCategory; 
use App\Models\Question;    
use App\Models\Dosen; 
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    use WithPagination;

    public $activeTab = 'responden';
    public $showModal = false;
    public $modalType = ''; 
    public $isEdit = false;
    public $editId = null;
    public $averageScore = 0; 

    // Properti untuk memisahkan sesi pengisian
    public $selectedRespondenId = null;
    public $selectedSessionTime = null; 
    public $filterDosen = null; 
    public $selectedKategori = null; 

    // Field Form
    public $nama_kategori, $deskripsi; 
    public $teks_pertanyaan, $tipe_jawaban = 'likert', $sub_category_id;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->selectedKategori = null;
        $this->selectedRespondenId = null;
        $this->selectedSessionTime = null;
        $this->filterDosen = null; 
        $this->resetPage();
    }

    public function updatedSelectedKategori()
    {
        $this->filterDosen = null;
        $this->resetPage();
    }

    public function viewDetailJawaban($userId, $categoryId, $createdAt = null)
    {
        $this->selectedRespondenId = $userId;
        $this->selectedKategori = $categoryId;
        $this->selectedSessionTime = $createdAt;

        // LOGIKA PERBAIKAN: Hitung rata-rata langsung dari Database
        $this->averageScore = number_format(
            \App\Models\Jawaban::where('user_id', $userId)
                ->where('created_at', $createdAt)
                ->whereNotNull('nilai_jawaban') // Hanya hitung yang ada angkanya (Likert)
                ->avg('nilai_jawaban') ?? 0, 
            2
        );

        $this->activeTab = 'detail_jawaban';
    }

    // --- LOGIKA MODAL ---
    public function openModal($type, $id = null, $extraId = null)
    {
        $this->resetValidation();
        $this->reset(['nama_kategori', 'deskripsi', 'teks_pertanyaan', 'sub_category_id', 'tipe_jawaban']);
        
        $this->modalType = $type;
        $this->showModal = true;
        $this->isEdit = $id ? true : false;
        $this->editId = $id;

        if ($type === 'kategori' && $id) {
            $cat = Category::find($id);
            $this->nama_kategori = $cat->nama_kategori;
            $this->deskripsi = $cat->deskripsi;
        } elseif ($type === 'sub' && $id) {
            $sub = SubCategory::find($id);
            $this->nama_kategori = $sub->nama_sub;
            $this->deskripsi = $sub->deskripsi_sub;
        } elseif ($type === 'pertanyaan' && $id) {
            $q = Question::find($id);
            $this->teks_pertanyaan = $q->teks_pertanyaan;
            $this->sub_category_id = $q->sub_category_id;
            $this->tipe_jawaban = $q->tipe_jawaban;
        } else {
            $this->sub_category_id = $extraId;
        }
    }

    public function closeModal() { $this->showModal = false; }

    public function save()
    {
        // Simpan status isEdit ke variabel lokal sebelum modal ditutup & isEdit direset
        $sedangEdit = $this->isEdit;

        if ($this->modalType === 'kategori') {
            $this->validate(['nama_kategori' => 'required']);
            Category::updateOrCreate(['id' => $this->editId], [
                'nama_kategori' => $this->nama_kategori,
                'slug' => \Illuminate\Support\Str::slug($this->nama_kategori),
                'deskripsi' => $this->deskripsi,
            ]);
            $pesan = $sedangEdit ? 'Kategori berhasil diperbarui!' : 'Kategori berhasil ditambahkan!';
        } 
        elseif ($this->modalType === 'sub') {
            $this->validate(['nama_kategori' => 'required']);
            SubCategory::updateOrCreate(['id' => $this->editId], [
                'category_id' => $this->selectedKategori,
                'nama_sub' => $this->nama_kategori,
                'deskripsi_sub' => $this->deskripsi,
            ]);
            $pesan = $sedangEdit ? 'Sub-Pertanyaan berhasil diperbarui!' : 'Sub-Pertanyaan berhasil ditambahkan!';
        } 
        elseif ($this->modalType === 'pertanyaan') {
            $this->validate(['teks_pertanyaan' => 'required', 'sub_category_id' => 'required']);
            Question::updateOrCreate(['id' => $this->editId], [
                'sub_category_id' => $this->sub_category_id,
                'teks_pertanyaan' => $this->teks_pertanyaan,
                'tipe_jawaban' => $this->tipe_jawaban,
            ]);
            $pesan = $sedangEdit ? 'Butir soal berhasil diperbarui!' : 'Butir soal berhasil ditambahkan!';
        }

        $this->closeModal();

        // HANYA kirim dispatch jika sedang dalam mode EDIT
        if ($sedangEdit) {
            $this->dispatch('show-toast', [
                'icon' => 'success', 
                'message' => $pesan
            ]);
        }
    }

    public function deleteResponden($userId, $categoryId, $createdAt = null) 
    {
        $query = Jawaban::where('user_id', $userId)
            ->whereHas('question.subCategory', function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        
        if($createdAt) {
            $query->where('created_at', $createdAt);
        }

        $query->delete();

        $this->dispatch('show-toast', [
            'icon' => 'success', 
            'message' => 'Jawaban responden berhasil dihapus.'
        ]);
    }

    public function deleteKategori($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            $this->dispatch('show-toast', icon: 'success', message: 'Kategori berhasil dihapus.');
        }
    }

    public function deleteSub($id)
    {
        $sub = SubCategory::find($id);
        if ($sub) {
            $sub->delete();
            $this->dispatch('show-toast', icon: 'success', message: 'Sub-Kategori berhasil dihapus.');
        }
    }

    public function deletePertanyaan($id)
    {
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            $this->dispatch('show-toast', icon: 'success', message: 'Butir soal berhasil dihapus.');
        }
    }
    
    public function render()
    {
        $detailJawaban = [];
        
        // PERBAIKAN LOGIC: Menghitung total sesi secara dinamis berdasarkan filter yang aktif
        $totalSesi = Jawaban::distinct('jawabans.user_id', 'jawabans.created_at')
            ->join('questions', 'jawabans.question_id', '=', 'questions.id')
            ->join('sub_categories', 'questions.sub_category_id', '=', 'sub_categories.id')
            // Filter berdasarkan kategori jika dipilih (misal: Kuesioner Dosen)
            ->when($this->selectedKategori, function($query) {
                $query->where('sub_categories.category_id', $this->selectedKategori);
            })
            // Filter berdasarkan dosen jika dipilih
            ->when($this->filterDosen, function($query) {
                $query->where('jawabans.dosen_id', $this->filterDosen);
            })
            ->count(['jawabans.user_id', 'jawabans.created_at']);

        // LOGIKA DINAMIS KOTAK KANAN (Kategori / Rata-rata Kategori)
            $rightBoxValue = 0;
            $rightBoxLabel = 'Total Kategori Utama';

            if ($this->activeTab === 'detail_jawaban') {
                // Jika di halaman Detail, gunakan nilai yang sudah dihitung di viewDetailJawaban
                $rightBoxValue = $this->averageScore;
                $rightBoxLabel = 'Rata-Rata Responden Ini';
            } elseif ($this->selectedKategori) {
                // Jika di halaman List Responden Kategori A, hitung rata-rata kategori tersebut
                $avgKategori = Jawaban::join('questions', 'jawabans.question_id', '=', 'questions.id')
                    ->join('sub_categories', 'questions.sub_category_id', '=', 'sub_categories.id')
                    ->where('sub_categories.category_id', $this->selectedKategori)
                    ->whereNotNull('nilai_jawaban')
                    ->avg('nilai_jawaban');
                
                $rightBoxValue = number_format($avgKategori ?? 0, 2);
                $rightBoxLabel = 'Rata-Rata Kategori Ini';
            } else {
                // Jika di Dashboard utama
                $rightBoxValue = Category::count();
                $rightBoxLabel = 'Total Kategori Utama';
            }

        // 1. Perbaikan pada main_cards (Optimasi N+1)
        $main_cards = Category::addSelect([
            'total_responden' => Jawaban::selectRaw('count(distinct concat(jawabans.user_id, jawabans.created_at))')
                ->join('questions', 'jawabans.question_id', '=', 'questions.id')
                ->join('sub_categories', 'questions.sub_category_id', '=', 'sub_categories.id')
                ->whereColumn('sub_categories.category_id', 'categories.id')
        ])->get();  

        // Logic untuk Detail Jawaban (Tetap seperti kodingan Anda)
        if ($this->selectedRespondenId && $this->selectedKategori) {
            $detailQuery = Jawaban::where('user_id', $this->selectedRespondenId)
                ->whereHas('question.subCategory', function($query) {
                    $query->where('category_id', $this->selectedKategori);
                });

            if($this->selectedSessionTime) {
                $detailQuery->where('created_at', $this->selectedSessionTime);
            }

            $detailJawaban = $detailQuery->with(['question.subCategory.category', 'dosen'])
                ->get()
                ->groupBy(fn($item) => $item->question->subCategory->category->nama_kategori ?? 'Kategori');
        }

        return view('livewire.admin-dashboard', [
            'stats' => [
                'total_responden' => $totalSesi, 
                'total_kategori' => Category::count(),
                'right_value' => $rightBoxValue, 
                'right_label' => $rightBoxLabel,
            ],
            'main_cards' => $main_cards,
            'activeCategory' => $this->selectedKategori ? Category::with(['subCategories.questions'])->find($this->selectedKategori) : null,
            'respondents' => Jawaban::join('users', 'jawabans.user_id', '=', 'users.id')
                ->join('questions', 'jawabans.question_id', '=', 'questions.id')
                ->join('sub_categories', 'questions.sub_category_id', '=', 'sub_categories.id')
                ->leftJoin('dosens', 'jawabans.dosen_id', '=', 'dosens.id') 
                ->select(
                    'users.id as user_id', 
                    'users.name', 
                    'sub_categories.category_id', 
                    'dosens.nama as nama_dosen', 
                    'dosens.nip as nip_dosen', 
                    'jawabans.status_responden', 
                    'jawabans.program_studi', 
                    'jawabans.created_at',
                    DB::raw('(SELECT AVG(j2.nilai_jawaban) FROM jawabans j2 
                            WHERE j2.user_id = jawabans.user_id 
                            AND j2.created_at = jawabans.created_at 
                            AND j2.nilai_jawaban IS NOT NULL) as rata_rata_nilai')
                )
                ->when($this->selectedKategori, fn($q) => $q->where('sub_categories.category_id', $this->selectedKategori))
                ->when($this->filterDosen, fn($q) => $q->where('jawabans.dosen_id', $this->filterDosen))
                ->distinct('jawabans.user_id', 'jawabans.created_at') 
                ->orderBy('jawabans.created_at', 'desc')
                ->paginate(10),
            'detailJawaban' => $detailJawaban,
            'userTerpilih' => User::find($this->selectedRespondenId),
            'listDosens' => Dosen::orderBy('nama')->get(),
        ])->layout('layouts.app');
    }
}