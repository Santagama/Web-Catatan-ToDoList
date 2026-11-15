# Dokumentasi Middleware Aplikasi

## 1. PreventBackHistory.php

### [FUNGSI]
Middleware ini berfungsi mengamankan halaman panel admin dari kerentanan navigasi riwayat browser (*Back-Forward Cache* / *BFCache*). Memastikan bahwa saat admin menekan tombol "Keluar Sesi" (logout), admin tidak dapat kembali melihat data sensitif dashboard hanya dengan menekan tombol "Back" di browser.

### [ALUR SISTEM/USER FLOW]
1. Admin sedang berada di dashboard sistem atau halaman kelola portofolio.
2. Admin menekan tombol "Keluar Sesi" -> Session dihancurkan (`invalidate`), token CSRF diregenerasi (`regenerateToken`), dan status otentikasi dicabut (`Auth::logout()`).
3. Pengguna dialihkan (redirect 302) ke halaman `/admin/login`.
4. Jika seseorang menekan tombol "Back" di peramban (browser):
   - Tanpa middleware ini, browser modern akan menampilkan halaman dari memori RAM (*disk/memory cache*), sehingga tampilan dashboard tetap terlihat meski sudah logout.
   - Dengan middleware ini, browser dipaksa menghubungi server. Server mendeteksi sesi sudah tidak valid, lalu middleware `auth` langsung melempar pengguna kembali ke `/admin/login`.

### [PENJELASAN TEKNIS]
- Header HTTP yang disuntikkan ke seluruh respon web:
  - `Cache-Control: no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0` (memberitahu peramban agar tidak pernah menyimpan salinan halaman HTML ke disk maupun memory cache).
  - `Pragma: no-cache` (kompatibilitas untuk klien protokol HTTP/1.0 lawas).
  - `Expires: Sun, 02 Jan 1990 00:00:00 GMT` (membuat respon langsung dianggap usang/kedaluwarsa sejak detik pertama diterima).
- Didaftarkan secara global pada grup `web` di `bootstrap/app.php` menggunakan `$middleware->web(append: [...])`.
- Dilengkapi pendeteksi sisi klien via JavaScript `pageshow` di `resources/views/layouts/admin.blade.php` serta *pushState trap* di `resources/views/admin/auth/login.blade.php` untuk perlindungan 3 lapis (*defense-in-depth*).
