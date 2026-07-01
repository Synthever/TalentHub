<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RewardController extends Controller
{
    public function index(): View
    {
        $rewards = Reward::withCount('claims')->latest()->paginate(15);

        return view('admin.rewards.index', compact('rewards'));
    }

    public function create(): View
    {
        return view('admin.rewards.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'poin_dibutuhkan' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('rewards', 'public');
        }

        Reward::create($validated);

        return redirect()
            ->route('admin.rewards.index')
            ->with('success', 'Reward berhasil ditambahkan.');
    }

    public function edit(Reward $reward): View
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    public function update(Request $request, Reward $reward): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'poin_dibutuhkan' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($reward->gambar) {
                Storage::disk('public')->delete($reward->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('rewards', 'public');
        }

        $reward->update($validated);

        return redirect()
            ->route('admin.rewards.index')
            ->with('success', 'Reward berhasil diperbarui.');
    }

    public function destroy(Reward $reward): RedirectResponse
    {
        // Check if reward has claims
        if ($reward->claims()->exists()) {
            return redirect()
                ->route('admin.rewards.index')
                ->with('error', 'Reward tidak dapat dihapus karena sudah ada yang mengklaim.');
        }

        // Delete image
        if ($reward->gambar) {
            Storage::disk('public')->delete($reward->gambar);
        }

        $reward->delete();

        return redirect()
            ->route('admin.rewards.index')
            ->with('success', 'Reward berhasil dihapus.');
    }
}
