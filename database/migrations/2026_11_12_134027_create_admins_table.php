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
        // Membuat tabel 'admins' untuk menyimpan akun pengelola sistem
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Primary Key (ID unik otomatis bertambah / Auto Increment)
            $table->string('name', 100); // Nama lengkap admin pengelola
            $table->string('username', 50)->unique(); // Username unik untuk login, tidak boleh ada yang kembar
            $table->string('password', 255); // Password terenkripsi (Bcrypt hash)
            $table->rememberToken(); // Token untuk fitur "Ingat Saya" (Remember Me)
            $table->timestamps(); // Mencatat created_at (kapan dibuat) dan updated_at (kapan diubah)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
