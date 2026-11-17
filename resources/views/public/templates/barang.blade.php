{{--
  ==============================================================================
  TEMPLATE PUBLIK: TOKO BARANG, RETAIL & PRODUK FISIK UMKM
  ==============================================================================
  - Desain modern, bersih, dan rapi khas storefront e-commerce & toko retail resmi.
  - Banner full-width membentang penuh di bagian paling atas website.
  - Profil toko & logo elegan bertumpuk rapi di bawah banner.
  - Etalase katalog produk dengan foto persegi, harga jelas, dan tombol order WhatsApp.
  - Informasi alamat toko fisik & peta lokasi terhubung Google Maps.
  - Bebas efek AI-slop: tanpa gradien norak, tanpa frame tebal bertumpuk, seleksi teks default.
--}}
@extends('layouts.app')

@section('title', ($portfolio->nama_umkm ?? 'Toko Barang UMKM') . ' — ' . ($portfolio->bio ?? 'Katalog Produk & Retail Resmi'))
@section('body_class', 'bg-slate-50 text-slate-900 min-h-screen antialiased flex flex-col justify-between')

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo Admin ' . $portfolio->nama_umkm . ', saya ingin bertanya mengenai ketersediaan stok barang dan pemesanan.') : null;
    $nama = $portfolio->nama_umkm ?? 'Toko Retail & Produk Fisik';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-slate-50 font-sans text-slate-900">

    <!-- ── 1. HEADER NAVIGASI STICKY ──────────────────────────── -->
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-9 w-9 shrink-0 rounded-lg object-cover border border-slate-200" />
                @else
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-sm font-bold text-white">
                        🛍️
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-900">{{ $nama }}</p>
                    <p class="text-[11px] font-medium text-slate-500">Toko Retail &amp; Produk Fisik</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                <a href="#katalog" class="hover:text-blue-600 transition-colors">Katalog Produk</a>
                <a href="#keunggulan" class="hover:text-blue-600 transition-colors">Keunggulan</a>
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi" class="hover:text-blue-600 transition-colors">Lokasi Toko</a>
                @endif
            </nav>

            <div class="flex items-center gap-2">
                @if ($portfolio->instagram_url)
                    <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="h-3.5 w-3.5 fill-current text-pink-600" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span class="hidden sm:inline">Instagram</span>
                    </a>
                @endif
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-blue-600 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-xs">
                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                        <span>Chat WA</span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main>
        <!-- ── 2. FULL-WIDTH BANNER WEBSITE DI ATAS ──────────────── -->
        <section class="relative w-full h-56 sm:h-72 md:h-84 lg:h-96 overflow-hidden bg-slate-800">
            @if ($portfolio->banner_path)
                <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-full w-full object-cover" />
            @else
                <div class="h-full w-full bg-slate-800 flex flex-col items-center justify-center text-center p-6 text-slate-400">
                    <span class="text-4xl sm:text-5xl mb-2">🛍️</span>
                    <p class="text-lg sm:text-xl font-bold text-white tracking-wide">{{ $nama }}</p>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1">Produk Berkualitas, Harga Terjangkau &amp; Siap Kirim</p>
                </div>
            @endif
        </section>

        <!-- ── 3. PROFIL TOKO (OVERLAPPING BANNER) ───────────────── -->
        <section class="relative bg-white border-b border-slate-200">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="relative -mt-14 sm:-mt-16 pb-8">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
                        <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                            <!-- Logo Toko -->
                            <div class="h-24 w-24 sm:h-28 sm:w-28 shrink-0 rounded-2xl border-4 border-white bg-white shadow-md overflow-hidden">
                                @if ($portfolio->logo_path)
                                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-full w-full object-cover" />
                                @else
                                    <div class="h-full w-full bg-blue-600 flex items-center justify-center text-3xl text-white font-black">
                                        🛍️
                                    </div>
                                @endif
                            </div>

                            <!-- Judul & Status Toko -->
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                                        {{ $nama }}
                                    </h1>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 border border-blue-200 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                                        Official Store
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm font-medium text-slate-500">
                                    Retail Resmi &bull; Ready Stock &bull; Pengiriman Cepat
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Kontak Cepat -->
                        <div class="flex flex-wrap items-center gap-2.5 pt-2 sm:pt-0">
                            @if ($waLink)
                                {{--
                                  // UBAH WARNA TOMBOL 'BELI VIA WA':
                                  // Ganti 'bg-blue-600 hover:bg-blue-700' jadi 'bg-emerald-600 hover:bg-emerald-700' (hijau) atau 'bg-indigo-600 hover:bg-indigo-700' (ungu)
                                --}}
                                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-5 py-2.5 text-xs font-bold text-white transition-colors shadow-xs">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                    <span>Chat CS WhatsApp</span>
                                </a>
                            @endif

                            @if ($portfolio->instagram_url)
                                <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors shadow-2xs">
                                    <svg class="h-4 w-4 fill-current text-pink-600" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    <span>Instagram</span>
                                </a>
                            @endif

                            <a href="#katalog"
                               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors shadow-2xs">
                                <span>Lihat Katalog</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Bio Deskripsi -->
                    @if ($portfolio->bio)
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="max-w-3xl text-sm sm:text-base leading-relaxed text-slate-600">
                                {{ $portfolio->bio }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- ── 4. KATALOG PRODUK BARANG ───────────────────────────── -->
        <section id="katalog" class="py-12 sm:py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="mb-8 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Katalog Produk &amp; Retail</h2>
                        <p class="mt-1 text-sm text-slate-600">Produk original berkualitas dengan garansi dan pelayanan terpercaya</p>
                    </div>
                    <span class="inline-block self-start sm:self-auto rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700">
                        {{ count($products) }} Produk Tersedia
                    </span>
                </div>

                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            <div class="flex flex-col justify-between overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs hover:border-slate-300 transition-all">
                                <div>
                                    <!-- Foto Produk -->
                                    <div class="aspect-square w-full overflow-hidden bg-slate-100">
                                        @if (!empty($item['image'] ?? $item['foto'] ?? null))
                                            <img src="{{ Storage::url($item['image'] ?? $item['foto']) }}"
                                                 alt="{{ $item['name'] ?? $item['judul'] ?? 'Produk' }}"
                                                 class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-slate-300">
                                                <span class="text-5xl">📦</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Produk -->
                                    <div class="p-5 space-y-2">
                                        <h3 class="text-base font-bold text-slate-900">
                                            {{ $item['name'] ?? $item['judul'] ?? 'Produk Retail' }}
                                        </h3>

                                        <p class="text-lg font-bold text-blue-600">
                                            {{ !empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Hubungi CS' }}
                                        </p>

                                        @if (!empty($item['description'] ?? $item['deskripsi'] ?? ''))
                                            <p class="text-xs leading-relaxed text-slate-600 line-clamp-2">
                                                {{ $item['description'] ?? $item['deskripsi'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Tombol Pesan Langsung ke WhatsApp -->
                                <div class="border-t border-slate-100 p-4 pt-3 bg-slate-50/50">
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Admin ' . $nama . ', saya mau order produk: ' . ($item['name'] ?? $item['judul'] ?? 'Barang') . ' (' . (!empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : '') . '). Apakah stoknya masih ready?') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-700 py-2.5 text-xs font-bold text-white transition-colors shadow-2xs">
                                            <span>Beli / Tanya Stok (WA)</span>
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-500">
                        <span class="text-4xl">📦</span>
                        <p class="mt-3 font-semibold text-slate-800">Katalog Barang Sedang Diperbarui</p>
                        <p class="mt-1 text-xs">Silakan hubungi WhatsApp kami langsung untuk daftar produk dan harga terbaru.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── 5. KEUNGGULAN TOKO ────────────────────────────────── -->
        <section id="keunggulan" class="border-y border-slate-200 bg-white py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-6 space-y-2">
                        <span class="text-3xl">🛡️</span>
                        <h3 class="text-base font-bold text-slate-900">Jaminan 100% Original</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Setiap unit produk melalui uji fisik dan dipastikan original sebelum sampai ke tangan Anda.
                        </p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-6 space-y-2">
                        <span class="text-3xl">📦</span>
                        <h3 class="text-base font-bold text-slate-900">Pengemasan Ekstra Aman</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Dilapisi bubble wrap tebal dan kardus pelindung sehingga aman untuk pengiriman ke seluruh Indonesia.
                        </p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-6 space-y-2">
                        <span class="text-3xl">⚡</span>
                        <h3 class="text-base font-bold text-slate-900">Proses Cepat &amp; Ramah</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Admin sigap merespons pertanyaan stok, spesifikasi, dan memproses orderan Anda di hari yang sama.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 6. LOKASI TOKO & KONTAK ──────────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="py-12 sm:py-16">
                <div class="mx-auto max-w-6xl px-4 sm:px-6">
                    <div class="mb-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Lokasi Toko Fisik &amp; Pengiriman</h2>
                        <p class="mt-1 text-sm text-slate-600">Kunjungi toko kami langsung atau pesan online via ekspedisi terpercaya</p>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xs">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="flex flex-col justify-between p-6 sm:p-8 space-y-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Jam Layanan Toko:</p>
                                        <p class="mt-1 text-sm font-bold text-slate-900">Senin &ndash; Sabtu: 08:30 &ndash; 20:00 WIB</p>
                                    </div>
                                    @if ($portfolio->alamat)
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Alamat Toko:</p>
                                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">{{ $portfolio->alamat }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-5 py-3 text-xs font-bold text-white transition-colors shadow-xs">
                                        <span>Konsultasi Stok &amp; Pesan (WA)</span>
                                    </a>
                                @endif
                            </div>

                            <div class="min-h-[300px] bg-slate-100">
                                @if ($portfolio->maps_embed_url)
                                    <iframe
                                        src="{{ $portfolio->maps_embed_url }}"
                                        class="h-full w-full min-h-[300px] border-0"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Peta Lokasi {{ $nama }}">
                                    </iframe>
                                @else
                                    <div class="flex h-full min-h-[300px] items-center justify-center text-sm text-slate-400">
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
    <footer class="border-t border-slate-200 bg-white py-8 text-center text-xs text-slate-500">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 space-y-2">
            <p class="font-bold text-slate-800">{{ $nama }}</p>
            <div class="flex flex-wrap items-center justify-center gap-4 font-medium text-slate-600">
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">WhatsApp: {{ $portfolio->whatsapp }}</a>
                @endif
                @if ($portfolio->instagram_url)
                    <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-pink-600">Instagram: {{ $portfolio->instagram }}</a>
                @endif
            </div>
            <p class="text-[11px] text-slate-400 pt-2">&copy; {{ date('Y') }} {{ $nama }}. Halaman portofolio resmi UMKM.</p>
        </div>
    </footer>

    <!-- ── 8. FLOATING WHATSAPP BUTTON ────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-lg hover:brightness-105 transition-all"
           style="box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Chat Toko (WA)</span>
        </a>
    @endif

</div>
@endsection
