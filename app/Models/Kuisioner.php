<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kuisioner extends Model
{
    use HasFactory;

    /**
     * Gabungkan semua kolom ke dalam satu array $fillable.
     * Pastikan 'parent_id' sudah ada agar relasi children bisa disimpan.
     */
    protected $fillable = [
        'nama_kuisioner', 
        'kategori', 
        'deskripsi', 
        'parent_id'
    ];

    /**
     * Relasi untuk mengambil Sub-Pertanyaan (Anak).
     * Ini menyelesaikan error 'Call to undefined relationship [children]'.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Kuisioner::class, 'parent_id');
    }

    /**
     * Relasi untuk kembali ke Kategori Utama (Induk).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Kuisioner::class, 'parent_id');
    }
    
    /**
     * Definisi Relasi One-to-Many ke tabel Pertanyaan.
     */
    public function pertanyaan(): HasMany
    {
        return $this->hasMany(Pertanyaan::class);
    }
}