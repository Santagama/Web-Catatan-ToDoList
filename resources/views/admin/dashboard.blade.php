@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
{{--
  ==============================================================================
  DASHBOARD ADMIN
  ==============================================================================
  Menampilkan ringkasan metrik statistik portofolio, log aktivitas terbaru,
  serta tombol aksi cepat ke modul-modul sistem.
--}}
<div class="space-y-6 sm:space-y-8">

    <!-- ================= WELCOME BANNER ================= -->
    <div class="rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-8 relative overflow-hidden shadow-sm">
        <div class="relative z-10 space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/30 text-xs font-bold text-teal-400">
                <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                <span>Panel Admin</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Hanan Aria Santagama' }}
            </h1>
            <p class="text-sm sm:text-base text-zinc-300 max-w-2xl font-normal leading-relaxed">
                Kelola landing page klien UMKM dengan praktis, pantau status publikasi, dan audit perubahan sistem secara real-time.
            </p>
        </div>
    </div>

    <!-- ================= 4 KARTU METRIK STATISTIK ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">
        <!-- 1. Total Web -->
        <div class="p-5 sm:p-6 rounded-3xl bg-[#18191f] border border-zinc-800 shadow-sm flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-bold text-zinc-300">Total Portofolio</span>
                <div class="w-11 h-11 rounded-2xl bg-teal-500/10 border border-teal-500/20 text-teal-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $totalPortfolios }}</p>
                <p class="text-xs text-zinc-400 mt-1 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    <span>Total website terdaftar</span>
                </p>
            </div>
        </div>

        <!-- 2. Web Aktif (Publish) -->
        <div class="p-5 sm:p-6 rounded-3xl bg-[#18191f] border border-zinc-800 shadow-sm flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-bold text-zinc-300">Web Aktif</span>
                <div class="w-11 h-11 rounded-2xl bg-teal-500/15 border border-teal-500/30 text-teal-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl sm:text-4xl font-extrabold text-teal-400 tracking-tight">{{ $publishedPortfolios }}</p>
                <p class="text-xs text-zinc-400 mt-1 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    <span>Siap diakses publik</span>
                </p>
            </div>
        </div>

        <!-- 3. Draft -->
        <div class="p-5 sm:p-6 rounded-3xl bg-[#18191f] border border-zinc-800 shadow-sm flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-bold text-zinc-300">Draft</span>
                <div class="w-11 h-11 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl sm:text-4xl font-extrabold text-amber-400 tracking-tight">{{ $draftPortfolios }}</p>
                <p class="text-xs text-zinc-400 mt-1 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    <span>Menunggu publikasi</span>
                </p>
            </div>
        </div>

        <!-- 4. Template Terpakai -->
        <div class="p-5 sm:p-6 rounded-3xl bg-[#18191f] border border-zinc-800 shadow-sm flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-bold text-zinc-300">Template Terpakai</span>
                <div class="w-11 h-11 rounded-2xl bg-zinc-800 border border-zinc-700 text-zinc-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $usedTemplates ?? 0 }}</p>
                <p class="text-xs text-zinc-400 mt-1 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    <span>Dari 5 varian template aktif</span>
                </p>
            </div>
        </div>
    </div>

    <!-- ================= 2 KOLOM: AKTIVITAS TERBARU & AKSI CEPAT ================= -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

        <!-- Kolom Kiri: Aktivitas Terbaru (2 Kolom di Desktop) -->
        <div class="xl:col-span-2 rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-7 space-y-5">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-white">Aktivitas Terakhir</h3>
                </div>
                <a href="{{ route('admin.logs.index') }}" class="text-xs sm:text-sm font-bold text-teal-400">
                    Lihat Semua &rarr;
                </a>
            </div>

            {{--
              Daftar Aktivitas Menggunakan @forelse
              @forelse: Struktur pengulangan cerdas Blade yang otomatis mengeksekusi blok @empty
              jika collection $recentActivities kosong, menghindari error 'Undefined array key' atau 'Attempt to read property on null'.
            --}}
            <div class="space-y-3">
                @forelse ($recentActivities as $log)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl bg-[#101116] border border-zinc-800/80">
                        <div class="flex items-start sm:items-center gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <div class="space-y-0.5">
                                <p class="text-sm font-semibold text-white leading-snug">{{ $log->description }}</p>
                                {{-- translatedFormat: Format tanggal lokal Indonesia memanfaatkan Carbon Laravel --}}
                                <p class="text-xs text-zinc-400">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Badge Action Menggunakan PHP 8 Match Expression -->
                        <div class="shrink-0 self-start sm:self-center">
                            @php
                                $badgeStyle = match(true) {
                                    str_contains($log->action, 'TAMBAH') => 'bg-teal-500/15 text-teal-300 border-teal-500/30',
                                    str_contains($log->action, 'EDIT') => 'bg-cyan-500/15 text-cyan-300 border-cyan-500/30',
                                    str_contains($log->action, 'HAPUS') => 'bg-rose-500/15 text-rose-300 border-rose-500/30',
                                    default => 'bg-zinc-800 text-zinc-300 border-zinc-700',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider {{ $badgeStyle }}">
                                {{ $log->action }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-zinc-500 text-sm">
                        Belum ada aktivitas yang tercatat dalam sistem.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Aksi Cepat (1 Kolom di Desktop) -->
        <div class="rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-7 space-y-5">
            <div class="flex items-center gap-2 pb-4 border-b border-zinc-800">
                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                <h3 class="text-base sm:text-lg font-bold text-white">Aksi Cepat CMS</h3>
            </div>

            <div class="space-y-3">
                <!-- Tombol Buat Web Baru Utama -->
                <a href="{{ route('admin.portfolios.create') }}"
                   class="w-full py-4 px-5 rounded-2xl bg-teal-600 text-white font-extrabold text-sm sm:text-base flex items-center justify-center gap-2 shadow-lg shadow-teal-950/40 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>Buat Web Baru</span>
                </a>

                <!-- Tombol Navigasi Cepat 1: Direktori -->
                <a href="{{ route('admin.portfolios.index') }}"
                   class="w-full p-4 rounded-2xl bg-[#101116] border border-zinc-800 text-zinc-200 flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-zinc-800 text-zinc-300 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Direktori Web Klien</p>
                        <p class="text-xs text-zinc-400">Daftar semua website UMKM</p>
                    </div>
                </a>

                <!-- Tombol Navigasi Cepat 2: Activity Log -->
                <a href="{{ route('admin.logs.index') }}"
                   class="w-full p-4 rounded-2xl bg-[#101116] border border-zinc-800 text-zinc-200 flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-zinc-800 text-zinc-300 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Activity Log</p>
                        <p class="text-xs text-zinc-400">Audit jejak aktivitas sistem</p>
                    </div>
                </a>

                <!-- Tombol Navigasi Cepat 3: Pengaturan -->
                <a href="{{ route('admin.settings.index') }}"
                   class="w-full p-4 rounded-2xl bg-[#101116] border border-zinc-800 text-zinc-200 flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-zinc-800 text-zinc-300 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Pengaturan</p>
                        <p class="text-xs text-zinc-400">Profil &amp; kredensial akun</p>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
