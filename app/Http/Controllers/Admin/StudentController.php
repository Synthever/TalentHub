<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'mahasiswa')
            ->with('profile')
            ->withSum(['points as total_poin' => fn ($q) => $q], 'jumlah');

        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('nim', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by skill
        if ($request->filled('skill')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->where('skill_id', $request->skill);
            });
        }

        // Filter by minimum poin
        if ($request->filled('min_poin')) {
            $query->having('total_poin', '>=', $request->min_poin);
        }

        // Sort by poin
        if ($request->filled('sort') && $request->sort === 'poin') {
            $query->orderByDesc('total_poin');
        } else {
            $query->latest();
        }

        $students = $query->paginate(20)->withQueryString();

        // Get skills for filter dropdown
        $skills = Skill::orderBy('name')->get();

        return view('admin.students.index', [
            'students' => $students,
            'skills' => $skills,
            'filters' => $request->only(['search', 'skill', 'min_poin', 'sort']),
        ]);
    }

    public function show(User $student): View
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $student->load([
            'profile',
            'skills.skill',
            'certificates',
            'portfolios',
            'points',
        ]);

        $totalPoin = $student->totalPoin();

        return view('admin.students.show', [
            'student' => $student,
            'totalPoin' => $totalPoin,
        ]);
    }
}
