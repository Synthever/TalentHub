<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolios = Auth::user()->portfolios()
            ->latest()
            ->get();

        return view('mahasiswa.portfolio.index', [
            'portfolios' => $portfolios,
        ]);
    }

    public function create(): View
    {
        return view('mahasiswa.portfolio.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'kategori' => ['required', 'in:personal,freelance,industri'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'url_demo' => ['nullable', 'url', 'max:255'],
            'url_repository' => ['nullable', 'url', 'max:255'],
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('portfolios', 'public');
        }

        Auth::user()->portfolios()->create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'gambar' => $gambarPath,
            'url_demo' => $validated['url_demo'],
            'url_repository' => $validated['url_repository'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.portfolios.index')->with('success', 'Portfolio berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function show(Portfolio $portfolio): View
    {
        if ($portfolio->user_id != Auth::id()) {
            abort(403);
        }

        return view('mahasiswa.portfolio.show', [
            'portfolio' => $portfolio,
        ]);
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        if ($portfolio->user_id != Auth::id()) {
            abort(403);
        }

        if ($portfolio->status === 'approved') {
            return back()->with('error', 'Portfolio yang sudah diverifikasi tidak dapat dihapus.');
        }

        if ($portfolio->gambar && Storage::disk('public')->exists($portfolio->gambar)) {
            Storage::disk('public')->delete($portfolio->gambar);
        }

        $portfolio->delete();

        return redirect()->route('mahasiswa.portfolios.index')->with('success', 'Portfolio berhasil dihapus.');
    }
}
