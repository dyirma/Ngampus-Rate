<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Jawaban;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
    ];

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
