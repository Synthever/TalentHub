@extends('layouts.app')

@section('title', 'Sertifikat Saya')
@section('page-title', 'Sertifikat Saya')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'certificate'])
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-500">Kelola sertifikat dan ajukan verifikasi untuk mendapatkan poin.</p>
        </div>
        <a href="{{ route('mahasiswa.certificates.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Sertifikat
        </a>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total Sertifikat</p>
            <p class="text-2xl font-bold text-slate-900">{{ $certificates->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Terverifikasi</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $certificates->where('status', 'approved')->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Menunggu</p>
            <p class="text-2xl font-bold text-amber-600">{{ $certificates->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    {{-- Certificate List --}}
    <div class="mt-6">
        @if ($certificates->isNotEmpty())
            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Sertifikat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Penerbit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Poin</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($certificates as $cert)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $cert->nama }}</p>
                                        <p class="text-xs text-slate-400">{{ optional($cert->tanggal_terbit)->format('d M Y') ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $cert->penerbit ?? '-' }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($cert->file_bukti)
                                        <a href="{{ Storage::url($cert->file_bukti) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat</a>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        @if ($cert->status === 'approved') bg-emerald-50 text-emerald-700
                                        @elseif ($cert->status === 'pending') bg-amber-50 text-amber-700
                                        @else bg-rose-50 text-rose-600 @endif">
                                        @if ($cert->status === 'approved') Disetujui
                                        @elseif ($cert->status === 'pending') Menunggu
                                        @else Ditolak @endif
                                    </span>
                                    @if ($cert->status === 'rejected' && $cert->catatan_admin)
                                        <p class="mt-1 text-xs text-rose-500">{{ $cert->catatan_admin }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($cert->poin > 0)
                                        <span class="inline-flex items-center gap-1 text-sm font-medium text-violet-700">★ {{ $cert->poin }}</span>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    @if ($cert->status !== 'approved')
                                        <form method="POST" action="{{ route('mahasiswa.certificates.destroy', $cert) }}" onsubmit="return confirm('Hapus sertifikat ini?')">
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

            {{-- Mobile Cards --}}
            <div class="space-y-3 md:hidden">
                @foreach ($certificates as $cert)
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $cert->nama }}</p>
                                <p class="text-xs text-slate-400">{{ $cert->penerbit ?? '-' }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ optional($cert->tanggal_terbit)->format('d M Y') ?? '-' }}</p>
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

                        <div class="mt-3 flex items-center gap-4">
                            @if ($cert->file_bukti)
                                <a href="{{ Storage::url($cert->file_bukti) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-700">Lihat File →</a>
                            @endif
                            @if ($cert->poin > 0)
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-violet-700">★ {{ $cert->poin }} Poin</span>
                            @endif
                        </div>

                        @if ($cert->status === 'rejected' && $cert->catatan_admin)
                            <p class="mt-2 text-xs text-rose-500">{{ $cert->catatan_admin }}</p>
                        @endif

                        @if ($cert->status !== 'approved')
                            <form method="POST" action="{{ route('mahasiswa.certificates.destroy', $cert) }}" onsubmit="return confirm('Hapus sertifikat ini?')" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-medium">Hapus Sertifikat</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h3 class="mt-4 text-sm font-medium text-slate-900">Belum ada sertifikat</h3>
                <p class="mt-1 text-sm text-slate-500">Mulai tambahkan sertifikat pertamamu!</p>
                <a href="{{ route('mahasiswa.certificates.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Sertifikat
                </a>
            </div>
        @endif
    </div>
@endsection
