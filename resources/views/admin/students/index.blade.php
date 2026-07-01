@extends('layouts.app')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
        Dashboard
    </a>
    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Mahasiswa
    </a>
    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        Verifikasi
    </a>
    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
        Kelola Reward
    </a>
@endsection

@section('content')
    {{-- Search & Filter --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('admin.students.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-slate-700">Cari Mahasiswa</label>
                    <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama, email, atau NIM" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>

                {{-- Skill Filter --}}
                <div>
                    <label for="skill" class="block text-sm font-medium text-slate-700">Filter Skill</label>
                    <select id="skill" name="skill" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua Skill</option>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" @selected(($filters['skill'] ?? '') == $skill->id)>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Min Poin --}}
                <div>
                    <label for="min_poin" class="block text-sm font-medium text-slate-700">Min. Poin</label>
                    <input type="number" id="min_poin" name="min_poin" value="{{ $filters['min_poin'] ?? '' }}" min="0" placeholder="0" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari
                </button>
                @if(array_filter($filters))
                    <a href="{{ route('admin.students.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Reset Filter</a>
                @endif
                <div class="flex-1"></div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="sort" value="poin" @checked(($filters['sort'] ?? '') === 'poin') class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Urutkan by Poin
                </label>
            </div>
        </form>
    </div>

    {{-- Results --}}
    <div class="mt-6">
        <p class="mb-4 text-sm text-slate-500">Menampilkan {{ $students->count() }} dari {{ $students->total() }} mahasiswa</p>

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Jurusan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Poin</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($students as $student)
                        <tr class="transition-colors hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($student->profile && $student->profile->foto)
                                        <img src="{{ Storage::url($student->profile->foto) }}" alt="{{ $student->name }}" class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-medium text-indigo-600">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $student->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $student->profile->nim ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $student->profile->jurusan ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-sm font-semibold text-violet-700">★ {{ number_format($student->total_poin ?? 0) }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <a href="{{ route('admin.students.show', $student) }}" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat Detail →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada mahasiswa ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="space-y-3 md:hidden">
            @forelse ($students as $student)
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        @if ($student->profile && $student->profile->foto)
                            <img src="{{ Storage::url($student->profile->foto) }}" alt="{{ $student->name }}" class="h-10 w-10 rounded-full object-cover">
                        @else
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-medium text-indigo-600">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900">{{ $student->name }}</p>
                            <p class="text-xs text-slate-400">{{ $student->email }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-violet-700">★ {{ number_format($student->total_poin ?? 0) }}</span>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-slate-500">NIM:</span>
                            <span class="ml-1 text-slate-900">{{ $student->profile->nim ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500">Jurusan:</span>
                            <span class="ml-1 text-slate-900">{{ $student->profile->jurusan ?? '-' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.students.show', $student) }}" class="mt-3 inline-block text-xs text-indigo-600 hover:text-indigo-700 font-medium">Lihat Detail →</a>
                </div>
            @empty
                <div class="rounded-xl border border-slate-200 bg-white p-12 text-center">
                    <p class="text-sm text-slate-400">Tidak ada mahasiswa ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($students->hasPages())
            <div class="mt-6">
                {{ $students->links() }}
            </div>
        @endif
    </div>
@endsection
