<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Jawaban;
use App\Models\Category;    
use App\Models\SubCategory; 
use App\Models\Question;    
use App\Models\SurveyHistory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    use WithPagination, WithFileUploads;

    public $activeTab = 'pengguna'; // default to users list
    public $hasilTab = 'ringkasan'; // 'ringkasan' atau 'detail'
    public $showModal = false;
    public $modalType = ''; 
    public $isEdit = false;
    public $editId = null;

    public $csv_file;
    public $search = '';

    public $selectedKategori = null; 
    public $selectedPeriode = null;

    // Field Form Kuesioner
    public $nama_kategori, $deskripsi; 
    public $teks_pertanyaan, $tipe_jawaban = 'likert', $sub_category_id;

    // Field Form Pengguna
    public $pengguna_name, $pengguna_email, $pengguna_nip, $pengguna_password;
    public $pengguna_tipe, $pengguna_jabatan, $pengguna_unit;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }
        $this->selectedPeriode = date('Y');
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->selectedKategori = null;
        $this->search = '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedKategori()
    {
        $this->resetPage();
    }

    // removed viewDetailJawaban and deleteResponden since responses are anonymous

    // --- LOGIKA MODAL ---
    public function openModal($type, $id = null, $extraId = null)
    {
        $this->resetValidation();
        $this->reset(['nama_kategori', 'deskripsi', 'teks_pertanyaan', 'sub_category_id', 'tipe_jawaban', 'pengguna_name', 'pengguna_email', 'pengguna_nip', 'pengguna_password', 'pengguna_tipe', 'pengguna_jabatan', 'pengguna_unit', 'csv_file']);
        
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
        } elseif ($type === 'pengguna' && $id) {
            $u = User::find($id);
            $this->pengguna_name = $u->name;
            $this->pengguna_email = $u->email;
            $this->pengguna_nip = $u->nip;
            $this->pengguna_tipe = $u->tipe_pegawai;
            $this->pengguna_jabatan = $u->jabatan;
            $this->pengguna_unit = $u->unit_kerja;
            // password dikosongkan saat diubah, bila ingin ganti ketikkan baru
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
        elseif ($this->modalType === 'pengguna') {
            $rules = [
                'pengguna_name' => 'required',
                'pengguna_nip' => 'required|unique:users,nip' . ($this->editId ? ',' . $this->editId : ''),
                'pengguna_tipe' => 'required',
            ];
            
            if ($sedangEdit) {
                if ($this->pengguna_email) {
                    $rules['pengguna_email'] = 'email|unique:users,email,' . $this->editId;
                }
            } else {
                if ($this->pengguna_email) {
                    $rules['pengguna_email'] = 'email|unique:users,email';
                }
                $rules['pengguna_password'] = 'required|min:8';
            }
            $this->validate($rules);

            // Default fallback untuk email jika kosong
            $emailTerdaftar = $this->pengguna_email ?: ($this->pengguna_nip . '@ush.ac.id');

            $data = [
                'name' => $this->pengguna_name,
                'email' => strtolower(str_replace(' ', '', $emailTerdaftar)),
                'nip' => $this->pengguna_nip,
                'tipe_pegawai' => $this->pengguna_tipe,
                'unit_kerja' => $this->pengguna_unit,
                'jabatan' => $this->pengguna_jabatan,
                'role' => 'user'
            ];
            
            if (!empty($this->pengguna_password)) {
                $data['password'] = \Illuminate\Support\Facades\Hash::make($this->pengguna_password);
            }

            User::updateOrCreate(['id' => $this->editId], $data);
            $pesan = $sedangEdit ? 'Data pegawai berhasil diperbarui!' : 'Pegawai baru berhasil ditambahkan!';
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

    public function deletePengguna($id) 
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->dispatch('show-toast', icon: 'success', message: 'Pengguna berhasil dihapus.');
        }
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

    public function importExcel()
    {
        $this->validate([
            'csv_file' => 'required|mimes:xlsx,xls,csv,txt|max:2048', // max 2MB
        ]);

        try {
            $import = new \App\Imports\UsersImport();
            \Maatwebsite\Excel\Facades\Excel::import($import, $this->csv_file->getRealPath());

            $this->closeModal();
            $this->reset('csv_file');

            $pesan = "Import selesai! {$import->importedCount} pengguna ditambahkan.";
            if ($import->skippedCount > 0) {
                $pesan .= " ({$import->skippedCount} data dilewati karena NIK sudah ada).";
            }

            $this->dispatch('show-toast', [
                'icon' => 'success', 
                'message' => $pesan
            ]);

        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'icon' => 'error', 
                'message' => 'Terjadi kesalahan saat mengimpor CSV.'
            ]);
        }
    }
    
    public function render()
    {
        // Data untuk tab pengguna
        $usersList = null;
        if ($this->activeTab === 'pengguna') {
            $query = User::where('role', '!=', 'admin')->orderBy('created_at', 'desc');
            
            if (!empty($this->search)) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nip', 'like', '%' . $this->search . '%');
                });
            }

            $usersList = $query->paginate(10);
        }

        // Statistik
        $totalPartisipan = SurveyHistory::where('periode', $this->selectedPeriode)->distinct('user_id')->count();
        $totalKategori = Category::count();
        
        // Setup data dashboard (hasil)
        $main_cards = collect();
        $detailHasil = [];
        $rawData = [];
        $rightBoxValue = 0;
        $rightBoxLabel = 'Total Kategori';

        if ($this->activeTab === 'hasil') {
            $main_cards = Category::all();
            $totalUsers = User::where('role', '!=', 'admin')->count();
            // Total partisipan unik di periode ini
            $totalPartisipan = SurveyHistory::where('periode', $this->selectedPeriode)->distinct('user_id')->count();
            
            $rightBoxLabel = 'Partisipasi';
            $rightBoxValue = "0%";
            if ($totalUsers > 0) {
                $rightBoxValue = round(($totalPartisipan / $totalUsers) * 100) . "%";
            }

            if ($this->selectedKategori) {
                // Load detail
                $kategori = Category::with('subCategories.questions')->find($this->selectedKategori);
                if ($kategori) {
                    // Kumpulkan semua ID pertanyaan dari kategori ini
                    $questionIds = [];
                    foreach ($kategori->subCategories as $sub) {
                        $questionIds = array_merge($questionIds, $sub->questions->pluck('id')->toArray());
                    }

                    // Ambil semua jawaban untuk kategori ini sekaligus dengan relasinya
                    $allJawabans = Jawaban::with('surveyHistory')
                        ->whereIn('question_id', $questionIds)
                        ->where('periode', $this->selectedPeriode)
                        ->get();

                    foreach ($kategori->subCategories as $sub) {
                        $subData = [];
                        foreach ($sub->questions as $q) {
                            $jawabansForQ = $allJawabans->where('question_id', $q->id);

                            if ($q->tipe_jawaban == 'likert') {
                                $avg = $jawabansForQ->avg('nilai_jawaban');
                                
                                // Distribusi nilai (1-5) untuk Chart.js
                                $dist = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
                                foreach ($jawabansForQ as $j) {
                                    if ($j->nilai_jawaban) {
                                        $dist[$j->nilai_jawaban]++;
                                    }
                                }

                                $subData[] = [
                                    'id' => $q->id,
                                    'pertanyaan' => $q->teks_pertanyaan,
                                    'tipe' => 'likert',
                                    'hasil' => number_format($avg ?? 0, 1),
                                    'distribusi' => array_values($dist), // array index 0-4 mapping to 1-5
                                ];
                            } else {
                                $texts = $jawabansForQ->whereNotNull('teks_jawaban')->pluck('teks_jawaban')->toArray();
                                $subData[] = [
                                    'id' => $q->id,
                                    'pertanyaan' => $q->teks_pertanyaan,
                                    'tipe' => 'text',
                                    'hasil' => $texts
                                ];
                            }
                        }
                        $detailHasil[$sub->nama_sub] = $subData;
                    }

                    // Susun Raw Data (Excel-like format)
                    $groupedJawabans = $allJawabans->groupBy('survey_history_id');
                    $counter = 1;
                    foreach ($groupedJawabans as $historyId => $jawabansGroup) {
                        if (!$historyId) continue; // Skip jika null (dari data dummy lama)

                        $history = clone $jawabansGroup->first()->surveyHistory;
                        $rowData = [
                            'responden' => 'Responden ' . $counter++,
                            'waktu' => $history ? $history->created_at->format('d M Y, H:i') : 'Unknown',
                            'jawaban' => []
                        ];

                        foreach ($jawabansGroup as $j) {
                            if ($j->nilai_jawaban) {
                                $rowData['jawaban'][$j->question_id] = $j->nilai_jawaban;
                            } else {
                                $rowData['jawaban'][$j->question_id] = $j->teks_jawaban;
                            }
                        }
                        $rawData[] = $rowData;
                    }
                }
            }
        }

        if ($this->activeTab === 'pertanyaan') {
            $main_cards = Category::all();
        }

        return view('livewire.admin-dashboard', [
            'stats' => [
                'total_responden' => $totalPartisipan, 
                'total_kategori' => $totalKategori,
                'right_value' => $rightBoxValue, 
                'right_label' => $rightBoxLabel,
            ],
            'usersList' => $usersList,
            'main_cards' => $main_cards,
            'detailHasil' => $detailHasil,
            'rawData' => $rawData,
            'activeCategory' => $this->selectedKategori ? Category::with(['subCategories.questions'])->find($this->selectedKategori) : null,
        ])->layout('layouts.app');
    }
}