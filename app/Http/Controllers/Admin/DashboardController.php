<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\RewardClaim;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'pending_skills' => UserSkill::where('status', 'pending')->count(),
            'pending_certificates' => Certificate::where('status', 'pending')->count(),
            'pending_portfolios' => Portfolio::where('status', 'pending')->count(),
            'pending_rewards' => RewardClaim::where('status', 'pending')->count(),
            'total_verifikasi_pending' => UserSkill::where('status', 'pending')->count()
                + Certificate::where('status', 'pending')->count()
                + Portfolio::where('status', 'pending')->count(),
        ];

        // Chart data - verifikasi per bulan (6 bulan terakhir)
        $verificationChart = $this->getVerificationChartData();

        // Recent activities
        $recentActivities = $this->getRecentActivities();

        // Top students by poin
        $topStudents = User::where('role', 'mahasiswa')
            ->with('profile')
            ->withSum(['points as total_poin' => fn ($q) => $q], 'jumlah')
            ->orderByDesc('total_poin')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'verificationChart' => $verificationChart,
            'recentActivities' => $recentActivities,
            'topStudents' => $topStudents,
        ]);
    }

    private function getVerificationChartData(): array
    {
        $months = [];
        $skillsData = [];
        $certificatesData = [];
        $portfoliosData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');

            $skillsData[] = UserSkill::where('status', 'approved')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();

            $certificatesData[] = Certificate::where('status', 'approved')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();

            $portfoliosData[] = Portfolio::where('status', 'approved')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();
        }

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Skills',
                    'data' => $skillsData,
                ],
                [
                    'label' => 'Sertifikat',
                    'data' => $certificatesData,
                ],
                [
                    'label' => 'Portfolio',
                    'data' => $portfoliosData,
                ],
            ],
        ];
    }

    private function getRecentActivities(): array
    {
        $activities = collect();

        // Recent skills
        UserSkill::with(['user', 'skill'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($skill) use ($activities) {
                $activities->push([
                    'type' => 'skill',
                    'user' => $skill->user->name,
                    'title' => $skill->skill->name,
                    'time' => $skill->created_at,
                ]);
            });

        // Recent certificates
        Certificate::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($cert) use ($activities) {
                $activities->push([
                    'type' => 'certificate',
                    'user' => $cert->user->name,
                    'title' => $cert->nama,
                    'time' => $cert->created_at,
                ]);
            });

        // Recent portfolios
        Portfolio::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($portfolio) use ($activities) {
                $activities->push([
                    'type' => 'portfolio',
                    'user' => $portfolio->user->name,
                    'title' => $portfolio->judul,
                    'time' => $portfolio->created_at,
                ]);
            });

        return $activities->sortByDesc('time')->take(10)->values()->toArray();
    }
}
