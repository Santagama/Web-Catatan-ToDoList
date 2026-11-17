# Catatan Dokumentasi: View Login Admin (`resources/views/admin/auth/`)

---

## 1. Apa itu File `login.blade.php`? (Bahasa Santai)
Ini adalah halaman **Pintu Gerbang Masuk Admin**! 🚪
Tampilannya berdesain minimalis gelap modern dengan kartu di tengah layar (*centered card*).

---

## 2. Fitur Keren di Halaman Ini:
1.  **Latar Video Animasi Halus**:
    *   Menggunakan tag `<video autoplay loop muted>` dengan file `/assets/login-bg.mp4` agar terlihat modern dan elegan.
2.  **Tombol Kembali ke Web**:
    *   Di pojok kiri atas ada tombol kembali ke halaman landing page utama (`route('home')`).
3.  **Pesan Error Otomatis**:
    *   Jika salah memasukkan username atau password, muncul pesan peringatan merah di bawah input form menggunakan `@error('username')`.
4.  **Anti-Back Trap (Keamanan Riwayat Browser)**:
    *   Ada script JavaScript `window.history.pushState` di bagian bawah agar saat admin sudah logout, pengunjung lain di komputer yang sama tidak bisa menekan tombol "Back" di browser untuk mengintip kembali.

---

## 3. Akun Login untuk Demo Ujikom:
- **Username**: `hanan`
- **Password**: `hanan123`

---

## 4. 💡 Jawaban Mantap untuk Penguji:
> *"Halaman login ini kami lindungi dengan token `@csrf` untuk mencegah penipuan request, serta script deteksi navigasi peramban agar sesi yang telah logout tidak dapat diakses kembali melalui tombol Back browser."*
