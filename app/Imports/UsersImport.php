<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public $importedCount = 0;
    public $skippedCount = 0;

    public function collection(Collection $rows)
    {
        // Pre-compute password hash ONCE for massive performance boost
        // BCrypt is intentionally slow, so hashing in a loop causes long delays.
        $defaultPassword = Hash::make('12345678');

        foreach ($rows as $index => $row) {
            if (count($row) >= 2) {
                $nik = trim($row[0] ?? '');
                $name = trim($row[1] ?? '');
                $tipe = isset($row[2]) && trim($row[2]) !== '' ? strtolower(trim($row[2])) : 'dosen';
                $jabatan = isset($row[3]) && trim($row[3]) !== '' ? trim($row[3]) : null;

                if (empty($nik) || empty($name)) continue;
                if (strtolower($nik) === 'nik' || strtolower($nik) === 'nuptk') continue;

                $user = User::firstOrCreate(
                    ['nip' => $nik],
                    [
                        'name' => $name,
                        'email' => strtolower($nik . '@ush.ac.id'),
                        'password' => $defaultPassword,
                        'role' => 'user',
                        'tipe_pegawai' => in_array($tipe, ['dosen', 'tendik']) ? $tipe : 'dosen',
                        'jabatan' => $jabatan,
                    ]
                );

                if ($user->wasRecentlyCreated) {
                    $this->importedCount++;
                } else {
                    $this->skippedCount++;
                }
            }
        }
    }
}
