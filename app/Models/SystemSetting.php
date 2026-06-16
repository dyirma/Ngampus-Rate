<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getActivePeriode()
    {
        $setting = self::where('key', 'active_periode')->first();
        return $setting ? $setting->value : date('Y');
    }
}
