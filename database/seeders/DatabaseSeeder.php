<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Point;
use App\Models\Portfolio;
use App\Models\Profile;
use App\Models\Reward;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin TalentHub',
            'email' => 'admin@talenthub.test',
        ]);

        // Skills master data
        $skills = collect([
            ['name' => 'PHP', 'kategori' => 'programming'],
            ['name' => 'Laravel', 'kategori' => 'programming'],
            ['name' => 'JavaScript', 'kategori' => 'programming'],
            ['name' => 'TypeScript', 'kategori' => 'programming'],
            ['name' => 'React', 'kategori' => 'programming'],
            ['name' => 'Vue.js', 'kategori' => 'programming'],
            ['name' => 'Python', 'kategori' => 'programming'],
            ['name' => 'Java', 'kategori' => 'programming'],
            ['name' => 'Flutter', 'kategori' => 'programming'],
            ['name' => 'Node.js', 'kategori' => 'programming'],
            ['name' => 'UI/UX Design', 'kategori' => 'design'],
            ['name' => 'Figma', 'kategori' => 'design'],
            ['name' => 'Adobe Photoshop', 'kategori' => 'design'],
            ['name' => 'Video Editing', 'kategori' => 'multimedia'],
            ['name' => 'Fotografi', 'kategori' => 'multimedia'],
            ['name' => 'Content Writing', 'kategori' => 'soft-skill'],
            ['name' => 'Public Speaking', 'kategori' => 'soft-skill'],
            ['name' => 'Project Management', 'kategori' => 'soft-skill'],
            ['name' => 'Data Analysis', 'kategori' => 'data'],
            ['name' => 'Machine Learning', 'kategori' => 'data'],
            ['name' => 'Docker', 'kategori' => 'devops'],
            ['name' => 'Cloud Computing', 'kategori' => 'devops'],
            ['name' => 'Git', 'kategori' => 'devops'],
            ['name' => 'MySQL', 'kategori' => 'programming'],
            ['name' => 'Tailwind CSS', 'kategori' => 'programming'],
        ])->map(fn (array $data) => Skill::create($data));

        // Rewards
        Reward::create(['nama' => 'Voucher Kantin Rp 25.000', 'deskripsi' => 'Voucher makan di kantin kampus senilai Rp 25.000', 'poin_dibutuhkan' => 10, 'stok' => 50]);
        Reward::create(['nama' => 'Voucher Kantin Rp 50.000', 'deskripsi' => 'Voucher makan di kantin kampus senilai Rp 50.000', 'poin_dibutuhkan' => 20, 'stok' => 30]);
        Reward::create(['nama' => 'Kaos Kampus Eksklusif', 'deskripsi' => 'Kaos eksklusif edisi terbatas dari kampus', 'poin_dibutuhkan' => 25, 'stok' => 20]);
        Reward::create(['nama' => 'Tumbler Kampus', 'deskripsi' => 'Tumbler stainless steel dengan logo kampus', 'poin_dibutuhkan' => 15, 'stok' => 30]);
        Reward::create(['nama' => 'Voucher Toko Buku Rp 50.000', 'deskripsi' => 'Voucher belanja di toko buku kampus', 'poin_dibutuhkan' => 20, 'stok' => 25]);
        Reward::create(['nama' => 'Hoodie Kampus', 'deskripsi' => 'Hoodie premium dengan logo kampus', 'poin_dibutuhkan' => 50, 'stok' => 10]);
        Reward::create(['nama' => 'Tiket Workshop Gratis', 'deskripsi' => 'Tiket gratis mengikuti workshop IT kampus', 'poin_dibutuhkan' => 30, 'stok' => 15]);
        Reward::create(['nama' => 'Voucher Kursus Online', 'deskripsi' => 'Voucher kursus online di platform edukasi', 'poin_dibutuhkan' => 40, 'stok' => 20]);

        // Mahasiswa with profiles, skills, certificates, portfolios
        $mahasiswas = User::factory(20)->create();

        foreach ($mahasiswas as $mahasiswa) {
            // Profile
            Profile::factory()->create(['user_id' => $mahasiswa->id]);

            // Assign 2-5 random skills
            $assignedSkills = $skills->random(fake()->numberBetween(2, 5));
            foreach ($assignedSkills as $skill) {
                $status = fake()->randomElement(['pending', 'approved', 'approved', 'approved']); // 75% approved
                $userSkill = UserSkill::factory()->create([
                    'user_id' => $mahasiswa->id,
                    'skill_id' => $skill->id,
                    'status' => $status,
                    'poin' => $status === 'approved' ? 5 : 0,
                    'verified_at' => $status === 'approved' ? now() : null,
                ]);

                if ($status === 'approved') {
                    Point::create([
                        'user_id' => $mahasiswa->id,
                        'pointable_type' => UserSkill::class,
                        'pointable_id' => $userSkill->id,
                        'jumlah' => 5,
                        'keterangan' => "Skill {$skill->name} diverifikasi",
                    ]);
                }
            }

            // 0-3 certificates
            $certCount = fake()->numberBetween(0, 3);
            for ($i = 0; $i < $certCount; $i++) {
                $level = fake()->randomElement(['lokal', 'regional', 'nasional', 'internasional']);
                $poinMap = ['lokal' => 1, 'regional' => 3, 'nasional' => 5, 'internasional' => 10];
                $status = fake()->randomElement(['pending', 'approved', 'approved']);

                $cert = Certificate::factory()->create([
                    'user_id' => $mahasiswa->id,
                    'level' => $level,
                    'status' => $status,
                    'poin' => $status === 'approved' ? $poinMap[$level] : 0,
                    'verified_at' => $status === 'approved' ? now() : null,
                ]);

                if ($status === 'approved') {
                    Point::create([
                        'user_id' => $mahasiswa->id,
                        'pointable_type' => Certificate::class,
                        'pointable_id' => $cert->id,
                        'jumlah' => $poinMap[$level],
                        'keterangan' => "Sertifikat {$level}: {$cert->nama}",
                    ]);
                }
            }

            // 0-2 portfolios
            $portCount = fake()->numberBetween(0, 2);
            for ($i = 0; $i < $portCount; $i++) {
                $kategori = fake()->randomElement(['personal', 'freelance', 'industri']);
                $poinMap = ['personal' => 2, 'freelance' => 5, 'industri' => 8];
                $status = fake()->randomElement(['pending', 'approved', 'approved']);

                $portfolio = Portfolio::factory()->create([
                    'user_id' => $mahasiswa->id,
                    'kategori' => $kategori,
                    'status' => $status,
                    'poin' => $status === 'approved' ? $poinMap[$kategori] : 0,
                    'verified_at' => $status === 'approved' ? now() : null,
                ]);

                if ($status === 'approved') {
                    Point::create([
                        'user_id' => $mahasiswa->id,
                        'pointable_type' => Portfolio::class,
                        'pointable_id' => $portfolio->id,
                        'jumlah' => $poinMap[$kategori],
                        'keterangan' => "Portfolio {$kategori}: {$portfolio->judul}",
                    ]);
                }
            }
        }
    }
}
