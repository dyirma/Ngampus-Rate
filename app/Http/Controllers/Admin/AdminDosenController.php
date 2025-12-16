<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class AdminDosenController extends Controller
{
    // Fungsi utama yang dijalankan saat admin membuka halaman daftar dosen.
    // Tujuannya: Mengambil dan menampilkan semua data dosen yang terdaftar di sistem.
    public function index()
    {   
        // Mengambil semua data Dosen dari database, diurutkan berdasarkan nama dan diambil 10 data per halaman.
        $dosens = Dosen::orderBy('nama')->paginate(10);

        // Mengembalikan view 'admin.dosens.index' dengan data dosen yang sudah diambil.
        return view('admin.dosens.index', compact('dosens'));
    }
    // Fungsi untuk menampilkan form tambah dosen. 
    // Tujuannya: Menampilkan form untuk memasukkan data dosen baru.    
    public function create()
    {   
        // Mengembalikan view 'admin.dosens.create' untuk menampilkan form tambah dosen.
        return view('admin.dosens.create');
    }
    // Fungsi untuk menyimpan data dosen baru ke database.
    // Tujuannya: Menyimpan data dosen baru yang diinputkan oleh admin.
    public function store(Request $request)
    {   
        // Validasi data yang diinputkan oleh admin.
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'], // Nama dosen harus diisi dan maksimal 255 karakter.
            'nip' => ['required', 'string', 'max:50', 'unique:dosens,nip'], // NIP dosen harus diisi dan maksimal 50 karakter dan harus unik.
        ]);

        // Memanggil model Dosen untuk menyimpan data dosen baru.
        Dosen::create($data);

        // Mengembalikan redirect ke halaman daftar dosen dengan pesan sukses.
        return redirect()->route('admin.dosen.index')->with('status', 'Data dosen berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan form edit dosen.
    // Tujuannya: Menampilkan form untuk mengedit data dosen yang sudah ada.
    public function edit(Dosen $dosen)
    {   
        // Mengembalikan view 'admin.dosens.edit' dengan data dosen yang sudah diambil. 
        return view('admin.dosens.edit', compact('dosen'));
    }
    // Fungsi untuk menyimpan data dosen yang sudah diedit ke database.
    // Tujuannya: Menyimpan data dosen yang sudah diedit yang diinputkan oleh admin.
    public function update(Request $request, Dosen $dosen)
    {
        // Validasi data yang diinputkan oleh admin.
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'], // Nama dosen harus diisi dan maksimal 255 karakter.
            'nip' => ['required', 'string', 'max:50', 'unique:dosens,nip,'.$dosen->id], // NIP dosen harus diisi dan maksimal 50 karakter dan harus unik.
            'nama' => ['required', 'string', 'max:255'], // Nama dosen harus diisi dan maksimal 255 karakter.
            'nip' => ['required', 'string', 'max:50', 'unique:dosens,nip,'.$dosen->id], // NIP dosen harus diisi dan maksimal 50 karakter dan harus unik.
        ]);

        // Memanggil model Dosen untuk menyimpan data dosen yang sudah diedit.
        $dosen->update($data);
        // Mengembalikan redirect ke halaman daftar dosen dengan pesan sukses.
        // Pesan sukses: Data dosen berhasil diperbarui.
        return redirect()->route('admin.dosen.index')->with('status', 'Data dosen berhasil diperbarui.');
    }

    // Fungsi untuk menghapus data dosen dari database.
    // Tujuannya: Menghapus data dosen yang diinputkan oleh admin.
    public function destroy(Dosen $dosen)
    {
        // Memanggil model Dosen untuk menghapus data dosen.
        $dosen->delete();
        // Mengembalikan redirect ke halaman daftar dosen dengan pesan sukses.
        // Pesan sukses: Data dosen berhasil dihapus.
        
    // Mengembalikan redirect ke halaman daftar dosen dengan pesan sukses.
    // Pesan sukses: Data dosen berhasil dihapus.
    return redirect()->route('admin.dosen.index')->with('status', 'Data dosen berhasil dihapus.');
}
}
