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
        // Membuat tabel 'activity_logs' untuk mencatat jejak audit aktivitas admin
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete(); // Relasi ke admin pelaku aksi
            $table->foreignId('portfolio_id')->nullable()->constrained('portfolios')->nullOnDelete(); // Relasi opsional jika aksi terkait portfolio tertentu
            $table->string('action', 100); // Kode aksi singkat (contoh: LOGIN, TAMBAH, EDIT, HAPUS, AUTO_DRAFT)
            $table->text('description'); // Penjelasan naratif aksi yang dilakukan
            $table->timestamp('created_at')->useCurrent(); // Waktu terjadinya aktivitas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
