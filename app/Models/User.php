<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Jawaban;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', // Nama lengkap user
        'email', // Alamat email user
        'password', // Password user (akan di-hash)
        'role', // Peran user (misal: 'admin', 'mahasiswa', 'dosen')
        'gender', // Jenis kelamin
        'status_responden', // Status responden (misal: 'mahasiswa aktif', 'alumni')
        'program_studi', // Program studi user
        'angkatan', // Tahun angkatan user
    ];

    // Relasi One-to-Many (Satu ke Banyak).
    // Satu User bisa memiliki BANYAK data Jawaban (nilai kuisioner).
    public function jawabans()
    {
        // Fungsi hasMany() memberitahu Laravel bahwa ada banyak baris di tabel 'jawabans'
        // yang memiliki 'user_id' yang mengarah ke User ini.
        return $this->hasMany(\App\Models\Jawaban::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // Properti $hidden menentukan kolom mana saja yang TIDAK boleh ditampilkan saat model diubah menjadi array atau JSON.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Properti $casts digunakan untuk mengubah tipe data kolom secara otomatis saat diambil dari database.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
