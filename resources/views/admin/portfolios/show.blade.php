@extends('layouts.admin')

@section('title', 'Detail Portofolio: ' . $portfolio->nama_umkm)
@section('page_title', 'Detail Portofolio')

@section('content')
{{--
  ==============================================================================
  DETAIL PORTOFOLIO KLIEN UMKM
  ==============================================================================
  Menyajikan informasi komprehensif profil UMKM, katalog produk, status paket,
  media gambar, riwayat pengalihan slug 301, dan fitur perpanjang masa aktif.
--}}
<div class="space-y-6 sm:space-y-8 max-w-6xl">

    <!-- ================= HEADER ATAS & TOMBOL AKSI ================= -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800">
        <div class="space-y-2">
            <div class="flex flex-wrap items-center gap-3">
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">{{ $portfolio->nama_umkm }}</h2>
                @if ($portfolio->status === 'publish' && !$portfolio->isExpired())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-500/15 text-teal-400 text-xs font-bold border border-teal-500/30">
                        <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                        Publish
                    </span>
                @elseif ($portfolio->isExpired())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-500/15 text-rose-400 text-xs font-bold border border-rose-500/30">
                        Expired
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-zinc-800 text-zinc-400 text-xs font-bold border border-zinc-700">
                        Draft
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-zinc-400 flex flex-wrap items-center gap-2">
                <span class="font-mono text-teal-400 font-semibold">{{ url($portfolio->slug) }}</span>
                <span>&bull;</span>
                <span class="capitalize">Template: <strong class="text-zinc-200">{{ $portfolio->template_id }}</strong></span>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Tombol Buka Web Publik -->
            <a href="{{ route('portfolio.public', $portfolio->slug) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#101116] text-zinc-200 text-xs font-bold border border-zinc-800">
                <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Lihat Web
            </a>

            <!-- Tombol Salin Link (Clipboard API) -->
            <button type="button" onclick="navigator.clipboard.writeText('{{ url($portfolio->slug) }}'); this.innerText='Tersalin!'; setTimeout(() => this.innerText='Salin URL', 2000)"
                    class="px-4 py-2.5 rounded-xl bg-[#101116] text-zinc-200 text-xs font-bold border border-zinc-800 cursor-pointer">
                Salin URL
            </button>

            {{--
              // UBAH WARNA TOMBOL 'PERPANJANG PAKET':
              // Ganti 'bg-teal-600 shadow-teal-950/40' jadi 'bg-blue-600 shadow-blue-950/40' (biru)
            --}}
            <!-- Tombol Perpanjang Paket (Buka Modal) -->
            <button type="button" onclick="document.getElementById('modal-extend').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 text-white text-xs font-bold shadow-md shadow-teal-950/40 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Perpanjang Paket
            </button>

            <!-- Tombol Edit -->
            <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-amber-600 text-white text-xs font-bold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>

            <!-- Tombol Hapus -->
            <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST"

                  {{-- // TEMPAT KODE POPUP KONFIRMASI HAPUS DETAIL PORTOFOLIO DI SINI // --}}

            >
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-950/80 text-rose-400 border border-rose-800/60 text-xs font-bold cursor-pointer">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- ================= GRID INFORMASI UTAMA ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

        <!-- SISI KIRI (2 Kolom): Detail Usaha & Katalog Produk -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card 1: Profil Usaha -->
            <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-5">
                <h3 class="text-base font-bold text-white pb-3 border-b border-zinc-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Profil &amp; Kontak Usaha
                </h3>

                <div>
                    <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-1.5">Deskripsi / Bio</span>
                    <p class="text-sm text-zinc-200 leading-relaxed font-medium">{{ $portfolio->bio ?? 'Belum ada deskripsi profil.' }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-1.5">Alamat Fisik</span>
                        <p class="text-sm text-zinc-200 font-medium">{{ $portfolio->alamat ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-1.5">Kontak WhatsApp</span>
                        @if ($portfolio->whatsapp)
                            {{-- preg_replace untuk sanitasi nomor WA ke format wa.me --}}
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $portfolio->whatsapp) }}" target="_blank"
                               class="text-sm text-teal-400 font-mono font-bold flex items-center gap-1.5">
                                {{ $portfolio->whatsapp }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @else
                            <p class="text-sm text-zinc-500">Belum diisi</p>
                        @endif
                    </div>
                    <div>
                        <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-1.5">Akun Instagram</span>
                        @if ($portfolio->instagram)
                            <a href="{{ $portfolio->instagram_url }}" target="_blank"
                               class="text-sm text-pink-400 font-mono font-bold flex items-center gap-1.5">
                                {{ $portfolio->instagram }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @else
                            <p class="text-sm text-zinc-500">Belum diisi</p>
                        @endif
                    </div>
                </div>

                <!-- Google Maps Embed -->
                @if ($portfolio->maps_embed_url)
                    <div class="pt-3">
                        <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-2.5">Lokasi Peta Google Maps</span>
                        <div class="rounded-2xl overflow-hidden border border-zinc-800 aspect-video max-h-64 bg-[#101116]">
                            <iframe src="{{ $portfolio->maps_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Card 2: Katalog Produk / Layanan -->
            <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Katalog Produk &amp; Layanan
                    </h3>
                    <span class="text-xs px-3 py-1 rounded-full bg-teal-500/15 text-teal-400 font-bold border border-teal-500/30">
                        {{ count($portfolio->products ?? []) }} Produk Terdaftar
                    </span>
                </div>

                @if (!empty($portfolio->products) && count($portfolio->products) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($portfolio->products as $item)
                            <div class="p-4 rounded-2xl bg-[#101116] border border-zinc-800 flex gap-3.5">
                                @if (!empty($item['image']))
                                    <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}"
                                         class="w-16 h-16 rounded-xl object-cover shrink-0 border border-zinc-700" />
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-[#14151a] border border-zinc-800 flex items-center justify-center shrink-0 text-zinc-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs font-bold text-teal-400 mt-1">
                                        {{ !empty($item['price']) && $item['price'] > 0 ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Gratis / Menyesuaikan' }}
                                    </p>
                                    @if (!empty($item['description']))
                                        <p class="text-xs text-zinc-400 mt-1.5 line-clamp-2">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-400 py-6 text-center">Belum ada produk atau layanan yang ditambahkan.</p>
                @endif
            </div>

        </div>

        <!-- SISI KANAN (1 Kolom): Status Paket, Media, & Riwayat Slug -->
        <div class="space-y-6">

            <!-- Card 3: Info Paket & Masa Aktif -->
            <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-4">
                <h3 class="text-base font-bold text-white pb-3 border-b border-zinc-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Informasi Paket
                </h3>

                <div class="space-y-3.5 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-400">Jenis Paket:</span>
                        <span class="font-bold text-white capitalize">{{ str_replace('_', ' ', $portfolio->paket ?? 'Belum diatur') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-zinc-400">Berakhir Pada:</span>
                        <span class="font-mono text-zinc-200 font-semibold">
                            {{ $portfolio->expired_at ? $portfolio->expired_at->format('d M Y, H:i') : 'Unlimited' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-zinc-400">Sisa Masa Aktif:</span>
                        @if ($portfolio->expired_at === null)
                            <span class="text-teal-400 font-bold">Unlimited</span>
                        @elseif ($portfolio->isExpired())
                            <span class="text-rose-400 font-bold">Expired</span>
                        @else
                            <span class="text-teal-400 font-bold">{{ $portfolio->remainingDays() }} Hari Lagi</span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-zinc-800">
                        <span class="text-zinc-500 text-xs">Dibuat Pada:</span>
                        <span class="text-zinc-400 text-xs font-medium">{{ $portfolio->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Gambar Logo & Banner -->
            <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-4">
                <h3 class="text-base font-bold text-white pb-3 border-b border-zinc-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Media Gambar
                </h3>

                <!-- Logo -->
                <div>
                    <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-2">Logo Usaha</span>
                    @if ($portfolio->logo_path)
                        <img src="{{ Storage::url($portfolio->logo_path) }}" alt="Logo" class="w-20 h-20 rounded-2xl object-cover border border-zinc-700 shadow-md" />
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-[#101116] border border-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            Tidak Ada
                        </div>
                    @endif
                </div>

                <!-- Banner -->
                <div>
                    <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider block mb-2">Banner / Cover</span>
                    @if ($portfolio->banner_path)
                        <img src="{{ Storage::url($portfolio->banner_path) }}" alt="Banner" class="w-full h-28 rounded-2xl object-cover border border-zinc-700 shadow-md" />
                    @else
                        <div class="w-full h-28 rounded-2xl bg-[#101116] border border-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            Tidak Ada Banner
                        </div>
                    @endif
                </div>
            </div>

            {{--
              Card 5: Riwayat Perubahan Slug (SEO 301 Permanent Redirect)
              Saat admin mengubah slug, rekam jejak lama disimpan di tabel slug_histories.
              Ketika ada orang mengakses tautan lama, sistem otomatis redirect 301 ke slug baru.
            --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                    <h3 class="text-base font-bold text-white">Riwayat Pengalihan Slug</h3>
                    <span class="text-xs px-2.5 py-0.5 rounded-md bg-teal-500/15 text-teal-400 border border-teal-500/30 font-bold">SEO 301</span>
                </div>

                @if ($portfolio->slugHistories->count() > 0)
                    <div class="space-y-2.5 text-xs">
                        @foreach ($portfolio->slugHistories as $hist)
                            <div class="p-3 rounded-xl bg-[#101116] border border-zinc-800">
                                <div class="flex items-center gap-1.5 font-mono">
                                    <span class="text-rose-400 line-through">/{{ $hist->slug_lama }}</span>
                                    <span class="text-zinc-500">&rarr;</span>
                                    <span class="text-teal-400 font-bold">/{{ $hist->slug_baru }}</span>
                                </div>
                                <span class="text-[11px] text-zinc-400 block mt-1.5">{{ $hist->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-zinc-400 leading-relaxed">Belum ada riwayat perubahan slug. Slug masih original.</p>
                @endif
            </div>

        </div>

    </div>

</div>

<!-- ================= MODAL PERPANJANG PAKET ================= -->
<div id="modal-extend" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 hidden">
    <div class="w-full max-w-md rounded-3xl bg-[#18191f] border border-zinc-800 p-6 sm:p-8 shadow-2xl relative">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-800">
            <h3 class="text-base font-bold text-white">Perpanjang Masa Aktif Paket</h3>
            <button type="button" onclick="document.getElementById('modal-extend').classList.add('hidden')"
                    class="text-zinc-400 text-xl leading-none p-1 cursor-pointer">&times;</button>
        </div>

        <form action="{{ route('admin.portfolios.extend', $portfolio->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <p class="text-xs text-zinc-300 leading-relaxed">
                Pilih durasi paket baru untuk memperpanjang masa aktif portofolio <strong class="text-white">{{ $portfolio->nama_umkm }}</strong>. Status otomatis diperbarui menjadi <em class="text-teal-400 font-semibold not-italic">Publish</em>.
            </p>

            <div>
                <label class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2.5">Pilih Durasi Tambahan:</label>
                <div class="space-y-2.5">
                    <label class="flex items-center gap-3.5 p-3.5 rounded-2xl border border-zinc-800 bg-[#101116] cursor-pointer">
                        <input type="radio" name="paket" value="3_bulan" checked class="text-teal-500 focus:ring-teal-500" />
                        <div>
                            <p class="text-sm font-bold text-white">Paket 3 Bulan</p>
                            <p class="text-xs text-zinc-400">Masa aktif bertambah 90 hari</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3.5 p-3.5 rounded-2xl border border-zinc-800 bg-[#101116] cursor-pointer">
                        <input type="radio" name="paket" value="1_tahun" class="text-teal-500 focus:ring-teal-500" />
                        <div>
                            <p class="text-sm font-bold text-white">Paket 1 Tahun (12 Bulan)</p>
                            <p class="text-xs text-zinc-400">Masa aktif bertambah 365 hari penuh</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-800">
                <button type="button" onclick="document.getElementById('modal-extend').classList.add('hidden')"
                        class="px-5 py-2.5 rounded-xl bg-zinc-800 text-zinc-300 text-xs font-bold cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-teal-600 text-white text-xs font-bold shadow-md shadow-teal-950/40 cursor-pointer">
                    Konfirmasi Perpanjangan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
