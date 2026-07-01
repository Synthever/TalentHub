<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserSkill>
 */
class UserSkillFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'skill_id' => Skill::factory(),
            'level' => fake()->randomElement(['pemula', 'menengah', 'mahir']),
            'bukti' => null,
            'status' => 'pending',
            'catatan_admin' => null,
            'poin' => 0,
            'verified_at' => null,
        ];
    }

    public function approved(int $poin = 5): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'poin' => $poin,
            'verified_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'catatan_admin' => 'Bukti tidak valid.',
        ]);
    }
}
