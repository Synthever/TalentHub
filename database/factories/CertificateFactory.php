<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certificate>
 */
class CertificateFactory extends Factory
{
    private const POIN_MAP = [
        'lokal' => 1,
        'regional' => 3,
        'nasional' => 5,
        'internasional' => 10,
    ];

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $level = fake()->randomElement(['lokal', 'regional', 'nasional', 'internasional']);

        return [
            'user_id' => User::factory(),
            'nama' => fake()->sentence(3),
            'penerbit' => fake()->company(),
            'level' => $level,
            'tanggal_terbit' => fake()->dateTimeBetween('-2 years', 'now'),
            'file_bukti' => null,
            'url_bukti' => null,
            'status' => 'pending',
            'catatan_admin' => null,
            'poin' => 0,
            'verified_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            $level = $attributes['level'] ?? 'lokal';

            return [
                'status' => 'approved',
                'poin' => self::POIN_MAP[$level],
                'verified_at' => now(),
            ];
        });
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'catatan_admin' => 'Sertifikat tidak valid.',
        ]);
    }
}
