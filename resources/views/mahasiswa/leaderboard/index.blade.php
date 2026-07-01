@extends('layouts.app')

@section('title', 'Leaderboard')
@section('page-title', 'Leaderboard')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'leaderboard'])
@endsection

@section('content')
    {{-- Your Position --}}
    <div class="rounded-xl border border-indigo-200 bg-gradient-to-r from-indigo-50 to-violet-50 p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Posisi Kamu</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">
                    @if ($currentRank)
                        #{{ $currentRank }}
                    @else
                        -
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full bg-violet-100 px-4 py-2 text-sm font-semibold text-violet-700">
                    ★ {{ number_format($currentPoin) }} Poin
                </span>
            </div>
        </div>
    </div>    {{-- Desktop Table (hidden on mobile) --}}
    <div class="hidden md:block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Peringkat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Jurusan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Poin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($mahasiswas as $index => $mhs)
                    @php $rank = $index + 1; @endphp
                    <tr class="{{ $mhs->id === $currentUserId ? 'bg-indigo-50/50' : '' }} transition-colors hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($rank === 1)
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">🥇</span>
                            @elseif ($rank === 2)
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-sm font-bold text-slate-600">🥈</span>
                            @elseif ($rank === 3)
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-orange-700">🥉</span>
                            @else
                                <span class="inline-flex h-8 w-8 items-center justify-center text-sm font-medium text-slate-500">{{ $rank }}</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($mhs->profile && $mhs->profile->foto)
                                    <img src="{{ Storage::url($mhs->profile->foto) }}" alt="{{ $mhs->name }}" class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-medium text-indigo-600">
                                        {{ strtoupper(substr($mhs->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-slate-900 {{ $mhs->id === $currentUserId ? 'text-indigo-700' : '' }}">
                                        {{ $mhs->name }}
                                        @if ($mhs->id === $currentUserId)
                                            <span class="text-xs text-indigo-500">(Kamu)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                            {{ $mhs->profile->jurusan ?? '-' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <span class="text-sm font-semibold text-slate-900">{{ number_format($mhs->total_poin ?? 0) }}</span>
                        </td>
                    </tr>
                @endforeach

                @if ($mahasiswas->isEmpty())
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada data leaderboard.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Mobile Cards (hidden on desktop) --}}
    <div class="mt-6 space-y-3 md:hidden">
        @forelse ($mahasiswas as $index => $mhs)
            @php $rank = $index + 1; @endphp
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm {{ $mhs->id === $currentUserId ? 'border-indigo-300 bg-indigo-50/30' : '' }}">
                <div class="flex items-center gap-3">
                    {{-- Rank --}}
                    <div class="shrink-0">
                        @if ($rank === 1)
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-lg font-bold text-amber-700">🥇</span>
                        @elseif ($rank === 2)
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-lg font-bold text-slate-600">🥈</span>
                        @elseif ($rank === 3)
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-lg font-bold text-orange-700">🥉</span>
                        @else
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-base font-bold text-slate-600">{{ $rank }}</span>
                        @endif
                    </div>

                    {{-- Avatar --}}
                    @if ($mhs->profile && $mhs->profile->foto)
                        <img src="{{ Storage::url($mhs->profile->foto) }}" alt="{{ $mhs->name }}" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-medium text-indigo-600">
                            {{ strtoupper(substr($mhs->name, 0, 1)) }}
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate {{ $mhs->id === $currentUserId ? 'text-indigo-700' : '' }}">
                            {{ $mhs->name }}
                            @if ($mhs->id === $currentUserId)
                                <span class="text-xs text-indigo-600">(Kamu)</span>
                            @endif
                        </p>
                        <p class="text-xs text-slate-500 truncate">{{ $mhs->profile->jurusan ?? '-' }}</p>
                    </div>

                    {{-- Poin --}}
                    <div class="shrink-0">
                        <span class="text-base font-bold text-slate-900">{{ number_format($mhs->total_poin ?? 0) }}</span>
                        <p class="text-xs text-slate-400">poin</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center">
                <p class="text-sm text-slate-400">Belum ada data leaderboard.</p>
            </div>
        @endforelse
    </div>
@endsection
