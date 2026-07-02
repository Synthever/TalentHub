<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(): View
    {
        $certificates = Auth::user()->certificates()
            ->latest()
            ->get();

        return view('mahasiswa.certificate.index', [
            'certificates' => $certificates,
        ]);
    }

    public function create(): View
    {
        return view('mahasiswa.certificate.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'in:lokal,regional,nasional,internasional'],
            'tanggal_terbit' => ['nullable', 'date'],
            'file_bukti' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,webp', 'max:5120'],
            'url_bukti' => ['nullable', 'url', 'max:255'],
        ]);

        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('certificates', 'public');
        }

        Auth::user()->certificates()->create([
            'nama' => $validated['nama'],
            'penerbit' => $validated['penerbit'],
            'level' => $validated['level'],
            'tanggal_terbit' => $validated['tanggal_terbit'],
            'file_bukti' => $filePath,
            'url_bukti' => $validated['url_bukti'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.certificates.index')->with('success', 'Sertifikat berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        if ($certificate->user_id != Auth::id()) {
            abort(403);
        }

        if ($certificate->status === 'approved') {
            return back()->with('error', 'Sertifikat yang sudah diverifikasi tidak dapat dihapus.');
        }

        if ($certificate->file_bukti && Storage::disk('public')->exists($certificate->file_bukti)) {
            Storage::disk('public')->delete($certificate->file_bukti);
        }

        $certificate->delete();

        return redirect()->route('mahasiswa.certificates.index')->with('success', 'Sertifikat berhasil dihapus.');
    }
}
