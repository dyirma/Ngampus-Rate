<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $dosenList = [
            "0143772673130313 Deny Prasetyo",
            "0502109401 Ardy Wicaksono",
            "0527068001 Kukuh Madyaningrana",
            "0546768669230352 Karin Sari Saputra",
            "0601089602 Nicky Gilang Wicaksono",
            "0604129602 Salsabila Amalia Putri Bumi",
            "0606079601 Nita Ilmiyatul Lailiyah",
            "0606099402 Azhar Rashed",
            "0607119302 Alfan Ridha",
            "0609069401 Yuniars Renowening",
            "0611079202 Nimas Ratna Sari",
            "0611089601 Viki Hendi Kurniaditya",
            "0612079601 Vincensia Serenade",
            "0613089201 Bella Gusniar",
            "0613098703 Ahmad Aufar Ribhi",
            "0614097701 Fitria Hayu Palupi",
            "0616129502 Graceilla Kristia Sheraphim Budiono",
            "0618097905 Etik Sulistyorini",
            "0618129501 Joshua Christmas Natanael Luwidharto",
            "0620019401 Lova Endriani Zen",
            "0620049303 Windy Rizkaprilisa",
            "0622129701 Imam Syafii",
            "0624019501 Mursalim",
            "0625089901 Maranatha Lisatyaningrum Hainekam Fobia",
            "0626019502 Intan Mustika Jati",
            "0626029502 Mutia Ulfa",
            "0626049701 Dwi Utari Iswavigra",
            "0626129401 Titik Dwi Noviati",
            "0628109204 Muhammad Rifzal Alief Ramadhan",
            "0630079202 Yulaikha Mar'atullatifah",
            "0630119002 Himmatunnisak Mahmudah",
            "0721089401 Mohammad Zainul Ma'arif",
            "1039776677130263 Adhi Luhur Wicaksono",
            "2156776677230133 Veronica Kinanthi Sihutami",
            "2745776677230172 Agatha Pricillia Sekar Tamtomo",
            "3258775676130203 Suyahman",
            "4834770671130502 Muhammad Adi Pratama",
            "6337776677230193 Elsa Pavita",
            "7147770671230393 Anindya Nurul Kusuma Dewi",
            "9651777678130122 Muhammad Anwar Fauzi"
        ];

        foreach ($dosenList as $dosenString) {
            $parts = explode(' ', $dosenString, 2);
            if (count($parts) === 2) {
                $nip = $parts[0];
                $name = $parts[1];

                User::updateOrCreate(
                    ['nip' => $nip],
                    [
                        'name' => $name,
                        'email' => strtolower($nip . '@ush.ac.id'),
                        'password' => Hash::make('12345678'),
                        'role' => 'user',
                        'tipe_pegawai' => 'dosen',
                    ]
                );
            }
        }
    }
}
