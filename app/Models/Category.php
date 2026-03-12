<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Daftarkan kolom yang boleh diisi secara massal
    protected $fillable = ['nama_kategori', 'slug', 'deskripsi'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
