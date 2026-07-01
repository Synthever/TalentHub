@extends('layouts.app')

@section('title', 'Tambah Sertifikat')
@section('page-title', 'Tambah Sertifikat')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'certificate'])
@endsection

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Tambah Sertifikat Baru</h2>
            <p class="mt-1 text-sm text-slate-500">Upload sertifikat untuk mendapatkan poin setelah diverifikasi.</p>

            <form method="POST" action="{{ route('mahasiswa.certificates.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                {{-- Nama Sertifikat --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700">Nama Sertifikat</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('nama') border-rose-300 @enderror" placeholder="Contoh: Sertifikat Web Development">
                    @error('nama')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label for="penerbit" class="block text-sm font-medium text-slate-700">Penerbit <span class="text-slate-400">(opsional)</span></label>
                    <input id="penerbit" type="text" name="penerbit" value="{{ old('penerbit') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('penerbit') border-rose-300 @enderror" placeholder="Contoh: Dicoding, Coursera, Google">
                    @error('penerbit')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Level --}}
                <div>
                    <label for="level" class="block text-sm font-medium text-slate-700">Level Sertifikat</label>
                    <select id="level" name="level" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('level') border-rose-300 @enderror">
                        <option value="">Pilih level</option>
                        <option value="lokal" @selected(old('level') === 'lokal')>Lokal</option>
                        <option value="regional" @selected(old('level') === 'regional')>Regional</option>
                        <option value="nasional" @selected(old('level') === 'nasional')>Nasional</option>
                        <option value="internasional" @selected(old('level') === 'internasional')>Internasional</option>
                    </select>
                    @error('level')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Terbit --}}
                <div>
                    <label for="tanggal_terbit" class="block text-sm font-medium text-slate-700">Tanggal Terbit <span class="text-slate-400">(opsional)</span></label>
                    <input id="tanggal_terbit" type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('tanggal_terbit') border-rose-300 @enderror">
                    @error('tanggal_terbit')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL Bukti --}}
                <div>
                    <label for="url_bukti" class="block text-sm font-medium text-slate-700">URL Bukti <span class="text-slate-400">(opsional)</span></label>
                    <input id="url_bukti" type="url" name="url_bukti" value="{{ old('url_bukti') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('url_bukti') border-rose-300 @enderror" placeholder="https://...">
                    @error('url_bukti')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- File Sertifikat --}}
                <div>
                    <label for="file_bukti" class="block text-sm font-medium text-slate-700">File Sertifikat</label>
                    <div class="mt-1 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300 px-6 py-8 transition-colors hover:border-indigo-400">
                        <div class="text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <div class="mt-2">
                                <input id="file_bukti" type="file" name="file_bukti" accept=".jpg,.jpeg,.png,.pdf,.webp" required class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                            <p class="mt-1 text-xs text-slate-400">File sertifikat atau screenshot. JPG, PNG, PDF, WebP. Maks 5MB.</p>
                        </div>
                    </div>
                    @error('file_bukti')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info --}}
                <div class="flex items-start gap-3 rounded-lg border border-sky-200 bg-sky-50 p-4">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm text-sky-800">
                        <p class="font-medium">Proses Verifikasi</p>
                        <p class="mt-1">Setelah disubmit, sertifikat kamu akan direview oleh admin. Poin akan diberikan setelah verifikasi disetujui (5 poin per sertifikat).</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('mahasiswa.certificates.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
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
