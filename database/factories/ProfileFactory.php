<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jurusan = fake()->randomElement([
            'Teknik Informatika',
            'Sistem Informasi',
            'Desain Komunikasi Visual',
            'Manajemen',
            'Akuntansi',
            'Teknik Elektro',
            'Ilmu Komunikasi',
            'Sastra Inggris',
        ]);

        return [
            'user_id' => User::factory(),
            'nim' => fake()->unique()->numerify('##########'),
            'jurusan' => $jurusan,
            'angkatan' => fake()->randomElement(['2021', '2022', '2023', '2024', '2025']),
            'bio' => fake()->sentence(10),
            'foto' => null,
            'telepon' => fake()->phoneNumber(),
            'linkedin' => null,
            'github' => null,
            'website' => null,
        ];
    }
}
