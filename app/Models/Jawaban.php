<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Mengimpor model-model yang berelasi
use App\Models\User;
use App\Models\Dosen;
use App\Models\Pertanyaan;


class Jawaban extends Model
{
    // Trait ini memungkinkan pembuatan data dummy (seeding) untuk testing
    use HasFactory;

    //menentukan kolom mana saja yang aman untuk diisi secara massal (Mass Assignment).
    //untuk melindungi kolom lain (seperti ID atau timestamps) dari perubahan yang tidak disengaja.
    protected $fillable = [
        'user_id', // ID Mahasiswa yang mengisi
        'dosen_id', // ID Dosen yang dinilai
        'question_id', // ID Pertanyaan yang sedang dijawab
        'nilai_jawaban', // Nilai angka (1-5) untuk pertanyaan tipe Likert
        'teks_jawaban', // Jawaban teks untuk pertanyaan tipe Esai
        'gender', 
        'status_responden',
        'program_studi', 
        'angkatan'
    ];

    //untuk mengubah tipe data kolom secara otomatis saat diambil dari database.
    //'nilai_jawaban' dipaksa menjadi integer agar konsisten saat dihitung rata-ratanya.
    protected $casts = [
        'nilai_jawaban' => 'integer',
    ];

    // --- DEFINISI RELASI ANTAR TABEL ---
    protected $guarded = ['id'];
    //Relasi ke User (Mahasiswa).
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Relasi ke Tabel Dosen
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
