<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use Illuminate\Http\Request;

// Controller untuk mengelola data kuisioner di admin panel.
class AdminKuisionerController extends Controller
{
    // Fungsi untuk menampilkan halaman daftar kuisioner.
    // Tujuannya: Menampilkan semua data kuisioner yang terdaftar di sistem.
    public function index()
    {
        // Mengambil semua data kuisioner dari database, diurutkan berdasarkan id dan diambil 10 data per halaman.
        $kuisioners = Kuisioner::withCount('pertanyaan')->orderBy('id')->paginate(10);
       
        // Mengembalikan view 'admin.kuisioner.index' dengan data kuisioner yang sudah diambil.
        return view('admin.kuisioner.index', compact('kuisioners'));
    }
    // Fungsi untuk menampilkan form tambah kuisioner.
    // Tujuannya: Menampilkan form untuk memasukkan data kuisioner baru.
    public function create()
    {   
        // Mengembalikan view 'admin.kuisioner.create' untuk menampilkan form tambah kuisioner.
        return view('admin.kuisioner.create');
    }
    // Fungsi untuk menyimpan data kuisioner baru ke database.
    // Tujuannya: Menyimpan data kuisioner baru yang diinputkan oleh admin.
    public function store(Request $request)
    {
        // Validasi data yang diinputkan oleh admin.
        $data = $request->validate([
            'nama_kuisioner' => ['required', 'string', 'max:255'], // Nama kuisioner harus diisi dan maksimal 255 karakter.
            'deskripsi' => ['nullable', 'string'], // Deskripsi kuisioner boleh diisi atau tidak.
            'nama_kuisioner' => ['required', 'string', 'max:255'], // Nama kuisioner harus diisi dan maksimal 255 karakter.
            'deskripsi' => ['nullable', 'string'], // Deskripsi kuisioner boleh diisi atau tidak.
        ]);

        // Memanggil model Kuisioner untuk menyimpan data kuisioner baru.
        Kuisioner::create($data);
        //  Mengembalikan redirect ke halaman daftar kuisioner dengan pesan sukses.
        // Pesan sukses: Kuisioner berhasil dibuat.

        return redirect()->route('admin.kuisioner.index')->with('status', 'Kuisioner berhasil dibuat.');
    }
    // Fungsi untuk menampilkan form edit kuisioner.
    public function edit(Kuisioner $kuisioner)
    {
        // Mengirim data $kuisioner yang ingin diedit ke view agar form terisi otomatis.
        return view('admin.kuisioner.edit', compact('kuisioner')); 
    }

    //Memproses update/perubahan data kuisioner ke database.
    public function update(Request $request, Kuisioner $kuisioner)
    {
        // Validasi inputan baru sebelum di-update.
        $data = $request->validate([
            'nama_kuisioner' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        // Melakukan update pada data kuisioner yang sedang dipilih.
        $kuisioner->update($data);
        
        // Redirect kembali ke daftar kuisioner dengan pesan sukses.
        return redirect()->route('admin.kuisioner.index')->with('status', 'Kuisioner berhasil diperbarui.');
    }

    //Menghapus data kuisioner dari database.
    public function destroy(Kuisioner $kuisioner)
    {
        // Menghapus data kuisioner yang dipilih.
        $kuisioner->delete();

        // Redirect kembali dengan pesan sukses.
        return redirect()->route('admin.kuisioner.index')->with('status', 'Kuisioner berhasil dihapus.');
    }
}

