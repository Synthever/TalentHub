<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalMahasiswa' => User::where('role', 'mahasiswa')->count(),
            'totalSkills' => Skill::count(),
            'totalPortfolios' => Portfolio::count(),
            'pendingVerifikasi' => UserSkill::where('status', 'pending')->count()
                + Certificate::where('status', 'pending')->count()
                + Portfolio::where('status', 'pending')->count(),
        ]);
    }
}
