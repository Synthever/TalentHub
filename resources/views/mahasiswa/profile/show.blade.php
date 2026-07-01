@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'profil'])
@endsection

@section('content')
    {{-- Profile Header --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        {{-- Banner --}}
        <div class="h-32 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

        <div class="px-6 pb-6">
            {{-- Avatar + Info --}}
            <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-12">
                <div class="relative">
                    @if ($profile->foto)
                        <img src="{{ Storage::url($profile->foto) }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full border-4 border-white bg-white object-cover shadow-sm">
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-indigo-100 text-2xl font-bold text-indigo-600 shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 sm:pb-1">
                    <h2 class="text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500">
                        {{ $profile->jurusan ?? 'Jurusan belum diisi' }}
                        @if ($profile->angkatan)
                            &bull; Angkatan {{ $profile->angkatan }}
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1 rounded-full bg-violet-50 px-3 py-1 text-sm font-medium text-violet-700">
                        ★ {{ number_format($totalPoin) }} Poin
                    </span>
                    <a href="{{ route('mahasiswa.profile.edit') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            {{-- Bio --}}
            @if ($profile->bio)
                <p class="mt-4 text-sm text-slate-600">{{ $profile->bio }}</p>
            @endif

            {{-- Detail Info --}}
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @if ($profile->nim)
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                        NIM: {{ $profile->nim }}
                    </div>
                @endif
                @if ($profile->telepon)
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $profile->telepon }}
                    </div>
                @endif
                @if ($profile->linkedin)
                    <a href="{{ $profile->linkedin }}" target="_blank" class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        LinkedIn
                    </a>
                @endif
                @if ($profile->github)
                    <a href="{{ $profile->github }}" target="_blank" class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                        GitHub
                    </a>
                @endif
                @if ($profile->website)
                    <a href="{{ $profile->website }}" target="_blank" class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        Website
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Skills Section --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Skill</h3>
            <span class="text-sm text-slate-500">{{ $user->skills->where('status', 'approved')->count() }} terverifikasi</span>
        </div>
        @if ($user->skills->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($user->skills as $userSkill)
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium
                        @if ($userSkill->status === 'approved') bg-emerald-50 text-emerald-700
                        @elseif ($userSkill->status === 'pending') bg-amber-50 text-amber-700
                        @else bg-rose-50 text-rose-600 @endif">
                        @if ($userSkill->status === 'approved')
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                        {{ $userSkill->skill->name }}
                        <span class="text-[10px] opacity-70">({{ $userSkill->level }})</span>
                    </span>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-slate-400">Belum ada skill ditambahkan.</p>
        @endif
    </div>

    {{-- Certificates Section --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Sertifikat</h3>
            <span class="text-sm text-slate-500">{{ $user->certificates->where('status', 'approved')->count() }} terverifikasi</span>
        </div>
        @if ($user->certificates->isNotEmpty())
            <div class="mt-4 space-y-3">
                @foreach ($user->certificates as $cert)
                    <div class="flex items-center justify-between rounded-lg border border-slate-100 p-3">
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $cert->nama }}</p>
                            <p class="text-xs text-slate-500">{{ $cert->penerbit }} &bull; {{ ucfirst($cert->level) }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if ($cert->status === 'approved') bg-emerald-50 text-emerald-700
                            @elseif ($cert->status === 'pending') bg-amber-50 text-amber-700
                            @else bg-rose-50 text-rose-600 @endif">
                            {{ ucfirst($cert->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-slate-400">Belum ada sertifikat ditambahkan.</p>
        @endif
    </div>

    {{-- Portfolios Section --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Portfolio</h3>
            <span class="text-sm text-slate-500">{{ $user->portfolios->where('status', 'approved')->count() }} terverifikasi</span>
        </div>
        @if ($user->portfolios->isNotEmpty())
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach ($user->portfolios as $portfolio)
                    <div class="rounded-lg border border-slate-100 p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ $portfolio->judul }}</p>
                                <p class="text-xs text-slate-500">{{ ucfirst($portfolio->kategori) }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                @if ($portfolio->status === 'approved') bg-emerald-50 text-emerald-700
                                @elseif ($portfolio->status === 'pending') bg-amber-50 text-amber-700
                                @else bg-rose-50 text-rose-600 @endif">
                                {{ ucfirst($portfolio->status) }}
                            </span>
                        </div>
                        @if ($portfolio->deskripsi)
                            <p class="mt-2 text-xs text-slate-500 line-clamp-2">{{ $portfolio->deskripsi }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-slate-400">Belum ada portfolio ditambahkan.</p>
        @endif
    </div>
@endsection
