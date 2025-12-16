<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import Model yang berelasi
use App\Models\Kuisioner;
use App\Models\Jawaban;

class Pertanyaan extends Model
{
    // Trait untuk keperluan testing/seeding data
    use HasFactory;

    // Properti $fillable: Daftar kolom yang boleh diisi secara massal (Mass Assignment).
    protected $fillable = [
        'kuisioner_id', // ID Kategori Kuisioner (Induk)
        'teks_pertanyaan', // Kalimat pertanyaan
        'tipe_jawaban', // Jenis jawaban: 'likert' (skala) atau 'text' (esai) atau 'dropdown'
        'opsi_dropdown', // Pilihan jawaban jika tipenya dropdown (disimpan sebagai JSON)
    ];

    // Properti $casts: Konversi otomatis tipe data saat diambil dari database.
    protected $casts = [
        'opsi_dropdown' => 'array',
    ];


    // Relasi ke Kuisioner (Inverse One-to-Many).
    // Setiap Pertanyaan pasti milik SATU Kategori Kuisioner.
    public function kuisioner()
    {
        return $this->belongsTo(Kuisioner::class);
    }

    // Relasi ke Jawaban (One-to-Many).
    // Satu Pertanyaan bisa memiliki BANYAK Jawaban dari berbagai mahasiswa.
    public function jawaban()
    {
        // artinya tabel 'jawabans' punya foreign key 'pertanyaan_id' yang merujuk ke model ini
        return $this->hasMany(Jawaban::class);
    }
}
