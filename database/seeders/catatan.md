# Catatan Dokumentasi: Folder Seeders (`database/seeders/`)

---

## 1. Apa itu Database Seeder? (Bahasa Santai)
Seeder itu ibarat **"Penyuntik Data Otomatis"**! 💉
Bayangkan saat kamu uji kompetensi di depan guru/penguji, komputermu baru di-install ulang atau database-nya masih kosong melompong. 
Masa kamu harus buka phpMyAdmin terus ngetik akun admin satu per satu? Lama dan rawan salah ketik!
Nah, dengan Seeder, kamu cukup buka terminal dan ketik satu baris saja:
```bash
php artisan db:seed
```
Dalam 1 detik, akun admin utama langsung terbuat dan kamu bisa langsung mendemokan login di depan penguji!

---

## 2. Alur Cara Kerjanya
```
Siswa / Penguji mengetik: php artisan db:seed
                     │
                     ▼
File Master 'DatabaseSeeder.php' terpanggil
                     │
                     ▼
DatabaseSeeder memanggil 'AdminSeeder.php'
                     │
                     ▼
AdminSeeder memasukkan data:
- Nama    : Hanan Aria Santagama
- Username: hanan
- Password: Hash::make('hanan123')
                     │
                     ▼
Database MySQL terisi, siap login dan presentasi!
```

---

## 3. Akun Login Default Bawaan Seeder:
- **Username**: `hanan`
- **Password**: `hanan123`
- *Catatan*: Menggunakan method `Admin::updateOrCreate()`, jadi kalau seeder dijalankan berkali-kali pun, tidak akan terjadi error duplikasi data!

---

## 4. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, Database Seeder ini kami siapkan untuk otomatisasi inisialisasi akun administrator default. Kami menggunakan method `updateOrCreate()` agar proses seeding bersifat idempoten (tidak menyebabkan duplikasi record) dan password-nya otomatis dienkripsi dengan standar hash Bcrypt."*
