<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('mahasiswa.dashboard', [
            'user' => $user,
            'totalPoin' => $user->totalPoin(),
            'totalSkills' => $user->skills()->where('status', 'approved')->count(),
            'totalCertificates' => $user->certificates()->where('status', 'approved')->count(),
            'totalPortfolios' => $user->portfolios()->where('status', 'approved')->count(),
            'pendingCount' => $user->skills()->where('status', 'pending')->count()
                + $user->certificates()->where('status', 'pending')->count()
                + $user->portfolios()->where('status', 'pending')->count(),
        ]);
    }
}
