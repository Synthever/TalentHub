<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'React', 'Vue.js',
                'Python', 'Java', 'C++', 'Go', 'Rust', 'Swift',
                'UI/UX Design', 'Figma', 'Adobe Photoshop', 'Adobe Illustrator',
                'Video Editing', 'Fotografi', 'Content Writing', 'Copywriting',
                'Public Speaking', 'Event Organizing', 'Project Management',
                'Data Analysis', 'Machine Learning', 'Cloud Computing',
                'DevOps', 'Docker', 'Kubernetes', 'Git',
                'MySQL', 'PostgreSQL', 'MongoDB', 'Redis',
                'Flutter', 'React Native', 'Kotlin', 'Node.js',
                'Tailwind CSS', 'Bootstrap', 'HTML/CSS',
            ]),
            'kategori' => fake()->randomElement([
                'programming', 'design', 'multimedia', 'soft-skill', 'data', 'devops',
            ]),
        ];
    }
}
