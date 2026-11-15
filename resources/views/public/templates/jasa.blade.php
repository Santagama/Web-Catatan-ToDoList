{{--
  ==============================================================================
  TEMPLATE PUBLIK: JASA & STUDIO PROFESIONAL
  ==============================================================================
  - preg_replace('/[^0-9]/', '', ...): Membersihkan karakter simbol (+, -, spasi)
    dari nomor WhatsApp agar valid dengan format internasional API wa.me.
  - urlencode(): Mengubah teks pesan pembuka otomatis ke format URL encoding (%20, dsb.)
  - $portfolio->products: Disimpan sebagai JSON di database, di-cast sebagai array di model,
    sehingga langsung bisa di-loop (@foreach / @forelse) tanpa decode manual.
  - Storage::url(): Memanggil tautan publik dari symbolic link public/storage.
--}}
@extends('layouts.app')

@section('title', ($portfolio->business_name ?? 'Layanan Profesional') . ' — ' . ($portfolio->bio ?? 'Landing Page'))
@section('body_class', 'bg-gray-950 text-gray-100 min-h-screen antialiased flex flex-col justify-between selection:bg-purple-600 selection:text-white')

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo ' . $portfolio->business_name . ', saya tertarik dengan layanan Anda.') : null;
    $nama = $portfolio->business_name ?? 'Brand Kami';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-gray-950 font-sans" style="color: #f1f1f5;">

    <!-- ── HEADER STICKY ──────────────────────────────────────── -->
    <header class="sticky top-0 z-50 border-b border-white/10 bg-gray-950/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-5 py-3">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-10 w-10 shrink-0 rounded-xl object-cover ring-1 ring-purple-500/40" />
                @else
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-purple-600 to-pink-600 text-sm font-black text-white shadow-md shadow-purple-900/40">
                        {{ substr($nama, 0, 1) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">{{ $nama }}</p>
                    <p class="text-[10px] text-purple-400 font-semibold tracking-wide">Professional Service</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-gray-400 md:flex">
                <a href="#layanan" class="">Layanan</a>
                <a href="#keunggulan" class="">Keunggulan</a>
                @if ($portfolio->bio)
                    <a href="#tentang" class="">Tentang</a>
                @endif
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi" class="">Lokasi</a>
                @endif
            </nav>

            @if ($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex shrink-0 items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-purple-900/40">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                    <span class="hidden sm:inline">Hubungi Kami</span>
                    <span class="sm:hidden">Chat</span>
                </a>
            @endif
        </div>
    </header>

    <main>
        <!-- ── HERO SECTION ──────────────────────────────────────── -->
        <section class="relative overflow-hidden">
            <!-- Background Glows -->
            <div class="pointer-events-none absolute -right-40 -top-40 h-[500px] w-[500px] rounded-full bg-purple-700/20 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-[400px] w-[400px] rounded-full bg-pink-700/15 blur-[100px]"></div>

            <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-5 py-14 md:py-20 lg:grid-cols-2">
                <!-- Sisi Kiri: Headline & CTA -->
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-purple-500/30 bg-purple-500/10 px-4 py-1.5 text-xs font-semibold text-purple-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-purple-400"></span>
                        <span>{{ $nama }}</span>
                    </div>

                    <h1 class="text-[2rem] font-extrabold leading-[1.15] text-white sm:text-4xl md:text-5xl">
                        {{ $portfolio->bio ? Str::limit($portfolio->bio, 80) : 'Layanan Profesional & Studio Kreatif ' . $nama }}
                    </h1>

                    <p class="max-w-md text-base leading-relaxed text-gray-400">
                        Kami menghadirkan layanan premium dengan standar kualitas tinggi untuk memenuhi setiap kebutuhan Anda secara elegan, solutif, dan profesional.
                    </p>

                    <div class="flex flex-wrap gap-3 pt-1">
                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple-900/40">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                <span>Mulai Sekarang</span>
                            </a>
                        @endif
                        <a href="#layanan"
                           class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white">
                            <span>Lihat Layanan</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>

                    <!-- Micro Stats -->
                    <div class="grid grid-cols-3 gap-3 border-t border-white/10 pt-6">
                        <div class="text-center">
                            <p class="text-2xl font-extrabold text-white">{{ count($products) ? count($products) . '+' : '10+' }}</p>
                            <p class="mt-1 text-[10px] text-gray-500 uppercase tracking-widest font-bold">Layanan</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-extrabold text-white">100%</p>
                            <p class="mt-1 text-[10px] text-gray-500 uppercase tracking-widest font-bold">Kualitas</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-extrabold text-white">24/7</p>
                            <p class="mt-1 text-[10px] text-gray-500 uppercase tracking-widest font-bold">Support</p>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Banner Frame Visual -->
                <div class="relative">
                    <div class="absolute -inset-4 rounded-3xl bg-gradient-to-br from-purple-600/20 to-pink-600/10 blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-gray-900">
                        @if ($portfolio->banner_path)
                            <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-[300px] w-full object-cover sm:h-[360px] md:h-[420px]" />
                        @elseif ($portfolio->logo_path)
                            <div class="flex h-[300px] w-full flex-col items-center justify-center bg-gradient-to-br from-purple-900/60 via-gray-900 to-pink-900/60 sm:h-[360px] md:h-[420px] p-8 text-center space-y-4">
                                <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-28 w-28 rounded-2xl object-cover ring-2 ring-purple-500/40 shadow-2xl" />
                                <p class="text-2xl font-bold text-white">{{ $nama }}</p>
                                <p class="text-xs text-purple-300">Premium Professional Service</p>
                            </div>
                        @else
                            <div class="flex h-[300px] w-full flex-col items-center justify-center bg-gradient-to-br from-purple-900 via-gray-900 to-pink-900 sm:h-[360px] md:h-[420px]">
                                <div class="space-y-3 text-center px-8">
                                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-600 to-pink-600 shadow-2xl shadow-purple-900/50">
                                        <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" /></svg>
                                    </div>
                                    <p class="text-2xl font-bold text-white">{{ $nama }}</p>
                                    <p class="text-sm text-gray-400">Premium Service</p>
                                </div>
                            </div>
                        @endif

                        <div class="absolute bottom-3 left-3 right-3 flex gap-2">
                            <div class="flex-1 rounded-xl bg-gray-950/80 px-3 py-2 backdrop-blur-sm border border-white/5">
                                <p class="text-[9px] font-semibold uppercase tracking-wider text-purple-400">Kelas</p>
                                <p class="text-sm font-bold text-white">Premium</p>
                            </div>
                            <div class="flex-1 rounded-xl bg-gray-950/80 px-3 py-2 backdrop-blur-sm border border-white/5">
                                <p class="text-[9px] font-semibold uppercase tracking-wider text-pink-400">Kualitas</p>
                                <p class="text-sm font-bold text-white">Terjamin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── KEUNGGULAN SECTION ──────────────────────────── -->
        <section id="keunggulan" class="border-y border-white/10 bg-gray-900/50 py-14">
            <div class="mx-auto max-w-6xl px-5">
                <div class="mb-10 text-center">
                    <p class="text-xs font-semibold uppercase tracking-widest text-purple-400">Keunggulan</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-white sm:text-3xl">Mengapa Memilih Kami</h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-gray-900 p-6">
                        <div class="mb-4 text-2xl text-purple-400">✦</div>
                        <h3 class="text-base font-bold text-white">Kelas Premium</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-400">Layanan dengan standar mutu premium yang dirancang untuk pengalaman terbaik Anda.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-gray-900 p-6">
                        <div class="mb-4 text-2xl text-purple-400">◈</div>
                        <h3 class="text-base font-bold text-white">Tim Berpengalaman</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-400">Didukung profesional berpengalaman yang siap memberikan solusi terbaik dan tepat waktu.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-gray-900 p-6">
                        <div class="mb-4 text-2xl text-purple-400">◉</div>
                        <h3 class="text-base font-bold text-white">Hasil Terukur</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-400">Setiap proses dan hasil kerja dirancang transparan, terukur, dan berdampak nyata.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── TENTANG SECTION ─────────────────────────────── -->
        @if ($portfolio->bio)
            <section id="tentang" class="py-16">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="overflow-hidden rounded-3xl border border-white/10 bg-gray-900">
                        <div class="grid lg:grid-cols-[1fr_360px]">
                            <div class="p-8 md:p-12 space-y-4">
                                <p class="text-xs font-semibold uppercase tracking-widest text-purple-400">Tentang Kami</p>
                                <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Profil &amp; Dedikasi</h2>
                                <p class="whitespace-pre-line text-sm leading-relaxed text-gray-300">
                                    {{ $portfolio->bio }}
                                </p>
                                @if ($portfolio->alamat)
                                    <p class="text-xs text-gray-400 pt-2 flex items-center gap-2">
                                        <svg class="h-4 w-4 text-purple-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>{{ $portfolio->alamat }}</span>
                                    </p>
                                @endif
                                @if ($waLink)
                                    <div class="pt-2">
                                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-purple-900/30">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                            <span>Konsultasi Langsung</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="hidden lg:flex flex-col items-center justify-center gap-4 bg-gradient-to-b from-purple-900/60 to-pink-900/40 p-10">
                                @if ($portfolio->logo_path)
                                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-24 w-24 rounded-2xl object-cover shadow-xl ring-2 ring-purple-500/40" />
                                @else
                                    <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-600 to-pink-600 text-3xl font-black text-white shadow-xl">
                                        {{ substr($nama, 0, 1) }}
                                    </div>
                                @endif
                                <p class="text-center text-sm font-bold text-white">{{ $nama }}</p>
                                <div class="flex gap-1 text-amber-400">
                                    ★ ★ ★ ★ ★
                                </div>
                                <p class="text-xs text-purple-300 font-semibold uppercase tracking-wider">Premium Quality</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- ── KATALOG PRODUK & LAYANAN ─────────────────────── -->
        @if (count($products) > 0)
            <section id="layanan" class="bg-gray-900/40 py-16">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-purple-400">Portofolio Layanan</p>
                            <h2 class="mt-2 text-2xl font-extrabold text-white sm:text-3xl">Pilihan Layanan &amp; Paket</h2>
                        </div>
                        <span class="text-xs px-3 py-1 rounded-full bg-purple-500/15 text-purple-300 border border-purple-500/30 font-bold self-start sm:self-auto">
                            {{ count($products) }} Layanan Tersedia
                        </span>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($products as $item)
                            <div class="group overflow-hidden rounded-2xl border border-white/10 bg-gray-900 flex flex-col justify-between">
                                <div>
                                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-800">
                                        @if (!empty($item['image']))
                                            <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-purple-950 via-gray-900 to-pink-950">
                                                <svg class="h-12 w-12 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                        <span class="absolute left-3 top-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-sm">Premium</span>
                                    </div>
                                    <div class="p-4 space-y-2">
                                        <h3 class="text-sm font-bold text-white">{{ $item['name'] }}</h3>
                                        <p class="text-sm font-extrabold text-pink-400">
                                            {{ !empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Konsultasi Harga' }}
                                        </p>
                                        @if (!empty($item['description']))
                                            <p class="text-xs leading-relaxed text-gray-400 line-clamp-2">{{ $item['description'] }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if ($waNumber)
                                    <div class="p-4 pt-0">
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $nama . ', saya tertarik memesan layanan: ' . $item['name']) }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl border border-purple-500/30 bg-purple-500/10 py-2 text-xs font-bold text-purple-300">
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                            <span>Tanya Sekarang</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ── LOKASI PETA GOOGLE MAPS ──────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="py-16">
                <div class="mx-auto max-w-6xl px-5 space-y-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-purple-400">Lokasi &amp; Studio</p>
                        <h2 class="mt-2 text-2xl font-extrabold text-white sm:text-3xl">Kunjungi Tempat Kami</h2>
                        @if ($portfolio->alamat)
                            <p class="mt-1 text-sm text-gray-400">{{ $portfolio->alamat }}</p>
                        @endif
                    </div>
                    @if ($portfolio->maps_embed_url)
                        <div class="overflow-hidden rounded-3xl border border-white/10 aspect-video max-h-96 bg-gray-900">
                            <iframe src="{{ $portfolio->maps_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- ── CTA BANNER ──────────────────────────────────── -->
        @if ($waLink)
            <section class="relative overflow-hidden py-20">
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-purple-900 via-gray-950 to-pink-900 opacity-90"></div>
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(168,85,247,0.18),transparent_70%)]"></div>
                <div class="relative mx-auto max-w-3xl px-5 text-center space-y-4">
                    <h2 class="text-2xl font-extrabold text-white sm:text-4xl">Siap Memulai Bersama Kami?</h2>
                    <p class="mx-auto max-w-lg text-sm sm:text-base leading-relaxed text-gray-300">
                        Hubungi tim kami dan dapatkan konsultasi terbaik untuk mewujudkan kebutuhan Anda secara profesional.
                    </p>
                    <div class="pt-3">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-3.5 text-sm font-semibold text-white shadow-xl shadow-purple-900/50">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                            <span>Chat via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </main>

    <!-- ── FOOTER ──────────────────────────────────────── -->
    <footer class="border-t border-white/10 bg-gray-950 py-8">
        <div class="mx-auto max-w-6xl px-5 text-center">
            <p class="text-sm font-bold text-white">{{ $nama }}</p>
            <p class="mt-1 text-xs text-gray-500">&copy; {{ date('Y') }} &bull; Professional Service</p>
        </div>
    </footer>

    <!-- ── FLOATING WHATSAPP ───────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp"
           class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-green-500/30">
            <svg class="h-7 w-7 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
        </a>
    @endif
</div>
@endsection
