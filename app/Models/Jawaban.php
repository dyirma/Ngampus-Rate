<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Pertanyaan;

class Jawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dosen_id',
        'pertanyaan_id',
        'nilai_jawaban',
        'teks_jawaban',
    ];

    protected $casts = [
        'nilai_jawaban' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
