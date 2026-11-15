<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Membuat tabel 'portfolios' untuk menyimpan data website portofolio UMKM
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete(); // Relasi ke tabel admins (siapa admin pembuatnya)
            $table->string('template_id', 50)->default('minuman'); // Pilihan template (minuman, makanan, organisasi, tokoh, jasa)
            $table->string('business_name', 150); // Nama usaha / brand UMKM
            $table->string('slug', 150)->unique(); // Alamat URL unik publik (contoh: /kopi-kita), tidak boleh duplikat
            $table->text('bio')->nullable(); // Deskripsi profil atau cerita singkat usaha
            $table->text('alamat')->nullable(); // Alamat fisik usaha
            $table->string('whatsapp', 20)->nullable(); // Nomor WhatsApp untuk tombol pesan langsung
            $table->text('maps_embed_url')->nullable(); // URL sematan peta Google Maps (tipe TEXT agar muat menampung URL maupun iframe)
            $table->string('logo_path', 255)->nullable(); // Lokasi penyimpanan file logo di storage
            $table->string('banner_path', 255)->nullable(); // Lokasi penyimpanan file foto banner di storage
            $table->json('products')->nullable(); // Kolom JSON fleksibel untuk daftar produk/layanan unggulan
            $table->string('paket', 20)->nullable(); // Jenis paket langganan ('3_bulan', '1_tahun', 'tanpa_batas')
            $table->timestamp('expired_at')->nullable(); // Tanggal kadaluarsa paket (untuk otomasi auto-draft)
            $table->string('status', 20)->default('draft'); // Status tayang website: 'draft' atau 'publish'
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
