@extends('layouts.app')

@section('title', 'Kelola Reward')
@section('page-title', 'Kelola Reward')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
        Dashboard
    </a>
    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Mahasiswa
    </a>
    <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Verifikasi Sertifikat
    </a>
    <a href="{{ route('admin.rewards.index') }}" class="flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
        Kelola Reward
    </a>
@endsection

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Daftar Reward</h2>
            <p class="mt-1 text-sm text-slate-600">Kelola reward yang dapat ditukar mahasiswa dengan poin mereka</p>
        </div>
        <a href="{{ route('admin.rewards.create') }}" 
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Reward
        </a>
    </div>

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- Desktop Grid --}}
    <div class="hidden lg:grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($rewards as $reward)
            <div class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:shadow-md">
                {{-- Image --}}
                <div class="aspect-video w-full overflow-hidden bg-slate-100">
                    @if ($reward->gambar)
                        <img src="{{ Storage::url($reward->gambar) }}" 
                            alt="{{ $reward->nama }}" 
                            class="h-full w-full object-cover transition-transform group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center">
                            <svg class="h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-4">
                    <div class="mb-2 flex items-start justify-between gap-2">
                        <h3 class="text-base font-semibold text-slate-900">{{ $reward->nama }}</h3>
                        @if ($reward->aktif)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">Nonaktif</span>
                        @endif
                    </div>

                    @if ($reward->deskripsi)
                        <p class="mb-3 line-clamp-2 text-sm text-slate-600">{{ $reward->deskripsi }}</p>
                    @endif

                    <div class="mb-4 flex items-center justify-between border-t border-slate-100 pt-3">
                        <div>
                            <p class="text-xs text-slate-500">Poin Dibutuhkan</p>
                            <p class="text-lg font-bold text-indigo-600">{{ number_format($reward->poin_dibutuhkan) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Stok</p>
                            <p class="text-lg font-bold text-slate-900">{{ number_format($reward->stok) }}</p>
                        </div>
                    </div>

                    <div class="mb-3 flex items-center gap-2 text-xs text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>{{ $reward->claims_count }} klaim</span>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.rewards.edit', $reward) }}" 
                            class="flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-center text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                            Edit
                        </a>
                        <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus reward ini?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                <p class="mt-4 text-sm text-slate-500">Belum ada reward. Tambahkan reward pertama Anda.</p>
                <a href="{{ route('admin.rewards.create') }}" 
                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Reward
                </a>
            </div>
        @endforelse
    </div>

    {{-- Mobile Cards --}}
    <div class="lg:hidden space-y-4">
        @forelse ($rewards as $reward)
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                @if ($reward->gambar)
                    <img src="{{ Storage::url($reward->gambar) }}" 
                        alt="{{ $reward->nama }}" 
                        class="aspect-video w-full object-cover">
                @else
                    <div class="aspect-video w-full bg-slate-100 flex items-center justify-center">
                        <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                    </div>
                @endif

                <div class="p-4">
                    <div class="mb-2 flex items-start justify-between gap-2">
                        <h3 class="text-base font-semibold text-slate-900">{{ $reward->nama }}</h3>
                        @if ($reward->aktif)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">Nonaktif</span>
                        @endif
                    </div>

                    @if ($reward->deskripsi)
                        <p class="mb-3 text-sm text-slate-600">{{ $reward->deskripsi }}</p>
                    @endif

                    <div class="mb-3 flex items-center justify-between rounded-lg bg-slate-50 p-3">
                        <div>
                            <p class="text-xs text-slate-500">Poin</p>
                            <p class="text-lg font-bold text-indigo-600">{{ number_format($reward->poin_dibutuhkan) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Stok</p>
                            <p class="text-lg font-bold text-slate-900">{{ number_format($reward->stok) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Klaim</p>
                            <p class="text-lg font-bold text-slate-900">{{ $reward->claims_count }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.rewards.edit', $reward) }}" 
                            class="flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-center text-sm font-medium text-slate-700">
                            Edit
                        </a>
                        <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus reward ini?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                <p class="text-sm text-slate-500">Belum ada reward.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($rewards->hasPages())
        <div class="mt-6">
            {{ $rewards->links() }}
        </div>
    @endif
@endsection
