<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RewardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $totalPoin = $user->totalPoin();
        $usedPoin = $user->rewardClaims()->where('status', '!=', 'rejected')->sum('poin_digunakan');
        $availablePoin = $totalPoin - $usedPoin;

        $rewards = Reward::where('aktif', true)
            ->orderBy('poin_dibutuhkan')
            ->get();

        $myClaims = $user->rewardClaims()
            ->with('reward')
            ->latest()
            ->get();

        return view('mahasiswa.reward.index', [
            'rewards' => $rewards,
            'myClaims' => $myClaims,
            'totalPoin' => $totalPoin,
            'availablePoin' => $availablePoin,
        ]);
    }

    public function claim(Request $request, Reward $reward): RedirectResponse
    {
        $user = Auth::user();

        if (! $reward->aktif) {
            return back()->with('error', 'Reward ini tidak tersedia.');
        }

        if ($reward->stok <= 0) {
            return back()->with('error', 'Stok reward habis.');
        }

        $totalPoin = $user->totalPoin();
        $usedPoin = $user->rewardClaims()->where('status', '!=', 'rejected')->sum('poin_digunakan');
        $availablePoin = $totalPoin - $usedPoin;

        if ($availablePoin < $reward->poin_dibutuhkan) {
            return back()->with('error', 'Poin kamu tidak cukup untuk klaim reward ini.');
        }

        $user->rewardClaims()->create([
            'reward_id' => $reward->id,
            'poin_digunakan' => $reward->poin_dibutuhkan,
            'status' => 'pending',
        ]);

        $reward->decrement('stok');

        return redirect()->route('mahasiswa.rewards.index')->with('success', 'Klaim reward berhasil! Menunggu persetujuan admin.');
    }
}
