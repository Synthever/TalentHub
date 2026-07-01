@extends('layouts.app')

@section('title', 'Review Sertifikat')
@section('page-title', 'Review Sertifikat')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
        Dashboard
    </a>
    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Mahasiswa
    </a>
    <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Verifikasi Sertifikat
    </a>
    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
        Kelola Reward
    </a>
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.certificates.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Certificate Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Student Info --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Mahasiswa</h3>
                <div class="flex items-center gap-4">
                    @if ($certificate->user->profile?->foto)
                        <img src="{{ Storage::url($certificate->user->profile->foto) }}" 
                            alt="{{ $certificate->user->name }}" 
                            class="h-16 w-16 rounded-full object-cover">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-100 text-lg font-medium text-indigo-600">
                            {{ strtoupper(substr($certificate->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-lg font-medium text-slate-900">{{ $certificate->user->name }}</p>
                        <p class="text-sm text-slate-500">NIM: {{ $certificate->user->profile?->nim ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $certificate->user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Certificate Details --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Detail Sertifikat</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Sertifikat</label>
                        <p class="text-base text-slate-900">{{ $certificate->nama }}</p>
                    </div>

                    @if ($certificate->penerbit)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Penerbit</label>
                            <p class="text-base text-slate-900">{{ $certificate->penerbit }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Level</label>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium
                            @if ($certificate->level === 'internasional') bg-purple-100 text-purple-700
                            @elseif ($certificate->level === 'nasional') bg-blue-100 text-blue-700
                            @elseif ($certificate->level === 'regional') bg-emerald-100 text-emerald-700
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ ucfirst($certificate->level) }}
                        </span>
                    </div>

                    @if ($certificate->tanggal_terbit)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Terbit</label>
                            <p class="text-base text-slate-900">{{ $certificate->tanggal_terbit->format('d F Y') }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Pengajuan</label>
                        <p class="text-base text-slate-900">{{ $certificate->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>

                    @if ($certificate->url_bukti)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">URL Bukti</label>
                            <a href="{{ $certificate->url_bukti }}" target="_blank" 
                                class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-700">
                                {{ $certificate->url_bukti }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    @endif

                    @if ($certificate->file_bukti)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">File Sertifikat</label>
                            <div class="rounded-lg border border-slate-200 p-4">
                                @php
                                    $fileExtension = pathinfo($certificate->file_bukti, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp

                                @if ($isImage)
                                    <img src="{{ Storage::url($certificate->file_bukti) }}" 
                                        alt="Sertifikat" 
                                        class="w-full rounded-lg">
                                @else
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100">
                                            <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-slate-900">{{ basename($certificate->file_bukti) }}</p>
                                            <p class="text-xs text-slate-500">{{ strtoupper($fileExtension) }} File</p>
                                        </div>
                                    </div>
                                @endif

                                <a href="{{ Storage::url($certificate->file_bukti) }}" 
                                    target="_blank"
                                    class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download File
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Action Panel --}}
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sticky top-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Aksi Verifikasi</h3>

                {{-- Approve Form --}}
                <form action="{{ route('admin.certificates.approve', $certificate) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <label for="poin" class="block text-sm font-medium text-slate-700 mb-2">Poin yang Diberikan *</label>
                        <input type="number" name="poin" id="poin" 
                            min="1" max="1000" value="50" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                        @error('poin')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Rekomendasi: Lokal 25-50, Regional 50-75, Nasional 75-100, Internasional 100-150</p>
                    </div>

                    <div class="mb-4">
                        <label for="catatan_admin_approve" class="block text-sm font-medium text-slate-700 mb-2">Catatan (opsional)</label>
                        <textarea name="catatan_admin" id="catatan_admin_approve" rows="3" 
                            placeholder="Tambahkan catatan untuk mahasiswa..."
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"></textarea>
                        @error('catatan_admin')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Setujui & Berikan Poin
                        </span>
                    </button>
                </form>

                <div class="relative mb-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-2 text-slate-500">atau</span>
                    </div>
                </div>

                {{-- Reject Form --}}
                <form action="{{ route('admin.certificates.reject', $certificate) }}" method="POST" 
                    onsubmit="return confirm('Yakin ingin menolak sertifikat ini?')">
                    @csrf
                    <div class="mb-4">
                        <label for="catatan_admin_reject" class="block text-sm font-medium text-slate-700 mb-2">Alasan Penolakan *</label>
                        <textarea name="catatan_admin" id="catatan_admin_reject" rows="3" required
                            placeholder="Jelaskan alasan penolakan..."
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"></textarea>
                    </div>

                    <button type="submit" 
                        class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak Sertifikat
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
