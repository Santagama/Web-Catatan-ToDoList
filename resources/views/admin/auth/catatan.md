# Dokumentasi View Otentikasi Admin

## 1. login.blade.php

### [FUNGSI]
Menyediakan antarmuka (UI) formulir login pengelola platform SentraUMKM. Dilengkapi masukan kredensial (username dan kata sandi), opsi *remember me*, visual peringatan error validasi, serta kartu bantuan kredensial default untuk mempermudah penilaian oleh dewan penguji UKK.

### [ALUR SISTEM/USER FLOW]
1. Pengunjung/penguji mengakses alamat `/admin/login` atau otomatis diarahkan ke sini saat mencoba membuka rute terproteksi tanpa login session.
2. Pengguna mengisi username dan kata sandi (disediakan petunjuk default: `hanan` / `hanan123`).
3. Form mengirim permintaan POST ke rute `admin.login.post` yang diproses oleh `AuthController@login`.
4. Jika valid, admin dialihkan ke `/admin/dashboard`. Jika salah, muncul pesan galat merah di bawah bidang input yang keliru.
5. Jika pengguna baru saja logout dan mencoba menekan tombol "Back" pada peramban, skrip proteksi di halaman ini menahan navigasi agar pengguna tetap berada di formulir login.

### [PENJELASAN TEKNIS]
- Menginduk ke tata letak `layouts.app` dengan tema *Dark Zinc* (`bg-zinc-950`).
- Token proteksi `@csrf` wajib disertakan untuk mencegah serangan *Cross-Site Request Forgery*.
- Menyematkan komponen alert `@include('components.alert')` untuk menangkap pesan flash sesi (`success`, `error`, `info`).
- Menggunakan skrip *history trap* berbasis `window.history.pushState` dan `window.onpopstate` untuk mencegah navigasi mundur ke sesi dashboard setelah proses keluar sesi berhasil.
