{{--
  ==============================================================================
  TEMPLATE PUBLIK: RESTORAN & KULINER MAKANAN
  ==============================================================================
  - Desain bertema kuliner hangat lezat (warm cream, flame orange, dan savory crimson).
  - Pilihan menu makanan disajikan dengan foto, harga porsi, dan tombol pesan WhatsApp.
  - Informasi jam operasional dan lokasi restoran terhubung Google Maps.
--}}
@extends('layouts.app')

@section('title', ($portfolio->business_name ?? 'Restoran & Kuliner') . ' — ' . ($portfolio->bio ?? 'Menu Lezat & Sajian Istimewa'))
@section('body_class', 'bg-[#fcfaf7] text-gray-800 min-h-screen antialiased flex flex-col justify-between selection:bg-orange-600 selection:text-white')

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo ' . $portfolio->business_name . ', saya ingin memesan menu makanan / reservasi meja.') : null;
    $nama = $portfolio->business_name ?? 'Resto & Kuliner Pilihan';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-[#fcfaf7] font-sans text-gray-800">

    <!-- ── TOP STRIP REMPAH NUSANTARA ──────────────────────────── -->
    <div class="h-1 w-full bg-gradient-to-r from-orange-600 via-amber-500 to-red-600"></div>

    <!-- ── HEADER STICKY ──────────────────────────────────────── -->
    <header class="sticky top-0 z-50 border-b border-orange-100/80 bg-white/95 shadow-xs backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-5 py-3">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-orange-500/40" />
                @else
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-600 text-base font-black text-white shadow-md shadow-orange-900/20">
                        🍲
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-gray-900">{{ $nama }}</p>
                    <p class="text-[10px] font-semibold tracking-wide text-orange-600">Restoran & Cita Rasa Istimewa</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-gray-600 md:flex">
                <a href="#menu" class="">Daftar Menu</a>
                <a href="#keunggulan" class="">Keistimewaan</a>
                @if ($portfolio->bio)
                    <a href="#tentang" class="">Tentang Resto</a>
                @endif
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi" class="">Lokasi & Jam Buka</a>
                @endif
            </nav>

            @if ($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-orange-600/30">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                    <span class="hidden sm:inline">Pesan Antar (WA)</span>
                    <span class="sm:hidden">Pesan</span>
                </a>
            @endif
        </div>
    </header>

    <main>
        <!-- ── HERO SECTION ──────────────────────────────────────── -->
        <section class="relative overflow-hidden bg-gradient-to-b from-orange-50/70 via-amber-50/30 to-[#fcfaf7] py-14 md:py-20">
            <!-- Subtle Culinary Glows -->
            <div class="pointer-events-none absolute -right-32 -top-32 h-[450px] w-[450px] rounded-full bg-orange-400/15 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-[400px] w-[400px] rounded-full bg-red-400/10 blur-[90px]"></div>

            <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-5 lg:grid-cols-2">
                <!-- Sisi Kiri: Headline & Ajakan Santap -->
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-orange-200 bg-orange-100/60 px-4 py-1.5 text-xs font-bold text-orange-700 shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                        <span>🔥 Cita Rasa Pilihan Berbumbu Alami</span>
                    </div>

                    <h1 class="text-3xl font-extrabold leading-[1.15] text-gray-900 sm:text-4xl md:text-5xl">
                        {{ $nama }}
                    </h1>

                    @if ($portfolio->bio)
                        <p class="max-w-lg text-base leading-relaxed text-gray-600">
                            {{ $portfolio->bio }}
                        </p>
                    @else
                        <p class="max-w-lg text-base leading-relaxed text-gray-600">
                            Menghadirkan hidangan kuliner lezat yang dimasak segar setiap hari dari resep pilihan keluarga dengan bahan-bahan rempah alami bermutu tinggi.
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 px-6 py-3.5 text-sm font-bold text-white shadow-xl shadow-orange-600/30">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                <span>Pesan Meja / Antar (WA)</span>
                            </a>
                        @endif
                        <a href="#menu"
                           class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-sm font-semibold text-gray-700 shadow-2xs">
                            <span>Lihat Menu Lengkap</span>
                            <svg class="h-4 w-4 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                    </div>

                    <!-- 3 Micro Stats -->
                    <div class="grid grid-cols-3 gap-3 border-t border-orange-100 pt-6">
                        <div>
                            <p class="text-2xl font-black text-gray-900">{{ count($products) > 0 ? count($products) : '20+' }}</p>
                            <p class="text-[10px] uppercase tracking-wider text-gray-500">Pilihan Menu</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-orange-600">100%</p>
                            <p class="text-[10px] uppercase tracking-wider text-gray-500">Halal & Higienis</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-red-600">Fresh</p>
                            <p class="text-[10px] uppercase tracking-wider text-gray-500">Masak Setiap Hari</p>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Foto Makanan Utama / Banner Resto -->
                <div class="relative flex justify-center">
                    <div class="relative w-full max-w-[440px] overflow-hidden rounded-3xl border-4 border-white bg-white p-2 shadow-2xl ring-1 ring-orange-200/60">
                        @if ($portfolio->banner_path)
                            <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @elseif ($portfolio->logo_path)
                            <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-80 w-full rounded-2xl object-cover sm:h-96" />
                        @else
                            <div class="flex h-80 w-full flex-col items-center justify-center rounded-2xl bg-gradient-to-tr from-orange-100 via-amber-50 to-red-100 text-center p-6 sm:h-96">
                                <span class="text-6xl mb-3">🍲</span>
                                <p class="text-xl font-bold text-gray-900">{{ $nama }}</p>
                                <p class="text-xs text-orange-600 mt-1 font-semibold">Kelezatan Tiada Duanya</p>
                            </div>
                        @endif

                        <div class="absolute bottom-5 left-5 right-5 rounded-2xl bg-gray-900/90 p-4 text-white backdrop-blur-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-orange-400">Rekomendasi Spesial</p>
                                    <p class="text-sm font-extrabold">{{ $nama }}</p>
                                </div>
                                <span class="rounded-lg bg-orange-600 px-2.5 py-1 text-xs font-bold text-white">Menu Utama</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 3 KEISTIMEWAAN DAPUR ──────────────────────────────── -->
        <section id="keunggulan" class="border-y border-orange-100 bg-white py-12">
            <div class="mx-auto max-w-6xl px-5">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-2xl border border-orange-100 bg-[#fffbf7] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl text-orange-600">
                            🥩
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Bahan Segar Terpilih</h3>
                        <p class="text-xs leading-relaxed text-gray-600">
                            Sayuran dan daging dipasok harian secara higienis, menjamin kesegaran dan cita rasa maksimal.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-orange-100 bg-[#fffbf7] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl text-orange-600">
                            🍲
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Rempah Alami Nusantara</h3>
                        <p class="text-xs leading-relaxed text-gray-600">
                            Diracik menggunakan rempah-rempah asli warisan nusantara tanpa pemanis atau pengawet buatan.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-orange-100 bg-[#fffbf7] p-6 space-y-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl text-orange-600">
                            🍱
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Porsi Mantap & Higienis</h3>
                        <p class="text-xs leading-relaxed text-gray-600">
                            Porsi mengenyangkan disajikan dalam kemasan bersih dan ramah untuk santap di tempat maupun take-away.
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
                            <span class="h-2 w-2 rounded-full bg-orange-600"></span>
                            <p class="text-xs font-bold uppercase tracking-widest text-orange-600">Katalog Kuliner</p>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 sm:text-3xl md:text-4xl">Daftar Menu & Hidangan</h2>
                        <p class="mt-2 text-sm text-gray-600">Semua menu disajikan hangat dan dibuat dari bahan segar</p>
                    </div>
                    <span class="rounded-xl border border-orange-200 bg-orange-50 px-4 py-2 text-xs font-bold text-orange-700">
                        {{ count($products) }} Sajian Tersedia
                    </span>
                </div>

                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $item)
                            <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xs">
                                <div>
                                    <!-- Foto Makanan -->
                                    <div class="aspect-4/3 w-full overflow-hidden bg-orange-50">
                                        @if (!empty($item['image'] ?? $item['foto'] ?? null))
                                            <img src="{{ Storage::url($item['image'] ?? $item['foto']) }}"
                                                 alt="{{ $item['name'] ?? $item['judul'] ?? 'Menu' }}"
                                                 class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-orange-100/50 text-orange-300">
                                                <span class="text-5xl">🍲</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Menu -->
                                    <div class="p-5 space-y-2">
                                        <h3 class="text-base font-bold text-gray-900">
                                            {{ $item['name'] ?? $item['judul'] ?? 'Menu Makanan' }}
                                        </h3>

                                        <p class="text-lg font-black text-orange-600">
                                            {{ !empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Harga Istimewa' }}
                                        </p>

                                        @if (!empty($item['description'] ?? $item['deskripsi'] ?? ''))
                                            <p class="text-xs leading-relaxed text-gray-600 line-clamp-2">
                                                {{ $item['description'] ?? $item['deskripsi'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Pesan Button -->
                                <div class="border-t border-gray-100 p-5 pt-3">
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $nama . ', saya mau pesan: ' . ($item['name'] ?? $item['judul'] ?? 'Menu') . ' (' . (!empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : '') . '). Mohon info porsi dan cara pemesanannya ya!') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-orange-50 py-2.5 text-xs font-bold text-orange-700">
                                            <span>Pesan Menu Ini (WA)</span>
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback Mock Cards Menu Kuliner -->
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-2xl border border-orange-100 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🍗</span>
                            <h3 class="text-base font-bold text-gray-900">Ayam Bakar Madu Spesial</h3>
                            <p class="text-xs text-gray-600">Ayam bakar bumbu rempah bakar madu meresap hingga ke tulang dengan sambal terasi gurih.</p>
                            <p class="text-sm font-bold text-orange-600">Rp 28.000</p>
                        </div>
                        <div class="rounded-2xl border border-orange-100 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🍲</span>
                            <h3 class="text-base font-bold text-gray-900">Sop Iga Sapi Kuah Rempah</h3>
                            <p class="text-xs text-gray-600">Iga sapi empuk bertabur daun bawang dan seledri dalam kaldu kuah kaya rempah menghangatkan.</p>
                            <p class="text-sm font-bold text-orange-600">Rp 38.000</p>
                        </div>
                        <div class="rounded-2xl border border-orange-100 bg-white p-6 text-center space-y-3 shadow-2xs">
                            <span class="text-4xl">🍜</span>
                            <h3 class="text-base font-bold text-gray-900">Bakso Urat Granat Juara</h3>
                            <p class="text-xs text-gray-600">Bakso urat sapi asli kenyal mantap dengan isian tetelan pedas gurih dan kuah sumsum gurih.</p>
                            <p class="text-sm font-bold text-orange-600">Rp 22.000</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── LOKASI RESTO & RESERVASI ──────────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="border-t border-orange-100 bg-[#f9f6f0] py-16 md:py-20">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="mb-10 text-center">
                        <p class="text-xs font-bold uppercase tracking-widest text-orange-600">Lokasi & Kunjungan</p>
                        <h2 class="mt-2 text-2xl font-black text-gray-900 sm:text-3xl">Kunjungi Tempat Kami</h2>
                        <p class="mt-2 text-sm text-gray-600">Ruangan nyaman, bersih, dan berfasilitas lengkap untuk keluarga maupun rombongan</p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-lg">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="flex flex-col justify-between p-8 space-y-6">
                                <div class="space-y-4">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-orange-100 px-3 py-1 text-xs font-bold text-orange-700">
                                        <span>⏰ Jam Buka Resto</span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900">10:00 WIB &ndash; 22:00 WIB</p>
                                    @if ($portfolio->alamat)
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-wider text-orange-600">Alamat Resto:</p>
                                            <p class="mt-1 text-xs text-gray-600 leading-relaxed">{{ $portfolio->alamat }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-600 px-5 py-3 text-xs font-bold text-white shadow-md">
                                        <span>Reservasi Meja / Paket Katering (WA)</span>
                                    </a>
                                @endif
                            </div>

                            <div class="min-h-[300px] bg-orange-50">
                                @if ($portfolio->maps_embed_url)
                                    <iframe
                                        src="{{ $portfolio->maps_embed_url }}"
                                        class="h-full w-full min-h-[320px] border-0"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Peta Lokasi {{ $nama }}">
                                    </iframe>
                                @else
                                    <div class="flex h-full min-h-[300px] items-center justify-center text-sm text-gray-400">
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
    <footer class="border-t border-orange-100 bg-[#1f1510] py-8 text-center text-xs text-gray-400">
        <div class="mx-auto max-w-6xl px-5 space-y-2">
            <p class="font-bold text-white">{{ $nama }} &bull; Cita Rasa Lezat & Katering Pilihan</p>
            <p>&copy; 2026 Hanan Aria Santagama | XII RPL 1</p>
        </div>
    </footer>

    <!-- ── FLOATING WHATSAPP BUTTON ──────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-2xl"
           style="box-shadow: 0 8px 25px rgba(37, 211, 102, 0.45);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Pesan Makanan (WA)</span>
        </a>
    @endif

</div>
@endsection
