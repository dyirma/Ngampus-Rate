<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

// Controller ini bertugas mengelola CRUD (Create, Read, Update, Delete) Pertanyaan.
// Uniknya, setiap pertanyaan SELALU terikat dengan satu Kuisioner (Parent-Child Relationship).
class AdminPertanyaanController extends Controller
{
    //Menampilkan daftar pertanyaan milik satu kuisioner tertentu menggunakan Route Model Binding (Kuisioner $kuisioner) agar otomatis dapat datanya.
    public function index(Kuisioner $kuisioner)
    {
        // Mengambil pertanyaan yang HANYA milik kuisioner ini saja.
        // Diurutkan berdasarkan ID dan dipagination 15 item per halaman.
        $pertanyaans = $kuisioner->pertanyaan()->orderBy('id')->paginate(15);

        // Mengirim data kuisioner (induk) dan pertanyaannya (anak) ke view.
        return view('admin.pertanyaan.index', compact('kuisioner', 'pertanyaans'));
    }

    //Menampilkan form untuk membuat pertanyaan baru di dalam kuisioner tertentu.
    public function create(Kuisioner $kuisioner)
    {
        // Kita kirim data $kuisioner agar form tahu pertanyaan ini mau disimpan ke mana.
        return view('admin.pertanyaan.create', compact('kuisioner'));
    }

    //Memproses penyimpanan pertanyaan baru.
    public function store(Request $request, Kuisioner $kuisioner)
    {
        // 1. Validasi Input
        $data = $request->validate([
            'teks_pertanyaan' => ['required', 'string'],
            // Tipe jawaban dibatasi hanya boleh 3 jenis ini:
            'tipe_jawaban' => ['required', 'in:likert,text,dropdown'],
            // Opsi dropdown boleh kosong jika tipenya bukan dropdown
            'opsi_dropdown' => ['nullable', 'array'],
            'opsi_dropdown.*' => ['nullable', 'string'],
        ]);

        // 2. Logika Khusus Tipe Dropdown
        if ($data['tipe_jawaban'] !== 'dropdown') {
            // Jika bukan dropdown, pastikan kolom opsi_dropdown dikosongkan (null)
            // untuk menghindari sampah data.
            $data['opsi_dropdown'] = null;
        } else {
            // Jika dropdown, bersihkan format datanya menggunakan fungsi helper di bawah.
            $data['opsi_dropdown'] = $this->sanitizeDropdownOptions($data['opsi_dropdown'] ?? []);
        }

        // 3. Simpan Data melalui Relasi
        // $kuisioner->pertanyaan()->create(...) otomatis mengisi kolom 'kuisioner_id'
        $kuisioner->pertanyaan()->create($data);

        return redirect()->route('admin.kuisioner.pertanyaan.index', $kuisioner)->with('status', 'Pertanyaan berhasil ditambahkan.');
    }

    //Menampilkan form edit pertanyaan.
    public function edit(Kuisioner $kuisioner, Pertanyaan $pertanyaan)
    {
        return view('admin.pertanyaan.edit', compact('kuisioner', 'pertanyaan'));
    }

    //Memproses update pertanyaan yang sudah ada.
    public function update(Request $request, Kuisioner $kuisioner, Pertanyaan $pertanyaan)
    {
        // 1. Validasi Input (Sama seperti store)
        $data = $request->validate([
            'teks_pertanyaan' => ['required', 'string'],
            'tipe_jawaban' => ['required', 'in:likert,text,dropdown'],
            'opsi_dropdown' => ['nullable', 'array'],
            'opsi_dropdown.*' => ['nullable', 'string'],
        ]);

        // 2. Logika Khusus Dropdown
        if ($data['tipe_jawaban'] !== 'dropdown') {
            $data['opsi_dropdown'] = null;
        } else {
            $data['opsi_dropdown'] = $this->sanitizeDropdownOptions($data['opsi_dropdown'] ?? []);
        }

        // 3. Update Data
        $pertanyaan->update($data);

        return redirect()->route('admin.kuisioner.pertanyaan.index', $kuisioner)->with('status', 'Pertanyaan berhasil diperbarui.');
    }

    //Menghapus pertanyaan.
    public function destroy(Kuisioner $kuisioner, Pertanyaan $pertanyaan)
    {
        $pertanyaan->delete();

        return redirect()->route('admin.kuisioner.pertanyaan.index', $kuisioner)->with('status', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Helper Function: Membersihkan input opsi dropdown.
     * Input user bisa berantakan (misal dipisah koma, atau enter/baris baru).
     * Fungsi ini merapikannya menjadi array bersih.
     */
    private function sanitizeDropdownOptions(array $options): array
    {
        return collect($options)
            // Memecah string berdasarkan koma (,) ATAU baris baru (\n)
            ->flatMap(fn ($value) => preg_split('/[,|\n]/', (string) $value))
            // Menghapus spasi di awal/akhir setiap opsi
            ->map(fn ($value) => trim($value))
            // Membuang nilai yang kosong/blank
            ->filter()
            // Reset index array agar urut dari 0
            ->values()
            ->all();
    }
}
