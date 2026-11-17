{{--
  ==============================================================================
  TEMPLATE PUBLIK: KEDAI KOPI, BOBA & MINUMAN KEKINIAN
  ==============================================================================
  - Desain modern, hangat, dan estetik khas specialty coffee shop & kedai minuman.
  - Banner full-width membentang penuh di bagian atas website.
  - Profil kedai & logo elegan bertumpuk rapi di bawah banner.
  - Etalase daftar varian minuman dengan foto, harga porsi, dan tombol pesan WhatsApp.
  - Informasi jam operasional & peta lokasi terhubung Google Maps.
  - Bebas efek AI-slop: tanpa gradien norak, tanpa frame tebal bertumpuk, seleksi teks default.
--}}
@extends('layouts.app')

@section('title', ($portfolio->nama_umkm ?? 'Kedai Minuman & Kopi') . ' — ' . ($portfolio->bio ?? 'Racikan Segar Cita Rasa Pilihan'))
@section('body_class', 'bg-[#181614] text-[#F3EFEA] min-h-screen antialiased flex flex-col justify-between')

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo ' . $portfolio->nama_umkm . ', saya ingin memesan menu minuman / tanya ketersediaan menu.') : null;
    $nama = $portfolio->nama_umkm ?? 'Kedai Kopi & Minuman Segar';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-[#181614] font-sans text-[#F3EFEA]">

    <!-- ── 1. HEADER NAVIGASI STICKY ──────────────────────────── -->
    <header class="sticky top-0 z-40 border-b border-[#2B2621] bg-[#181614]/95 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-9 w-9 shrink-0 rounded-lg object-cover border border-[#332E29]" />
                @else
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-600 text-sm font-bold text-white">
                        ☕
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">{{ $nama }}</p>
                    <p class="text-[11px] font-medium text-amber-400">Coffee &amp; Artisan Beverage</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-neutral-400 md:flex">
                <a href="#menu" class="hover:text-amber-400 transition-colors">Daftar Menu</a>
                <a href="#keunggulan" class="hover:text-amber-400 transition-colors">Keistimewaan</a>
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi" class="hover:text-amber-400 transition-colors">Lokasi &amp; Jam Buka</a>
                @endif
            </nav>

            <div class="flex items-center gap-2">
                @if ($portfolio->instagram_url)
                    <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-[#332E29] bg-[#221F1C] px-3 py-1.5 text-xs font-semibold text-neutral-300 hover:bg-[#2B2724] transition-colors">
                        <svg class="h-3.5 w-3.5 fill-current text-pink-400" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span class="hidden sm:inline">Instagram</span>
                    </a>
                @endif
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-amber-600 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-amber-700 transition-colors shadow-xs">
                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                        <span>Pesan (WA)</span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main>
        <!-- ── 2. FULL-WIDTH BANNER WEBSITE DI ATAS ──────────────── -->
        <section class="relative w-full h-56 sm:h-72 md:h-84 lg:h-96 overflow-hidden bg-[#100E0D]">
            @if ($portfolio->banner_path)
                <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-full w-full object-cover" />
            @else
                <div class="h-full w-full bg-[#100E0D] flex flex-col items-center justify-center text-center p-6 text-neutral-500">
                    <span class="text-4xl sm:text-5xl mb-2">☕</span>
                    <p class="text-lg sm:text-xl font-bold text-white tracking-wide">{{ $nama }}</p>
                    <p class="text-xs sm:text-sm text-neutral-400 mt-1">Cita Rasa Otentik, Segar &amp; Diseduh Penuh Dedikasi</p>
                </div>
            @endif
        </section>

        <!-- ── 3. PROFIL KEDAI (OVERLAPPING BANNER) ──────────────── -->
        <section class="relative bg-[#1E1B18] border-b border-[#2B2621]">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="relative -mt-14 sm:-mt-16 pb-8">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
                        <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                            <!-- Logo Kedai -->
                            <div class="h-24 w-24 sm:h-28 sm:w-28 shrink-0 rounded-2xl border-4 border-[#1E1B18] bg-[#24201C] shadow-md overflow-hidden">
                                @if ($portfolio->logo_path)
                                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-full w-full object-cover" />
                                @else
                                    <div class="h-full w-full bg-amber-600 flex items-center justify-center text-3xl text-white font-black">
                                        ☕
                                    </div>
                                @endif
                            </div>

                            <!-- Judul & Kategori -->
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                        {{ $nama }}
                                    </h1>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-950/70 border border-amber-600/30 px-2.5 py-0.5 text-xs font-semibold text-amber-300">
                                        Kedai Resmi
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm font-medium text-neutral-400">
                                    Coffee &bull; Tea &bull; Boba &bull; Signature Drinks
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Kontak Cepat -->
                        <div class="flex flex-wrap items-center gap-2.5 pt-2 sm:pt-0">
                            @if ($waLink)
                                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 rounded-xl bg-amber-600 hover:bg-amber-700 px-5 py-2.5 text-xs font-bold text-white transition-colors shadow-xs">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                    <span>Pesan via WhatsApp</span>
                                </a>
                            @endif

                            @if ($portfolio->instagram_url)
                                <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 rounded-xl border border-[#332E29] bg-[#24201C] hover:bg-[#2C2723] px-4 py-2.5 text-xs font-bold text-neutral-300 transition-colors shadow-2xs">
                                    <svg class="h-4 w-4 fill-current text-pink-400" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    <span>Instagram</span>
                                </a>
                            @endif

                            <a href="#menu"
                               class="inline-flex items-center gap-1.5 rounded-xl border border-[#332E29] bg-[#24201C] hover:bg-[#2C2723] px-4 py-2.5 text-xs font-bold text-neutral-300 transition-colors shadow-2xs">
                                <span>Buka Menu</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Bio Deskripsi -->
                    @if ($portfolio->bio)
                        <div class="mt-4 pt-4 border-t border-[#2B2621]">
                            <p class="max-w-3xl text-sm sm:text-base leading-relaxed text-neutral-300">
                                {{ $portfolio->bio }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- ── 4. DAFTAR MENU MINUMAN KATALOG ────────────────────── -->
        <section id="menu" class="py-12 sm:py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="mb-8 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Varian Minuman &amp; Signature</h2>
                        <p class="mt-1 text-sm text-neutral-400">Diracik langsung dari biji kopi pilihan dan bahan alami berkualitas tinggi</p>
                    </div>
                    <span class="inline-block self-start sm:self-auto rounded-lg border border-[#332E29] bg-[#221F1C] px-3 py-1.5 text-xs font-semibold text-neutral-300">
                        {{ count($products) }} Minuman Tersedia
                    </span>
                </div>

                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            <div class="flex flex-col justify-between overflow-hidden rounded-xl border border-[#2B2621] bg-[#201D1A] shadow-xs hover:border-[#3D3730] transition-all">
                                <div>
                                    <!-- Foto Minuman -->
                                    <div class="aspect-4/3 w-full overflow-hidden bg-[#181614]">
                                        @if (!empty($item['image'] ?? $item['foto'] ?? null))
                                            <img src="{{ Storage::url($item['image'] ?? $item['foto']) }}"
                                                 alt="{{ $item['name'] ?? $item['judul'] ?? 'Menu' }}"
                                                 class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-neutral-600">
                                                <span class="text-5xl">☕</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Minuman -->
                                    <div class="p-5 space-y-2">
                                        <h3 class="text-base font-bold text-white">
                                            {{ $item['name'] ?? $item['judul'] ?? 'Menu Minuman' }}
                                        </h3>

                                        <p class="text-lg font-bold text-amber-400">
                                            {{ !empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Harga Spesial' }}
                                        </p>

                                        @if (!empty($item['description'] ?? $item['deskripsi'] ?? ''))
                                            <p class="text-xs leading-relaxed text-neutral-400 line-clamp-2">
                                                {{ $item['description'] ?? $item['deskripsi'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Tombol Pesan Langsung ke WhatsApp -->
                                <div class="border-t border-[#2B2621] p-4 pt-3 bg-[#1B1815]">
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $nama . ', saya mau pesan menu: ' . ($item['name'] ?? $item['judul'] ?? 'Minuman') . ' (' . (!empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : '') . '). Mohon info cara pemesanannya ya!') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="flex w-full items-center justify-center gap-2 rounded-lg bg-amber-600 hover:bg-amber-700 py-2.5 text-xs font-bold text-white transition-colors shadow-2xs">
                                            <span>Pesan Minuman Ini (WA)</span>
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl border border-[#2B2621] bg-[#1E1B18] p-12 text-center text-neutral-400">
                        <span class="text-4xl">☕</span>
                        <p class="mt-3 font-semibold text-white">Daftar Minuman Sedang Disiapkan</p>
                        <p class="mt-1 text-xs">Silakan hubungi WhatsApp kami langsung untuk rekomendasi menu hari ini.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── 5. KEISTIMEWAAN KEDAI ─────────────────────────────── -->
        <section id="keunggulan" class="border-y border-[#2B2621] bg-[#1E1B18] py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-xl border border-[#2B2621] bg-[#221F1C] p-6 space-y-2">
                        <span class="text-3xl">🌱</span>
                        <h3 class="text-base font-bold text-white">Bahan &amp; Daun Pilihan</h3>
                        <p class="text-xs leading-relaxed text-neutral-400">
                            Biji kopi nusantara hasil sangrai presisi dan daun teh murni dari perkebunan dataran tinggi.
                        </p>
                    </div>
                    <div class="rounded-xl border border-[#2B2621] bg-[#221F1C] p-6 space-y-2">
                        <span class="text-3xl">🍯</span>
                        <h3 class="text-base font-bold text-white">Gula &amp; Sirup Alami</h3>
                        <p class="text-xs leading-relaxed text-neutral-400">
                            Menggunakan pemanis alami, susu murni berkualitas, dan tanpa pemanis buatan yang menusuk.
                        </p>
                    </div>
                    <div class="rounded-xl border border-[#2B2621] bg-[#221F1C] p-6 space-y-2">
                        <span class="text-3xl">❄️</span>
                        <h3 class="text-base font-bold text-white">Disajikan Segar</h3>
                        <p class="text-xs leading-relaxed text-neutral-400">
                            Setiap gelas diseduh dan diracik langsung saat dipesan untuk menjaga aroma dan kesegaran maksimal.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 6. LOKASI KEDAI & KONTAK ──────────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="py-12 sm:py-16">
                <div class="mx-auto max-w-6xl px-4 sm:px-6">
                    <div class="mb-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Lokasi Kedai &amp; Jam Kunjungan</h2>
                        <p class="mt-1 text-sm text-neutral-400">Suasana santai untuk ngopi, nugas, maupun kumpul bersama teman</p>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-[#2B2621] bg-[#1E1B18] shadow-xs">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="flex flex-col justify-between p-6 sm:p-8 space-y-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-amber-400">Jam Operasional:</p>
                                        <p class="mt-1 text-sm font-bold text-white">Buka Setiap Hari: 09:00 &ndash; 23:00 WIB</p>
                                    </div>
                                    @if ($portfolio->alamat)
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-amber-400">Alamat Kedai:</p>
                                            <p class="mt-1 text-xs text-neutral-300 leading-relaxed">{{ $portfolio->alamat }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-600 hover:bg-amber-700 px-5 py-3 text-xs font-bold text-white transition-colors shadow-xs">
                                        <span>Order Take-Away / Tanya Menu (WA)</span>
                                    </a>
                                @endif
                            </div>

                            <div class="min-h-[300px] bg-[#141210]">
                                @if ($portfolio->maps_embed_url)
                                    <iframe
                                        src="{{ $portfolio->maps_embed_url }}"
                                        class="h-full w-full min-h-[300px] border-0"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Peta Lokasi {{ $nama }}">
                                    </iframe>
                                @else
                                    <div class="flex h-full min-h-[300px] items-center justify-center text-sm text-neutral-600">
                                        Peta lokasi belum disematkan
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>

    <!-- ── 7. FOOTER RESMI ────────────────────────────────────── -->
    <footer class="border-t border-[#2B2621] bg-[#141210] py-8 text-center text-xs text-neutral-500">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 space-y-2">
            <p class="font-bold text-neutral-300">{{ $nama }}</p>
            <div class="flex flex-wrap items-center justify-center gap-4 font-medium text-neutral-400">
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="hover:text-amber-400">WhatsApp: {{ $portfolio->whatsapp }}</a>
                @endif
                @if ($portfolio->instagram_url)
                    <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-pink-400">Instagram: {{ $portfolio->instagram }}</a>
                @endif
            </div>
            <p class="text-[11px] text-neutral-600 pt-2">&copy; {{ date('Y') }} {{ $nama }}. Halaman portofolio resmi UMKM.</p>
        </div>
    </footer>

    <!-- ── 8. FLOATING WHATSAPP BUTTON ────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-lg hover:brightness-105 transition-all"
           style="box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Pesan Minuman (WA)</span>
        </a>
    @endif

</div>
@endsection
