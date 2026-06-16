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
        'periode',
        'question_id',
        'nilai_jawaban',
        'teks_jawaban',
        'survey_history_id'
    ];

    //untuk mengubah tipe data kolom secara otomatis saat diambil dari database.
    //'nilai_jawaban' dipaksa menjadi integer agar konsisten saat dihitung rata-ratanya.
    protected $casts = [
        'nilai_jawaban' => 'integer',
    ];

    // --- DEFINISI RELASI ANTAR TABEL ---
    protected $guarded = ['id'];
    
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function surveyHistory(): BelongsTo
    {
        return $this->belongsTo(SurveyHistory::class, 'survey_history_id');
    }
}
