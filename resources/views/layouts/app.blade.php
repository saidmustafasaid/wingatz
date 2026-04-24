<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WingaTZ') }} - @yield('title', __('ui.dashibodi'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="page-bg text-gray-800 font-sans">

    <!-- Sidebar + Main -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-bg fixed inset-y-0 left-0 z-50 w-64 text-white flex flex-col transition-transform -translate-x-full md:translate-x-0">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b sidebar-border">
                <div class="logo-badge w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-lg">W</div>
                <div>
                    <div class="font-bold text-lg leading-tight text-white">WinGatz</div>
                    <div class="text-purple-300 text-xs">{{ __('ui.usimamizi') }}</div>
                </div>
            </div>

            <!-- User info -->
            <div class="flex items-center gap-3 px-6 py-4 border-b sidebar-border">
                <div class="user-avatar w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? '' }}</div>
                    <div class="text-xs text-purple-300 truncate">{{ auth()->user()->email ?? '' }}</div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <p class="text-purple-400 text-xs uppercase tracking-wider px-3 mb-3 font-semibold">{{ __('ui.dashibodi') }}</p>
                <a href="{{ route('dashboard') }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dashboard') ? 'nav-active text-white' : 'text-purple-200 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('ui.dashibodi') }}
                </a>

                <p class="text-purple-400 text-xs uppercase tracking-wider px-3 pt-3 mb-2 font-semibold">Biashara</p>
                <a href="{{ route('bidhaa.index') }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('bidhaa.*') ? 'nav-active text-white' : 'text-purple-200 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    {{ __('ui.bidhaa') }}
                </a>
                <a href="{{ route('mauzo.index') }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('mauzo.*') ? 'nav-active text-white' : 'text-purple-200 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    {{ __('ui.mauzo') }}
                </a>
                <a href="{{ route('wateja.index') }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('wateja.*') ? 'nav-active text-white' : 'text-purple-200 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ __('ui.wateja') }}
                </a>
                <a href="{{ route('maswali.index') }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('maswali.*') ? 'nav-active text-white' : 'text-purple-200 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    {{ __('ui.maswali') }}
                </a>
                <a href="{{ route('ripoti.index') }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('ripoti.*') ? 'nav-active text-white' : 'text-purple-200 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    {{ __('ui.ripoti') }}
                </a>
            </nav>

            <!-- Language switcher -->
            <div class="px-4 pt-4 border-t sidebar-border">
                <p class="text-purple-400 text-xs uppercase tracking-wider mb-2 font-semibold">{{ __('ui.lugha') }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('lugha.badilisha', 'sw') }}"
                       class="flex-1 text-center px-3 py-1.5 rounded-lg text-sm font-medium transition {{ app()->getLocale() === 'sw' ? 'lang-active' : 'bg-white/10 text-purple-200 hover:bg-white/20 hover:text-white' }}">
                        🇹🇿 Kiswahili
                    </a>
                    <a href="{{ route('lugha.badilisha', 'en') }}"
                       class="flex-1 text-center px-3 py-1.5 rounded-lg text-sm font-medium transition {{ app()->getLocale() === 'en' ? 'lang-active' : 'bg-white/10 text-purple-200 hover:bg-white/20 hover:text-white' }}">
                        🇬🇧 English
                    </a>
                </div>
            </div>

            <!-- Logout -->
            <div class="px-4 py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-purple-300 hover:text-white transition text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        {{ __('ui.toka') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content area -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">

            <!-- Top bar -->
            <header class="header-bar sticky top-0 z-40 bg-white px-4 md:px-6 py-3 flex items-center justify-between shadow-sm">
                <!-- Mobile menu toggle -->
                <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"
                        class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-purple-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <h1 class="text-lg font-semibold text-gray-800 md:hidden">WinGatz</h1>

                <!-- Page title on desktop -->
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-gray-900">@yield('page-title', __('ui.dashibodi'))</h1>
                    <p class="text-xs text-gray-400">{{ now()->format('l, F j, Y') }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Quick add sale button -->
                    <a href="{{ route('mauzo.create') }}"
                       class="btn-primary hidden sm:flex items-center gap-2 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('ui.rekodi_uuzaji') }}
                    </a>

                    <!-- Notification bell -->
                    <div class="relative" id="notif-wrapper">
                        <button id="notif-btn" onclick="toggleNotifications()"
                                class="relative p-2 rounded-xl text-gray-500 hover:bg-purple-50 hover:text-purple-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span id="notif-badge" class="absolute top-1 right-1 w-2 h-2 bg-pink-500 rounded-full hidden"></span>
                        </button>

                        <!-- Dropdown -->
                        <div id="notif-dropdown"
                             class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
                             style="box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100" style="background: linear-gradient(135deg,#7c3aed,#2563eb);">
                                <span class="text-sm font-bold text-white">{{ __('ui.arifa') }}</span>
                                <span id="notif-count" class="text-xs bg-white/20 text-white px-2 py-0.5 rounded-full">0</span>
                            </div>
                            <!-- List -->
                            <div id="notif-list" class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                                <div class="px-4 py-8 text-center text-gray-400 text-sm" id="notif-empty">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    {{ __('ui.hakuna_arifa') }}
                                </div>
                            </div>
                            <!-- Footer -->
                            <a href="{{ route('maswali.index') }}" class="block text-center py-3 text-xs font-semibold text-purple-600 hover:bg-purple-50 border-t border-gray-100 transition">
                                {{ __('ui.ona_maswali_yote') }}
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash messages -->
            <div class="px-4 md:px-6 pt-4">
                @if(session('success'))
                    <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page content -->
            <main class="flex-1 px-4 md:px-6 pb-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
    const notifUrl = "{{ route('notifications.index') }}";
    const iconColors = {
        blue:   { bg: '#eff6ff', icon: '#3b82f6' },
        green:  { bg: '#f0fdf4', icon: '#16a34a' },
        orange: { bg: '#fff7ed', icon: '#ea580c' },
    };
    const svgIcons = {
        chat: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>',
        sale: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
        box:  '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
    };

    function renderNotifications(data) {
        const list  = document.getElementById('notif-list');
        const badge = document.getElementById('notif-badge');
        const count = document.getElementById('notif-count');
        const empty = document.getElementById('notif-empty');

        count.textContent = data.count;
        badge.classList.toggle('hidden', data.count === 0);

        if (!data.notifications.length) { empty.classList.remove('hidden'); return; }
        empty.classList.add('hidden');
        list.innerHTML = '';

        data.notifications.forEach(n => {
            const c = iconColors[n.color] || iconColors.blue;
            const svg = svgIcons[n.icon] || svgIcons.chat;
            const item = document.createElement('a');
            item.href = n.url;
            item.className = 'flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition';
            item.innerHTML = `
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background:${c.bg}">
                    <svg class="w-5 h-5" fill="none" stroke="${c.icon}" viewBox="0 0 24 24">${svg}</svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-800 truncate">${n.title}</p>
                    <p class="text-xs text-gray-500 truncate">${n.body}</p>
                    <p class="text-xs text-gray-400 mt-0.5">${n.time}</p>
                </div>`;
            list.appendChild(item);
        });
    }

    function loadNotifications() {
        fetch(notifUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(renderNotifications)
            .catch(() => {});
    }

    function toggleNotifications() {
        const dd = document.getElementById('notif-dropdown');
        const open = !dd.classList.contains('hidden');
        dd.classList.toggle('hidden', open);
        if (!open) loadNotifications();
    }

    // Close on outside click
    document.addEventListener('click', e => {
        const wrapper = document.getElementById('notif-wrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('notif-dropdown').classList.add('hidden');
        }
    });

    // Load badge count on page load
    loadNotifications();
    </script>
</body>
</html>
