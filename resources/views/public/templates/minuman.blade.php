{{--
  ==============================================================================
  TEMPLATE PUBLIK: KEDAI KOPI & MINUMAN SEGAR
  ==============================================================================
  - Desain bertema hangat warm espresso dan roasted amber honey.
  - Tombol 'Pesan Minuman Ini': Otomatis membuka aplikasi WhatsApp pembeli dengan
    teks pesan yang langsung memuat nama minuman dan harganya.
  - number_format($item['price'], 0, ',', '.'): Memformat harga menjadi format Rupiah.
--}}
@extends('layouts.app')

@section('title', ($portfolio->business_name ?? 'Kedai Minuman') . ' — ' . ($portfolio->bio ?? 'Menu & Minuman Segar'))
@section('body_class', 'bg-[#140c08] text-[#f5ebe6] min-h-screen antialiased flex flex-col justify-between selection:bg-amber-600 selection:text-white')

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo ' . $portfolio->business_name . ', saya ingin memesan menu minuman.') : null;
    $nama = $portfolio->business_name ?? 'Kedai Kopi & Minuman';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-[#140c08] font-sans text-[#f5ebe6]">

    <!-- ── HEADER STICKY ──────────────────────────────────────── -->
    <header class="sticky top-0 z-50 border-b border-amber-900/30 bg-[#140c08]/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-5 py-3">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-amber-500/50" />
                @else
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-amber-700 text-base font-black text-white shadow-md shadow-amber-950">
                        ☕
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">{{ $nama }}</p>
                    <p class="text-[10px] font-semibold tracking-wide text-amber-400">Coffee & Fresh Beverages</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-amber-200/70 md:flex">
                <a href="#menu" class="">Daftar Menu</a>
                <a href="#keunggulan" class="">Keunggulan</a>
                @if ($portfolio->bio)
                    <a href="#cerita" class="">Cerita Kedai</a>
                @endif
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi" class="">Lokasi & Jam Buka</a>
                @endif
            </nav>

            @if ($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-2 text-xs font-bold text-white shadow-lg shadow-amber-950/60">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                    <span class="hidden sm:inline">Pesan Minuman (WA)</span>
                    <span class="sm:hidden">Order</span>
                </a>
            @endif
        </div>
    </header>

    <main>
        <!-- ── HERO SECTION ──────────────────────────────────────── -->
        <section class="relative overflow-hidden py-14 md:py-20">
            <!-- Ambient Glows Amber & Roasted Honey -->
            <div class="pointer-events-none absolute -right-36 -top-36 h-[480px] w-[480px] rounded-full bg-amber-600/20 blur-[110px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-[420px] w-[420px] rounded-full bg-orange-700/20 blur-[100px]"></div>

            <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-5 lg:grid-cols-2">
                <!-- Sisi Kiri: Headline, Bio, & Order CTA -->
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-4 py-1.5 text-xs font-semibold text-amber-300">
                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                        <span>Racikan Segar Setiap Hari</span>
                    </div>

                    <h1 class="text-3xl font-extrabold leading-[1.15] text-white sm:text-4xl md:text-5xl">
                        {{ $nama }}
                    </h1>

                    @if ($portfolio->bio)
                        <p class="max-w-lg text-base leading-relaxed text-amber-100/80">
                            {{ $portfolio->bio }}
                        </p>
                    @else
                        <p class="max-w-lg text-base leading-relaxed text-amber-100/70">
                            Hadir menyajikan sensasi kopi autentik dan ragam racikan minuman dingin segar dengan bahan bermutu tinggi, siap menemani momen santai dan produktif Anda.
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3.5 text-sm font-bold text-white shadow-xl shadow-amber-950/60">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                <span>Pesan via WhatsApp</span>
                            </a>
                        @endif
                        <a href="#menu"
                           class="inline-flex items-center gap-2 rounded-xl border border-amber-500/40 bg-amber-950/40 px-6 py-3.5 text-sm font-semibold text-amber-200">
                            <span>Buka Buku Menu</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                    </div>

                    <!-- Micro Stats -->
                    <div class="grid grid-cols-3 gap-3 border-t border-amber-900/30 pt-6">
                        <div>
                            <p class="text-2xl font-black text-amber-400">{{ count($products) > 0 ? count($products) : '15+' }}</p>
                            <p class="text-[10px] uppercase tracking-wider text-amber-200/60">Varian Menu</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-amber-400">100%</p>
                            <p class="text-[10px] uppercase tracking-wider text-amber-200/60">Gula & Bahan Alami</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-amber-400">Fresh</p>
                            <p class="text-[10px] uppercase tracking-wider text-amber-200/60">Racik Tiap Hari</p>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Foto Showcase / Banner Kedai -->
                <div class="relative flex justify-center">
                    <div class="relative w-full max-w-[420px] overflow-hidden rounded-3xl border-2 border-amber-500/30 bg-[#21150e] p-2 shadow-2xl shadow-amber-950">
                        @if ($portfolio->banner_path)
                            <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @elseif ($portfolio->logo_path)
                            <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @else
                            <div class="flex h-80 w-full flex-col items-center justify-center rounded-2xl bg-gradient-to-b from-[#2e1d13] to-[#1a0f08] sm:h-96">
                                <span class="text-6xl mb-3">☕</span>
                                <p class="text-xl font-bold text-white">{{ $nama }}</p>
                                <p class="text-xs text-amber-400 mt-1">Cita Rasa Otentik & Segar</p>
                            </div>
                        @endif

                        <div class="absolute bottom-5 left-5 right-5 rounded-2xl border border-amber-500/30 bg-[#160d08]/85 p-4 backdrop-blur-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-400">Pilihan Terfavorit</p>
                                    <p class="text-sm font-extrabold text-white">Signature Drink</p>
                                </div>
                                <span class="rounded-lg bg-amber-500/20 px-2.5 py-1 text-xs font-bold text-amber-300">Siap Saji</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 3 KEUNGGULAN KEDAI ────────────────────────────────── -->
        <section id="keunggulan" class="border-y border-amber-900/30 bg-[#1b110a] py-12">
            <div class="mx-auto max-w-6xl px-5">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-2xl border border-amber-900/40 bg-[#22160d] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-2xl text-amber-400">
                            ☕
                        </div>
                        <h3 class="text-base font-bold text-white">Bahan & Kopi Bermutu</h3>
                        <p class="text-xs leading-relaxed text-amber-100/70">
                            Menggunakan biji kopi sangrai fresh pilihan dan susu segar tanpa bahan pengawet sintesis.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-amber-900/40 bg-[#22160d] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-2xl text-amber-400">
                            🧊
                        </div>
                        <h3 class="text-base font-bold text-white">Es Kristal Higienis & Gula Murni</h3>
                        <p class="text-xs leading-relaxed text-amber-100/70">
                            Kualitas air steril bersertifikat pangan dengan pilihan pemanis gula aren organik alami.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-amber-900/40 bg-[#22160d] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-2xl text-amber-400">
                            ⚡
                        </div>
                        <h3 class="text-base font-bold text-white">Pesan Cepat Siap Ambil / Kirim</h3>
                        <p class="text-xs leading-relaxed text-amber-100/70">
                            Cukup satu klik WA, minuman favorit langsung diracik tanpa perlu antre lama di kedai.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── DAFTAR MENU KATALOG ───────────────────────────────── -->
        <section id="menu" class="py-16 md:py-24">
            <div class="mx-auto max-w-6xl px-5">
                <div class="mb-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            <p class="text-xs font-bold uppercase tracking-widest text-amber-400">Buku Menu</p>
                        </div>
                        <h2 class="text-2xl font-black text-white sm:text-3xl md:text-4xl">Daftar Menu & Racikan Segar</h2>
                        <p class="mt-2 text-sm text-amber-200/60">Pilih menu favoritmu dan pesan langsung via WhatsApp</p>
                    </div>
                    <span class="rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-2 text-xs font-bold text-amber-300">
                        {{ count($products) }} Menu Tersedia
                    </span>
                </div>

                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-amber-900/40 bg-[#21150e]">
                                <div>
                                    <!-- Foto Minuman -->
                                    <div class="aspect-4/3 w-full overflow-hidden bg-[#160d08]">
                                        @if (!empty($item['image'] ?? $item['foto'] ?? null))
                                            <img src="{{ Storage::url($item['image'] ?? $item['foto']) }}"
                                                 alt="{{ $item['name'] ?? $item['judul'] ?? 'Menu' }}"
                                                 class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-tr from-[#1b1009] to-[#2c1b11] text-amber-400/40">
                                                <span class="text-5xl">🥤</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Menu -->
                                    <div class="p-5 space-y-2">
                                        <div class="flex items-start justify-between gap-2">
                                            <h3 class="text-base font-bold text-white">
                                                {{ $item['name'] ?? $item['judul'] ?? 'Menu Minuman' }}
                                            </h3>
                                        </div>

                                        <p class="text-lg font-black text-amber-400">
                                            {{ !empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Harga Spesial' }}
                                        </p>

                                        @if (!empty($item['description'] ?? $item['deskripsi'] ?? ''))
                                            <p class="text-xs leading-relaxed text-amber-100/70 line-clamp-2">
                                                {{ $item['description'] ?? $item['deskripsi'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Order Button -->
                                <div class="border-t border-amber-900/30 p-5 pt-3">
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $nama . ', saya mau pesan: ' . ($item['name'] ?? $item['judul'] ?? 'Menu') . ' (' . (!empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : '') . '). Mohon info cara pesan dan pengambilannya ya!') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-amber-500/20 py-2.5 text-xs font-bold text-amber-300">
                                            <span>Pesan Minuman Ini</span>
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback Mock Cards Menu -->
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-2xl border border-amber-900/40 bg-[#21150e] p-6 text-center space-y-3">
                            <span class="text-4xl">☕</span>
                            <h3 class="text-base font-bold text-white">Signature Kopi Susu Aren</h3>
                            <p class="text-xs text-amber-100/70">Espresso robusta & arabika dengan gurihnya susu murni dan manis legit gula aren.</p>
                            <p class="text-sm font-bold text-amber-400">Rp 18.000</p>
                        </div>
                        <div class="rounded-2xl border border-amber-900/40 bg-[#21150e] p-6 text-center space-y-3">
                            <span class="text-4xl">🍵</span>
                            <h3 class="text-base font-bold text-white">Matcha Latte Creamy</h3>
                            <p class="text-xs text-amber-100/70">Bubuk matcha murni berpadu susu lembut, manis seimbang dan kaya antioksidan.</p>
                            <p class="text-sm font-bold text-amber-400">Rp 22.000</p>
                        </div>
                        <div class="rounded-2xl border border-amber-900/40 bg-[#21150e] p-6 text-center space-y-3">
                            <span class="text-4xl">🍹</span>
                            <h3 class="text-base font-bold text-white">Sparkling Berry Tea</h3>
                            <p class="text-xs text-amber-100/70">Seduhan teh buah segar berkarbonasi dingin dengan potongan buah beri asli.</p>
                            <p class="text-sm font-bold text-amber-400">Rp 20.000</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── LOKASI KEDAI & JAM OPERASIONAL ────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="border-t border-amber-900/30 bg-[#170f09] py-16 md:py-20">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="mb-10 text-center">
                        <p class="text-xs font-bold uppercase tracking-widest text-amber-400">Kunjungi Kami</p>
                        <h2 class="mt-2 text-2xl font-black text-white sm:text-3xl">Lokasi Kedai & Jam Operasional</h2>
                        <p class="mt-2 text-sm text-amber-200/60">Suasana nyaman untuk nongkrong, nugas, atau sekadar take-away santai</p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-amber-900/40 bg-[#22160d] shadow-2xl">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="flex flex-col justify-between p-8 space-y-6">
                                <div class="space-y-4">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-bold text-amber-400">
                                        <span>⏰ Buka Setiap Hari</span>
                                    </div>
                                    <p class="text-sm font-bold text-white">09:00 WIB &ndash; 22:30 WIB</p>
                                    @if ($portfolio->alamat)
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-wider text-amber-300">Alamat Lengkap:</p>
                                            <p class="mt-1 text-xs text-amber-100/80 leading-relaxed">{{ $portfolio->alamat }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-xs font-bold text-white shadow-md">
                                        <span>Tanya Meja / Pre-Order via WA</span>
                                    </a>
                                @endif
                            </div>

                            <div class="min-h-[300px] bg-[#140c08]">
                                @if ($portfolio->maps_embed_url)
                                    <iframe
                                        src="{{ $portfolio->maps_embed_url }}"
                                        class="h-full w-full min-h-[320px] border-0"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Peta Lokasi Kedai {{ $nama }}">
                                    </iframe>
                                @else
                                    <div class="flex h-full min-h-[300px] items-center justify-center text-sm text-amber-200/40">
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
    <footer class="border-t border-amber-900/30 bg-[#0e0704] py-8 text-center text-xs text-amber-200/50">
        <div class="mx-auto max-w-6xl px-5 space-y-2">
            <p class="font-bold text-white">{{ $nama }} &bull; Coffee, Tea & Refreshing Drinks</p>
            <p>&copy; 2026 Hanan Aria Santagama | XII RPL 1</p>
        </div>
    </footer>

    <!-- ── FLOATING WHATSAPP BUTTON ──────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-2xl"
           style="box-shadow: 0 8px 25px rgba(37, 211, 102, 0.45);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Pesan Minuman (WA)</span>
        </a>
    @endif

</div>
@endsection
