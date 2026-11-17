@extends('layouts.admin')

@section('title', 'Buat Web Portofolio Baru')
@section('page_title', 'Buat Web Baru')

@section('content')
{{--
  ==============================================================================
  FORM TAMBAH PORTOFOLIO KLIEN UMKM
  ==============================================================================
  - enctype="multipart/form-data": Wajib disertakan agar form dapat mengirim berkas
    gambar (logo, banner, foto produk) dalam format multipart binary ke server.
  - @csrf: Token pengaman transaksi form bawaan Laravel.
--}}
<div class="space-y-6 sm:space-y-8 max-w-5xl">

    <!-- ================= HEADER SECTION & TAB SWITCHER ================= -->
    <div class="space-y-5">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Buat Web Baru</h1>
            <p class="text-xs sm:text-sm text-zinc-400 mt-1 font-medium">Buat website portofolio klien UMKM baru dalam hitungan detik.</p>
        </div>

        <!-- Tab Switcher (Daftar Website / Buat Web Baru) -->
        <div class="grid grid-cols-2 p-1.5 rounded-2xl bg-[#101116] border border-zinc-800 gap-1.5">
            <a href="{{ route('admin.portfolios.index') }}"
               class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-zinc-400 text-xs sm:text-sm font-bold">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                <span>Daftar Website</span>
            </a>
            <a href="{{ route('admin.portfolios.create') }}"
               class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-teal-500/15 text-teal-300 border border-teal-500/30 text-xs sm:text-sm font-bold shadow-xs">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                <span>Buat Web Baru</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
    @csrf

    <!-- ================= SECTION 1: PILIHAN TEMPLATE ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-4">
        <div>
            <h3 class="text-base font-bold text-white mb-1">Pilih Template Visual</h3>
            <p class="text-xs sm:text-sm text-zinc-400">Template menentukan tata letak dan konsep visual halaman publik klien.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 pt-2">
            @foreach ($templates as $key => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="template_id" value="{{ $key }}"
                        {{ old('template_id') === $key ? 'checked' : '' }}
                        class="hidden peer" />
                    {{--
                      // UBAH WARNA SELEKSI TEMPLATE:
                      // Ganti 'peer-checked:border-teal-500 peer-checked:bg-teal-500/15' jadi 'peer-checked:border-blue-500 peer-checked:bg-blue-500/15' (biru)
                    --}}
                    <div class="p-4 sm:p-5 rounded-2xl border-2 text-center
                        peer-checked:border-teal-500 peer-checked:bg-teal-500/15
                        border-zinc-800 bg-[#101116]">
                        <p class="text-xs sm:text-sm font-bold text-white capitalize">{{ $key }}</p>
                        <p class="text-[10px] text-zinc-400 mt-1 line-clamp-1">{{ $label }}</p>
                    </div>
                </label>
            @endforeach
        </div>
        @error('template_id')
            <p class="mt-2 text-xs text-rose-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- ================= SECTION 2: DATA PROFIL USAHA ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-5">
        <div>
            <h3 class="text-base font-bold text-white mb-1">Profil Usaha UMKM</h3>
            <p class="text-xs sm:text-sm text-zinc-400">Informasi identitas brand dan kontak yang akan dipajang di web publik.</p>
        </div>

        <!-- Nama UMKM -->
        <div>
            <label for="nama_umkm" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Nama UMKM <span class="text-rose-400">*</span></label>
            <input type="text" name="nama_umkm" id="nama_umkm" value="{{ old('nama_umkm') }}" required
                placeholder="Contoh: Kedai Kopi Senja Nusantara"
                class="w-full px-4 py-3 rounded-xl bg-[#101116] border @error('nama_umkm') border-rose-500 @else border-zinc-800 @enderror text-white placeholder-zinc-500 text-sm outline-none font-medium" />
            @error('nama_umkm')
                <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug URL (Auto-Generate dari Nama Usaha) -->
        <div>
            <label for="slug" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Slug URL Resmi <span class="text-rose-400">*</span></label>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <span class="px-4 py-3 rounded-xl bg-[#14151a] border border-zinc-800 text-xs font-mono text-zinc-400 shrink-0 select-none">{{ url('/') }}/</span>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                    placeholder="kopi-senja-nusantara"
                    class="flex-1 px-4 py-3 rounded-xl bg-[#101116] border @error('slug') border-rose-500 @else border-zinc-800 @enderror text-teal-400 placeholder-zinc-500 text-sm font-mono outline-none font-bold" />
            </div>
            <p class="mt-1.5 text-xs text-zinc-400" id="slug-feedback">Slug otomatis digenerate dan menjadi alamat web resmi.</p>
            @error('slug')
                <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bio / Deskripsi Usaha -->
        <div>
            <label for="bio" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Deskripsi / Bio Usaha</label>
            <textarea name="bio" id="bio" rows="3" placeholder="Ceritakan tentang keunggulan produk dan kisah usaha Anda..."
                class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white placeholder-zinc-500 text-sm outline-none resize-none font-medium leading-relaxed">{{ old('bio') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- WhatsApp -->
            <div>
                <label for="whatsapp" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Nomor WhatsApp Usaha <span class="text-rose-400">*</span></label>
                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="081234567890"
                    class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white placeholder-zinc-500 text-sm outline-none font-medium" />
            </div>

            <!-- Instagram -->
            <div>
                <label for="instagram" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Akun Instagram Usaha</label>
                <input type="text" name="instagram" id="instagram" value="{{ old('instagram') }}" placeholder="@namatoko atau namatoko"
                    class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white placeholder-zinc-500 text-sm outline-none font-medium" />
            </div>
        </div>

        <!-- Alamat Fisik -->
        <div>
            <label for="alamat" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Alamat Fisik Toko</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Jl. Raya No. 123, Majalengka"
                class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white placeholder-zinc-500 text-sm outline-none font-medium" />
        </div>

        <!-- Google Maps Embed -->
        <div>
            <label for="maps_embed_url" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Google Maps Embed (URL atau Tag Iframe)</label>
            <input type="text" name="maps_embed_url" id="maps_embed_url" value="{{ old('maps_embed_url') }}" placeholder="Paste link embed atau seluruh tag <iframe src='...'> dari Google Maps"
                class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white placeholder-zinc-500 text-sm outline-none font-mono text-xs" />
            <p class="text-[11px] text-zinc-400 mt-1.5">Bisa paste langsung link embed maupun seluruh kode <code class="text-teal-400">&lt;iframe src="..."&gt;</code> dari Google Maps (Bagikan &gt; Sematkan peta). Sistem otomatis mengekstrak URL aslinya.</p>
        </div>
    </div>

    <!-- ================= SECTION 3: UPLOAD GAMBAR ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-5">
        <div>
            <h3 class="text-base font-bold text-white mb-1">Gambar Logo & Banner</h3>
            <p class="text-xs sm:text-sm text-zinc-400">Format gambar JPG, PNG, atau WEBP.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Logo -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-zinc-300 uppercase tracking-wider">Logo Usaha <span class="text-zinc-500">(Max 2MB)</span></label>
                <input type="file" name="logo" accept="image/jpeg,image/png,image/webp"
                    onchange="previewImage(this, 'preview-logo')"
                    class="w-full text-xs text-zinc-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-zinc-800 file:text-zinc-200 file:font-semibold file:text-xs file:cursor-pointer cursor-pointer" />
                <div id="preview-logo" class="hidden">
                    <p class="text-[11px] text-teal-400 mb-1">Preview Logo:</p>
                    <img src="" alt="Preview Logo" class="w-20 h-20 rounded-xl object-cover border border-teal-500/50" />
                </div>
            </div>

            <!-- Banner -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-zinc-300 uppercase tracking-wider">Foto Banner / Cover <span class="text-zinc-500">(Max 5MB)</span></label>
                <input type="file" name="banner" accept="image/jpeg,image/png,image/webp"
                    onchange="previewImage(this, 'preview-banner')"
                    class="w-full text-xs text-zinc-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-zinc-800 file:text-zinc-200 file:font-semibold file:text-xs file:cursor-pointer cursor-pointer" />
                <div id="preview-banner" class="hidden">
                    <p class="text-[11px] text-teal-400 mb-1">Preview Banner:</p>
                    <img src="" alt="Preview Banner" class="w-full h-28 rounded-xl object-cover border border-teal-500/50" />
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SECTION 4: PRODUK / LAYANAN DINAMIS ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-white mb-1">Produk / Layanan Unggulan</h3>
                <p class="text-xs sm:text-sm text-zinc-400">Tambahkan katalog produk, harga, foto, dan deskripsi yang langsung terhubung ke WhatsApp.</p>
            </div>
            {{--
              // UBAH WARNA TOMBOL '+ TAMBAH PRODUK':
              // Ganti 'bg-teal-600 shadow-teal-950/40' jadi 'bg-blue-600 shadow-blue-950/40' (biru)
            --}}
            <button type="button" onclick="addProductRow()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 text-white text-xs font-bold shadow-md shadow-teal-950/40 cursor-pointer self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </button>
        </div>

        {{--
          Container Baris Produk Dinamis:
          Setiap produk dikirim menggunakan notasi array PHP: products[0][name], products[0][price], dst.
          Sehingga Controller Laravel otomatis menerimanya sebagai array asosiatif terstruktur.
        --}}
        <div id="products-container" class="space-y-4">
            <!-- Row Produk Pertama -->
            <div class="p-4 sm:p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-3.5 product-row">
                <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                    <span class="text-xs font-bold text-zinc-300">Produk #1</span>
                    <button type="button" onclick="this.closest('.product-row').remove()"
                        class="text-xs text-rose-400 cursor-pointer font-bold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nama Produk <span class="text-rose-400">*</span></label>
                        <input type="text" name="products[0][name]" placeholder="Nama produk" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white placeholder-zinc-500 text-xs outline-none" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Harga (Rp)</label>
                        <input type="number" name="products[0][price]" placeholder="Harga (Rp)" min="0"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white placeholder-zinc-500 text-xs outline-none" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Foto Produk</label>
                        <input type="file" name="products[0][image_file]" accept="image/jpeg,image/png,image/webp"
                            class="w-full text-xs text-zinc-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-zinc-800 file:text-zinc-300 file:text-[10px] file:cursor-pointer cursor-pointer" />
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Deskripsi Singkat</label>
                    <textarea name="products[0][description]" placeholder="Deskripsi singkat produk" rows="2"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white placeholder-zinc-500 text-xs outline-none resize-none"></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SECTION 5: PAKET & STATUS ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#18191f] border border-zinc-800 space-y-5">
        <div>
            <h3 class="text-base font-bold text-white mb-1">Pengaturan Paket & Status</h3>
            <p class="text-xs sm:text-sm text-zinc-400">Atur masa berlaku paket hosting serta status penayangan di web publik.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="paket" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Paket Durasi Langganan</label>
                <select name="paket" id="paket"
                    class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white text-sm outline-none font-medium">
                    <option value="">Pilih paket...</option>
                    <option value="3_bulan" {{ old('paket') === '3_bulan' ? 'selected' : '' }}>3 Bulan (Trial 90 Hari)</option>
                    <option value="1_tahun" {{ old('paket') === '1_tahun' ? 'selected' : '' }}>1 Tahun (365 Hari)</option>
                    <option value="tanpa_batas" {{ old('paket') === 'tanpa_batas' ? 'selected' : '' }}>Tanpa Batas (Unlimited)</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-xs font-bold text-zinc-300 uppercase tracking-wider mb-2">Status Publikasi <span class="text-rose-400">*</span></label>
                <select name="status" id="status" required
                    class="w-full px-4 py-3 rounded-xl bg-[#101116] border border-zinc-800 text-white text-sm outline-none font-medium">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Hanya Admin)</option>
                    <option value="publish" {{ old('status', 'publish') === 'publish' ? 'selected' : '' }}>Publish (Aktif di Web Publik)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- ================= TOMBOL SIMPAN / BATAL ================= -->
    {{--
      // UBAH WARNA TOMBOL 'SIMPAN PORTOFOLIO' DI SINI:
      // Jika penguji minta warna BIRU : ganti 'bg-teal-600 shadow-teal-950/50' jadi 'bg-blue-600 shadow-blue-950/50'
      // Jika penguji minta warna MERAH: ganti jadi 'bg-rose-600 shadow-rose-950/50'
      // Jika penguji minta warna HIJAU: ganti jadi 'bg-emerald-600 shadow-emerald-950/50'
    --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
        <button type="submit" class="px-8 py-3.5 rounded-xl bg-teal-600 text-white text-sm font-bold shadow-lg shadow-teal-950/50 cursor-pointer flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Portofolio
        </button>
        <a href="{{ route('admin.portfolios.index') }}" class="px-6 py-3.5 rounded-xl bg-zinc-800 text-zinc-300 text-sm font-semibold border border-zinc-700 text-center">
            Batal
        </a>
    </div>
</form>
</div>

{{--
  ==============================================================================
  JAVASCRIPT LOGIC UNTUK FORM TAMBAH
  ==============================================================================
--}}
<script>
    // 1. Auto-generate slug dari nama usaha secara real-time
    const nameInput = document.getElementById('nama_umkm');
    const slugInput = document.getElementById('slug');

    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function () {
            const raw = this.value;
            const generated = raw
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = generated;
        });
    }

    // 2. Client-side Image Preview menggunakan FileReader API
    function previewImage(input, previewId) {
        const container = document.getElementById(previewId);
        const img = container.querySelector('img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 3. Tambah Baris Produk Dinamis
    let productIndex = 1;

    function addProductRow() {
        const container = document.getElementById('products-container');
        const row = document.createElement('div');
        row.className = 'p-4 sm:p-5 rounded-2xl bg-[#101116] border border-zinc-800 space-y-3.5 product-row';
        row.innerHTML = `
            <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                <span class="text-xs font-bold text-zinc-300">Produk #${productIndex + 1}</span>
                <button type="button" onclick="this.closest('.product-row').remove()"
                    class="text-xs text-rose-400 cursor-pointer font-bold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nama Produk <span class="text-rose-400">*</span></label>
                    <input type="text" name="products[${productIndex}][name]" placeholder="Nama produk" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white placeholder-zinc-500 text-xs outline-none" />
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Harga (Rp)</label>
                    <input type="number" name="products[${productIndex}][price]" placeholder="Harga (Rp)" min="0"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white placeholder-zinc-500 text-xs outline-none" />
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Foto Produk</label>
                    <input type="file" name="products[${productIndex}][image_file]" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-xs text-zinc-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-zinc-800 file:text-zinc-300 file:text-[10px] file:cursor-pointer cursor-pointer" />
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Deskripsi Singkat</label>
                <textarea name="products[${productIndex}][description]" placeholder="Deskripsi singkat produk" rows="2"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#18191f] border border-zinc-800 text-white placeholder-zinc-500 text-xs outline-none resize-none"></textarea>
            </div>
        `;
        container.appendChild(row);
        productIndex++;
    }
</script>
@endsection
