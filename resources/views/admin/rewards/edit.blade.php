@extends('layouts.app')

@section('title', 'Edit Reward')
@section('page-title', 'Edit Reward')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
        Dashboard
    </a>
    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Mahasiswa
    </a>
    <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Verifikasi Sertifikat
    </a>
    <a href="{{ route('admin.rewards.index') }}" class="flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
        Kelola Reward
    </a>
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.rewards.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Reward
        </a>
    </div>

    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-6 text-xl font-semibold text-slate-900">Edit Reward</h2>

            <form action="{{ route('admin.rewards.update', $reward) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Reward <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $reward->nama) }}" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 @error('nama') border-red-300 @enderror"
                        placeholder="Contoh: Voucher Google Play 50K">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 @error('deskripsi') border-red-300 @enderror"
                        placeholder="Jelaskan detail reward, syarat & ketentuan...">{{ old('deskripsi', $reward->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Maksimal 1000 karakter</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    {{-- Poin Dibutuhkan --}}
                    <div>
                        <label for="poin_dibutuhkan" class="block text-sm font-medium text-slate-700 mb-2">
                            Poin Dibutuhkan <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="poin_dibutuhkan" id="poin_dibutuhkan" value="{{ old('poin_dibutuhkan', $reward->poin_dibutuhkan) }}" required min="1"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 @error('poin_dibutuhkan') border-red-300 @enderror"
                            placeholder="100">
                        @error('poin_dibutuhkan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label for="stok" class="block text-sm font-medium text-slate-700 mb-2">
                            Stok <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok', $reward->stok) }}" required min="0"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 @error('stok') border-red-300 @enderror"
                            placeholder="10">
                        @error('stok')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="gambar" class="block text-sm font-medium text-slate-700 mb-2">
                        Gambar Reward
                    </label>

                    @if ($reward->gambar)
                        <div class="mb-4">
                            <p class="mb-2 text-xs text-slate-600">Gambar saat ini:</p>
                            <img src="{{ Storage::url($reward->gambar) }}" alt="{{ $reward->nama }}" 
                                class="h-32 w-auto rounded-lg border border-slate-200 object-cover">
                        </div>
                    @endif

                    <div class="flex items-center gap-4">
                        <label for="gambar" class="flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $reward->gambar ? 'Ganti Gambar' : 'Pilih Gambar' }}
                        </label>
                        <span id="file-name" class="text-sm text-slate-500">Belum ada file dipilih</span>
                    </div>
                    <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden"
                        onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Belum ada file dipilih'; previewImage(this);">
                    @error('gambar')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>

                    {{-- Image Preview --}}
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="mb-2 text-xs text-slate-600">Preview gambar baru:</p>
                        <img id="preview" class="h-48 w-auto rounded-lg border border-slate-200 object-cover" alt="Preview">
                    </div>
                </div>

                {{-- Status Aktif --}}
                <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $reward->aktif) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500/20">
                    <label for="aktif" class="flex-1">
                        <span class="text-sm font-medium text-slate-900">Aktifkan Reward</span>
                        <p class="text-xs text-slate-600">Reward yang aktif akan ditampilkan ke mahasiswa dan dapat ditukar</p>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.rewards.index') }}" 
                        class="rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-center text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                        class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                        Update Reward
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.classList.add('hidden');
    }
}
</script>
@endpush
