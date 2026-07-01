@extends('layouts.app')

@section('title', 'Tambah Portfolio')
@section('page-title', 'Tambah Portfolio')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'portfolio'])
@endsection

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Tambah Portfolio Baru</h2>
            <p class="mt-1 text-sm text-slate-500">Tambahkan project atau karya yang ingin kamu showcase.</p>

            <form method="POST" action="{{ route('mahasiswa.portfolios.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                {{-- Judul --}}
                <div>
                    <label for="judul" class="block text-sm font-medium text-slate-700">Judul Project</label>
                    <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('judul') border-rose-300 @enderror" placeholder="Contoh: E-Commerce App">
                    @error('judul')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select id="kategori" name="kategori" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('kategori') border-rose-300 @enderror">
                        <option value="">-- Pilih kategori --</option>
                        <option value="personal" @selected(old('kategori') === 'personal')>Personal (2 poin)</option>
                        <option value="freelance" @selected(old('kategori') === 'freelance')>Freelance (5 poin)</option>
                        <option value="industri" @selected(old('kategori') === 'industri')>Industri (8 poin)</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('deskripsi') border-rose-300 @enderror" placeholder="Jelaskan tentang project ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="gambar" class="block text-sm font-medium text-slate-700">Screenshot / Gambar <span class="text-slate-400">(opsional)</span></label>
                    <div class="mt-1 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300 px-6 py-8 transition-colors hover:border-indigo-400">
                        <div class="text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <div class="mt-2">
                                <input id="gambar" type="file" name="gambar" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                            <p class="mt-1 text-xs text-slate-400">JPG, PNG, atau WebP. Maks 5MB.</p>
                        </div>
                    </div>
                    @error('gambar')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URLs --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="url_demo" class="block text-sm font-medium text-slate-700">URL Demo <span class="text-slate-400">(opsional)</span></label>
                        <input id="url_demo" type="url" name="url_demo" value="{{ old('url_demo') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('url_demo') border-rose-300 @enderror" placeholder="https://demo.example.com">
                        @error('url_demo')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="url_repository" class="block text-sm font-medium text-slate-700">URL Repository <span class="text-slate-400">(opsional)</span></label>
                        <input id="url_repository" type="url" name="url_repository" value="{{ old('url_repository') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('url_repository') border-rose-300 @enderror" placeholder="https://github.com/user/repo">
                        @error('url_repository')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex items-start gap-3 rounded-lg border border-sky-200 bg-sky-50 p-4">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm text-sky-800">
                        <p class="font-medium">Poin berdasarkan kategori</p>
                        <ul class="mt-1 space-y-0.5 text-xs">
                            <li>Personal: <strong>2 poin</strong></li>
                            <li>Freelance: <strong>5 poin</strong></li>
                            <li>Industri: <strong>8 poin</strong></li>
                        </ul>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('mahasiswa.portfolios.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
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
