<?php

namespace App\Http\Controllers\Admin;

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
 * PortfolioController (Pengontrol Utama Manajemen Portofolio UMKM)
 *
 * Controller ini adalah jantung aplikasi. Menangani seluruh operasi CRUD
 * (Create, Read, Update, Delete) data portofolio UMKM, termasuk:
 * - Validasi dan auto-generate slug unik
 * - Upload gambar logo dan banner ke storage
 * - Penyimpanan data produk dinamis ke kolom JSON
 * - Pencatatan riwayat slug untuk SEO 301 Redirect
 * - Perpanjangan masa aktif paket langganan
 */
class PortfolioController extends Controller
{
    /**
     * Daftar template yang tersedia di platform.
     * Digunakan untuk validasi dan tampilan pilihan di form.
     */
    private const TEMPLATE_OPTIONS = [
        'minuman' => 'Minuman (Kopi, Boba, Kedai)',
        'makanan' => 'Makanan (Kuliner, Resto, Bakso)',
        'organisasi' => 'Organisasi (OSIS, Komunitas)',
        'tokoh' => 'Tokoh (Caleg, Profil Publik)',
        'jasa' => 'Jasa (Salon, Servis, Studio)',
    ];

    /**
     * Menampilkan daftar seluruh portofolio UMKM (dengan fitur search & filter status).
     */
    public function index(Request $request): View
    {
        // Mulai query dasar
        $query = Portfolio::query();

        // Fitur Pencarian: Filter berdasarkan nama usaha atau slug
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', '%'.$search.'%')
                    ->orWhere('slug', 'like', '%'.$search.'%');
            });
        }

        // Fitur Filter Status: Semua / Publish / Draft / Expired
        if ($request->filled('status')) {
            $status = $request->input('status');

            if ($status === 'expired') {
                // Portofolio yang masa aktifnya sudah lewat
                $query->whereNotNull('expired_at')->where('expired_at', '<', now());
            } else {
                // Filter berdasarkan kolom status (publish / draft)
                $query->where('status', $status);
            }
        }

        // Hitung total untuk badge tab filter
        $totalCount = Portfolio::count();
        $publishCount = Portfolio::where('status', 'publish')->count();
        $draftCount = Portfolio::where('status', 'draft')->count();

        // Ambil data dengan urutan terbaru dan paginasi 10 per halaman
        $portfolios = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('admin.portfolios.index', compact('portfolios', 'totalCount', 'publishCount', 'draftCount'));
    }

    /**
     * Menampilkan formulir pembuatan portofolio UMKM baru.
     */
    public function create(): View
    {
        $templates = self::TEMPLATE_OPTIONS;

        return view('admin.portfolios.create', compact('templates'));
    }

    /**
     * Memproses penyimpanan data portofolio baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi seluruh input dari form
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', 'unique:portfolios,slug', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'not_in:admin,login,logout,dashboard,api,build,images,css,js,storage,up'],
            'template_id' => ['required', 'string', 'in:'.implode(',', array_keys(self::TEMPLATE_OPTIONS))],
            'bio' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'maps_embed_url' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'paket' => ['nullable', 'string', 'in:3_bulan,1_tahun,tanpa_batas'],
            'status' => ['required', 'string', 'in:draft,publish'],
            // Validasi array produk dinamis
            'products' => ['nullable', 'array'],
            'products.*.name' => ['required_with:products', 'string', 'max:150'],
            'products.*.price' => ['nullable', 'numeric', 'min:0'],
            'products.*.description' => ['nullable', 'string'],
        ], [
            'business_name.required' => 'Nama usaha wajib diisi.',
            'slug.required' => 'Slug URL wajib diisi.',
            'slug.unique' => 'Slug URL ini sudah digunakan UMKM lain, silakan pilih yang berbeda.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'template_id.required' => 'Pilih salah satu template terlebih dahulu.',
            'slug.not_in' => 'Slug ini merupakan kata kunci sistem dan tidak boleh digunakan.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'banner.max' => 'Ukuran banner maksimal 5MB.',
        ]);

        // 2. Upload file logo jika ada
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('uploads/logos', 'public');
        }

        // 3. Upload file banner jika ada
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('uploads/banners', 'public');
        }

        // 4. Upload foto produk jika ada
        $products = $this->processProductUploads($request);

        // 5. Hitung tanggal kadaluarsa berdasarkan pilihan paket
        $expiredAt = $this->calculateExpiredDate($validated['paket'] ?? null);

        // 6. Simpan data ke tabel portfolios
        $portfolio = Portfolio::create([
            'admin_id' => auth()->id(),
            'template_id' => $validated['template_id'],
            'business_name' => $validated['business_name'],
            'slug' => $validated['slug'],
            'bio' => $validated['bio'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'maps_embed_url' => $validated['maps_embed_url'] ?? null,
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
            'products' => $products,
            'paket' => $validated['paket'] ?? null,
            'expired_at' => $expiredAt,
            'status' => $validated['status'],
        ]);

        // 7. Catat jejak audit ke activity_logs
        ActivityLog::record(
            'TAMBAH_PORTFOLIO',
            'Admin '.auth()->user()->name.' menambahkan portofolio baru: '.$portfolio->business_name,
            $portfolio->id
        );

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio "'.$portfolio->business_name.'" berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail lengkap satu portofolio UMKM.
     */
    public function show(Portfolio $portfolio): View
    {
        return view('admin.portfolios.show', compact('portfolio'));
    }

    /**
     * Menampilkan formulir edit portofolio yang sudah terisi data lama.
     */
    public function edit(Portfolio $portfolio): View
    {
        $templates = self::TEMPLATE_OPTIONS;

        return view('admin.portfolios.edit', compact('portfolio', 'templates'));
    }

    /**
     * Memproses pembaruan data portofolio ke database.
     */
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        // 1. Validasi input (slug unik tapi abaikan slug milik portofolio ini sendiri)
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', 'unique:portfolios,slug,'.$portfolio->id, 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'not_in:admin,login,logout,dashboard,api,build,images,css,js,storage,up'],
            'template_id' => ['required', 'string', 'in:'.implode(',', array_keys(self::TEMPLATE_OPTIONS))],
            'bio' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
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
            'slug.unique' => 'Slug URL ini sudah digunakan UMKM lain.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
        ]);

        // 2. Deteksi perubahan slug (Fitur SEO 301 Redirect)
        $slugLama = $portfolio->slug;
        $slugBaru = $validated['slug'];

        if ($slugLama !== $slugBaru) {
            // Simpan riwayat slug lama ke tabel slug_histories
            SlugHistory::create([
                'portfolio_id' => $portfolio->id,
                'slug_lama' => $slugLama,
                'slug_baru' => $slugBaru,
                'created_at' => now(),
            ]);
        }

        // 3. Upload logo baru jika ada (hapus logo lama dari storage)
        if ($request->hasFile('logo')) {
            if ($portfolio->logo_path) {
                Storage::disk('public')->delete($portfolio->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('uploads/logos', 'public');
        }

        // 4. Upload banner baru jika ada (hapus banner lama dari storage)
        if ($request->hasFile('banner')) {
            if ($portfolio->banner_path) {
                Storage::disk('public')->delete($portfolio->banner_path);
            }
            $validated['banner_path'] = $request->file('banner')->store('uploads/banners', 'public');
        }

        // 5. Proses upload foto produk
        $products = $this->processProductUploads($request, $portfolio);

        // 6. Update data di database
        $portfolio->update([
            'template_id' => $validated['template_id'],
            'business_name' => $validated['business_name'],
            'slug' => $validated['slug'],
            'bio' => $validated['bio'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'maps_embed_url' => $validated['maps_embed_url'] ?? null,
            'logo_path' => $validated['logo_path'] ?? $portfolio->logo_path,
            'banner_path' => $validated['banner_path'] ?? $portfolio->banner_path,
            'products' => $products,
            'paket' => $validated['paket'] ?? $portfolio->paket,
            'status' => $validated['status'],
        ]);

        // 7. Catat jejak audit
        $desc = 'Admin '.auth()->user()->name.' memperbarui portofolio: '.$portfolio->business_name;
        if ($slugLama !== $slugBaru) {
            $desc .= ' (Slug diubah dari "'.$slugLama.'" menjadi "'.$slugBaru.'")';
        }
        ActivityLog::record('EDIT_PORTFOLIO', $desc, $portfolio->id);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio "'.$portfolio->business_name.'" berhasil diperbarui!');
    }

    /**
     * Menghapus portofolio beserta file gambar terkait dari storage dan database.
     */
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $namaUsaha = $portfolio->business_name;

        // 1. Hapus file gambar logo dan banner dari disk storage
        if ($portfolio->logo_path) {
            Storage::disk('public')->delete($portfolio->logo_path);
        }
        if ($portfolio->banner_path) {
            Storage::disk('public')->delete($portfolio->banner_path);
        }

        // 2. Hapus foto produk dari disk storage
        if ($portfolio->products) {
            foreach ($portfolio->products as $product) {
                if (! empty($product['image'])) {
                    Storage::disk('public')->delete($product['image']);
                }
            }
        }

        // 3. Hapus data dari database (slug_histories otomatis terhapus via CASCADE)
        $portfolio->delete();

        // 4. Catat jejak audit
        ActivityLog::record(
            'HAPUS_PORTFOLIO',
            'Admin '.auth()->user()->name.' menghapus portofolio: '.$namaUsaha
        );

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio "'.$namaUsaha.'" berhasil dihapus.');
    }

    /**
     * Memproses perpanjangan masa aktif paket portofolio.
     */
    public function extend(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $request->validate([
            'paket' => ['required', 'string', 'in:3_bulan,1_tahun'],
        ]);

        // Hitung tanggal expired baru berdasarkan status saat ini:
        // Jika sudah expired -> hitung dari sekarang + durasi baru
        // Jika belum expired -> hitung dari expired_at lama + durasi baru (perpanjangan)
        $baseDate = ($portfolio->isExpired() || $portfolio->expired_at === null)
            ? now()
            : $portfolio->expired_at;

        $newExpiredAt = $request->input('paket') === '3_bulan'
            ? $baseDate->copy()->addMonths(3)
            : $baseDate->copy()->addYear();

        // Update status dan tanggal kadaluarsa
        $portfolio->update([
            'paket' => $request->input('paket'),
            'expired_at' => $newExpiredAt,
            'status' => 'publish',
        ]);

        // Catat jejak audit
        ActivityLog::record(
            'PERPANJANG_PAKET',
            'Admin '.auth()->user()->name.' memperpanjang paket portofolio "'.$portfolio->business_name
                .'" hingga '.$newExpiredAt->format('d M Y'),
            $portfolio->id
        );

        return redirect()->route('admin.portfolios.show', $portfolio->id)
            ->with('success', 'Paket "'.$portfolio->business_name.'" berhasil diperpanjang hingga '.$newExpiredAt->format('d M Y').'!');
    }

    /**
     * API endpoint: Memeriksa ketersediaan slug secara realtime (dipanggil via AJAX).
     */
    public function checkSlug(Request $request): JsonResponse
    {
        // Generate slug dari nama yang dikirim
        $slug = Str::slug($request->input('name', ''));

        // Periksa apakah slug sudah dipakai (kecuali milik portfolio yang sedang diedit)
        $excludeId = $request->input('exclude_id');
        $isAvailable = ! Portfolio::where('slug', $slug)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        return response()->json([
            'slug' => $slug,
            'is_available' => $isAvailable,
        ]);
    }

    /**
     * Helper Private: Memproses upload foto produk dan menyusun array produk.
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
            // Skip produk tanpa nama (baris kosong)
            if (empty($item['name'])) {
                continue;
            }

            $imagePath = $existingProducts[$index]['image'] ?? null;

            // Upload foto produk baru jika ada
            if ($request->hasFile("products.{$index}.image_file")) {
                // Hapus foto lama jika ada
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file("products.{$index}.image_file")->store('uploads/products', 'public');
            }

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
     * Helper Private: Menghitung tanggal kadaluarsa berdasarkan pilihan paket.
     */
    private function calculateExpiredDate(?string $paket): ?Carbon
    {
        return match ($paket) {
            '3_bulan' => now()->addMonths(3),
            '1_tahun' => now()->addYear(),
            default => null,  // Paket 'tanpa_batas' atau null = tidak ada batas waktu
        };
    }
}
