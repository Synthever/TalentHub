@extends('layouts.app')

@section('title', 'Reward')
@section('page-title', 'Katalog Reward')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'reward'])
@endsection

@section('content')
    {{-- Poin Info --}}
    <div class="rounded-xl border border-violet-200 bg-gradient-to-r from-violet-50 to-indigo-50 p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-violet-600">Poin Tersedia</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">{{ number_format($availablePoin) }}</p>
                <p class="mt-1 text-xs text-slate-500">Total: {{ number_format($totalPoin) }} poin &bull; Digunakan: {{ number_format($totalPoin - $availablePoin) }} poin</p>
            </div>
        </div>
    </div>

    {{-- Reward Catalog --}}
    <h3 class="mt-6 text-lg font-semibold text-slate-900">Katalog Reward</h3>
    <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($rewards as $reward)
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50 text-lg">🎁</div>
                    <span class="inline-flex items-center rounded-full bg-violet-100 px-2.5 py-0.5 text-xs font-semibold text-violet-700">{{ number_format($reward->poin_dibutuhkan) }} poin</span>
                </div>
                <h4 class="mt-3 text-sm font-semibold text-slate-900">{{ $reward->nama }}</h4>
                @if ($reward->deskripsi)
                    <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $reward->deskripsi }}</p>
                @endif
                <div class="mt-3 flex items-center justify-between">
                    <span class="text-xs text-slate-400">Stok: {{ $reward->stok }}</span>
                    @if ($reward->stok > 0 && $availablePoin >= $reward->poin_dibutuhkan)
                        <form method="POST" action="{{ route('mahasiswa.rewards.claim', $reward) }}" onsubmit="return confirm('Klaim reward {{ $reward->nama }}? Poin kamu akan berkurang {{ number_format($reward->poin_dibutuhkan) }}.')">
                            @csrf
                            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                                Klaim
                            </button>
                        </form>
                    @elseif ($reward->stok <= 0)
                        <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-400">Habis</span>
                    @else
                        <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-400">Poin kurang</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <p class="text-sm text-slate-400">Belum ada reward tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- My Claims --}}
    @if ($myClaims->isNotEmpty())
        <h3 class="mt-8 text-lg font-semibold text-slate-900">Riwayat Klaim</h3>
        <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Reward</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Poin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($myClaims as $claim)
                        <tr class="transition-colors hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">{{ $claim->reward->nama }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ number_format($claim->poin_digunakan) }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                    @if ($claim->status === 'approved') bg-emerald-50 text-emerald-700
                                    @elseif ($claim->status === 'pending') bg-amber-50 text-amber-700
                                    @else bg-rose-50 text-rose-600 @endif">
                                    @if ($claim->status === 'approved') Disetujui
                                    @elseif ($claim->status === 'pending') Menunggu
                                    @else Ditolak @endif
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $claim->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
