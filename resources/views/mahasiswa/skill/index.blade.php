@extends('layouts.app')

@section('title', 'Skill Saya')
@section('page-title', 'Skill Saya')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'skill'])
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-500">Kelola skill dan ajukan verifikasi untuk mendapatkan poin.</p>
        </div>
        <a href="{{ route('mahasiswa.skills.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Skill
        </a>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total Skill</p>
            <p class="text-2xl font-bold text-slate-900">{{ $userSkills->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Terverifikasi</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $userSkills->where('status', 'approved')->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Menunggu</p>
            <p class="text-2xl font-bold text-amber-600">{{ $userSkills->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    {{-- Skill List --}}
    <div class="mt-6">
        @if ($userSkills->isNotEmpty())
            {{-- Desktop Table (hidden on mobile) --}}
            <div class="hidden md:block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Skill</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Bukti</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Poin</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($userSkills as $userSkill)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $userSkill->skill->name }}</p>
                                        <p class="text-xs text-slate-400">{{ ucfirst($userSkill->skill->kategori ?? '-') }}</p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                        {{ ucfirst($userSkill->level) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($userSkill->bukti)
                                        <a href="{{ Storage::url($userSkill->bukti) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat</a>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        @if ($userSkill->status === 'approved') bg-emerald-50 text-emerald-700
                                        @elseif ($userSkill->status === 'pending') bg-amber-50 text-amber-700
                                        @else bg-rose-50 text-rose-600 @endif">
                                        @if ($userSkill->status === 'approved') Disetujui
                                        @elseif ($userSkill->status === 'pending') Menunggu
                                        @else Ditolak @endif
                                    </span>
                                    @if ($userSkill->status === 'rejected' && $userSkill->catatan_admin)
                                        <p class="mt-1 text-xs text-rose-500">{{ $userSkill->catatan_admin }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($userSkill->poin > 0)
                                        <span class="inline-flex items-center gap-1 text-sm font-medium text-violet-700">★ {{ $userSkill->poin }}</span>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    @if ($userSkill->status !== 'approved')
                                        <form method="POST" action="{{ route('mahasiswa.skills.destroy', $userSkill) }}" onsubmit="return confirm('Hapus skill ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-rose-600 hover:text-rose-700">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards (hidden on desktop) --}}
            <div class="space-y-3 md:hidden">
                @foreach ($userSkills as $userSkill)
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $userSkill->skill->name }}</p>
                                <p class="text-xs text-slate-400">{{ ucfirst($userSkill->skill->kategori ?? '-') }}</p>
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

                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-slate-500">Level</p>
                                <span class="mt-1 inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                    {{ ucfirst($userSkill->level) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Bukti</p>
                                @if ($userSkill->bukti)
                                    <a href="{{ Storage::url($userSkill->bukti) }}" target="_blank" class="mt-1 inline-block text-xs text-indigo-600 hover:text-indigo-700">Lihat Bukti →</a>
                                @else
                                    <span class="mt-1 inline-block text-xs text-slate-400">Tidak ada</span>
                                @endif
                            </div>
                        </div>

                        @if ($userSkill->poin > 0)
                            <div class="mt-3">
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-violet-700">★ {{ $userSkill->poin }} Poin</span>
                            </div>
                        @endif

                        @if ($userSkill->status === 'rejected' && $userSkill->catatan_admin)
                            <p class="mt-2 text-xs text-rose-500">{{ $userSkill->catatan_admin }}</p>
                        @endif

                        @if ($userSkill->status !== 'approved')
                            <form method="POST" action="{{ route('mahasiswa.skills.destroy', $userSkill) }}" onsubmit="return confirm('Hapus skill ini?')" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-medium">Hapus Skill</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                <h3 class="mt-4 text-sm font-medium text-slate-900">Belum ada skill</h3>
                <p class="mt-1 text-sm text-slate-500">Mulai tambahkan skill pertamamu!</p>
                <a href="{{ route('mahasiswa.skills.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Skill
                </a>
            </div>
        @endif
    </div>
@endsection
