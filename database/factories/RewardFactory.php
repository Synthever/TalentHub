<?php

namespace Database\Factories;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reward>
 */
class RewardFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->randomElement([
                'Voucher Kantin Rp 25.000',
                'Voucher Kantin Rp 50.000',
                'Kaos Kampus Eksklusif',
                'Tumbler Kampus',
                'Voucher Toko Buku Rp 50.000',
                'Flash Drive 32GB',
                'Sertifikat Penghargaan',
                'Voucher Kursus Online',
                'Hoodie Kampus',
                'Tiket Workshop Gratis',
            ]),
            'deskripsi' => fake()->sentence(8),
            'poin_dibutuhkan' => fake()->randomElement([5, 10, 15, 20, 25, 30, 50]),
            'stok' => fake()->numberBetween(5, 50),
            'gambar' => null,
            'aktif' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'aktif' => false,
        ]);
    }
}
