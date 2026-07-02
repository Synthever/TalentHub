<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $userSkills = Auth::user()->skills()
            ->with('skill')
            ->latest()
            ->get();

        return view('mahasiswa.skill.index', [
            'userSkills' => $userSkills,
        ]);
    }

    public function create(): View
    {
        $existingSkillIds = Auth::user()->skills()->pluck('skill_id');

        $skills = Skill::whereNotIn('id', $existingSkillIds)
            ->orderBy('name')
            ->get()
            ->groupBy('kategori');

        return view('mahasiswa.skill.create', [
            'skills' => $skills,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'skill_id' => ['required', 'exists:skills,id'],
            'level' => ['required', 'in:pemula,menengah,mahir'],
            'bukti' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,webp', 'max:5120'],
        ]);

        // Check duplicate
        $exists = Auth::user()->skills()->where('skill_id', $validated['skill_id'])->exists();
        if ($exists) {
            return back()->withErrors(['skill_id' => 'Skill ini sudah ditambahkan.']);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('skills', 'public');
        }

        Auth::user()->skills()->create([
            'skill_id' => $validated['skill_id'],
            'level' => $validated['level'],
            'bukti' => $buktiPath,
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.skills.index')->with('success', 'Skill berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function destroy(UserSkill $skill): RedirectResponse
    {
        if ($skill->user_id != Auth::id()) {
            abort(403);
        }

        if ($skill->status === 'approved') {
            return back()->with('error', 'Skill yang sudah diverifikasi tidak dapat dihapus.');
        }

        if ($skill->bukti && Storage::disk('public')->exists($skill->bukti)) {
            Storage::disk('public')->delete($skill->bukti);
        }

        $skill->delete();

        return redirect()->route('mahasiswa.skills.index')->with('success', 'Skill berhasil dihapus.');
    }
}
