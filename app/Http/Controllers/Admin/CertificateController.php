<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Point;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(Request $request): View
    {
        $query = Certificate::with(['user', 'user.profile'])
            ->where('status', 'pending')
            ->latest();

        // Search by student name or certificate name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $certificates = $query->paginate(15);

        return view('admin.certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate): View
    {
        $certificate->load(['user', 'user.profile']);

        return view('admin.certificates.show', compact('certificate'));
    }

    public function approve(Request $request, Certificate $certificate): RedirectResponse
    {
        $validated = $request->validate([
            'poin' => 'required|integer|min:1|max:1000',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($certificate, $validated) {
            // Update certificate status
            $certificate->update([
                'status' => 'approved',
                'poin' => $validated['poin'],
                'catatan_admin' => $validated['catatan_admin'] ?? null,
                'verified_at' => now(),
            ]);

            // Create point record
            Point::create([
                'user_id' => $certificate->user_id,
                'pointable_type' => Certificate::class,
                'pointable_id' => $certificate->id,
                'jumlah' => $validated['poin'],
                'keterangan' => 'Sertifikat: '.$certificate->nama,
            ]);
        });

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil disetujui dan poin telah diberikan.');
    }

    public function reject(Request $request, Certificate $certificate): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $certificate->update([
            'status' => 'rejected',
            'catatan_admin' => $validated['catatan_admin'],
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat ditolak.');
    }
}
