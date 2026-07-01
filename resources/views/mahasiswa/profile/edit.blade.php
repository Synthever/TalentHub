@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('sidebar')
    @include('mahasiswa.partials.sidebar', ['active' => 'profil'])
@endsection

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Edit Profil</h2>
            <p class="mt-1 text-sm text-slate-500">Lengkapi profil untuk membangun talent card kamu.</p>

            <form method="POST" action="{{ route('mahasiswa.profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Foto --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Foto Profil</label>
                    <div class="mt-2 flex items-center gap-4">
                        @if ($profile->foto)
                            <img src="{{ Storage::url($profile->foto) }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover">
                        @else
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-100 text-lg font-bold text-indigo-600">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <input id="foto" type="file" name="foto" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-slate-400">JPG, PNG, atau WebP. Maks 2MB.</p>
                        </div>
                    </div>
                    @error('foto')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('name') border-rose-300 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIM + Angkatan --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nim" class="block text-sm font-medium text-slate-700">NIM</label>
                        <input id="nim" type="text" name="nim" value="{{ old('nim', $profile->nim) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('nim') border-rose-300 @enderror" placeholder="Contoh: 2021001001">
                        @error('nim')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="angkatan" class="block text-sm font-medium text-slate-700">Angkatan</label>
                        <input id="angkatan" type="text" name="angkatan" value="{{ old('angkatan', $profile->angkatan) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('angkatan') border-rose-300 @enderror" placeholder="Contoh: 2023" maxlength="4">
                        @error('angkatan')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Jurusan --}}
                <div>
                    <label for="jurusan" class="block text-sm font-medium text-slate-700">Jurusan / Program Studi</label>
                    <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan', $profile->jurusan) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('jurusan') border-rose-300 @enderror" placeholder="Contoh: Teknik Informatika">
                    @error('jurusan')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bio --}}
                <div>
                    <label for="bio" class="block text-sm font-medium text-slate-700">Bio</label>
                    <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('bio') border-rose-300 @enderror" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div>
                    <label for="telepon" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                    <input id="telepon" type="text" name="telepon" value="{{ old('telepon', $profile->telepon) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('telepon') border-rose-300 @enderror" placeholder="Contoh: 081234567890">
                    @error('telepon')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-slate-200">

                <p class="text-sm font-medium text-slate-700">Tautan Sosial</p>

                {{-- LinkedIn --}}
                <div>
                    <label for="linkedin" class="block text-sm font-medium text-slate-700">LinkedIn</label>
                    <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('linkedin') border-rose-300 @enderror" placeholder="https://linkedin.com/in/username">
                    @error('linkedin')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- GitHub --}}
                <div>
                    <label for="github" class="block text-sm font-medium text-slate-700">GitHub</label>
                    <input id="github" type="url" name="github" value="{{ old('github', $profile->github) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('github') border-rose-300 @enderror" placeholder="https://github.com/username">
                    @error('github')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Website --}}
                <div>
                    <label for="website" class="block text-sm font-medium text-slate-700">Website</label>
                    <input id="website" type="url" name="website" value="{{ old('website', $profile->website) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('website') border-rose-300 @enderror" placeholder="https://example.com">
                    @error('website')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('mahasiswa.profile.show') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
