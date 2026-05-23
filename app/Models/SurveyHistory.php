<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
