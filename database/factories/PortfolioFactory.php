<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Portfolio>
 */
class PortfolioFactory extends Factory
{
    private const POIN_MAP = [
        'personal' => 2,
        'freelance' => 5,
        'industri' => 8,
    ];

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = fake()->randomElement(['personal', 'freelance', 'industri']);

        return [
            'user_id' => User::factory(),
            'judul' => fake()->sentence(4),
            'deskripsi' => fake()->paragraph(),
            'kategori' => $kategori,
            'gambar' => null,
            'url_demo' => fake()->optional()->url(),
            'url_repository' => fake()->optional()->url(),
            'status' => 'pending',
            'catatan_admin' => null,
            'poin' => 0,
            'verified_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            $kategori = $attributes['kategori'] ?? 'personal';

            return [
                'status' => 'approved',
                'poin' => self::POIN_MAP[$kategori],
                'verified_at' => now(),
            ];
        });
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'catatan_admin' => 'Portfolio tidak memenuhi kriteria.',
        ]);
    }
}
