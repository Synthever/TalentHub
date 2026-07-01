@extends('layouts.app')

@section('title', 'Rekomendasi AI')
@section('page-title', 'Rekomendasi AI')

@section('sidebar')
    @include('mahasiswa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Rekomendasi AI Powered</h2>
        <p class="mt-1 text-sm text-slate-600">Dapatkan rekomendasi personal menggunakan AI</p>
    </div>

    {{-- Tabs --}}
    <div class="mb-6 border-b border-slate-200">
        <nav class="-mb-px flex gap-6" x-data="{ activeTab: 'skills' }">
            <button @click="activeTab = 'skills'" 
                :class="activeTab === 'skills' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                Rekomendasi Skill
            </button>
            <button @click="activeTab = 'path'" 
                :class="activeTab === 'path' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                Development Path
            </button>
            <button @click="activeTab = 'collab'" 
                :class="activeTab === 'collab' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                Rekomendasi Kolaborasi
            </button>
        </nav>
    </div>

    {{-- Skill Recommendations --}}
    <div x-show="activeTab === 'skills'" x-cloak>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Skill yang Sebaiknya Dipelajari</h3>
            <button onclick="loadSkillRecommendations()" 
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Generate Rekomendasi
            </button>
        </div>

        <div id="skill-loading" class="hidden rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <div class="inline-flex h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-indigo-600"></div>
            <p class="mt-4 text-sm text-slate-600">Menganalisis skill Anda dengan AI...</p>
        </div>

        <div id="skill-results" class="space-y-4"></div>
    </div>

    {{-- Development Path --}}
    <div x-show="activeTab === 'path'" x-cloak>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Jalur Pengembangan Karir</h3>
            <button onclick="loadDevelopmentPath()" 
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Generate Roadmap
            </button>
        </div>

        <div id="path-loading" class="hidden rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <div class="inline-flex h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-indigo-600"></div>
            <p class="mt-4 text-sm text-slate-600">Membuat development path dengan AI...</p>
        </div>

        <div id="path-results"></div>
    </div>

    {{-- Collaboration --}}
    <div x-show="activeTab === 'collab'" x-cloak>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Partner Kolaborasi Ideal</h3>
            <button onclick="loadCollaborationRecommendations()" 
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Generate Rekomendasi
            </button>
        </div>

        <div id="collab-loading" class="hidden rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <div class="inline-flex h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-indigo-600"></div>
            <p class="mt-4 text-sm text-slate-600">Mencari partner kolaborasi terbaik dengan AI...</p>
        </div>

        <div id="collab-results" class="grid grid-cols-1 gap-4 md:grid-cols-2"></div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
async function loadSkillRecommendations() {
    const loading = document.getElementById('skill-loading');
    const results = document.getElementById('skill-results');
    
    loading.classList.remove('hidden');
    results.innerHTML = '';
    
    try {
        const response = await fetch('/mahasiswa/ai/skill-matching');
        const data = await response.json();
        
        if (data.error) {
            results.innerHTML = `<div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">${data.error}</div>`;
            return;
        }
        
        if (data.message) {
            results.innerHTML = `<div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">${data.message}</div>`;
            return;
        }
        
        const recommendations = data.recommendations || [];
        
        if (recommendations.length === 0) {
            results.innerHTML = '<div class="rounded-lg border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Tidak ada rekomendasi saat ini.</div>';
            return;
        }
        
        results.innerHTML = recommendations.map(rec => `
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-slate-900">${rec.skill_name}</h4>
                        <p class="mt-2 text-sm text-slate-600">${rec.reason}</p>
                    </div>
                    <span class="ml-4 inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ${
                        rec.priority === 'high' ? 'bg-red-100 text-red-700' :
                        rec.priority === 'medium' ? 'bg-amber-100 text-amber-700' :
                        'bg-slate-100 text-slate-700'
                    }">
                        ${rec.priority}
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs text-slate-500">
                    <span>⏱️ ${rec.estimated_time} minggu</span>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        results.innerHTML = '<div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">Gagal memuat rekomendasi. Silakan coba lagi.</div>';
    } finally {
        loading.classList.add('hidden');
    }
}

async function loadDevelopmentPath() {
    const loading = document.getElementById('path-loading');
    const results = document.getElementById('path-results');
    
    loading.classList.remove('hidden');
    results.innerHTML = '';
    
    try {
        const response = await fetch('/mahasiswa/ai/development-path');
        const data = await response.json();
        
        if (data.error) {
            results.innerHTML = `<div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">${data.error}</div>`;
            return;
        }
        
        if (data.message) {
            results.innerHTML = `<div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">${data.message}</div>`;
            return;
        }
        
        const path = data.path || [];
        const tips = data.tips || [];
        
        if (path.length === 0) {
            results.innerHTML = '<div class="rounded-lg border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Tidak ada development path saat ini.</div>';
            return;
        }
        
        let html = '<div class="space-y-6">';
        
        // Timeline
        if (data.timeline) {
            html += `<div class="rounded-lg border border-indigo-200 bg-indigo-50 p-4"><p class="text-sm font-medium text-indigo-900">📅 Total Estimasi: ${data.timeline}</p></div>`;
        }
        
        // Path phases
        html += path.map((phase, idx) => `
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-600">${idx + 1}</span>
                    <div>
                        <h4 class="text-base font-semibold text-slate-900">${phase.phase}</h4>
                        <p class="text-xs text-slate-500">Durasi: ${phase.duration}</p>
                    </div>
                </div>
                <p class="mb-4 text-sm text-slate-600">${phase.description}</p>
                <div class="space-y-3">
                    ${phase.skills && phase.skills.length > 0 ? `
                        <div>
                            <p class="mb-2 text-xs font-medium text-slate-700">Skills:</p>
                            <div class="flex flex-wrap gap-2">
                                ${phase.skills.map(s => `<span class="rounded-full bg-indigo-100 px-3 py-1 text-xs text-indigo-700">${s}</span>`).join('')}
                            </div>
                        </div>
                    ` : ''}
                    ${phase.projects && phase.projects.length > 0 ? `
                        <div>
                            <p class="mb-2 text-xs font-medium text-slate-700">Projects:</p>
                            <ul class="list-inside list-disc text-xs text-slate-600 space-y-1">
                                ${phase.projects.map(p => `<li>${p}</li>`).join('')}
                            </ul>
                        </div>
                    ` : ''}
                    ${phase.certifications && phase.certifications.length > 0 ? `
                        <div>
                            <p class="mb-2 text-xs font-medium text-slate-700">Certifications:</p>
                            <ul class="list-inside list-disc text-xs text-slate-600 space-y-1">
                                ${phase.certifications.map(c => `<li>${c}</li>`).join('')}
                            </ul>
                        </div>
                    ` : ''}
                </div>
            </div>
        `).join('');
        
        // Tips
        if (tips.length > 0) {
            html += `
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-6">
                    <h4 class="mb-3 text-sm font-semibold text-emerald-900">💡 Tips untuk Sukses</h4>
                    <ul class="list-inside list-disc space-y-2 text-sm text-emerald-800">
                        ${tips.map(t => `<li>${t}</li>`).join('')}
                    </ul>
                </div>
            `;
        }
        
        html += '</div>';
        results.innerHTML = html;
        
    } catch (error) {
        results.innerHTML = '<div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">Gagal memuat development path. Silakan coba lagi.</div>';
    } finally {
        loading.classList.add('hidden');
    }
}

async function loadCollaborationRecommendations() {
    const loading = document.getElementById('collab-loading');
    const results = document.getElementById('collab-results');
    
    loading.classList.remove('hidden');
    results.innerHTML = '';
    
    try {
        const response = await fetch('/mahasiswa/ai/collaboration');
        const data = await response.json();
        
        if (data.error) {
            results.innerHTML = `<div class="col-span-full rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">${data.error}</div>`;
            return;
        }
        
        if (data.message) {
            results.innerHTML = `<div class="col-span-full rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">${data.message}</div>`;
            return;
        }
        
        const recommendations = data.recommendations || [];
        
        if (recommendations.length === 0) {
            results.innerHTML = '<div class="col-span-full rounded-lg border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Tidak ada rekomendasi saat ini.</div>';
            return;
        }
        
        results.innerHTML = recommendations.map(rec => `
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="text-base font-semibold text-slate-900">${rec.name}</h4>
                    <span class="text-lg font-bold text-indigo-600">${rec.match_score}%</span>
                </div>
                <p class="mb-4 text-sm text-slate-600">${rec.reason}</p>
                ${rec.complementary_skills && rec.complementary_skills.length > 0 ? `
                    <div class="mb-3">
                        <p class="mb-2 text-xs font-medium text-slate-700">Complementary Skills:</p>
                        <div class="flex flex-wrap gap-2">
                            ${rec.complementary_skills.map(s => `<span class="rounded-full bg-emerald-100 px-2 py-1 text-xs text-emerald-700">${s}</span>`).join('')}
                        </div>
                    </div>
                ` : ''}
                ${rec.collaboration_ideas && rec.collaboration_ideas.length > 0 ? `
                    <div>
                        <p class="mb-2 text-xs font-medium text-slate-700">Ide Kolaborasi:</p>
                        <ul class="list-inside list-disc space-y-1 text-xs text-slate-600">
                            ${rec.collaboration_ideas.map(idea => `<li>${idea}</li>`).join('')}
                        </ul>
                    </div>
                ` : ''}
            </div>
        `).join('');
        
    } catch (error) {
        results.innerHTML = '<div class="col-span-full rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">Gagal memuat rekomendasi. Silakan coba lagi.</div>';
    } finally {
        loading.classList.add('hidden');
    }
}
</script>
@endpush
