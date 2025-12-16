<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pertanyaan;

class Kuisioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kuisioner',
        'deskripsi',
    ];

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}
