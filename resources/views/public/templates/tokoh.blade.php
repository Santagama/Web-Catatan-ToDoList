{{--
  ==============================================================================
  TEMPLATE PUBLIK: TOKOH PUBLIK, CALEG & KAMPANYE ASPIRASI
  ==============================================================================
  - Desain bertema resmi merah-putih dengan aksen emas dan navy.
  - str_pad($idx + 1, 2, '0', STR_PAD_LEFT): Memberi format nomor urut 2 digit (01, 02, ...)
    pada setiap kartu Program Kerja secara otomatis.
  - Google Maps Embed: Menampilkan lokasi posko/kantor sekretariat jika URL diisi.
--}}
@extends('layouts.app')

@section('title', ($portfolio->business_name ?? 'Tokoh Publik') . ' — ' . ($portfolio->bio ?? 'Profil Resmi & Aspirasi'))
@section('body_class', 'bg-white text-gray-900 min-h-screen antialiased flex flex-col justify-between selection:bg-red-700 selection:text-white')

@section('content')
@php
    $RED = '#c0172d';
    $GOLD = '#c8972a';
    $DARK = '#1a1a2e';

    $waNumber = preg_replace('/[^0-9]/', '', $portfolio->whatsapp ?? '');
    $waLink = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo Tim ' . $portfolio->business_name . ', saya ingin menyampaikan aspirasi dan dukungan.') : null;
    $nama = $portfolio->business_name ?? 'Figur Publik';
    $products = $portfolio->products ?? [];
@endphp

<div class="min-h-screen bg-white font-sans text-gray-800">

    <!-- ── TOP STRIP MERAH PUTIH ─────────────────────────────── -->
    <div style="height: 4px; background: linear-gradient(90deg, #c0172d 50%, #ffffff 50%);"></div>

    <!-- ── HEADER STICKY ──────────────────────────────────────── -->
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 shadow-xs backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-5 py-3">
            <div class="flex min-w-0 items-center gap-3">
                @if ($portfolio->logo_path)
                    <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-11 w-11 shrink-0 rounded-full object-cover ring-2 ring-[#c0172d]" />
                @else
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-sm font-black text-white shadow-sm" style="background-color: #c0172d;">
                        {{ substr($nama, 0, 1) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-gray-900">{{ $nama }}</p>
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-[#c0172d]">Aspirasi & Dedikasi</p>
                </div>
            </div>

            <nav class="hidden items-center gap-6 text-sm font-medium text-gray-600 md:flex">
                <a href="#program" class="">Program</a>
                <a href="#profil" class="">Profil</a>
                @if ($portfolio->maps_embed_url || $portfolio->alamat)
                    <a href="#lokasi" class="">Posko / Kantor</a>
                @endif
                <a href="#dukung" class="">Dukungan</a>
            </nav>

            @if ($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex shrink-0 items-center gap-2 rounded-xl px-4 py-2 text-xs font-semibold text-white shadow-md"
                   style="background-color: #c0172d; box-shadow: 0 4px 14px rgba(192, 23, 45, 0.35);">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                    <span class="hidden sm:inline">Hubungi Tim Kampanye</span>
                    <span class="sm:hidden">Kontak Tim</span>
                </a>
            @endif
        </div>
    </header>

    <main>
        <!-- ── HERO SECTION ──────────────────────────────────────── -->
        <section class="relative overflow-hidden" style="background-color: #1a1a2e;">
            <!-- Pattern Bendera Diagonal Halus -->
            <div class="pointer-events-none absolute inset-0 opacity-5"
                 style="background-image: repeating-linear-gradient(45deg, #c0172d 0px, #c0172d 2px, transparent 2px, transparent 22px);"></div>

            <!-- Glow Merah & Gold -->
            <div class="pointer-events-none absolute -right-32 top-0 h-96 w-96 rounded-full blur-[110px]" style="background: rgba(192, 23, 45, 0.35);"></div>
            <div class="pointer-events-none absolute -bottom-24 left-0 h-72 w-72 rounded-full blur-[90px]" style="background: rgba(200, 151, 42, 0.25);"></div>

            <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-5 py-14 md:py-20 lg:grid-cols-[1fr_420px]">
                <!-- Sisi Kiri: Narasi & Aspirasi -->
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2.5 rounded-full border px-4 py-1.5 text-xs font-semibold"
                         style="border-color: rgba(200, 151, 42, 0.5); background-color: rgba(200, 151, 42, 0.15); color: #c8972a;">
                        <span class="h-1.5 w-1.5 rounded-full" style="background-color: #c8972a;"></span>
                        <span>Profil Resmi & Rekam Jejak</span>
                    </div>

                    <h1 class="text-3xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl">
                        {{ $nama }}
                    </h1>

                    @if ($portfolio->bio)
                        <p class="max-w-lg text-base leading-relaxed text-gray-300">
                            {{ $portfolio->bio }}
                        </p>
                    @else
                        <p class="max-w-lg text-base leading-relaxed italic text-gray-400">
                            "Berdedikasi mengabdi dengan integritas, menghadirkan karya nyata demi kemajuan dan kesejahteraan bersama."
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl px-6 py-3.5 text-sm font-semibold text-white shadow-xl"
                               style="background-color: #c0172d; box-shadow: 0 10px 25px rgba(192, 23, 45, 0.4);">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                <span>Hubungi Tim Aspirasi</span>
                            </a>
                        @endif
                        <a href="#program"
                           class="inline-flex items-center gap-2 rounded-xl border px-6 py-3.5 text-sm font-semibold text-white"
                           style="border-color: rgba(200, 151, 42, 0.6);">
                            <span>Lihat Agenda Program</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                    </div>

                    <!-- 3 Micro Stats -->
                    <div class="grid grid-cols-3 gap-3 border-t pt-6" style="border-color: rgba(255, 255, 255, 0.1);">
                        <div class="text-center">
                            <p class="text-2xl font-black text-white">{{ count($products) > 0 ? count($products) : '05+' }}</p>
                            <p class="mt-1 text-[10px] uppercase tracking-widest text-gray-400">Program Kerja</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-black text-[#c8972a]">Nyata</p>
                            <p class="mt-1 text-[10px] uppercase tracking-widest text-gray-400">Komitmen</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-black text-white">Rakyat</p>
                            <p class="mt-1 text-[10px] uppercase tracking-widest text-gray-400">Prioritas</p>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Foto Profil Berbingkai Emas -->
                <div class="relative flex justify-center">
                    <div class="absolute inset-0 rounded-full opacity-20 blur-3xl" style="background-color: #c0172d;"></div>

                    <div class="relative w-full max-w-[360px]">
                        <div class="relative overflow-hidden rounded-3xl border-2 p-1.5 shadow-2xl" style="border-color: #c8972a;">
                            @if ($portfolio->banner_path)
                                <img src="{{ Storage::url($portfolio->banner_path) }}" alt="{{ $nama }}" class="h-[360px] w-full rounded-2xl object-cover sm:h-[420px]" />
                            @elseif ($portfolio->logo_path)
                                <img src="{{ Storage::url($portfolio->logo_path) }}" alt="{{ $nama }}" class="h-[360px] w-full rounded-2xl object-cover sm:h-[420px]" />
                            @else
                                <div class="flex h-[360px] w-full flex-col items-center justify-center rounded-2xl sm:h-[420px]"
                                     style="background: linear-gradient(135deg, #c0172d 0%, #1a1a2e 70%);">
                                    <div class="space-y-4 px-8 text-center">
                                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-white/10 text-4xl font-black text-white ring-2" style="border-color: #c8972a;">
                                            {{ substr($nama, 0, 1) }}
                                        </div>
                                        <p class="text-xl font-bold text-white">{{ $nama }}</p>
                                        <p class="text-xs uppercase tracking-wider" style="color: #c8972a;">Profil Resmi Terverifikasi</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Overlay Badge Gold/Navy -->
                            <div class="absolute bottom-4 left-4 right-4 rounded-xl px-4 py-3 backdrop-blur-md shadow-lg"
                                 style="background: rgba(26, 26, 46, 0.9); border: 1px solid rgba(200, 151, 42, 0.4);">
                                <p class="text-[9px] font-bold uppercase tracking-widest" style="color: #c8972a;">Profil Tokoh Terpercaya</p>
                                <p class="text-sm font-extrabold text-white truncate">{{ $nama }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── PROFIL & VISI MISI ──────────────────────────────── -->
        <section id="profil" class="py-16 md:py-24 bg-white">
            <div class="mx-auto max-w-6xl px-5">
                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-xl">
                    <div class="grid lg:grid-cols-[1fr_380px]">
                        <!-- Kolom Kiri: Visi & Gagasan -->
                        <div class="p-8 md:p-12 space-y-6">
                            <div class="flex items-center gap-2">
                                <div class="h-6 w-1.5 rounded-full" style="background-color: #c0172d;"></div>
                                <span class="text-xs font-bold uppercase tracking-widest" style="color: #c0172d;">Profil & Visi Misi</span>
                            </div>

                            <h2 class="text-2xl font-black text-gray-900 sm:text-3xl">Mengenal Lebih Dekat {{ $nama }}</h2>

                            @if ($portfolio->bio)
                                <div class="prose max-w-none text-sm leading-relaxed text-gray-600 space-y-3">
                                    <p class="text-base text-gray-700 font-medium leading-relaxed">{{ $portfolio->bio }}</p>
                                    <p class="text-gray-500">
                                        Komitmen pelayanan kami berpijak pada aspirasi masyarakat. Melalui transparansi, kerja terencana, dan komunikasi terbuka, kami bertekad memperjuangkan kebijakan serta inisiatif yang membawa kemaslahatan publik secara nyata dan berkelanjutan.
                                    </p>
                                </div>
                            @else
                                <p class="text-sm leading-relaxed text-gray-600">
                                    Profil publik resmi ini didedikasikan untuk transparansi informasi, pemaparan agenda pengabdian, serta kanal langsung bagi warga dan relawan untuk menyampaikan saran, ide, dan aspirasi pembangunan lingkungan secara konstruktif.
                                </p>
                            @endif

                            @if ($waLink)
                                <div class="pt-2">
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold text-white shadow-md"
                                       style="background-color: #c0172d;">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                                        <span>Sampaikan Masukan ke Tim</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Kanan: 5 Nilai Utama -->
                        <div class="flex flex-col justify-center gap-4 p-8 md:p-10 text-white" style="background-color: #1a1a2e;">
                            <div class="mb-2">
                                <p class="text-xs font-bold uppercase tracking-widest" style="color: #c8972a;">Landasan Pengabdian</p>
                                <h3 class="text-lg font-extrabold text-white">5 Nilai Perjuangan</h3>
                            </div>

                            @php
                                $nilaiUtama = [
                                    ['title' => 'Integritas Tinggi', 'desc' => 'Menjunjung kejujuran dan moralitas dalam setiap langkah tindakan.'],
                                    ['title' => 'Amanah & Bertanggung Jawab', 'desc' => 'Menjalankan mandat warga dengan kesungguhan hati.'],
                                    ['title' => 'Peduli & Membumi', 'desc' => 'Hadir langsung di tengah persoalan nyata masyarakat.'],
                                    ['title' => 'Inovatif & Solutif', 'desc' => 'Merumuskan solusi cerdas berbasis kebutuhan riil.'],
                                    ['title' => 'Transparan & Terbuka', 'desc' => 'Keterbukaan informasi dan pertanggungjawaban terukur.'],
                                ];
                            @endphp

                            <div class="space-y-3.5">
                                @foreach ($nilaiUtama as $idx => $item)
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-xs font-black text-white shadow-xs" style="background-color: #c0172d;">
                                            {{ $idx + 1 }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $item['title'] }}</p>
                                            <p class="text-[11px] text-gray-400 leading-snug">{{ $item['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── PROGRAM KERJA / KATALOG AGENDA ───────────────────── -->
        <section id="program" class="py-16 md:py-24" style="background-color: #f8fafc;">
            <div class="mx-auto max-w-6xl px-5">
                <div class="mb-12">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="h-6 w-1.5 rounded-full" style="background-color: #c0172d;"></div>
                        <p class="text-xs font-bold uppercase tracking-widest" style="color: #c0172d;">Agenda & Aksi Konkret</p>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 sm:text-3xl md:text-4xl">Program Kerja Unggulan</h2>
                    <p class="mt-2 text-sm text-gray-600">Komitmen rencana aksi strategis demi kemajuan bersama</p>
                </div>

                @if (count($products) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $idx => $item)
                            <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                <div>
                                    <!-- Header Nomor & Judul -->
                                    <div class="flex items-start gap-4 p-6">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-black text-white shadow-sm" style="background-color: #c0172d;">
                                            {{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-base font-bold text-gray-900 leading-snug">
                                                {{ $item['name'] ?? $item['judul'] ?? 'Program Kerja ' . ($idx + 1) }}
                                            </h3>
                                            @if (!empty($item['description'] ?? $item['deskripsi'] ?? ''))
                                                <p class="mt-2 text-xs leading-relaxed text-gray-600">
                                                    {{ $item['description'] ?? $item['deskripsi'] }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Foto Program jika ada -->
                                    @if (!empty($item['image'] ?? $item['foto'] ?? null))
                                        <div class="aspect-16/8 overflow-hidden bg-gray-100 border-y border-gray-100">
                                            <img src="{{ Storage::url($item['image'] ?? $item['foto']) }}"
                                                 alt="{{ $item['name'] ?? $item['judul'] ?? 'Program' }}"
                                                 class="h-full w-full object-cover" />
                                        </div>
                                    @endif
                                </div>

                                <!-- Footer Card -->
                                <div class="p-6 pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Prioritas Terjadwal</span>
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Tim ' . $nama . ', saya ingin bertanya mengenai program: ' . ($item['name'] ?? $item['judul'] ?? 'Program')) }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#c0172d]">
                                            <span>Dukung Program</span>
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback 3 Program Kerja Default jika belum ada katalog diisi -->
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl text-sm font-black text-white" style="background-color: #c0172d;">01</div>
                            <h3 class="mt-4 text-base font-bold text-gray-900">Pemberdayaan Ekonomi Warga</h3>
                            <p class="mt-2 text-xs leading-relaxed text-gray-600">Pelatihan keterampilan praktis UMKM, akses permodalan bergulir, dan pendampingan pemasaran produk lokal.</p>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl text-sm font-black text-white" style="background-color: #c0172d;">02</div>
                            <h3 class="mt-4 text-base font-bold text-gray-900">Kesehatan & Fasilitas Ramah Lansia</h3>
                            <p class="mt-2 text-xs leading-relaxed text-gray-600">Penyuluhan posyandu terintegrasi, bantuan kesehatan jemput bola, dan jaminan nutrisi ibu dan balita.</p>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl text-sm font-black text-white" style="background-color: #c0172d;">03</div>
                            <h3 class="mt-4 text-base font-bold text-gray-900">Kanal Aspirasi Digital Warga</h3>
                            <p class="mt-2 text-xs leading-relaxed text-gray-600">Layanan pengaduan tanggap cepat via WhatsApp agar persoalan lingkungan langsung terpantau dan terselesaikan.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- ── POSKO & LOKASI KANTOR ────────────────────────────── -->
        @if ($portfolio->maps_embed_url || $portfolio->alamat)
            <section id="lokasi" class="py-16 md:py-20 bg-white border-t border-gray-100">
                <div class="mx-auto max-w-6xl px-5">
                    <div class="mb-10 text-center">
                        <p class="text-xs font-bold uppercase tracking-widest" style="color: #c0172d;">Sekretariat & Posko</p>
                        <h2 class="mt-2 text-2xl font-black text-gray-900 sm:text-3xl">Pusat Informasi & Koordinasi</h2>
                        <p class="mt-2 text-sm text-gray-600">Pintu kami selalu terbuka untuk silaturahmi dan dialog warga</p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-lg">
                        <div class="grid lg:grid-cols-[380px_1fr]">
                            <div class="p-8 space-y-5 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold text-white" style="background-color: #1a1a2e;">
                                        <span>📍 Posko Utama</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $nama }}</h3>
                                    @if ($portfolio->alamat)
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $portfolio->alamat }}</p>
                                    @endif
                                </div>

                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-xs font-bold text-white shadow-md"
                                       style="background-color: #c0172d;">
                                        <span>Petunjuk Arah & Konfirmasi Silaturahmi</span>
                                    </a>
                                @endif
                            </div>

                            <div class="min-h-[300px] bg-gray-100">
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

        <!-- ── DUKUNGAN & AJAKAN ─────────────────────────────────── -->
        <section id="dukung" class="relative overflow-hidden py-20" style="background-color: #1a1a2e;">
            <div class="pointer-events-none absolute inset-0 opacity-15"
                 style="background-image: radial-gradient(circle at 25% 50%, #c0172d, transparent 65%), radial-gradient(circle at 75% 50%, #c8972a, transparent 55%);"></div>

            <div class="relative mx-auto max-w-3xl px-5 text-center space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full border px-4 py-1.5 text-xs font-semibold"
                     style="border-color: rgba(200, 151, 42, 0.5); color: #c8972a;">
                    <span>Bersatu Untuk Kebaikan</span>
                </div>

                <h2 class="text-3xl font-extrabold text-white sm:text-4xl md:text-5xl leading-tight">
                    Bersama Wujudkan<br /><span style="color: #c8972a;">Perubahan Nyata</span>
                </h2>

                <p class="mx-auto max-w-xl text-sm leading-relaxed text-gray-300">
                    Dukungan, doa, dan masukan Anda adalah energi terbesar bagi langkah pengabdian ini. Mari bersinergi dan bergotong-royong membangun masa depan yang berkeadilan.
                </p>

                @if ($waLink)
                    <div class="pt-4 flex flex-wrap justify-center gap-4">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2.5 rounded-xl px-8 py-4 text-sm font-bold text-white shadow-2xl"
                           style="background-color: #c0172d; box-shadow: 0 10px 30px rgba(192, 23, 45, 0.5);">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
                            <span>Bergabung / Sampaikan Dukungan via WA</span>
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- ── FOOTER RESMI ───────────────────────────────────────── -->
    <footer class="py-8 text-center text-xs text-gray-400" style="background-color: #1a1a2e; border-top: 1px solid rgba(255,255,255,0.08);">
        <div class="mx-auto max-w-6xl px-5 space-y-2">
            <p class="font-bold text-white">{{ $nama }} &bull; Saluran Aspirasi & Informasi Resmi</p>
            <p>&copy; 2026 Hanan Aria Santagama | XII RPL 1</p>
        </div>
    </footer>

    <!-- ── FLOATING WHATSAPP BUTTON ──────────────────────────── -->
    @if ($waLink)
        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 rounded-full bg-[#25D366] px-5 py-3 text-xs font-bold text-white shadow-2xl"
           style="box-shadow: 0 8px 25px rgba(37, 211, 102, 0.45);">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.17-3.12.82.83-3.04-.2-.32a8.188 8.188 0 01-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.14.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.46-.01z"/></svg>
            <span>Kirim Aspirasi</span>
        </a>
    @endif

</div>
@endsection
