<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        $user->load(['profile', 'skills.skill', 'certificates', 'portfolios']);

        return view('mahasiswa.profile.show', [
            'user' => $user,
            'profile' => $user->profile,
            'totalPoin' => $user->totalPoin(),
        ]);
    }

    public function edit(): View
    {
        $user = Auth::user();

        return view('mahasiswa.profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['nullable', 'string', 'max:20'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'angkatan' => ['nullable', 'string', 'max:4'],
            'bio' => ['nullable', 'string', 'max:500'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Update user name
        $user->update(['name' => $validated['name']]);

        // Handle foto upload
        $fotoPath = $user->profile->foto;
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('profiles', 'public');
        }

        // Update profile
        $user->profile->update([
            'nim' => $validated['nim'],
            'jurusan' => $validated['jurusan'],
            'angkatan' => $validated['angkatan'],
            'bio' => $validated['bio'],
            'telepon' => $validated['telepon'],
            'linkedin' => $validated['linkedin'],
            'github' => $validated['github'],
            'website' => $validated['website'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('mahasiswa.profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
