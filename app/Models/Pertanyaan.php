<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Kuisioner;
use App\Models\Jawaban;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuisioner_id',
        'teks_pertanyaan',
        'tipe_jawaban',
        'opsi_dropdown',
    ];

    protected $casts = [
        'opsi_dropdown' => 'array',
    ];

    public function kuisioner()
    {
        return $this->belongsTo(Kuisioner::class);
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
