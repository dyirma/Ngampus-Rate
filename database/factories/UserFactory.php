<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'user',
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'status_responden' => fake()->randomElement(['mahasiswa', 'staf']),
            'program_studi' => fake()->randomElement([
                'S1 Teknik Informatika',
                'S1 Bisnis Digital',
                'S1 Hukum Bisnis',
                'S1 Manajemen Bisnis Internasional',
                'S1 Teknologi Pangan',
                'S1 Gizi',
            ]),
            'angkatan' => (string) fake()->numberBetween(date('Y') - 5, date('Y')),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
