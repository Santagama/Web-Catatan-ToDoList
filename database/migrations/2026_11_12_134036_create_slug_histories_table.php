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
        // Membuat tabel 'slug_histories' untuk mencatat riwayat perubahan URL (SEO 301 Permanent Redirect)
        Schema::create('slug_histories', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('portfolio_id')->constrained('portfolios')->cascadeOnDelete(); // Relasi ke portofolio (ikut terhapus jika portofolio dihapus)
            $table->string('slug_lama', 150)->index(); // Slug lama sebelum diedit (diberi indeks agar pencarian redirect sangat cepat)
            $table->string('slug_baru', 150); // Slug baru tujuan pengalihan
            $table->timestamp('created_at')->useCurrent(); // Waktu perubahan slug
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slug_histories');
    }
};
