@extends('layouts.app')

@section('title', 'Verifikasi Sertifikat')
@section('page-title', 'Verifikasi Sertifikat')

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
    {{-- Filter & Search --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('admin.certificates.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-slate-700 mb-1">Cari</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama mahasiswa atau sertifikat..."
                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            </div>

            <div class="w-full sm:w-48">
                <label for="level" class="block text-sm font-medium text-slate-700 mb-1">Level</label>
                <select name="level" id="level" 
                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    <option value="">Semua Level</option>
                    <option value="lokal" {{ request('level') === 'lokal' ? 'selected' : '' }}>Lokal</option>
                    <option value="regional" {{ request('level') === 'regional' ? 'selected' : '' }}>Regional</option>
                    <option value="nasional" {{ request('level') === 'nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="internasional" {{ request('level') === 'internasional' ? 'selected' : '' }}>Internasional</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'level']))
                    <a href="{{ route('admin.certificates.index') }}" class="rounded-lg border border-slate-300 bg-white px-6 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden lg:block rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Sertifikat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal Terbit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Diajukan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($certificates as $certificate)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($certificate->user->profile?->foto)
                                    <img src="{{ Storage::url($certificate->user->profile->foto) }}" 
                                        alt="{{ $certificate->user->name }}" 
                                        class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-medium text-indigo-600">
                                        {{ strtoupper(substr($certificate->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $certificate->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $certificate->user->profile?->nim ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-900">{{ $certificate->nama }}</p>
                            @if ($certificate->penerbit)
                                <p class="text-xs text-slate-500">{{ $certificate->penerbit }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                @if ($certificate->level === 'internasional') bg-purple-100 text-purple-700
                                @elseif ($certificate->level === 'nasional') bg-blue-100 text-blue-700
                                @elseif ($certificate->level === 'regional') bg-emerald-100 text-emerald-700
                                @else bg-slate-100 text-slate-700 @endif">
                                {{ ucfirst($certificate->level) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $certificate->tanggal_terbit?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $certificate->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.certificates.show', $certificate) }}" 
                                class="inline-flex items-center gap-1 rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                            Tidak ada sertifikat yang perlu diverifikasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Cards --}}
    <div class="lg:hidden space-y-4">
        @forelse ($certificates as $certificate)
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3 mb-3">
                    @if ($certificate->user->profile?->foto)
                        <img src="{{ Storage::url($certificate->user->profile->foto) }}" 
                            alt="{{ $certificate->user->name }}" 
                            class="h-12 w-12 rounded-full object-cover">
                    @else
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-sm font-medium text-indigo-600">
                            {{ strtoupper(substr($certificate->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900">{{ $certificate->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $certificate->user->profile?->nim ?? '-' }}</p>
                    </div>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                        @if ($certificate->level === 'internasional') bg-purple-100 text-purple-700
                        @elseif ($certificate->level === 'nasional') bg-blue-100 text-blue-700
                        @elseif ($certificate->level === 'regional') bg-emerald-100 text-emerald-700
                        @else bg-slate-100 text-slate-700 @endif">
                        {{ ucfirst($certificate->level) }}
                    </span>
                </div>

                <div class="space-y-2 mb-4">
                    <div>
                        <p class="text-sm font-medium text-slate-900">{{ $certificate->nama }}</p>
                        @if ($certificate->penerbit)
                            <p class="text-xs text-slate-500">{{ $certificate->penerbit }}</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span>Terbit: {{ $certificate->tanggal_terbit?->format('d M Y') ?? '-' }}</span>
                        <span>Diajukan: {{ $certificate->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <a href="{{ route('admin.certificates.show', $certificate) }}" 
                    class="block w-full rounded-lg bg-indigo-600 px-4 py-2 text-center text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                    Review Sertifikat
                </a>
            </div>
        @empty
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <p class="text-sm text-slate-500">Tidak ada sertifikat yang perlu diverifikasi.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($certificates->hasPages())
        <div class="mt-6">
            {{ $certificates->links() }}
        </div>
    @endif
@endsection
