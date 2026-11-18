@extends('layouts.admin')

@section('title', 'Edit Portofolio: ' . $portfolio->nama_umkm)
@section('page_title', 'Edit Portofolio')

@section('content')
{{--
  ==============================================================================
  FORM EDIT PORTOFOLIO KLIEN UMKM
  ==============================================================================
  - @method('PUT'): HTTP Method Spoofing karena HTML native form hanya mendukung GET & POST.
  - enctype="multipart/form-data": Wajib untuk upload berkas baru jika user ingin mengganti logo/banner/foto.
  - old('field', $portfolio->field): Mengambil input sebelumnya jika validasi gagal, atau nilai database saat ini.
--}}
<div class="space-y-6 sm:space-y-8 max-w-5xl">

    <!-- ================= HEADER SECTION ================= -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 tracking-tight">Edit Portofolio</h1>
            <p class="text-xs sm:text-sm text-zinc-500 mt-1 font-medium">Perbarui profil, produk, template, atau pengaturan status publikasi.</p>
        </div>
        <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-700 text-xs sm:text-sm font-bold self-start sm:self-center">
            &larr; Kembali ke Direktori
        </a>
    </div>

    <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
    @csrf
    @method('PUT')

    <!-- ================= SECTION 1: PILIHAN TEMPLATE ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-zinc-200 space-y-4">
        <div>
            <h3 class="text-base font-bold text-zinc-900 mb-1">Pilih Template Visual</h3>
            <p class="text-xs sm:text-sm text-zinc-500">Template menentukan tata letak dan konsep visual halaman publik klien.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 pt-2">
            @foreach ($templates as $key => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="template_id" value="{{ $key }}"
                        {{ old('template_id', $portfolio->template_id) === $key ? 'checked' : '' }}
                        class="hidden peer" />
                    <div class="p-4 sm:p-5 rounded-2xl border-2 text-center
                        peer-checked:border-teal-500 peer-checked:bg-teal-500/15
                        border-zinc-200 bg-zinc-50">
                        <p class="text-xs sm:text-sm font-bold text-zinc-900 capitalize">{{ $key }}</p>
                        <p class="text-[10px] text-zinc-500 mt-1 line-clamp-1">{{ $label }}</p>
                    </div>
                </label>
            @endforeach
        </div>
        @error('template_id')
            <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- ================= SECTION 2: DATA PROFIL USAHA ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-zinc-200 space-y-5">
        <div>
            <h3 class="text-base font-bold text-zinc-900 mb-1">Profil Usaha UMKM</h3>
            <p class="text-xs sm:text-sm text-zinc-500">Informasi identitas brand dan kontak yang akan dipajang di web publik.</p>
        </div>

        <!-- Nama UMKM -->
        <div>
            <label for="nama_umkm" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Nama UMKM <span class="text-rose-500">*</span></label>
            <input type="text" name="nama_umkm" id="nama_umkm" value="{{ old('nama_umkm', $portfolio->nama_umkm) }}" required
                class="w-full px-4 py-3 rounded-xl bg-zinc-50 border @error('nama_umkm') border-rose-500 @else border-zinc-200 @enderror text-zinc-900 placeholder-zinc-400 text-sm outline-none font-medium" />
            @error('nama_umkm')
                <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug URL -->
        <div>
            <label for="slug" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Slug URL Resmi <span class="text-rose-500">*</span></label>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <span class="px-4 py-3 rounded-xl bg-zinc-100 border border-zinc-200 text-xs font-mono text-zinc-500 shrink-0 select-none">{{ url('/') }}/</span>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $portfolio->slug) }}" required
                    class="flex-1 px-4 py-3 rounded-xl bg-zinc-50 border @error('slug') border-rose-500 @else border-zinc-200 @enderror text-teal-600 placeholder-zinc-400 text-sm font-mono outline-none font-bold" />
            </div>
            <!-- Peringatan jika slug diubah dari slug asli (Dukungan SEO 301 Permanent Redirect) -->
            <div class="mt-2.5 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs flex items-start gap-2 hidden" id="slug-warning">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><strong>Perhatian SEO:</strong> Mengubah slug akan membuat URL lama (<span class="font-mono underline">{{ url($portfolio->slug) }}</span>) otomatis dialihkan secara 301 permanen ke URL baru via riwayat slug.</span>
            </div>
            @error('slug')
                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bio / Deskripsi -->
        <div>
            <label for="bio" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Deskripsi / Bio Usaha</label>
            <textarea name="bio" id="bio" rows="3"
                class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-sm outline-none resize-none font-medium leading-relaxed">{{ old('bio', $portfolio->bio) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- WhatsApp -->
            <div>
                <label for="whatsapp" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Nomor WhatsApp Usaha</label>
                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $portfolio->whatsapp) }}" placeholder="081234567890"
                    class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-sm outline-none font-medium" />
            </div>

            <!-- Instagram -->
            <div>
                <label for="instagram" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Akun Instagram Usaha</label>
                <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $portfolio->instagram) }}" placeholder="@namatoko atau namatoko"
                    class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-sm outline-none font-medium" />
            </div>
        </div>

        <!-- Alamat Fisik -->
        <div>
            <label for="alamat" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Alamat Fisik Usaha</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $portfolio->alamat) }}" placeholder="Jl. Raya No. 123, Majalengka"
                class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-sm outline-none font-medium" />
        </div>

        <!-- Google Maps Embed -->
        <div>
            <label for="maps_embed_url" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Google Maps Embed (URL atau Tag Iframe)</label>
            <input type="text" name="maps_embed_url" id="maps_embed_url" value="{{ old('maps_embed_url', $portfolio->maps_embed_url) }}"
                placeholder="Paste link embed atau seluruh tag <iframe src='...'> dari Google Maps"
                class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-sm outline-none font-mono text-xs" />
            <p class="text-[11px] text-zinc-400 mt-1.5">Bisa paste langsung link embed maupun seluruh kode <code class="text-teal-600">&lt;iframe src="..."&gt;</code> dari Google Maps (Bagikan &gt; Sematkan peta). Sistem otomatis mengekstrak URL aslinya.</p>
        </div>
    </div>

    <!-- ================= SECTION 3: UPLOAD GAMBAR ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-zinc-200 space-y-5">
        <div>
            <h3 class="text-base font-bold text-zinc-900 mb-1">Gambar Logo & Banner</h3>
            <p class="text-xs sm:text-sm text-zinc-500">Format JPG, PNG, atau WEBP.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Logo -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider">Logo Usaha <span class="text-zinc-400">(Max 2MB)</span></label>
                @if ($portfolio->logo_path)
                    <div class="p-3 rounded-2xl bg-zinc-50 border border-zinc-200 flex items-center gap-3">
                        <img src="{{ Storage::url($portfolio->logo_path) }}" alt="Logo saat ini" class="w-16 h-16 rounded-xl object-cover border border-zinc-200 shrink-0" />
                        <div class="text-xs">
                            <p class="text-zinc-900 font-medium">Logo Terpasang</p>
                            <p class="text-[11px] text-zinc-400">Pilih file baru untuk mengganti</p>
                        </div>
                    </div>
                @endif
                <input type="file" name="logo" accept="image/jpeg,image/png,image/webp"
                    onchange="previewImage(this, 'preview-logo')"
                    class="w-full text-xs text-zinc-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-zinc-100 file:text-zinc-700 file:font-semibold file:text-xs file:cursor-pointer cursor-pointer" />
                <div id="preview-logo" class="hidden">
                    <p class="text-[11px] text-teal-600 mb-1">Preview Logo Baru:</p>
                    <img src="" alt="Preview Logo" class="w-20 h-20 rounded-xl object-cover border border-teal-500/50" />
                </div>
            </div>

            <!-- Banner -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider">Foto Banner / Cover <span class="text-zinc-400">(Max 5MB)</span></label>
                @if ($portfolio->banner_path)
                    <div class="p-3 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-2">
                        <img src="{{ Storage::url($portfolio->banner_path) }}" alt="Banner saat ini" class="w-full h-24 rounded-xl object-cover border border-zinc-200" />
                        <div class="text-xs flex items-center justify-between">
                            <span class="text-zinc-900 font-medium">Banner Terpasang</span>
                            <span class="text-[11px] text-zinc-400">Pilih file baru untuk mengganti</span>
                        </div>
                    </div>
                @endif
                <input type="file" name="banner" accept="image/jpeg,image/png,image/webp"
                    onchange="previewImage(this, 'preview-banner')"
                    class="w-full text-xs text-zinc-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-zinc-100 file:text-zinc-700 file:font-semibold file:text-xs file:cursor-pointer cursor-pointer" />
                <div id="preview-banner" class="hidden">
                    <p class="text-[11px] text-teal-600 mb-1">Preview Banner Baru:</p>
                    <img src="" alt="Preview Banner" class="w-full h-28 rounded-xl object-cover border border-teal-500/50" />
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SECTION 4: PRODUK / LAYANAN DINAMIS ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-zinc-200 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-zinc-900 mb-1">Produk / Layanan Unggulan</h3>
                <p class="text-xs sm:text-sm text-zinc-500">Kelola katalog produk, foto, dan harga yang langsung terhubung ke WhatsApp.</p>
            </div>
            <button type="button" onclick="addProductRow()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 text-white text-xs font-bold shadow-md shadow-teal-100 cursor-pointer self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </button>
        </div>

        <div id="products-container" class="space-y-4">
            {{-- Loop produk yang sudah tersimpan sebelumnya --}}
            @if ($portfolio->products)
                @foreach ($portfolio->products as $i => $product)
                    <div class="p-4 sm:p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-3.5 product-row">
                        <div class="flex items-center justify-between pb-2 border-b border-zinc-200">
                            <span class="text-xs font-bold text-zinc-700">Produk #{{ $i + 1 }}</span>
                            <button type="button" onclick="this.closest('.product-row').remove()"
                                class="text-xs text-rose-500 cursor-pointer font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                                <input type="text" name="products[{{ $i }}][name]" value="{{ $product['name'] ?? '' }}" placeholder="Nama produk" required
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-xs outline-none" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Harga (Rp)</label>
                                <input type="number" name="products[{{ $i }}][price]" value="{{ $product['price'] ?? 0 }}" placeholder="Harga (Rp)" min="0"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-xs outline-none" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Foto Produk Baru</label>
                                <input type="file" name="products[{{ $i }}][image_file]" accept="image/jpeg,image/png,image/webp"
                                    class="w-full text-xs text-zinc-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-zinc-100 file:text-zinc-700 file:text-[10px] file:cursor-pointer cursor-pointer" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Deskripsi Singkat</label>
                            <textarea name="products[{{ $i }}][description]" placeholder="Deskripsi singkat produk" rows="2"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-xs outline-none resize-none">{{ $product['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- ================= SECTION 5: PAKET & STATUS ================= -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-zinc-200 space-y-5">
        <div>
            <h3 class="text-base font-bold text-zinc-900 mb-1">Pengaturan Paket & Status</h3>
            <p class="text-xs sm:text-sm text-zinc-500">Atur masa berlaku paket hosting serta status penayangan di web publik.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="paket" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Paket Durasi Langganan</label>
                <select name="paket" id="paket"
                    class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm outline-none font-medium">
                    <option value="">Pilih paket...</option>
                    <option value="3_bulan" {{ old('paket', $portfolio->paket) === '3_bulan' ? 'selected' : '' }}>3 Bulan</option>
                    <option value="1_tahun" {{ old('paket', $portfolio->paket) === '1_tahun' ? 'selected' : '' }}>1 Tahun</option>
                    <option value="tanpa_batas" {{ old('paket', $portfolio->paket) === 'tanpa_batas' ? 'selected' : '' }}>Tanpa Batas</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Status Publikasi <span class="text-rose-500">*</span></label>
                <select name="status" id="status" required
                    class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-900 text-sm outline-none font-medium">
                    <option value="draft" {{ old('status', $portfolio->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="publish" {{ old('status', $portfolio->status) === 'publish' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>
        </div>
    </div>

    <!-- ================= TOMBOL SIMPAN PERUBAHAN ================= -->
    {{--
      // UBAH WARNA TOMBOL 'SIMPAN PERUBAHAN' DI SINI:
      // Jika penguji minta warna BIRU : ganti 'bg-teal-600 shadow-teal-100' jadi 'bg-blue-600 shadow-blue-100'
      // Jika penguji minta warna MERAH: ganti jadi 'bg-rose-600 shadow-rose-100'
      // Jika penguji minta warna HIJAU: ganti jadi 'bg-emerald-600 shadow-emerald-100'
    --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
        <button type="submit" class="px-8 py-3.5 rounded-xl bg-teal-600 text-white text-sm font-bold shadow-lg shadow-teal-100 cursor-pointer flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Perubahan
        </button>
        <a href="{{ route('admin.portfolios.index') }}" class="px-6 py-3.5 rounded-xl bg-zinc-100 text-zinc-700 text-sm font-semibold border border-zinc-200 text-center">
            Batal
        </a>
    </div>
</form>
</div>

{{--
  ==============================================================================
  JAVASCRIPT LOGIC FORM EDIT
  ==============================================================================
--}}
<script>
    // 1. Deteksi Perubahan Slug untuk Peringatan SEO 301
    const originalSlug = '{{ $portfolio->slug }}';
    const slugInput = document.getElementById('slug');
    const slugWarning = document.getElementById('slug-warning');

    if (slugInput && slugWarning) {
        slugInput.addEventListener('input', function () {
            if (this.value !== originalSlug && this.value.length > 0) {
                slugWarning.classList.remove('hidden');
            } else {
                slugWarning.classList.add('hidden');
            }
        });
    }

    // 2. Client-side Image Preview
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
    let productIndex = {{ count($portfolio->products ?? []) }};

    function addProductRow() {
        const container = document.getElementById('products-container');
        const row = document.createElement('div');
        row.className = 'p-4 sm:p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-3.5 product-row';
        row.innerHTML = `
            <div class="flex items-center justify-between pb-2 border-b border-zinc-200">
                <span class="text-xs font-bold text-zinc-700">Produk #${productIndex + 1}</span>
                <button type="button" onclick="this.closest('.product-row').remove()"
                    class="text-xs text-rose-500 cursor-pointer font-bold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                    <input type="text" name="products[${productIndex}][name]" placeholder="Nama produk" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-xs outline-none" />
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Harga (Rp)</label>
                    <input type="number" name="products[${productIndex}][price]" placeholder="Harga (Rp)" min="0"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-xs outline-none" />
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Foto Produk Baru</label>
                    <input type="file" name="products[${productIndex}][image_file]" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-xs text-zinc-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-zinc-100 file:text-zinc-700 file:text-[10px] file:cursor-pointer cursor-pointer" />
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 mb-1">Deskripsi Singkat</label>
                <textarea name="products[${productIndex}][description]" placeholder="Deskripsi singkat produk" rows="2"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-zinc-200 text-zinc-900 placeholder-zinc-400 text-xs outline-none resize-none"></textarea>
            </div>
        `;
        container.appendChild(row);
        productIndex++;
    }
</script>
@endsection
