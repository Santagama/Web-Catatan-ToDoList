# Catatan Dokumentasi: 5 Template Portofolio UMKM (`resources/views/public/templates/`)

---

## 1. Apa Fungsi Folder Ini? (Bahasa Santai)
Folder ini berisi **5 Pilihan Desain Website UMKM** yang siap pakai! 🚀
Setiap kali admin membuat web baru dan memilih salah satu template, sistem otomatis menggunakan file Blade yang sesuai di folder ini:

1.  ☕ **`minuman.blade.php`** (Tema Amber / Kopi)
    *   Cocok untuk: Kedai Kopi, Kafe, Es Boba, Jus Buah, Minuman Kekinian.
    *   Fokus: Menampilkan menu minuman segar, harga, dan tombol order WhatsApp.
2.  🍔 **`makanan.blade.php`** (Tema Oranye Hangat)
    *   Cocok untuk: Rumah Makan, Warung Bakso, Katering, Kuliner Camilan.
    *   Fokus: Menampilkan foto hidangan makanan lezat dan pemesanan antar (delivery).
3.  📦 **`barang.blade.php`** (Tema Biru Retail)
    *   Cocok untuk: Toko Retail, Fashion/Baju, Gadget, Kerajinan Tangan, Produk Fisik.
    *   Fokus: Etalase katalog produk, spesifikasi, dan tombol beli langsung via WhatsApp.
4.  👤 **`tokoh.blade.php`** (Tema Cyan Elegan)
    *   Cocok untuk: Caleg, Tokoh Masyarakat, Praktisi, Profil Publik, Konsultan.
    *   Fokus: Foto profil besar, visi misi, rekam jejak pengabdian, dan kontak silaturahmi.
5.  ✂️ **`jasa.blade.php`** (Tema Emerald / Hijau Zamrud)
    *   Cocok untuk: Barbershop, Salon, Bengkel Servis Mobil/Motor, Studio Foto.
    *   Fokus: Daftar paket layanan servis, estimasi harga pengerjaan, dan tombol reservasi.

---

## 2. Cara Kerja Template Dinamis (Alur Sistem):
```
Pengunjung membuka alamat: localhost:8000/kopi-kenangan
                         │
                         ▼
PublicController memeriksa kolom 'template_id' pada data kopi-kenangan
Contoh: template_id = 'minuman'
                         │
                         ▼
Laravel memanggil file: public/templates/minuman.blade.php
                         │
                         ▼
Template Blade me-looping daftar produk dari database ($portfolio->products)
dan menampilkan nomor WhatsApp yang siap diklik untuk pemesanan langsung!
```

---

## 3. Fitur Teknis Hebat di Setiap Template:
*   **Format Pesan WhatsApp Otomatis**: Saat pengunjung klik *"Pesan via WhatsApp"*, chat WhatsApp langsung terisi pesan pembuka otomatis:
    `"Halo, saya ingin memesan [Nama Produk] dari website Anda..."`
*   **Aman dari Data Kosong**: Jika UMKM belum mengisi foto produk atau maps, template tetap tampil rapi tanpa ada icon gambar rusak (*broken image*).
*   **Responsif 100%**: Nyaman dibuka dari HP, tablet, maupun laptop.

---

## 4. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, sistem kami menyediakan 5 varian template industri berbeda. Setiap template dirancang responsif menggunakan Tailwind CSS v4, membaca katalog produk langsung dari data JSON Eloquent, dan terintegrasi otomatis dengan Call-to-Action WhatsApp pemesanan produk."*
