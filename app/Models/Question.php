<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Namespace yang benar

class Question extends Model
{
    protected $fillable = ['sub_category_id', 'teks_pertanyaan', 'tipe_jawaban'];

    // Pastikan menggunakan namespace yang diimport di atas
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}