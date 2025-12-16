<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Mengimpor model Pertanyaan agar bisa dihubungkan (relasi)
use App\Models\Pertanyaan;

class Kuisioner extends Model
{
    // Trait ini memungkinkan kita membuat data dummy (seeding) untuk tabel kuisioners dengan mudah.
    use HasFactory;

    //untuk menentukan kolom mana saja yang boleh diisi secara massal (Mass Assignment).
    protected $fillable = [
        'nama_kuisioner',// Nama/Judul Kategori Kuisioner (misal: Kompetensi Pedagogik)
        'deskripsi',      // Penjelasan singkat mengenai kategori tersebut
    ];

    // Definisi Relasi One-to-Many (Satu ke Banyak).
    //Satu data Kuisioner (Kategori) bisa memiliki BANYAK butir Pertanyaan di dalamnya.
    public function pertanyaan()
    {
        // Fungsi hasMany() memberitahu Laravel bahwa ada banyak baris di tabel 'pertanyaans'
        // yang memiliki 'kuisioner_id' yang mengarah ke Kuisioner ini.
        return $this->hasMany(Pertanyaan::class);
    }
}
