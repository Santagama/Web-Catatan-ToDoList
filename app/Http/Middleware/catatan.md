# Catatan Dokumentasi: Folder Middleware (`app/Http/Middleware/`)

---

## 1. Apa itu Middleware? (Bahasa Santai)
Middleware itu ibarat **"Satpam Penjaga Pintu"** di depan gedung aplikasi kita! 👮‍♂️
Sebelum permintaan tamu (request) boleh masuk ke dalam ruangan (Controller), satpam ini akan memeriksa terlebih dahulu:
- *"Apakah kamu sudah punya kartu akses login?"*
- *"Apakah data kamu aman atau bawa virus/hacker?"*
- *"Apakah browser kamu boleh menyimpan rekaman ruangan ini ke cache?"*

---

## 2. File di Folder Ini: `PreventBackHistory.php`

### Masalah Nyata yang Sering Terjadi:
Bayangkan kamu sedang login di lab sekolah atau warnet. Setelah selesai mengelola web UMKM, kamu menekan tombol **"Logout"**. 
Lalu kamu beranjak pergi. Tiba-tiba teman sebelahmu iseng menekan tombol panah **"Back" (Kembali)** di browser. 
Pada website biasa, halaman dashboard admin langsung terbuka lagi dari memori cache browser! Bahaya banget kan?

### Solusi Cerdas yang Kita Buat:
Middleware `PreventBackHistory` ini menyuntikkan header khusus ke browser pengunjung:
```http
Cache-Control: no-cache, private, no-store, must-revalidate
Pragma: no-cache
Expires: Sun, 02 Jan 1990 00:00:00 GMT
```
Artinya kita berpesan ke browser: *"Jangan pernah sekali-kali simpan halaman ini di memori komputer! Setiap kali tombol Back ditekan, kamu WAJIB tanya ulang ke server!"*

Saat browser bertanya ulang ke server, Laravel tahu bahwa sesi login sudah dihancurkan, sehingga browser langsung ditolak dan otomatis dilempar ke halaman login!

---

## 3. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, middleware PreventBackHistory ini kami terapkan untuk mengatasi celah keamanan Back-Forward Cache (BFCache). Dengan menyuntikkan header HTTP `no-store, no-cache, must-revalidate`, browser dipaksa merefresh status otentikasi dari server saat tombol Back ditekan pasca logout, sehingga data dashboard tidak dapat diintip kembali."*
