<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Meta CSRF Token: Digunakan jika ada panggilan AJAX / Fetch API agar request diverifikasi aman oleh Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — CMS Web Builder</title>

    <!-- Google Fonts: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS v4 via Vite --}}
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#0f1014] text-zinc-100 min-h-screen antialiased flex flex-col font-sans">

    {{--
      ==========================================================================
      BACKDROP SIDEBAR KHUSUS MOBILE
      ==========================================================================
      Menutup area konten saat sidebar terbuka di layar HP agar fokus pada navigasi.
    --}}
    <div id="sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-black/75 z-40 hidden lg:hidden"></div>

    {{--
      ==========================================================================
      SIDEBAR ADMIN (NAVIGASI UTAMA)
      ==========================================================================
      Di layar desktop (lg:) tampil statis di sebelah kiri (w-72).
      Di layar mobile, disembunyikan (-translate-x-full) dan dapat dibuka via toggle.
    --}}
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-[#14151a] border-r border-zinc-800/80 flex flex-col justify-between shrink-0 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none">
        <div class="flex flex-col h-full overflow-y-auto">
            <!-- Header Brand & Logo -->
            <div class="h-20 px-6 border-b border-zinc-800/80 flex items-center justify-between shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-white p-1 border border-white/20 flex items-center justify-center shrink-0 shadow-md">
                        <img src="/assets/logo.png" alt="Logo" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold tracking-tight text-white">Web Builder</h1>
                        <span class="block text-[10px] tracking-widest text-teal-400 font-bold uppercase -mt-0.5">Management System</span>
                    </div>
                </a>

                <!-- Tombol Close Sidebar Khusus HP -->
                <button type="button" onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-xl text-zinc-400 bg-zinc-800/60 cursor-pointer" aria-label="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{--
              Navigasi Menu Sidebar
              request()->routeIs('nama.route'): Helper Laravel untuk mengecek rute aktif saat ini
              sehingga menu yang sedang dibuka otomatis mendapatkan styling aktif (highlight teal).
            --}}
            <nav class="p-4 sm:p-5 space-y-2 flex-1">
                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl text-sm font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-teal-500/15 text-teal-400 border border-teal-500/30' : 'text-zinc-400' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Direktori Web (Portofolio Klien) -->
                <a href="{{ Route::has('admin.portfolios.index') ? route('admin.portfolios.index') : '#' }}"
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl text-sm font-bold {{ request()->routeIs('admin.portfolios.*') ? 'bg-teal-500/15 text-teal-400 border border-teal-500/30' : 'text-zinc-400' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span>Direktori Web</span>
                </a>

                <!-- 3. Activity Log (Riwayat Audit Jejak Sistem) -->
                <a href="{{ Route::has('admin.logs.index') ? route('admin.logs.index') : '#' }}"
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl text-sm font-bold {{ request()->routeIs('admin.logs.*') ? 'bg-teal-500/15 text-teal-400 border border-teal-500/30' : 'text-zinc-400' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Activity Log</span>
                </a>

                <!-- 4. Pengaturan Sistem -->
                <a href="{{ Route::has('admin.settings.index') ? route('admin.settings.index') : '#' }}"
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl text-sm font-bold {{ request()->routeIs('admin.settings.*') ? 'bg-teal-500/15 text-teal-400 border border-teal-500/30' : 'text-zinc-400' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Pengaturan</span>
                </a>
            </nav>

            <!-- Profil Admin Bawah & Tombol Logout -->
            <div class="p-4 sm:p-5 border-t border-zinc-800/80 bg-[#101116] shrink-0 space-y-3">
                <div class="p-3.5 rounded-2xl bg-[#18191f] border border-zinc-800 space-y-1">
                    <p class="text-[11px] font-medium text-zinc-400">Logged in as</p>
                    <p class="text-sm font-extrabold text-white truncate">{{ auth()->user()->name ?? 'Hanan Aria Santagama' }}</p>
                    <p class="text-xs font-semibold text-teal-400">Admin</p>
                </div>

                {{--
                  Form Logout:
                  Wajib menggunakan method POST dan menyertakan @csrf untuk mencegah serangan Cross-Site Request Forgery (CSRF).
                  Tautan GET untuk logout sangat rentan di-trigger dari luar (misal via tag <img src="/logout">).
                --}}
                <form action="{{ route('admin.logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar dari sesi admin?');">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-rose-300 bg-rose-950/40 border border-rose-900/60 cursor-pointer">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{--
      ==========================================================================
      AREA KONTEN UTAMA
      ==========================================================================
      Di desktop, padding-left (lg:pl-72) menyesuaikan lebar sidebar kiri (w-72).
      Topbar atas hanya tampil di layar HP/tablet (lg:hidden) untuk tombol menu.
      Di desktop langsung menampilkan konten halaman tanpa header ganda.
    --}}
    <div class="pl-0 lg:pl-72 flex-1 flex flex-col min-h-screen">
        <!-- Topbar Mobile Khusus Layar Kecil (lg:hidden) -->
        <header class="lg:hidden h-16 border-b border-zinc-800/80 bg-[#14151a] px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <!-- Tombol Hamburger Mobile -->
                <button type="button" onclick="toggleAdminSidebar()" class="p-2 rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-300 cursor-pointer" aria-label="Buka Menu Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>

                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white p-0.5 flex items-center justify-center shrink-0">
                        <img src="/assets/logo.png" alt="Logo" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                    </div>
                    <span class="text-sm font-extrabold text-white">Web Builder</span>
                </div>
            </div>

            <div class="flex items-center gap-2 rounded-full border border-teal-500/30 bg-teal-500/10 px-3 py-1">
                <span class="h-2 w-2 rounded-full bg-teal-400"></span>
                <span class="text-xs font-bold text-teal-300">Admin</span>
            </div>
        </header>

        {{-- Wadah Konten Halaman Utama --}}
        <main class="p-4 sm:p-6 lg:p-8 flex-1 max-w-7xl w-full mx-auto">
            @include('components.alert')

            @yield('content')
        </main>

        <!-- Footer Admin -->
        <footer class="px-4 sm:px-8 py-5 border-t border-zinc-800/80 text-center text-xs text-zinc-500">
            &copy; 2026 Hanan Aria Santagama | XII RPL 1
        </footer>
    </div>

    {{--
      ==========================================================================
      JAVASCRIPT LOGIC
      ==========================================================================
    --}}
    <script>
        // Toggle Sidebar Mobile (Buka / Tutup Drawer)
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !backdrop) return;

            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
            }
        }

        // Script Keamanan: Deteksi Back-Forward Cache (bfcache) Browser Setelah Logout
        // Mencegah halaman admin dapat dilihat kembali saat tombol 'Back' browser ditekan setelah sesi logout
        window.addEventListener('pageshow', function (event) {
            var isBackForward = event.persisted ||
                (window.performance && window.performance.getEntriesByType &&
                 window.performance.getEntriesByType('navigation')[0] &&
                 window.performance.getEntriesByType('navigation')[0].type === 'back_forward') ||
                (window.performance && window.performance.navigation &&
                 window.performance.navigation.type === 2);

            if (isBackForward) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
