{{--
  ==============================================================================
  HALAMAN UTAMA PUBLIK (LANDING PAGE CMS WEB BUILDER)
  ==============================================================================
  - $waUrl: Dibuat menggunakan rawurlencode() agar karakter spasi dan baris baru
    terkonversi aman ke format URL (%20, %0A) tanpa memutus tautan WhatsApp.
  - Tampilan menggunakan Tailwind CSS statis tanpa transisi/animasi,
    menghasilkan kode yang sangat bersih, mudah dipelajari, dan performa tinggi.
--}}
@extends('layouts.app')

@php
    $waUrl = 'https://wa.me/62895324392999?text=' . rawurlencode('Halo Developer CMSWebBuilder Hanan Aria Santagama, saya: [PERKENALKAN DIRI]. Saya memerlukan informasi lebih lanjut dan tertarik untuk memesan pembuatan website portofolio profesional di CMS Web Builder. Mohon bantuan dan arahannya. Terima kasih.');
@endphp

@section('title', 'CMS Web Builder - Jasa Pembuatan Website Portofolio Profesional')
@section('body_class', 'bg-white text-slate-900 min-h-screen antialiased flex flex-col justify-between overflow-x-hidden')

@section('content')
<div class="relative bg-white text-slate-900 min-h-screen flex flex-col justify-between">

    <!-- ================= NAVBAR ATAS (CLEAN WHITE & TEAL ACCENT) ================= -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand & Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white p-1 border border-slate-200 shadow-xs flex items-center justify-center shrink-0">
                    <img src="/assets/logo.png" alt="CMS Web Builder Logo" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                </div>
                <div>
                    <span class="text-base sm:text-lg font-extrabold tracking-tight text-slate-900">CMS Web Builder</span>
                    <span class="block text-[10px] tracking-widest text-teal-600 font-bold uppercase -mt-0.5">Management Platform</span>
                </div>
            </a>

            <!-- Navigasi Menu Desktop (Pill Buttons Rapi — Tidak Dempetan) -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5 text-xs xl:text-sm font-semibold text-slate-600">
                <a href="#kategori" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">Pilihan Desain</a>
                <a href="#fitur" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">Fitur Unggulan</a>
                <a href="#cara-kerja" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">Cara Kerja</a>
                <a href="#paket" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">Paket Layanan</a>
                <a href="#faq" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">FAQ</a>
                <a href="#pengembang" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">Developer</a>
                <a href="#lokasi" class="px-3 py-2 rounded-xl text-slate-600 whitespace-nowrap">Lokasi</a>
            </nav>

            <!-- Aksi Tombol Desktop -->
            <div class="hidden sm:flex items-center shrink-0">
                <a href="{{ route('admin.login') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-600 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Login Admin</span>
                </a>
            </div>

            <!-- Tombol Mobile Toggle -->
            <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    class="lg:hidden p-2.5 rounded-xl text-slate-600 border border-slate-200 cursor-pointer"
                    aria-label="Toggle Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Dropdown Menu Mobile -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-6 py-5 space-y-4 shadow-xl">
            <nav class="flex flex-col space-y-1 text-sm font-bold text-slate-800">
                <a href="#kategori" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">Pilihan Desain</a>
                <a href="#fitur" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">Fitur Unggulan</a>
                <a href="#cara-kerja" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">Cara Kerja</a>
                <a href="#paket" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">Paket Layanan</a>
                <a href="#faq" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">FAQ</a>
                <a href="#pengembang" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">Developer</a>
                <a href="#lokasi" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="px-3.5 py-2.5 rounded-xl">Lokasi Kantor</a>
            </nav>
            <div class="pt-4 border-t border-slate-200">
                <a href="{{ route('admin.login') }}" class="w-full text-center py-3 rounded-xl text-sm font-bold text-white bg-teal-600 shadow-xs block">
                    Login Admin
                </a>
            </div>
        </div>
    </header>

    <main class="space-y-24 sm:space-y-36 py-12 sm:py-20">

        <!-- ================= HERO SECTION (CLEAN, MODERN & ELEGAN) ================= -->
        <section class="max-w-5xl mx-auto px-5 sm:px-8 text-center space-y-6 sm:space-y-8">

            <!-- Judul Utama Bold & Berkarakter -->
            <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15] max-w-4xl mx-auto">
                Website Portofolio UMKM,<br class="hidden sm:inline" />
                <span class="text-teal-600">24 Jam Langsung Jadi.</span>
            </h1>

            <!-- Subtitle Ringkas & Padat -->
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-normal leading-relaxed">
                Kirim foto dan info produk via WhatsApp. Kami buatkan website instan yang estetik, cepat, dan siap dipakai untuk memperluas jangkauan bisnis Anda.
            </p>

            <!-- Dual CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-1">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-xl bg-teal-600 text-white text-sm sm:text-base font-extrabold shadow-sm">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Pesan Website via WhatsApp</span>
                </a>
                <a href="#kategori"
                   class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-white text-slate-800 text-sm sm:text-base font-bold border border-slate-300 shadow-xs flex items-center justify-center gap-2">
                    <span>Lihat 5 Pilihan Desain</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/></svg>
                </a>
            </div>

        </section>

        <!-- ================= SECTION 1: PILIHAN DESAIN & TEMPLATE (INTERACTIVE CATALOG LIST) ================= -->
        <section id="kategori" class="max-w-6xl mx-auto px-5 sm:px-8">
            <div class="text-center space-y-3 mb-10 sm:mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-teal-600">KATALOG TEMPLATE RESMI</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Pilihan Konsep Desain</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-medium">Setiap jenis usaha memiliki karakter visual yang unik. Pilih konsep desain yang paling mewakili identitas brand Anda.</p>
            </div>

            <div class="space-y-4">
                <!-- 1. Minuman -->
                <div class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <span class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-mono text-sm font-bold flex items-center justify-center shrink-0">01</span>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="px-2.5 py-0.5 rounded-md bg-amber-50 border border-amber-200 text-amber-900 text-[11px] font-bold tracking-wide uppercase">Template Minuman</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Kedai Kopi &amp; Minuman Segar</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl font-normal">
                                Cocok untuk coffee shop, boba drink, cafe, kedai jus, dan aneka minuman kekinian. Menonjolkan foto produk yang segar serta tombol order cepat.
                            </p>
                        </div>
                    </div>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-xs shrink-0 self-start md:self-center">
                        <span>Pesan Desain Ini</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- 2. Makanan -->
                <div class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <span class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-mono text-sm font-bold flex items-center justify-center shrink-0">02</span>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="px-2.5 py-0.5 rounded-md bg-orange-50 border border-orange-200 text-orange-900 text-[11px] font-bold tracking-wide uppercase">Template Makanan</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Restoran &amp; Kuliner Makanan</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl font-normal">
                                Cocok untuk resto keluarga, warung makan, kuliner bakso, katering pesta, dan oleh-oleh daerah. Lengkap dengan daftar harga menu dan jam buka toko.
                            </p>
                        </div>
                    </div>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-xs shrink-0 self-start md:self-center">
                        <span>Pesan Desain Ini</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- 3. Jasa -->
                <div class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <span class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-mono text-sm font-bold flex items-center justify-center shrink-0">03</span>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="px-2.5 py-0.5 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-900 text-[11px] font-bold tracking-wide uppercase">Template Jasa</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Studio &amp; Layanan Servis</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl font-normal">
                                Cocok untuk fotografer, bengkel reparasi, salon/barbershop, konsultan, dan penyedia servis teknis. Menyajikan daftar paket pricelist transparan.
                            </p>
                        </div>
                    </div>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-xs shrink-0 self-start md:self-center">
                        <span>Pesan Desain Ini</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- 4. Tokoh -->
                <div class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <span class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-mono text-sm font-bold flex items-center justify-center shrink-0">04</span>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="px-2.5 py-0.5 rounded-md bg-cyan-50 border border-cyan-200 text-cyan-900 text-[11px] font-bold tracking-wide uppercase">Template Tokoh</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Personal Branding &amp; Publik</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl font-normal">
                                Cocok untuk figur publik, politisi, pembicara, akademisi, dan profesional independen. Menyajikan profil biografi, visi misi, dan rekam jejak berwibawa.
                            </p>
                        </div>
                    </div>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-xs shrink-0 self-start md:self-center">
                        <span>Pesan Desain Ini</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- 5. Barang -->
                <div class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <span class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-mono text-sm font-bold flex items-center justify-center shrink-0">05</span>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="px-2.5 py-0.5 rounded-md bg-blue-50 border border-blue-200 text-blue-900 text-[11px] font-bold tracking-wide uppercase">Template Barang</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Retail, Fashion &amp; Produk Fisik</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl font-normal">
                                Cocok untuk toko pakaian/distro, elektronik, retail, dan toko kelontong UMKM. Menampilkan etalase katalog produk, harga resmi, dan order via WhatsApp.
                            </p>
                        </div>
                    </div>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-xs shrink-0 self-start md:self-center">
                        <span>Pesan Desain Ini</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- 6. Custom -->
                <div class="group p-5 sm:p-6 rounded-2xl bg-white border-2 border-dashed border-slate-300 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-start sm:items-center gap-4">
                        <span class="w-11 h-11 rounded-xl bg-teal-50 border border-teal-200 text-teal-700 font-mono text-sm font-bold flex items-center justify-center shrink-0">★</span>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="px-2.5 py-0.5 rounded-md bg-teal-100 text-teal-900 text-[11px] font-bold tracking-wide uppercase">Kebutuhan Custom</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Ingin Desain Sesuai Request?</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl font-normal">
                                Punya bisnis yang butuh tata letak khusus? Diskusikan dengan kami. Tim siap menyesuaikan struktur katalog dan warna agar pas dengan brand Anda.
                            </p>
                        </div>
                    </div>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-teal-600 text-white text-xs font-bold shadow-xs shrink-0 self-start md:self-center">
                        <span>Konsultasi Khusus via WA</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ================= SECTION 2: FITUR UNGGULAN (DESAIN CARD MENARIK) ================= -->
        <section id="fitur" class="max-w-7xl mx-auto px-5 sm:px-8">
            <div class="text-center space-y-3 mb-12 sm:mb-16">
                <span class="text-xs font-extrabold uppercase tracking-widest text-teal-600">KEUNGGULAN SISTEM</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Fitur Website Lengkap</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-medium">Dirancang dari nol dengan standar rekayasa modern untuk memaksimalkan kepuasan calon pembeli Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Card 1 -->
                <div class="group relative rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                    <div class="absolute inset-x-8 top-0 h-1 bg-transparent rounded-b-full"></div>
                    <div class="space-y-4">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-600">Identitas Brand</span>
                            <h3 class="text-xl font-extrabold text-slate-900 mt-1">Alamat Link / Slug Kustom</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-normal">
                            Dapatkan alamat URL resmi yang rapi seperti <span class="font-semibold text-slate-800">webmu.id/nama-usaha</span> yang siap dipajang di bio Instagram, TikTok, WhatsApp, dan kartu nama usaha Anda.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Meningkatkan kepercayaan pembeli</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group relative rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                    <div class="absolute inset-x-8 top-0 h-1 bg-transparent rounded-b-full"></div>
                    <div class="space-y-4">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-600">Presentasi Produk</span>
                            <h3 class="text-xl font-extrabold text-slate-900 mt-1">Katalog Produk &amp; Menu Dinamis</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-normal">
                            Tampilkan foto produk berkualitas tinggi, deskripsi keunggulan, varian menu, dan label harga transparan secara rapi, informatif, dan menggugah selera pelanggan.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Update menu kapan saja via Admin</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group relative rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                    <div class="absolute inset-x-8 top-0 h-1 bg-transparent rounded-b-full"></div>
                    <div class="space-y-4">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-600">Konversi Penjualan</span>
                            <h3 class="text-xl font-extrabold text-slate-900 mt-1">Direct WhatsApp Order</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-normal">
                            Ketika pembeli tertarik pada satu produk, cukup satu klik tombol pesan, WhatsApp otomatis terbuka dengan pesan pembuka nama produk yang dipilih. Cepat tanpa ribet form panjang.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Menghilangkan friksi checkout</span>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="group relative rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                    <div class="absolute inset-x-8 top-0 h-1 bg-transparent rounded-b-full"></div>
                    <div class="space-y-4">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-600">Navigasi Pelanggan</span>
                            <h3 class="text-xl font-extrabold text-slate-900 mt-1">Sematan Peta Google Maps</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-normal">
                            Memudahkan konsumen menemukan lokasi toko offline, rute petunjuk arah langsung, dan meningkatkan reputasi lokal bisnis Anda dengan integrasi peta interaktif.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Satu klik buka rute di Google Maps</span>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="group relative rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                    <div class="absolute inset-x-8 top-0 h-1 bg-transparent rounded-b-full"></div>
                    <div class="space-y-4">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-600">Mobile-First</span>
                            <h3 class="text-xl font-extrabold text-slate-900 mt-1">100% Responsif di Layar HP</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-normal">
                            Dibuat dengan arsitektur mobile-first. Tampilan halaman akan secara otomatis beradaptasi mulus di Android maupun iPhone tanpa patah atau acak-acakan.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Diuji presisi di beragam resolusi</span>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="group relative rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                    <div class="absolute inset-x-8 top-0 h-1 bg-transparent rounded-b-full"></div>
                    <div class="space-y-4">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-600">Kecepatan Tinggi</span>
                            <h3 class="text-xl font-extrabold text-slate-900 mt-1">Performa Cepat Tanpa Beban</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed font-normal">
                            Bebas dari plugin lambat. Website dibuka instan dalam hitungan milidetik sehingga calon pembeli tidak kabur saat membuka tautan promosi Anda.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Skor optimasi PageSpeed tinggi</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SECTION 3: 3 LANGKAH TERIMA BERES (CONNECTED PROCESS FLOW) ================= -->
        <section id="cara-kerja" class="max-w-6xl mx-auto px-5 sm:px-8">
            <div class="text-center space-y-3 mb-14 sm:mb-20">
                <span class="text-xs font-extrabold text-teal-600 tracking-widest uppercase">PROSES PRAKTIS &amp; TRANSPARAN</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">3 Langkah Terima Beres</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-xl mx-auto font-medium">Anda tidak perlu paham teknis koding sama sekali. Kami urus semua dari desain hingga online.</p>
            </div>

            <!-- Connected Flow Container -->
            <div class="relative">
                <!-- Track Line Horizontal Desktop -->
                <div class="hidden md:block absolute top-12 left-24 right-24 h-0.5 bg-slate-200 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-12 relative z-10">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center text-center space-y-4 group">
                        <div class="w-24 h-24 rounded-3xl bg-white border-2 border-slate-200 shadow-sm flex items-center justify-center relative">
                            <span class="text-3xl font-extrabold text-slate-900">01</span>
                            <span class="absolute -bottom-2.5 px-3 py-0.5 rounded-full bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider">Materi</span>
                        </div>
                        <div class="space-y-2 pt-2">
                            <h3 class="text-xl font-extrabold text-slate-900">Kirim Materi via WhatsApp</h3>
                            <p class="text-sm text-slate-600 leading-relaxed font-normal max-w-xs mx-auto">
                                Cukup kirimkan nama bisnis, foto produk, daftar harga, dan info kontak Anda ke WhatsApp kami.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center text-center space-y-4 group">
                        <div class="w-24 h-24 rounded-3xl bg-white border-2 border-teal-500 shadow-md shadow-teal-500/10 flex items-center justify-center relative">
                            <span class="text-3xl font-extrabold text-teal-600">02</span>
                            <span class="absolute -bottom-2.5 px-3 py-0.5 rounded-full bg-teal-600 text-white text-[10px] font-bold uppercase tracking-wider">Produksi</span>
                        </div>
                        <div class="space-y-2 pt-2">
                            <h3 class="text-xl font-extrabold text-slate-900">Proses Pengerjaan Cepat</h3>
                            <p class="text-sm text-slate-600 leading-relaxed font-normal max-w-xs mx-auto">
                                Tim kami merancang dan menata website Anda, cuma 24 jam langsung beres siap online.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center text-center space-y-4 group">
                        <div class="w-24 h-24 rounded-3xl bg-white border-2 border-slate-200 shadow-sm flex items-center justify-center relative">
                            <span class="text-3xl font-extrabold text-slate-900">03</span>
                            <span class="absolute -bottom-2.5 px-3 py-0.5 rounded-full bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider">Aktif</span>
                        </div>
                        <div class="space-y-2 pt-2">
                            <h3 class="text-xl font-extrabold text-slate-900">Website Resmi Siap Pakai</h3>
                            <p class="text-sm text-slate-600 leading-relaxed font-normal max-w-xs mx-auto">
                                Website aktif dan siap disebar di media sosial untuk langsung menerima pesanan dari konsumen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SECTION 4: PAKET LAYANAN (HARGA TIDAK AKAN TURUN BARIS) ================= -->
        <section id="paket" class="max-w-6xl mx-auto px-5 sm:px-8">
            <div class="text-center space-y-3 mb-14 sm:mb-18">
                <span class="text-xs font-extrabold text-teal-600 tracking-widest uppercase">INVESTASI BERSAHABAT</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Pilihan Paket Layanan</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-medium">Semua paket mendapatkan fitur website lengkap yang sama. Perbedaan hanya pada durasi aktif dan benefit layanan operasional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Paket Starter -->
                <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-md flex flex-col justify-between space-y-8">
                    <div class="space-y-5">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Paket Starter</span>

                        <!-- Harga: whitespace-nowrap menjamin Rp dan Nominal selalu bersatu di HP & Desktop -->
                        <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">Rp 75.000</span>
                            <span class="text-xs sm:text-sm text-slate-500 font-semibold whitespace-nowrap">/ 3 Bulan</span>
                        </div>

                        <p class="text-sm text-slate-600 font-medium">Pilihan ekonomis untuk pelaku usaha yang ingin mulai membangun kehadiran digital resmi.</p>

                        <div class="pt-6 border-t border-slate-100 space-y-3 text-sm text-slate-700 font-medium">
                            <p class="font-bold text-slate-900 text-xs uppercase tracking-wider pb-1">Fitur Website Lengkap:</p>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Bebas Pilih dari 5 Template Desain</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Katalog Produk &amp; Pricelist Dinamis</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Tombol Direct Order via WhatsApp &amp; Instagram</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Integrasi Lokasi Peta Google Maps</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Dukungan SEO 301 Redirect saat Ganti Link/Slug</span>
                            </li>

                            <p class="font-bold text-slate-900 text-xs uppercase tracking-wider pt-3 pb-1 border-t border-slate-100">Benefit Layanan Operasional:</p>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Masa Aktif Hosting &amp; Sistem 90 Hari</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Gratis Update Menu/Data 1x per Bulan</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Standard Support via WhatsApp</span>
                            </li>
                        </div>
                    </div>

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="w-full py-3.5 rounded-xl bg-slate-900 text-white text-sm font-bold text-center shadow-xs block">
                        Pesan Paket 3 Bulan
                    </a>
                </div>

                <!-- Paket Pro Bisnis (Highlighted) -->
                <div class="p-8 sm:p-10 rounded-3xl bg-white border-2 border-teal-600 shadow-md flex flex-col justify-between space-y-8 relative">
                    <span class="absolute -top-3.5 right-8 px-3.5 py-1 rounded-full bg-teal-600 text-white text-xs font-bold uppercase tracking-wider shadow-xs">
                        PALING HEMAT (33%)
                    </span>

                    <div class="space-y-5">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-teal-600">Paket Pro Bisnis</span>

                        <!-- Harga: whitespace-nowrap menjamin Rp dan 200.000 tidak akan pernah terpisah -->
                        <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">Rp 200.000</span>
                            <span class="text-xs sm:text-sm text-slate-500 font-semibold whitespace-nowrap">/ 1 Tahun Penuh</span>
                        </div>

                        <p class="text-sm text-slate-600 font-medium">Solusi menyeluruh selama 365 hari penuh tanpa khawatir website terhenti di tengah jalan.</p>

                        <div class="pt-6 border-t border-slate-100 space-y-3 text-sm text-slate-700 font-medium">
                            <p class="font-bold text-slate-900 text-xs uppercase tracking-wider pb-1">Fitur Website Lengkap:</p>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Bebas Pilih dari 5 Template Desain</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Katalog Produk &amp; Pricelist Dinamis</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Tombol Direct Order via WhatsApp &amp; Instagram</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Integrasi Lokasi Peta Google Maps</span>
                            </li>
                            <li class="flex items-center gap-3 list-none">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Dukungan SEO 301 Redirect saat Ganti Link/Slug</span>
                            </li>

                            <p class="font-bold text-teal-700 text-xs uppercase tracking-wider pt-3 pb-1 border-t border-slate-100">Benefit Layanan Ekstra (Prioritas):</p>
                            <li class="flex items-center gap-3 list-none font-bold text-slate-900">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Masa Aktif 365 Hari Penuh (1 Tahun)</span>
                            </li>
                            <li class="flex items-center gap-3 list-none font-bold text-slate-900">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Gratis Update Menu &amp; Foto hingga 3x/Bulan</span>
                            </li>
                            <li class="flex items-center gap-3 list-none font-bold text-slate-900">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                <span>Prioritas Fast-Response WhatsApp Support (Chat Diprioritaskan)</span>
                            </li>
                        </div>
                    </div>

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="w-full py-3.5 rounded-xl bg-teal-600 text-white text-sm font-bold text-center shadow-xs block">
                        Pesan Paket 1 Tahun
                    </a>
                </div>
            </div>
        </section>

        <!-- ================= SECTION: FAQ (PERTANYAAN UMUM CALON KLIEN) ================= -->
        <section id="faq" class="max-w-4xl mx-auto px-5 sm:px-8">
            <div class="text-center space-y-3 mb-10 sm:mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-teal-600">KONSULTASI &amp; JAWABAN</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-sm sm:text-base text-slate-600 max-w-xl mx-auto font-medium">Semua informasi penting seputar cara pemesanan, teknis, dan pengelolaan website bisnis Anda.</p>
            </div>

            <div class="space-y-3.5">
                <!-- FAQ 1 -->
                <details class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah saya harus paham koding atau komputer untuk memesan?</span>
                        <span class="w-7 h-7 rounded-lg bg-slate-100 group-open:bg-teal-600 group-open:text-white text-slate-600 flex items-center justify-center shrink-0 text-sm">
                            <svg class="w-4 h-4 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-2 border-t border-slate-100">
                        Sama sekali tidak perlu! Anda cukup mengirimkan nama usaha, deskripsi singkat, foto produk, dan daftar harga ke WhatsApp kami. Tim kami yang akan merancang, mengoptimasi, dan menerbitkan websitenya hingga siap pakai.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-slate-900 text-sm sm:text-base">
                        <span>Berapa lama proses pengerjaan website sampai aktif?</span>
                        <span class="w-7 h-7 rounded-lg bg-slate-100 group-open:bg-teal-600 group-open:text-white text-slate-600 flex items-center justify-center shrink-0 text-sm">
                            <svg class="w-4 h-4 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-2 border-t border-slate-100">
                        Pengerjaan sangat cepat, cuma dalam 24 jam website Anda langsung beres dan aktif siap pakai setelah seluruh materi dikirimkan melalui WhatsApp.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah website lancar dan rapi dibuka di smartphone?</span>
                        <span class="w-7 h-7 rounded-lg bg-slate-100 group-open:bg-teal-600 group-open:text-white text-slate-600 flex items-center justify-center shrink-0 text-sm">
                            <svg class="w-4 h-4 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-2 border-t border-slate-100">
                        Tentu saja. Semua template kami dibangun dengan standar <em>mobile-first</em>. Tampilan website akan menyesuaikan layar HP Android maupun iPhone dengan mulus, ringan, dan cepat dimuat tanpa patah.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-slate-900 text-sm sm:text-base">
                        <span>Bagaimana jika nanti saya ingin menambah menu atau mengganti harga?</span>
                        <span class="w-7 h-7 rounded-lg bg-slate-100 group-open:bg-teal-600 group-open:text-white text-slate-600 flex items-center justify-center shrink-0 text-sm">
                            <svg class="w-4 h-4 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-2 border-t border-slate-100">
                        Anda memiliki akses langsung ke Panel Admin CMS Web Builder untuk memperbarui menu produk secara mandiri. Selain itu, Anda juga dapat meminta bantuan update menu berkala melalui customer support WhatsApp kami sesuai paket layanan Anda.
                    </p>
                </details>

                <!-- FAQ 5 -->
                <details class="group p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah bisa berkonsultasi terlebih dahulu sebelum memesan?</span>
                        <span class="w-7 h-7 rounded-lg bg-slate-100 group-open:bg-teal-600 group-open:text-white text-slate-600 flex items-center justify-center shrink-0 text-sm">
                            <svg class="w-4 h-4 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-2 border-t border-slate-100">
                        Bisa banget! Konsultasi via WhatsApp adalah 100% gratis. Diskusikan jenis usaha dan kebutuhan katalog Anda bersama Web Developer kami agar mendapatkan pilihan template yang paling tepat.
                    </p>
                </details>
            </div>
        </section>

        <!-- ================= SECTION 5: PROFIL DEVELOPER ================= -->
        <section id="pengembang" class="max-w-5xl mx-auto px-5 sm:px-8">
            <div class="rounded-3xl bg-slate-50 border border-slate-200/90 p-8 sm:p-12 text-slate-900 shadow-xs relative">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 sm:gap-12 relative z-10">
                    <!-- Foto Profil Hanan (Frame Bersih) -->
                    <div class="shrink-0 text-center">
                        <div class="w-40 h-52 sm:w-44 sm:h-56 rounded-2xl overflow-hidden border border-slate-300 bg-white shadow-xs relative group">
                            <img src="/assets/developer/foto-hanan.jpg" alt="Hanan Aria Santagama" class="w-full h-full object-cover" onerror="this.src='/assets/developer/foto-hanan.JPG'; this.onerror=function(){this.style.display='none'};" />
                        </div>
                    </div>

                    <!-- Informasi Identitas & Portofolio Rekayasa -->
                    <div class="space-y-5 text-center lg:text-left flex-1">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-teal-600 block mb-1">WEB DEVELOPER</span>
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Hanan Aria Santagama</h2>
                            <div class="mt-1 space-y-0.5">
                                <p class="text-sm sm:text-base text-slate-800 font-semibold">Rekayasa Perangkat Lunak (XII RPL 1)</p>
                                <p class="text-xs sm:text-sm text-slate-500 font-medium">SMK Negeri 1 Majalengka</p>
                            </div>
                        </div>

                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal italic">
                            &ldquo;Setiap baris Code adalah sebuah puisi indah yang ditulis dengan Logika.&rdquo;
                        </p>

                        <!-- Tanda Tangan Digital & Tombol Kontak -->
                        <div class="pt-5 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-600 text-white text-xs font-bold shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    <span>Chat WhatsApp</span>
                                </a>
                                <a href="https://instagram.com/santagamax" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-slate-700 text-xs font-bold border border-slate-200 shadow-xs">
                                    <svg class="w-4 h-4 text-pink-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.13-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span>@santagamax</span>
                                </a>
                            </div>

                            <!-- Tanda Tangan Digital (Kontras Tajam di Background Bersih) -->
                            <div class="flex flex-col items-center sm:items-end justify-center">
                                <span class="text-xs text-slate-500 font-semibold mb-1">Tanda Tangan Digital</span>
                                <div class="h-16 w-48 sm:h-20 sm:w-56 flex items-center justify-center sm:justify-end">
                                    <img src="/assets/developer/signature.png" alt="Tanda Tangan Hanan Aria Santagama" class="h-full w-auto max-w-full object-contain" onerror="this.style.display='none'" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SECTION: LOKASI OPERASIONAL & KANTOR (GOOGLE MAPS) ================= -->
        <section id="lokasi" class="max-w-5xl mx-auto px-5 sm:px-8">
            <div class="rounded-3xl bg-slate-50 border border-slate-200/90 p-6 sm:p-10 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-teal-600 block">LOKASI &amp; PENGEMBANGAN</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">SMK Negeri 1 Majalengka</h2>
                    </div>
                    <a href="https://maps.google.com/?q=SMK+Negeri+1+Majalengka" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-300 text-slate-700 text-xs font-bold shadow-sm shrink-0 self-start sm:self-auto">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Buka Google Maps</span>
                    </a>
                </div>

                <!-- Google Maps Embed Container -->
                <div class="w-full h-72 sm:h-96 rounded-2xl overflow-hidden border border-slate-200 shadow-inner">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.544727630577!2d108.2467472749959!3d-6.825089793172777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f25e34584607f%3A0xfc1ced4877ff3283!2sSMK%20Negeri%201%20Majalengka!5e0!3m2!1sid!2sid!4v1794739248096!5m2!1sid!2sid"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin">
                    </iframe>
                </div>
            </div>
        </section>

        <!-- ================= SECTION 6: CALL TO ACTION PENUTUP ================= -->
        <section class="max-w-6xl mx-auto px-5 sm:px-8">
            <div class="rounded-3xl bg-slate-900 text-white p-10 sm:p-14 text-center space-y-6 shadow-sm">
                <div class="space-y-3 max-w-3xl mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Siap Meluncurkan Website Resmi Bisnis Anda?</h2>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-medium">
                        Konsultasikan kebutuhan usaha Anda hari ini melalui WhatsApp. Kami siap menghadirkan website portofolio profesional untuk melipatgandakan reputasi bisnis Anda.
                    </p>
                </div>

                <div class="pt-2">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-xl bg-teal-600 text-white font-bold text-base shadow-sm cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>Mulai Konsultasi Gratis (WhatsApp)</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- ================= FOOTER BERSIH ================= -->
    <footer class="border-t border-slate-200 bg-white py-8 px-5 sm:px-8">
        <div class="max-w-7xl mx-auto text-center text-sm text-slate-500">
            <p class="font-medium text-slate-600">
                &copy; 2026 Hanan Aria Santagama | XII RPL 1
            </p>
        </div>
    </footer>

    <!-- ================= FLOATING WHATSAPP BUTTON (STATIC / TANPA ANIMASI) ================= -->
    <aside class="fixed bottom-6 right-6 z-50">
        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
           class="flex items-center gap-2 px-4 py-3 rounded-full bg-[#25D366] text-white font-bold shadow-lg"
           aria-label="Chat WhatsApp Admin">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            <span class="text-xs sm:text-sm font-bold tracking-wide">Pesan Website</span>
        </a>
    </aside>

</div>
@endsection
