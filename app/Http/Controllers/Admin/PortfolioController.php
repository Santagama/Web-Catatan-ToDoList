<?php

namespace App\Http\Controllers\Admin;

// Mengimpor class Controller dasar, model-model terkait, dan utilitas Laravel
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Portfolio;
use App\Models\SlugHistory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * PortfolioController (Pusat Logika CRUD Portofolio UMKM)
 *
 * Ini adalah Controller utama aplikasi yang menangani:
 * 1. Menampilkan daftar portofolio (Read) dengan filter dan pencarian.
 * 2. Menambah portofolio baru (Create) beserta upload gambar & array JSON produk.
 * 3. Menampilkan detail portofolio (Show).
 * 4. Mengubah data portofolio (Update) & deteksi riwayat slug untuk SEO 301.
 * 5. Menghapus data portofolio (Delete) & pembersihan file di storage disk.
 * 6. Perpanjangan masa aktif paket langganan UMKM (Extend).
 * 7. Pengecekan ketersediaan slug unik secara realtime via AJAX.
 */
class PortfolioController extends Controller
{
    /**
     * Daftar pilihan tema template visual yang tersedia di sistem kami.
     * Digunakan untuk validasi data dan pengisian dropdown pilihan di form.
     */
    private const TEMPLATE_OPTIONS = [
        'minuman' => 'Minuman (Kopi, Boba, Kedai)',
        'makanan' => 'Makanan (Kuliner, Resto, Bakso)',
        'barang' => 'Barang (Elektronik, Fashion, Retail)',
        'tokoh' => 'Tokoh (Caleg, Profil Publik)',
        'jasa' => 'Jasa (Salon, Servis, Studio)',
    ];

    /**
     * 1. READ: Menampilkan daftar seluruh portofolio UMKM (Index)
     * Dilengkapi fitur pencarian nama/slug dan filter tab status.
     */
    public function index(Request $request): View
    {
        // Siapkan query dasar Eloquent
        $query = Portfolio::query();

        // FITUR 1: PENCARIAN (Search)
        // Jika admin mengetik kata kunci di kotak pencarian:
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_umkm', 'like', '%'.$search.'%')
                    ->orWhere('slug', 'like', '%'.$search.'%');
            });
        }

        // FITUR 2: FILTER STATUS (Semua / Publish / Draft / Expired)
        if ($request->filled('status')) {
            $status = $request->input('status');

            if ($status === 'expired') {
                // Cari portofolio yang tanggal expired-nya sudah lewat dari hari ini
                $query->whereNotNull('expired_at')->where('expired_at', '<', now());
            } else {
                // Filter berdasarkan kolom status ('publish' atau 'draft')
                $query->where('status', $status);
            }
        }

        // Hitung total angka untuk lencana (badge) di atas tabel
        $totalCount = Portfolio::count();
        $publishCount = Portfolio::where('status', 'publish')->count();
        $draftCount = Portfolio::where('status', 'draft')->count();

        // Ambil data yang sudah diurutkan dari yang terbaru dan bagi jadi 10 per halaman (Pagination)
        $portfolios = $query->latest('updated_at')->paginate(10)->withQueryString();

        // Tampilkan ke view Blade admin/portfolios/index.blade.php
        return view('admin.portfolios.index', compact('portfolios', 'totalCount', 'publishCount', 'draftCount'));
    }

    /**
     * 2. CREATE FORM: Menampilkan halaman formulir tambah website portofolio baru.
     */
    public function create(): View
    {
        // Ambil daftar template visual untuk dipilih admin di formulir
        $templates = self::TEMPLATE_OPTIONS;

        return view('admin.portfolios.create', compact('templates'));
    }

    /**
     * 3. STORE: Memproses penyimpanan data portofolio baru ke database MySQL.
     */
    public function store(Request $request): RedirectResponse
    {
        // LANGKAH 1: VALIDASI INPUT FORM
        // Memastikan semua data yang diisi admin valid dan aman
        $validated = $request->validate([
            'nama_umkm' => ['required', 'string', 'max:150'],
            // Slug harus unik di tabel portfolios, hanya huruf kecil-angka-strip, dan tidak boleh pakai kata sistem
            'slug' => ['required', 'string', 'max:150', 'unique:portfolios,slug', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'not_in:admin,login,logout,dashboard,api,build,images,css,js,storage,up'],
            'template_id' => ['required', 'string', 'in:'.implode(',', array_keys(self::TEMPLATE_OPTIONS))],
            'bio' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'maps_embed_url' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],    // Max 2MB
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],  // Max 5MB
            'paket' => ['nullable', 'string', 'in:3_bulan,1_tahun,tanpa_batas'],
            'status' => ['required', 'string', 'in:draft,publish'],
            // Validasi untuk array dinamis produk
            'products' => ['nullable', 'array'],
            'products.*.name' => ['required_with:products', 'string', 'max:150'],
            'products.*.price' => ['nullable', 'numeric', 'min:0'],
            'products.*.description' => ['nullable', 'string'],
        ], [
            // Pesan ramah dalam Bahasa Indonesia jika validasi gagal
            'nama_umkm.required' => 'Nama UMKM wajib diisi.',
            'slug.required' => 'Slug URL wajib diisi.',
            'slug.unique' => 'Slug URL ini sudah digunakan UMKM lain, silakan pilih yang berbeda.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'template_id.required' => 'Pilih salah satu template terlebih dahulu.',
            'slug.not_in' => 'Slug ini merupakan kata kunci sistem dan tidak boleh digunakan.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'banner.max' => 'Ukuran banner maksimal 5MB.',
        ]);

        // LANGKAH 2: UPLOAD GAMBAR LOGO
        $logoPath = null;
        if ($request->hasFile('logo')) {
            // Simpan gambar ke folder storage/app/public/uploads/logos
            $logoPath = $request->file('logo')->store('uploads/logos', 'public');
        }

        // LANGKAH 3: UPLOAD GAMBAR BANNER
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            // Simpan gambar ke folder storage/app/public/uploads/banners
            $bannerPath = $request->file('banner')->store('uploads/banners', 'public');
        }

        // LANGKAH 4: PROSES DAFTAR PRODUK & UPLOAD FOTO PRODUK
        // Menyusun array produk dan upload fotonya (disimpan sebagai JSON di database)
        $products = $this->processProductUploads($request);

        // LANGKAH 5: HITUNG TANGGAL KEDALUWARSA PAKET
        $expiredAt = $this->calculateExpiredDate($validated['paket'] ?? null);

        // LANGKAH 6: SIMPAN DATA KE TABEL 'portfolios' MENGGUNAKAN ELOQUENT
        $portfolio = Portfolio::create([
            'admin_id' => auth()->id(), // Admin yang sedang login menjadi pemilik/pembuat
            'template_id' => $validated['template_id'],
            'nama_umkm' => $validated['nama_umkm'],
            'slug' => $validated['slug'],
            'bio' => $validated['bio'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'maps_embed_url' => $validated['maps_embed_url'] ?? null,
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
            'products' => $products, // Otomatis diubah jadi string JSON oleh Model casts
            'paket' => $validated['paket'] ?? null,
            'expired_at' => $expiredAt,
            'status' => $validated['status'],
        ]);

        // LANGKAH 7: CATAT JEJAK AUDIT KE 'activity_logs'
        ActivityLog::record(
            'TAMBAH_PORTFOLIO',
            'Admin '.auth()->user()->name.' menambahkan portofolio baru: '.$portfolio->nama_umkm,
            $portfolio->id
        );

        // LANGKAH 8: KEMBALI KE TABEL UTAMA DENGAN PESAN SUKSES
        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio "'.$portfolio->nama_umkm.'" berhasil ditambahkan!');
    }

    /**
     * 4. SHOW: Menampilkan rincian lengkap 1 data portofolio UMKM.
     */
    public function show(Portfolio $portfolio): View
    {
        return view('admin.portfolios.show', compact('portfolio'));
    }

    /**
     * 5. EDIT FORM: Menampilkan halaman formulir edit yang terisi data lama.
     */
    public function edit(Portfolio $portfolio): View
    {
        $templates = self::TEMPLATE_OPTIONS;

        return view('admin.portfolios.edit', compact('portfolio', 'templates'));
    }

    /**
     * 6. UPDATE: Memproses pembaruan data portofolio UMKM ke database.
     */
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        // LANGKAH 1: VALIDASI INPUT FORM
        // Perhatikan bagian 'unique:portfolios,slug,'.$portfolio->id
        // Artinya slug harus unik, KECUALI slug milik data ini sendiri (agar tidak bentrok saat diedit)
        $validated = $request->validate([
            'nama_umkm' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', 'unique:portfolios,slug,'.$portfolio->id, 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'not_in:admin,login,logout,dashboard,api,build,images,css,js,storage,up'],
            'template_id' => ['required', 'string', 'in:'.implode(',', array_keys(self::TEMPLATE_OPTIONS))],
            'bio' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'maps_embed_url' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'paket' => ['nullable', 'string', 'in:3_bulan,1_tahun,tanpa_batas'],
            'status' => ['required', 'string', 'in:draft,publish'],
            'products' => ['nullable', 'array'],
            'products.*.name' => ['required_with:products', 'string', 'max:150'],
            'products.*.price' => ['nullable', 'numeric', 'min:0'],
            'products.*.description' => ['nullable', 'string'],
        ], [
            'nama_umkm.required' => 'Nama UMKM wajib diisi.',
            'slug.unique' => 'Slug URL ini sudah digunakan UMKM lain.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
        ]);

        // LANGKAH 2: DETEKSI PERUBAHAN SLUG (FITUR UNGGULAN SEO 301 REDIRECT)
        $slugLama = $portfolio->slug;
        $slugBaru = $validated['slug'];

        // Jika alamat URL diubah oleh admin:
        if ($slugLama !== $slugBaru) {
            // Catat alamat slug lama ke tabel 'slug_histories'
            // Sehingga pengunjung yang membuka link lama otomatis dialihkan ke link baru!
            SlugHistory::create([
                'portfolio_id' => $portfolio->id,
                'slug_lama' => $slugLama,
                'slug_baru' => $slugBaru,
                'created_at' => now(),
            ]);
        }

        // LANGKAH 3: GANTI LOGO JIKA ADA FILE BARU YANG DIUPLOAD
        if ($request->hasFile('logo')) {
            // Hapus logo lama dari disk storage agar server tidak penuh sampah
            if ($portfolio->logo_path) {
                Storage::disk('public')->delete($portfolio->logo_path);
            }
            // Simpan file logo baru
            $validated['logo_path'] = $request->file('logo')->store('uploads/logos', 'public');
        }

        // LANGKAH 4: GANTI BANNER JIKA ADA FILE BARU YANG DIUPLOAD
        if ($request->hasFile('banner')) {
            // Hapus banner lama dari disk storage
            if ($portfolio->banner_path) {
                Storage::disk('public')->delete($portfolio->banner_path);
            }
            // Simpan file banner baru
            $validated['banner_path'] = $request->file('banner')->store('uploads/banners', 'public');
        }

        // LANGKAH 5: PROSES UPLOAD FOTO PRODUK
        $products = $this->processProductUploads($request, $portfolio);

        // LANGKAH 6: SIMPAN PERUBAHAN KE DATABASE MYSQL
        $portfolio->update([
            'template_id' => $validated['template_id'],
            'nama_umkm' => $validated['nama_umkm'],
            'slug' => $validated['slug'],
            'bio' => $validated['bio'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'maps_embed_url' => $validated['maps_embed_url'] ?? null,
            'logo_path' => $validated['logo_path'] ?? $portfolio->logo_path,
            'banner_path' => $validated['banner_path'] ?? $portfolio->banner_path,
            'products' => $products,
            'paket' => $validated['paket'] ?? $portfolio->paket,
            'status' => $validated['status'],
        ]);

        // LANGKAH 7: CATAT JEJAK AUDIT PERUBAHAN KE ACTIVITY_LOGS
        $desc = 'Admin '.auth()->user()->name.' memperbarui portofolio: '.$portfolio->nama_umkm;
        if ($slugLama !== $slugBaru) {
            $desc .= ' (Slug diubah dari "'.$slugLama.'" menjadi "'.$slugBaru.'")';
        }
        ActivityLog::record('EDIT_PORTFOLIO', $desc, $portfolio->id);

        // LANGKAH 8: KEMBALI KE DAFTAR DENGAN NOTIFIKASI SUKSES
        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio "'.$portfolio->nama_umkm.'" berhasil diperbarui!');
    }

    /**
     * 7. DESTROY: Menghapus data portofolio beserta file gambarnya dari server.
     */
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $namaUsaha = $portfolio->nama_umkm;

        // LANGKAH 1: HAPUS FILE LOGO DAN BANNER DARI STORAGE DISK
        if ($portfolio->logo_path) {
            Storage::disk('public')->delete($portfolio->logo_path);
        }
        if ($portfolio->banner_path) {
            Storage::disk('public')->delete($portfolio->banner_path);
        }

        // LANGKAH 2: HAPUS FILE FOTO PRODUK DARI STORAGE DISK
        if ($portfolio->products) {
            foreach ($portfolio->products as $product) {
                if (! empty($product['image'])) {
                    Storage::disk('public')->delete($product['image']);
                }
            }
        }

        // LANGKAH 3: HAPUS DATA DARI DATABASE MYSQL
        // Riwayat slug di slug_histories otomatis terhapus karena relasi Cascade on Delete
        $portfolio->delete();

        // LANGKAH 4: CATAT JEJAK AUDIT PENGHAPUSAN
        ActivityLog::record(
            'HAPUS_PORTFOLIO',
            'Admin '.auth()->user()->name.' menghapus portofolio: '.$namaUsaha
        );

        // LANGKAH 5: KEMBALI KE DAFTAR DENGAN PESAN INFORMASI
        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio "'.$namaUsaha.'" berhasil dihapus.');
    }

    /**
     * 8. EXTEND: Memperpanjang masa aktif paket portofolio yang sudah habis.
     */
    public function extend(Request $request, Portfolio $portfolio): RedirectResponse
    {
        // Validasi pilihan paket tambahan
        $request->validate([
            'paket' => ['required', 'string', 'in:3_bulan,1_tahun'],
        ]);

        // LOGIKA PERPANJANGAN:
        // Jika paket sudah terlanjur expired -> Mulai hitung dari hari ini + durasi baru
        // Jika paket masih aktif -> Tambahkan durasi baru di atas tanggal expired_at yang lama
        $baseDate = ($portfolio->isExpired() || $portfolio->expired_at === null)
            ? now()
            : $portfolio->expired_at;

        // Tambah 3 bulan atau 1 tahun
        $newExpiredAt = $request->input('paket') === '3_bulan'
            ? $baseDate->copy()->addMonths(3)
            : $baseDate->copy()->addYear();

        // Update database dan aktifkan kembali status ke 'publish'
        $portfolio->update([
            'paket' => $request->input('paket'),
            'expired_at' => $newExpiredAt,
            'status' => 'publish',
        ]);

        // Catat ke log aktivitas
        ActivityLog::record(
            'PERPANJANG_PAKET',
            'Admin '.auth()->user()->name.' memperpanjang paket portofolio "'.$portfolio->nama_umkm
                .'" hingga '.$newExpiredAt->format('d M Y'),
            $portfolio->id
        );

        return redirect()->route('admin.portfolios.show', $portfolio->id)
            ->with('success', 'Paket "'.$portfolio->nama_umkm.'" berhasil diperpanjang hingga '.$newExpiredAt->format('d M Y').'!');
    }

    /**
     * 9. AJAX API: Memeriksa ketersediaan slug URL secara realtime saat admin mengetik nama UMKM.
     */
    public function checkSlug(Request $request): JsonResponse
    {
        // Otomatis ubah nama jadi slug URL (contoh: "Kopi Kita Enak" jadi "kopi-kita-enak")
        $slug = Str::slug($request->input('name', ''));

        // Cek apakah slug sudah pernah dipakai oleh toko lain di database
        $excludeId = $request->input('exclude_id');
        $isAvailable = ! Portfolio::where('slug', $slug)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        // Kembalikan respon format JSON ke script JavaScript di browser
        return response()->json([
            'slug' => $slug,
            'is_available' => $isAvailable,
        ]);
    }

    /**
     * FUNGSI PEMBANTU PRIVATE: Memproses upload foto produk dan menyusun array produk JSON.
     */
    private function processProductUploads(Request $request, ?Portfolio $existingPortfolio = null): ?array
    {
        $productsInput = $request->input('products');

        if (empty($productsInput)) {
            return null;
        }

        $products = [];
        $existingProducts = $existingPortfolio?->products ?? [];

        foreach ($productsInput as $index => $item) {
            // Lewati baris yang namanya kosong
            if (empty($item['name'])) {
                continue;
            }

            // Pertahankan path foto lama jika ada
            $imagePath = $existingProducts[$index]['image'] ?? null;

            // Jika ada foto produk baru yang diupload pada baris ini:
            if ($request->hasFile("products.{$index}.image_file")) {
                // Hapus foto lama dari storage
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                // Simpan foto produk baru ke folder storage/app/public/uploads/products
                $imagePath = $request->file("products.{$index}.image_file")->store('uploads/products', 'public');
            }

            // Susun satu per satu data produk ke dalam array PHP
            $products[] = [
                'name' => $item['name'],
                'price' => (int) ($item['price'] ?? 0),
                'description' => $item['description'] ?? null,
                'image' => $imagePath,
            ];
        }

        return ! empty($products) ? $products : null;
    }

    /**
     * FUNGSI PEMBANTU PRIVATE: Menghitung tanggal kadaluarsa berdasarkan pilihan paket.
     */
    private function calculateExpiredDate(?string $paket): ?Carbon
    {
        return match ($paket) {
            '3_bulan' => now()->addMonths(3), // Tambah 3 bulan dari hari ini
            '1_tahun' => now()->addYear(),     // Tambah 1 tahun dari hari ini
            default => null,                   // Paket 'tanpa_batas' atau kosong = tidak pernah kedaluwarsa
        };
    }
}
