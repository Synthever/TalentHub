@extends('layouts.app')

@section('title', 'Portfolio Saya')
@section('page-title', 'Portfolio Saya')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'portfolio'])
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-500">Kelola portfolio dan ajukan verifikasi untuk mendapatkan poin.</p>
        </div>
        <a href="{{ route('mahasiswa.portfolios.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Portfolio
        </a>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total Portfolio</p>
            <p class="text-2xl font-bold text-slate-900">{{ $portfolios->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Terverifikasi</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $portfolios->where('status', 'approved')->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Menunggu</p>
            <p class="text-2xl font-bold text-amber-600">{{ $portfolios->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    {{-- Portfolio Grid --}}
    <div class="mt-6">
        @if ($portfolios->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($portfolios as $portfolio)
                    <div class="group rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md overflow-hidden">
                        {{-- Image --}}
                        <div class="aspect-video bg-slate-100">
                            @if ($portfolio->gambar)
                                <img src="{{ Storage::url($portfolio->gambar) }}" alt="{{ $portfolio->judul }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h3 class="truncate text-sm font-semibold text-slate-900">{{ $portfolio->judul }}</h3>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ ucfirst($portfolio->kategori) }}</p>
                                </div>
                                <span class="shrink-0 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                    @if ($portfolio->status === 'approved') bg-emerald-50 text-emerald-700
                                    @elseif ($portfolio->status === 'pending') bg-amber-50 text-amber-700
                                    @else bg-rose-50 text-rose-600 @endif">
                                    @if ($portfolio->status === 'approved') Disetujui
                                    @elseif ($portfolio->status === 'pending') Menunggu
                                    @else Ditolak @endif
                                </span>
                            </div>

                            @if ($portfolio->deskripsi)
                                <p class="mt-2 text-xs text-slate-500 line-clamp-2">{{ $portfolio->deskripsi }}</p>
                            @endif

                            @if ($portfolio->status === 'rejected' && $portfolio->catatan_admin)
                                <p class="mt-2 text-xs text-rose-500">{{ $portfolio->catatan_admin }}</p>
                            @endif

                            @if ($portfolio->poin > 0)
                                <p class="mt-2 inline-flex items-center gap-1 text-xs font-medium text-violet-700">★ {{ $portfolio->poin }} Poin</p>
                            @endif

                            {{-- Actions --}}
                            <div class="mt-3 flex items-center gap-2 border-t border-slate-100 pt-3">
                                @if ($portfolio->url_demo)
                                    <a href="{{ $portfolio->url_demo }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-700">Demo</a>
                                @endif
                                @if ($portfolio->url_repository)
                                    <a href="{{ $portfolio->url_repository }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-700">Repo</a>
                                @endif
                                <div class="flex-1"></div>
                                @if ($portfolio->status !== 'approved')
                                    <form method="POST" action="{{ route('mahasiswa.portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Hapus portfolio ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-rose-600 hover:text-rose-700">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <h3 class="mt-4 text-sm font-medium text-slate-900">Belum ada portfolio</h3>
                <p class="mt-1 text-sm text-slate-500">Mulai tambahkan portfolio pertamamu!</p>
                <a href="{{ route('mahasiswa.portfolios.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Portfolio
                </a>
            </div>
        @endif
    </div>
@endsection
