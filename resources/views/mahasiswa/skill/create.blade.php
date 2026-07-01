@extends('layouts.app')

@section('title', 'Tambah Skill')
@section('page-title', 'Tambah Skill')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'skill'])
@endsection

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Tambah Skill Baru</h2>
            <p class="mt-1 text-sm text-slate-500">Pilih skill, tentukan level, dan unggah bukti pendukung.</p>

            <form method="POST" action="{{ route('mahasiswa.skills.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                {{-- Skill Selection --}}
                <div>
                    <label for="skill_id" class="block text-sm font-medium text-slate-700">Pilih Skill</label>
                    <select id="skill_id" name="skill_id" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('skill_id') border-rose-300 @enderror">
                        <option value="">-- Pilih skill --</option>
                        @foreach ($skills as $kategori => $items)
                            <optgroup label="{{ ucfirst($kategori) }}">
                                @foreach ($items as $skill)
                                    <option value="{{ $skill->id }}" @selected(old('skill_id') == $skill->id)>{{ $skill->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('skill_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Level --}}
                <div>
                    <label for="level" class="block text-sm font-medium text-slate-700">Level Kemampuan</label>
                    <select id="level" name="level" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('level') border-rose-300 @enderror">
                        <option value="">-- Pilih level --</option>
                        <option value="pemula" @selected(old('level') === 'pemula')>Pemula</option>
                        <option value="menengah" @selected(old('level') === 'menengah')>Menengah</option>
                        <option value="mahir" @selected(old('level') === 'mahir')>Mahir</option>
                    </select>
                    @error('level')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bukti --}}
                <div>
                    <label for="bukti" class="block text-sm font-medium text-slate-700">Bukti Pendukung <span class="text-slate-400">(opsional)</span></label>
                    <div class="mt-1 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300 px-6 py-8 transition-colors hover:border-indigo-400">
                        <div class="text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <div class="mt-2">
                                <input id="bukti" type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf,.webp" class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                            <p class="mt-1 text-xs text-slate-400">Sertifikat, screenshot, atau dokumen. JPG, PNG, PDF, WebP. Maks 5MB.</p>
                        </div>
                    </div>
                    @error('bukti')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info --}}
                <div class="flex items-start gap-3 rounded-lg border border-sky-200 bg-sky-50 p-4">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm text-sky-800">
                        <p class="font-medium">Proses Verifikasi</p>
                        <p class="mt-1">Setelah disubmit, skill kamu akan direview oleh admin. Poin akan diberikan setelah verifikasi disetujui.</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('mahasiswa.skills.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit untuk Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
