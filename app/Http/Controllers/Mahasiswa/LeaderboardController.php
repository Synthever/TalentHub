<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        $mahasiswas = User::where('role', 'mahasiswa')
            ->with('profile')
            ->withSum(['points as total_poin' => fn ($q) => $q], 'jumlah')
            ->orderByDesc('total_poin')
            ->limit(50)
            ->get();

        $currentUser = Auth::user();
        $currentRank = $mahasiswas->search(fn (User $u) => $u->id === $currentUser->id);
        $currentRank = $currentRank !== false ? $currentRank + 1 : null;

        return view('mahasiswa.leaderboard.index', [
            'mahasiswas' => $mahasiswas,
            'currentUserId' => $currentUser->id,
            'currentRank' => $currentRank,
            'currentPoin' => $currentUser->totalPoin(),
        ]);
    }
}
