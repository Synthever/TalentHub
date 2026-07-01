<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — TalentHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 hidden w-64 border-r border-slate-200 bg-white lg:block">
            <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-6">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">T</div>
                <span class="text-lg font-bold text-slate-900">TalentHub</span>
            </div>
            <nav class="mt-4 space-y-1 px-3">
                @yield('sidebar')
            </nav>
            <div class="absolute bottom-0 w-full border-t border-slate-200 p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile header --}}
        <header class="fixed inset-x-0 top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:hidden">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-lg font-bold text-slate-900">TalentHub</span>
            </div>
            @if(Auth::user()->profile && Auth::user()->profile->foto)
                <img src="{{ Storage::url(Auth::user()->profile->foto) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover">
            @else
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-medium text-indigo-700">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </header>

        {{-- Mobile sidebar overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>
        <aside id="sidebar-mobile" class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-slate-200 bg-white lg:hidden">
            <div class="flex h-16 items-center justify-between border-b border-slate-200 px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">T</div>
                    <span class="text-lg font-bold text-slate-900">TalentHub</span>
                </div>
                <button id="sidebar-close" class="rounded-lg p-1 text-slate-400 hover:text-slate-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="mt-4 space-y-1 px-3">
                @yield('sidebar')
            </nav>
            <div class="absolute bottom-0 w-full border-t border-slate-200 p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition-colors hover:bg-slate-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1 pt-16 lg:ml-64 lg:pt-0">
            {{-- Top bar (desktop) --}}
            <header class="hidden h-16 items-center justify-between border-b border-slate-200 bg-white px-8 lg:flex">
                <h1 class="text-lg font-semibold text-slate-900">@yield('page-title')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->profile && Auth::user()->profile->foto)
                        <img src="{{ Storage::url(Auth::user()->profile->foto) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover">
                    @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-medium text-indigo-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </header>

            <div class="p-4 lg:p-8">
                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 flex items-center gap-3 rounded-lg border border-rose-200 bg-rose-50 p-4">
                        <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        const toggle = document.getElementById('sidebar-toggle');
        const close = document.getElementById('sidebar-close');
        const overlay = document.getElementById('sidebar-overlay');
        const mobileSidebar = document.getElementById('sidebar-mobile');

        function openSidebar() {
            mobileSidebar?.classList.remove('hidden');
            overlay?.classList.remove('hidden');
        }
        function closeSidebar() {
            mobileSidebar?.classList.add('hidden');
            overlay?.classList.add('hidden');
        }

        toggle?.addEventListener('click', openSidebar);
        close?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
    </script>
    @stack('scripts')
</body>
</html>
