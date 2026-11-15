{{--
  ==============================================================================
  TEMPLATE PUBLIK: LEMBAGA, YAYASAN & KOMUNITAS
  ==============================================================================
  - Desain bertema modern terpercaya dengan warna emerald green dan slate.
  - 3 Pilar Penggerak dan agenda kegiatan/program kerja organisasi.
  - Kanal kontak narahubung langsung via WhatsApp untuk memudahkan kolaborasi warga.
--}}
@extends('layouts.app')

@section('title', ($portfolio->business_name ?? 'Lembaga & Organisasi') . ' — ' . ($portfolio->bio ?? 'Portal Resmi & Agenda'))
@section('body_class', 'bg-[#f8fafc] text-slate-800 min-h-screen antialiased flex flex-col justify-between selection:bg-emerald-600 selection:text-white')

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo Pengurus ' . $portfolio->business_name . ', saya ingin berkoordinasi dan menjalin kemitraan.') : null;
    $nama = $portfolio->business_name ?? 'Lembaga / Komunitas';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-[#f8fafc] font-sans text-slate-800">

    <!-- ── TOP ACCENT BAR ─────────────────────────────────────── -->
    <div class="h-1 w-full bg-gradient-to-r from-emerald-600 via-teal-500 to-sky-600"></div>

    <!-- ── HEADER STICKY ──────────────────────────────────────── -->
    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 shadow-xs backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-5 py-3">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-emerald-500/40" />
                @else
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 text-base font-black text-white shadow-md shadow-emerald-900/20">
                        🏛️
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-900">{{ $nama }}</p>
                    <p class="text-[10px] font-semibold tracking-wide text-emerald-600">Portal Resmi Lembaga & Komunitas</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                <a href="#program" class="">Program Kerja</a>
                <a href="#pilar" class="">Pilar Aksi</a>
                @if ($portfolio->bio)
                    <a href="#visi" class="">Visi Misi</a>
                @endif
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#sekretariat" class="">Sekretariat</a>
                @endif
            </nav>

            @if ($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-emerald-600/30">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                    <span class="hidden sm:inline">Narahubung (WA)</span>
                    <span class="sm:hidden">Kontak</span>
                </a>
            @endif
        </div>
    </header>

    <main>
        <!-- ── HERO SECTION ──────────────────────────────────────── -->
        <section class="relative overflow-hidden bg-gradient-to-b from-emerald-50/60 via-slate-50 to-[#f8fafc] py-14 md:py-20">
            <!-- Ambient Glows Emerald & Ocean -->
            <div class="pointer-events-none absolute -right-32 -top-32 h-[450px] w-[450px] rounded-full bg-emerald-400/15 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-[400px] w-[400px] rounded-full bg-teal-400/10 blur-[90px]"></div>

            <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-5 lg:grid-cols-2">
                <!-- Sisi Kiri: Headline, Misi & Tombol Sinergi -->
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-100/60 px-4 py-1.5 text-xs font-bold text-emerald-800 shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span>🌱 Bersinergi & Menebar Dampak Positif</span>
                    </div>

                    <h1 class="text-3xl font-extrabold leading-[1.15] text-slate-900 sm:text-4xl md:text-5xl">
                        {{ $nama }}
                    </h1>

                    @if ($portfolio->bio)
                        <p class="max-w-lg text-base leading-relaxed text-slate-600">
                            {{ $portfolio->bio }}
                        </p>
                    @else
                        <p class="max-w-lg text-base leading-relaxed text-slate-600">
                            Wadah kolaborasi kepemudaan, komunitas, dan aksi sosial terencana yang berdedikasi membangun kapasitas generasi muda dan memperkuat kesejahteraan masyarakat.
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-3.5 text-sm font-bold text-white shadow-xl shadow-emerald-600/30">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                <span>Hubungi Narahubung via WA</span>
                            </a>
                        @endif
                        <a href="#program"
                           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 shadow-2xs">
                            <span>Jelajahi Program</span>
                            <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                    </div>

                    <!-- 3 Micro Stats -->
                    <div class="grid grid-cols-3 gap-3 border-t border-slate-200 pt-6">
                        <div>
                            <p class="text-2xl font-black text-slate-900">{{ count($products) > 0 ? count($products) : '10+' }}</p>
                            <p class="text-[10px] uppercase tracking-wider text-slate-500">Program Terjadwal</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-emerald-600">Aktif</p>
                            <p class="text-[10px] uppercase tracking-wider text-slate-500">Status Legalitas</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-teal-600">Sinergi</p>
                            <p class="text-[10px] uppercase tracking-wider text-slate-500">Kemitraan Terbuka</p>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Frame Showcase Lembaga -->
                <div class="relative flex justify-center">
                    <div class="relative w-full max-w-[440px] overflow-hidden rounded-3xl border-4 border-white bg-white p-2 shadow-2xl ring-1 ring-emerald-200/60">
                        @if ($portfolio->banner_path)
                            <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @elseif ($portfolio->logo_path)
                            <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @else
                            <div class="flex h-80 w-full flex-col items-center justify-center rounded-2xl bg-gradient-to-tr from-emerald-100 via-teal-50 to-sky-100 text-center p-6 sm:h-96">
                                <span class="text-6xl mb-3">🏛️</span>
                                <p class="text-xl font-bold text-slate-900">{{ $nama }}</p>
                                <p class="text-xs text-emerald-700 mt-1 font-semibold">Integritas, Aksi & Kolaborasi</p>
                            </div>
                        @endif

                        <div class="absolute bottom-5 left-5 right-5 rounded-2xl bg-slate-900/90 p-4 text-white backdrop-blur-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">Komitmen Layanan</p>
                                    <p class="text-sm font-extrabold">{{ $nama }}</p>
                                </div>
                                <span class="rounded-lg bg-emerald-600 px-2.5 py-1 text-xs font-bold text-white">Terverifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 3 PILAR AKSI ORGANISASI ───────────────────────────── -->
        <section id="pilar" class="border-y border-slate-200 bg-white py-12">
            <div class="mx-auto max-w-6xl px-5">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-[#fbfdfc] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-2xl text-emerald-700">
                            🤝
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Kolaborasi & Kemitraan</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Membangun jejaring sinergis dengan berbagai pihak demi memperluas jangkauan kebermanfaatan bersama.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-[#fbfdfc] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-2xl text-emerald-700">
                            💡
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Pemberdayaan Terencana</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Menyelenggarakan program pelatihan, aksi sosial, dan pendampingan terarah sesuai potensi lokal.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-[#fbfdfc] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-2xl text-emerald-700">
                            🎯
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Transparan & Bertanggung Jawab</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Mengedepankan akuntabilitas laporan kegiatan dan tata kelola organisasi yang bersih dan berintegritas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── PROGRAM KERJA / INISIATIF ─────────────────────────── -->
        <section id="program" class="py-16 md:py-24">
            <div class="mx-auto max-w-6xl px-5">
                <div class="mb-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                            <p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Agenda & Inisiatif</p>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 sm:text-3xl md:text-4xl">Program Kerja Organisasi</h2>
                        <p class="mt-2 text-sm text-slate-600">Daftar agenda kegiatan dan inisiatif pengabdian yang sedang berjalan</p>
                    </div>
                    <span class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-800">
                        {{ count($products) }} Program Terdaftar
                    </span>
                </div>

                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xs">
                                <div>
                                    <!-- Foto Kegiatan Program -->
                                    <div class="aspect-4/3 w-full overflow-hidden bg-emerald-50">
                                        @if (!empty($item['image'] ?? $item['foto'] ?? null))
                                            <img src="{{ Storage::url($item['image'] ?? $item['foto']) }}"
                                                 alt="{{ $item['name'] ?? $item['judul'] ?? 'Program' }}"
                                                 class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-emerald-100/50 text-emerald-300">
                                                <span class="text-5xl">📋</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Program -->
                                    <div class="p-5 space-y-2">
                                        <h3 class="text-base font-bold text-slate-900">
                                            {{ $item['name'] ?? $item['judul'] ?? 'Program Inisiatif' }}
                                        </h3>

                                        <p class="text-sm font-extrabold text-emerald-700">
                                            {{ !empty($item['price']) && $item['price'] > 0 ? 'Target/Alokasi: Rp ' . number_format($item['price'], 0, ',', '.') : 'Inisiatif Pengabdian' }}
                                        </p>

                                        @if (!empty($item['description'] ?? $item['deskripsi'] ?? ''))
                                            <p class="text-xs leading-relaxed text-slate-600 line-clamp-2">
                                                {{ $item['description'] ?? $item['deskripsi'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Narahubung Program -->
                                <div class="border-t border-slate-100 p-5 pt-3">
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Pengurus ' . $nama . ', saya ingin berpartisipasi / mendukung program: ' . ($item['name'] ?? $item['judul'] ?? 'Program') . '. Mohon info lebih lanjut ya!') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-50 py-2.5 text-xs font-bold text-emerald-800">
                                            <span>Dukung / Gabung Program</span>
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback Mock Cards Program Komunitas -->
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🎓</span>
                            <h3 class="text-base font-bold text-slate-900">Pelatihan Digital & Soft Skill</h3>
                            <p class="text-xs text-slate-600">Workshop praktis pengembangan kapasitas talenta muda untuk siap kerja dan berwirausaha mandiri.</p>
                            <p class="text-xs font-bold text-emerald-700">Agenda Bulanan</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🌳</span>
                            <h3 class="text-base font-bold text-slate-900">Gerakan Peduli Lingkungan Hidup</h3>
                            <p class="text-xs text-slate-600">Aksi bersih pantai/sungai dan penghijauan pohon bibit produktif bersama relawan pemuda.</p>
                            <p class="text-xs font-bold text-emerald-700">Aksi Lapangan</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🎁</span>
                            <h3 class="text-base font-bold text-slate-900">Bantuan Sosial Tanggap Warga</h3>
                            <p class="text-xs text-slate-600">Penyaluran sembako dan perlengkapan sekolah bagi anak yatim dan keluarga prasejahtera.</p>
                            <p class="text-xs font-bold text-emerald-700">Sosial & Edukasi</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── SEKRETARIAT & PUSAT KOORDINASI ────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="sekretariat" class="border-t border-slate-200 bg-white py-16 md:py-20">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="mb-10 text-center">
                        <p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Pusat Informasi</p>
                        <h2 class="mt-2 text-2xl font-black text-slate-900 sm:text-3xl">Sekretariat & Hub Koordinasi</h2>
                        <p class="mt-2 text-sm text-slate-600">Titik temu dan pusat kegiatan koordinasi pengurus serta relawan</p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="flex flex-col justify-between p-8 space-y-6">
                                <div class="space-y-4">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                        <span>📍 Kantor Sekretariat</span>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900">{{ $nama }}</h3>
                                    @if ($portfolio->alamat)
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Alamat Lengkap:</p>
                                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">{{ $portfolio->alamat }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-xs font-bold text-white shadow-md">
                                        <span>Konfirmasi Kunjungan via WA</span>
                                    </a>
                                @endif
                            </div>

                            <div class="min-h-[300px] bg-slate-100">
                                @if ($portfolio->maps_embed_url)
                                    <iframe
                                        src="{{ $portfolio->maps_embed_url }}"
                                        class="h-full w-full min-h-[320px] border-0"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Peta Lokasi {{ $nama }}">
                                    </iframe>
                                @else
                                    <div class="flex h-full min-h-[300px] items-center justify-center text-sm text-slate-400">
                                        Peta belum disematkan
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>

    <!-- ── FOOTER RESMI ───────────────────────────────────────── -->
    <footer class="border-t border-slate-200 bg-slate-900 py-8 text-center text-xs text-slate-400">
        <div class="mx-auto max-w-6xl px-5 space-y-2">
            <p class="font-bold text-white">{{ $nama }} &bull; Sinergi, Integritas & Aksi Nyata</p>
            <p>&copy; 2026 Hanan Aria Santagama | XII RPL 1</p>
        </div>
    </footer>

    <!-- ── FLOATING WHATSAPP BUTTON ──────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-2xl"
           style="box-shadow: 0 8px 25px rgba(37, 211, 102, 0.45);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Hubungi Narahubung</span>
        </a>
    @endif

</div>
@endsection
