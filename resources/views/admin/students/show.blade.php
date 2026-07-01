@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
        Dashboard
    </a>
    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Mahasiswa
    </a>
@endsection

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    {{-- Profile Card --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-start">
            @if ($student->profile && $student->profile->foto)
                <img src="{{ Storage::url($student->profile->foto) }}" alt="{{ $student->name }}" class="h-20 w-20 rounded-full object-cover">
            @else
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-indigo-100 text-2xl font-bold text-indigo-600">
                    {{ strtoupper(substr($student->name, 0, 2)) }}
                </div>
            @endif
            <div class="flex-1">
                <h2 class="text-xl font-bold text-slate-900">{{ $student->name }}</h2>
                <p class="text-sm text-slate-500">{{ $student->email }}</p>
                <div class="mt-3 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div>
                        <p class="text-xs text-slate-500">NIM</p>
                        <p class="text-sm font-medium text-slate-900">{{ $student->profile->nim ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Jurusan</p>
                        <p class="text-sm font-medium text-slate-900">{{ $student->profile->jurusan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Angkatan</p>
                        <p class="text-sm font-medium text-slate-900">{{ $student->profile->angkatan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total Poin</p>
                        <p class="text-sm font-bold text-violet-700">★ {{ number_format($totalPoin) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Skills</p>
            <p class="text-2xl font-bold text-slate-900">{{ $student->skills->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Sertifikat</p>
            <p class="text-2xl font-bold text-slate-900">{{ $student->certificates->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Portfolio</p>
            <p class="text-2xl font-bold text-slate-900">{{ $student->portfolios->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Verified</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $student->skills->where('status', 'approved')->count() + $student->certificates->where('status', 'approved')->count() + $student->portfolios->where('status', 'approved')->count() }}</p>
        </div>
    </div>

    {{-- Skills --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900">Skills</h3>
        @if ($student->skills->isNotEmpty())
            <div class="mt-4 space-y-2">
                @foreach ($student->skills as $userSkill)
                    <div class="flex items-center justify-between rounded-lg border border-slate-100 p-3">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">{{ $userSkill->skill->name }}</p>
                            <p class="text-xs text-slate-400">{{ ucfirst($userSkill->level) }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if ($userSkill->status === 'approved') bg-emerald-50 text-emerald-700
                            @elseif ($userSkill->status === 'pending') bg-amber-50 text-amber-700
                            @else bg-rose-50 text-rose-600 @endif">
                            @if ($userSkill->status === 'approved') Disetujui
                            @elseif ($userSkill->status === 'pending') Menunggu
                            @else Ditolak @endif
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-slate-400">Belum ada skill.</p>
        @endif
    </div>

    {{-- Certificates --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900">Sertifikat</h3>
        @if ($student->certificates->isNotEmpty())
            <div class="mt-4 space-y-2">
                @foreach ($student->certificates as $cert)
                    <div class="flex items-center justify-between rounded-lg border border-slate-100 p-3">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">{{ $cert->nama }}</p>
                            <p class="text-xs text-slate-400">{{ $cert->penerbit }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if ($cert->status === 'approved') bg-emerald-50 text-emerald-700
                            @elseif ($cert->status === 'pending') bg-amber-50 text-amber-700
                            @else bg-rose-50 text-rose-600 @endif">
                            @if ($cert->status === 'approved') Disetujui
                            @elseif ($cert->status === 'pending') Menunggu
                            @else Ditolak @endif
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-slate-400">Belum ada sertifikat.</p>
        @endif
    </div>

    {{-- Portfolios --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900">Portfolio</h3>
        @if ($student->portfolios->isNotEmpty())
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($student->portfolios as $portfolio)
                    <div class="rounded-lg border border-slate-100 p-3">
                        <p class="text-sm font-medium text-slate-900">{{ $portfolio->judul }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ ucfirst($portfolio->kategori) }}</p>
                        <span class="mt-2 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                            @if ($portfolio->status === 'approved') bg-emerald-50 text-emerald-700
                            @elseif ($portfolio->status === 'pending') bg-amber-50 text-amber-700
                            @else bg-rose-50 text-rose-600 @endif">
                            @if ($portfolio->status === 'approved') Disetujui
                            @elseif ($portfolio->status === 'pending') Menunggu
                            @else Ditolak @endif
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-slate-400">Belum ada portfolio.</p>
        @endif
    </div>
@endsection
