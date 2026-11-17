<?php

namespace App\Models;

// Mengimpor class Model dan Relasi Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model SlugHistory
 *
 * Ini adalah model untuk mencatat riwayat perubahan URL slug portofolio UMKM.
 * Model ini adalah pondasi fitur SEO "HTTP 301 Permanent Redirect".
 * Contoh: Jika slug diubah dari "/toko-roti" menjadi "/bakery-lezat",
 * pengunjung yang masih membuka link lama "/toko-roti" tidak akan error 404,
 * melainkan otomatis diarahkan ke "/bakery-lezat".
 */
class SlugHistory extends Model
{
    use HasFactory;

    // 1. Menentukan nama tabel di database MySQL
    protected $table = 'slug_histories';

    // 2. Kita matikan updated_at karena riwayat URL hanya butuh kapan perubahan itu terjadi (created_at)
    public $timestamps = false;

    // 3. Kolom-kolom yang boleh diisi langsung (Mass Assignment)
    protected $fillable = [
        'portfolio_id', // ID portofolio pemilik slug ini
        'slug_lama',    // Alamat slug sebelum diubah (contoh: "toko-roti")
        'slug_baru',    // Alamat slug setelah diubah (contoh: "bakery-lezat")
        'created_at',   // Waktu saat pergantian slug dilakukan
    ];

    // 4. Casting tipe data otomatis dari Laravel
    protected function casts(): array
    {
        return [
            // Mengubah created_at menjadi objek Carbon (tanggal & waktu)
            'created_at' => 'datetime',
        ];
    }

    // 5. RELASI: Catatan riwayat ini dimiliki oleh satu Portofolio UMKM (Many-to-One)
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
