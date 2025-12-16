<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Mengimpor model Jawaban agar bisa dihubungkan (relasi)
use App\Models\Jawaban;

class Dosen extends Model
{
    // Trait ini memungkinkan kita membuat data dummy (seeding) untuk tabel dosen dengan mudah.
    use HasFactory;

     /**
     * Properti $fillable menentukan kolom mana saja yang boleh diisi secara massal (Mass Assignment).
     * Ini adalah fitur keamanan Laravel agar user tidak bisa sembarangan mengubah kolom lain (misal: ID atau timestamps).
     */
    protected $fillable = [
        'nama', // Nama Lengkap Dosen
        'nip', //NIP
    ];

    /**
     * Definisi Relasi One-to-Many (Satu ke Banyak).
     * Artinya: Satu orang Dosen bisa memiliki BANYAK data Jawaban (nilai kuisioner) dari mahasiswa.
     */
    public function jawaban()
    {
        // Fungsi hasMany() memberitahu Laravel bahwa ada banyak baris di tabel 'jawabans'
        // yang memiliki 'dosen_id' yang mengarah ke Dosen ini.
        return $this->hasMany(Jawaban::class);
    }
}
