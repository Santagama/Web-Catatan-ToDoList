{{--
  ==============================================================================
  TEMPLATE PUBLIK: TOKO BARANG, RETAIL & PRODUK FISIK UMKM
  ==============================================================================
  - Dirancang khusus untuk UMKM yang menjual produk fisik (fashion, elektronik, perabot, merchandise, retail).
  - Menampilkan etalase katalog produk, harga resmi, detail spesifikasi, dan tombol checkout via WhatsApp.
  - Dilengkapi tautan resmi Instagram dan WhatsApp sebagai kanal promosi & penjualan utama.
  - Sesuai standar: Tanpa efek animasi rumit, desain solid, mudah dipahami programmer pemula.
--}}
@extends('layouts.app')

@section('title', ($portfolio->nama_umkm ?? 'Toko Barang UMKM') . ' — ' . ($portfolio->bio ?? 'Katalog Produk & Retail'))
@section('body_class', 'bg-[#f8fafc] text-slate-800 min-h-screen antialiased flex flex-col justify-between selection:bg-blue-600 selection:text-white')

@section('content')
@php
    // Membersihkan format nomor WhatsApp agar hanya berupa digit angka
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');

    // Link WhatsApp umum untuk menyapa toko
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo Admin ' . $portfolio->nama_umkm . ', saya ingin bertanya mengenai ketersediaan stok barang dan pemesanan.') : null;

    $nama = $portfolio->nama_umkm ?? 'Toko Barang UMKM';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-[#f8fafc] font-sans text-slate-800">

    <!-- ── 1. GARIS AKSEN ATAS (TOP ACCENT BAR) ────────────────── -->
    <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500"></div>

    <!-- ── 2. HEADER NAVIGASI (STICKY) ────────────────────────── -->
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-5 py-3">
            {{-- Logo dan Nama Toko --}}
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-blue-500/30" />
                @else
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-base font-black text-white shadow-xs">
                        🛍️
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-900">{{ $nama }}</p>
                    <p class="text-[10px] font-semibold tracking-wide text-blue-600">Katalog Resmi &amp; Toko Retail</p>
                </div>
            </div>

            {{-- Navigasi Menu Halaman --}}
            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                <a href="#katalog">Katalog Barang</a>
                <a href="#keunggulan">Keunggulan</a>
                @if ($portfolio->bio)
                    <a href="#tentang">Tentang Toko</a>
                @endif
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi">Lokasi Toko</a>
                @endif
            </nav>

            {{-- Tombol Kontak Cepat WhatsApp & Instagram di Header --}}
            <div class="flex items-center gap-2">
                @if ($portfolio->instagram_url)
                    <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex shrink-0 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-pink-600 shadow-xs" title="Kunjungi Instagram Resmi">
                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span class="hidden sm:inline">Instagram</span>
                    </a>
                @endif
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-xs">
                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                        <span class="hidden sm:inline">Pesan via WA</span>
                        <span class="sm:hidden">Order</span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main>
        <!-- ── 3. HERO SECTION (BANNER & PROFIL TOKO) ─────────────── -->
        <section id="tentang" class="relative overflow-hidden bg-gradient-to-b from-blue-50/70 via-slate-50 to-[#f8fafc] py-14 md:py-20">
            <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-5 lg:grid-cols-2">
                {{-- Kolom Kiri: Headline, Bio & Tombol Aksi --}}
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-100/70 px-4 py-1.5 text-xs font-bold text-blue-900">
                        <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                        <span>🛍️ Toko Retail &amp; Produk Fisik Terpercaya</span>
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
                            Pusat belanja produk berkualitas, retail, dan barang kebutuhan harian terlengkap. Kami mengutamakan keaslian produk, harga bersahabat, serta pengiriman cepat ke seluruh wilayah.
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        <a href="#katalog"
                           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-md">
                            <span>Lihat Katalog Produk</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>

                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 shadow-2xs">
                                <svg class="h-4 w-4 fill-emerald-600" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                <span>Chat CS WA</span>
                            </a>
                        @endif

                        @if ($portfolio->instagram_url)
                            <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 shadow-2xs">
                                <svg class="h-4 w-4 fill-pink-600" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                <span>Instagram</span>
                            </a>
                        @endif
                    </div>

                    {{-- 3 Indikator Statistik Toko --}}
                    <div class="grid grid-cols-3 gap-3 border-t border-slate-200 pt-6">
                        <div>
                            <p class="text-2xl font-black text-slate-900">{{ count($products) > 0 ? count($products) : '50+' }}</p>
                            <p class="text-[10px] uppercase tracking-wider text-slate-500">Pilihan Produk</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-blue-600">100%</p>
                            <p class="text-[10px] uppercase tracking-wider text-slate-500">Produk Asli</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-indigo-600">Cepat</p>
                            <p class="text-[10px] uppercase tracking-wider text-slate-500">Siap Kirim</p>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Showcase Gambar Banner / Produk --}}
                <div class="relative flex justify-center">
                    <div class="relative w-full max-w-[440px] overflow-hidden rounded-3xl border-4 border-white bg-white p-2 shadow-xl ring-1 ring-blue-200">
                        @if ($portfolio->banner_path)
                            <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @elseif ($portfolio->logo_path)
                            <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @else
                            <div class="flex h-80 w-full flex-col items-center justify-center rounded-2xl bg-gradient-to-tr from-blue-100 via-indigo-50 to-slate-100 text-center p-6 sm:h-96">
                                <span class="text-6xl mb-3">📦</span>
                                <p class="text-xl font-bold text-slate-900">{{ $nama }}</p>
                                <p class="text-xs text-blue-700 mt-1 font-semibold">Ready Stock &amp; Kualitas Terbaik</p>
                            </div>
                        @endif

                        <div class="absolute bottom-5 left-5 right-5 rounded-2xl bg-slate-900/90 p-4 text-white backdrop-blur-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-blue-300">Status Toko</p>
                                    <p class="text-sm font-extrabold">{{ $nama }}</p>
                                </div>
                                <span class="rounded-lg bg-emerald-600 px-2.5 py-1 text-xs font-bold text-white">Buka &amp; Melayani</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 4. KEUNGGULAN BELANJA (3 VALUE PROPOSITION) ───────── -->
        <section id="keunggulan" class="border-y border-slate-200 bg-white py-12">
            <div class="mx-auto max-w-6xl px-5">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-[#fbfdfc] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-blue-700">
                            📦
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Kualitas Barang Terjamin</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Setiap produk melewati pengecekan kualitas sebelum dikirim agar diterima dalam kondisi prima dan sesuai pesanan.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-[#fbfdfc] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-blue-700">
                            ⚡
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Pemesanan Mudah via WA</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Cukup pilih produk di katalog dan klik order, Anda langsung terhubung dengan admin untuk konsultasi dan pembayaran aman.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-[#fbfdfc] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-blue-700">
                            🚚
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Pengiriman Cepat &amp; Aman</h3>
                        <p class="text-xs leading-relaxed text-slate-600">
                            Didukung berbagai opsi kurir terpercaya serta packing rapi berlapis agar pesanan sampai tepat waktu ke alamat Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 5. KATALOG PRODUK & BARANG DAGANGAN ───────────────── -->
        <section id="katalog" class="py-16 md:py-24">
            <div class="mx-auto max-w-6xl px-5">
                <div class="mb-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                            <p class="text-xs font-bold uppercase tracking-widest text-blue-600">Etalase &amp; Harga</p>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 sm:text-3xl md:text-4xl">Katalog Produk &amp; Barang Pilihan</h2>
                        <p class="mt-2 text-sm text-slate-600">Pilih barang yang Anda butuhkan dan hubungi kami langsung via WhatsApp untuk order cepat</p>
                    </div>
                    <span class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-bold text-blue-800">
                        {{ count($products) }} Produk Tersedia
                    </span>
                </div>

                {{-- Tampilan Grid Produk --}}
                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            @php
                                $itemName = $item['name'] ?? $item['judul'] ?? 'Produk';
                                $itemPrice = !empty($item['price']) && is_numeric($item['price']) ? (float)$item['price'] : null;
                                $itemDesc = $item['description'] ?? $item['deskripsi'] ?? '';
                                $itemImage = $item['image'] ?? $item['foto'] ?? null;

                                // Link WhatsApp spesifik untuk pembelian produk ini
                                $orderWaText = 'Halo Admin ' . $nama . ', saya tertarik ingin memesan produk: ' . $itemName;
                                if ($itemPrice) {
                                    $orderWaText .= ' seharga Rp ' . number_format($itemPrice, 0, ',', '.');
                                }
                                $orderWaText .= '. Apakah stoknya masih tersedia?';
                                $orderWaUrl = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode($orderWaText) : null;
                            @endphp

                            <div class="flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xs">
                                <div>
                                    <!-- Foto Produk Fisik -->
                                    <div class="aspect-4/3 w-full overflow-hidden bg-slate-100">
                                        @if ($itemImage)
                                            <img src="{{ Storage::url($itemImage) }}"
                                                 alt="{{ $itemName }}"
                                                 class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-blue-50 text-blue-400">
                                                <span class="text-5xl">🛍️</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Barang (Nama, Harga & Keterangan) -->
                                    <div class="p-5 space-y-2">
                                        <h3 class="text-base font-bold text-slate-900">
                                            {{ $itemName }}
                                        </h3>

                                        <p class="text-base font-black text-blue-700">
                                            @if ($itemPrice)
                                                Rp {{ number_format($itemPrice, 0, ',', '.') }}
                                            @else
                                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hubungi Admin untuk Harga</span>
                                            @endif
                                        </p>

                                        @if (!empty($itemDesc))
                                            <p class="text-xs leading-relaxed text-slate-600 line-clamp-2">
                                                {{ $itemDesc }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Tombol Pesan via WhatsApp -->
                                <div class="border-t border-slate-100 p-5 pt-3">
                                    @if ($orderWaUrl)
                                        <a href="{{ $orderWaUrl }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 py-2.5 text-xs font-bold text-white shadow-xs">
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                            <span>Pesan Barang Ini</span>
                                        </a>
                                    @else
                                        <button type="button" disabled class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-200 py-2.5 text-xs font-bold text-slate-500 cursor-not-allowed">
                                            <span>Pesan Barang</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Contoh Etalase Mockup jika belum ada data produk --}}
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">👕</span>
                            <h3 class="text-base font-bold text-slate-900">Fashion &amp; Pakaian</h3>
                            <p class="text-xs text-slate-600">Koleksi baju, celana, jaket, dan busana trendi berkualitas distro dengan bahan nyaman.</p>
                            <p class="text-xs font-bold text-blue-700">Mulai Rp 75.000</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🔌</span>
                            <h3 class="text-base font-bold text-slate-900">Aksesoris &amp; Gadget</h3>
                            <p class="text-xs text-slate-600">Perlengkapan elektronik harian, kabel data, charger fast charging, dan casing pelindung.</p>
                            <p class="text-xs font-bold text-blue-700">Mulai Rp 45.000</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🎒</span>
                            <h3 class="text-base font-bold text-slate-900">Tas &amp; Perlengkapan</h3>
                            <p class="text-xs text-slate-600">Tas ransel, dompet kulit sintetis, dan pernak-pernik serbaguna untuk aktivitas harian.</p>
                            <p class="text-xs font-bold text-blue-700">Mulai Rp 95.000</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── 6. LOKASI TOKO OFFLINE & GOOGLE MAPS ───────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="border-t border-slate-200 bg-white py-16 md:py-20">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="mb-10 text-center">
                        <p class="text-xs font-bold uppercase tracking-widest text-blue-600">Kunjungi Toko Fisik</p>
                        <h2 class="mt-2 text-2xl font-black text-slate-900 sm:text-3xl">Lokasi Toko &amp; Titik Temu</h2>
                        <p class="mt-2 text-sm text-slate-600">Silakan berkunjung langsung ke alamat kami untuk memilih dan mencoba barang secara langsung</p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="flex flex-col justify-between p-8 space-y-6">
                                <div class="space-y-4">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                                        <span>📍 Alamat Toko</span>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900">{{ $nama }}</h3>
                                    @if ($portfolio->alamat)
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Alamat Lengkap:</p>
                                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">{{ $portfolio->alamat }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2">
                                    @if ($waLink)
                                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-xs font-bold text-white shadow-md">
                                            <span>Tanya Rute / Jam Buka via WA</span>
                                        </a>
                                    @endif
                                    @if ($portfolio->instagram_url)
                                        <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-5 py-2.5 text-xs font-bold text-pink-600">
                                            <span>Kunjungi Instagram Resmi</span>
                                        </a>
                                    @endif
                                </div>
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

    <!-- ── 7. FOOTER RESMI TOKO ───────────────────────────────── -->
    <footer class="border-t border-slate-200 bg-slate-900 py-8 text-center text-xs text-slate-400">
        <div class="mx-auto max-w-6xl px-5 space-y-3">
            <p class="font-bold text-white">{{ $nama }} &bull; Belanja Aman, Nyaman &amp; Terpercaya</p>
            <div class="flex flex-wrap items-center justify-center gap-4 text-xs font-medium">
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="text-emerald-400">WhatsApp: {{ $portfolio->whatsapp }}</a>
                @endif
                @if ($portfolio->instagram_url)
                    <a href="{{ $portfolio->instagram_url }}" target="_blank" rel="noopener noreferrer" class="text-pink-400">Instagram: {{ $portfolio->instagram }}</a>
                @endif
            </div>
            <p>&copy; 2026 Hanan Aria Santagama | XII RPL 1</p>
        </div>
    </footer>

    <!-- ── 8. FLOATING WHATSAPP BUTTON ────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-2xl"
           style="box-shadow: 0 8px 25px rgba(37, 211, 102, 0.45);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Tanya Stok via WhatsApp</span>
        </a>
    @endif

</div>
@endsection
