# DOKUMEN KELENGKAPAN APLIKASI
## PEMBUATAN WEB BUILDER UMKM
**RPL SMKN 1 MAJALENGKA**

---

### A. Latar Belakang

Kamu adalah pegawai sebuah perusahaan yang bergerak di bidang pembuatan web. Kamu ditugaskan pada divisi pembuatan web UMKM. Perusahaan menawarkan paket pembuatan website murah bagi UMKM, sehingga sistem yang dibangun harus mampu menangani banyak UMKM (multi-tenant) dalam satu aplikasi.

Tugasmu adalah merancang dan membangun aplikasi web builder UMKM, mulai dari halaman publik perusahaan, autentikasi admin, pengelolaan data UMKM, hingga halaman contoh template yang menampilkan data UMKM.

---

### B. Tujuan Pembelajaran

Setelah mengerjakan soal ini, peserta diharapkan mampu:
1. Merancang kebutuhan halaman aplikasi web builder multi-tenant.
2. Merancang database ternormalisasi dengan pemisahan entitas dan `tenant_id`.
3. Menentukan strategi validasi data, terutama pada slug yang bersifat unik global.
4. Membandingkan pendekatan *generating* dan *rendering* beserta konsekuensinya.
5. Menangani edge case dasar seperti duplikasi slug, penghapusan data, dan perubahan template.

---

### C. Langkah Pengerjaan

#### 1. Persiapan Kebutuhan
Detailkan halaman yang akan dibuat. Minimal mencakup halaman berikut.

##### 1.1 Halaman Publik Perusahaan
Halaman untuk mengiklankan bahwa perusahaan menyediakan paket pembuatan web murah untuk UMKM.  
**Wajib memuat:**
- Nama dan profil singkat perusahaan.
- Daftar paket pembuatan web.
- Keunggulan layanan.
- Call to action menuju halaman login admin atau form kontak.

##### 1.2 Halaman Login Admin
Halaman untuk masuk ke area admin.  
**Ketentuan:**
- Admin memasukkan username dan password.
- Password wajib disimpan dalam bentuk hash (misalnya bcrypt atau argon2), bukan plaintext.
- Sesi login menggunakan session cookie atau JWT; pilih salah satu dengan alasan yang jelas.
- Jika ada peran super admin dan admin UMKM, pisahkan hak aksesnya.
- Halaman admin tidak boleh dapat diakses tanpa login.

##### 1.3 Halaman Utama Admin (Dashboard)
Halaman utama setelah login.  
**Wajib menampilkan statistik, minimal:**
- Jumlah UMKM yang sudah terdaftar.
- Jumlah produk dari seluruh UMKM.
- Daftar UMKM terbaru.

##### 1.4 Halaman Create UMKM
Halaman untuk mendaftarkan UMKM yang memesan pembuatan web.  
**Form wajib mencakup:**
- **Form profil UMKM:** nama UMKM, deskripsi, alamat, kontak, logo.
- **Form barang/produk UMKM:** nama produk, harga, stok, deskripsi, gambar. Harus dapat menambah lebih dari satu produk.
- **Form pemilihan template:** pilihan template 1, 2, atau 3.
- **Alamat web UMKM (slug):** slug yang akan digunakan sebagai alamat publik UMKM.

**Validasi slug wajib dispesifikasikan sebagai berikut:**
- **Format slug:** huruf kecil, angka, dan tanda hubung; tidak diawali atau diakhiri tanda hubung; panjang minimal dan maksimal ditentukan.
- **Uniqueness scope:** slug harus unik secara global di seluruh platform, karena slug digunakan sebagai alamat publik UMKM (contoh: `domain.com/nama-umkm`).
- **Validasi aplikasi dan database:** selain validasi di aplikasi, wajib ada UNIQUE constraint pada kolom slug di database untuk mencegah race condition saat dua request menyimpan slug yang sama secara bersamaan.
- **Penanganan duplikat:** jika slug sudah dipakai, sistem tidak hanya menolak, tetapi memberikan opsi auto-suffix (misalnya `nama-umkm-1`, `nama-umkm-2`) atau menampilkan pesan error yang jelas.
- **Perubahan slug:** jika slug diubah, sistem harus menyimpan slug lama dan menyediakan redirect dari slug lama ke slug baru agar tautan lama tidak rusak.

**Edge case yang harus dipikirkan:**
- Apa yang terjadi jika slug yang diminta sudah dipakai UMKM lain?
- Apa yang terjadi jika UMKM dihapus? Apakah slug dapat dipakai ulang? Apakah data produk dan profil ikut terhapus?
- Apa yang terjadi jika template yang dipilih UMKM dihapus dari master template?
- Bagaimana validasi upload gambar produk (tipe file, ukuran maksimal, lokasi penyimpanan)?

##### 1.5 Halaman List UMKM
Halaman daftar UMKM dengan informasi penting seadanya, minimal:
- Nama UMKM.
- Slug/alamat web.
- Template yang dipilih.
- Jumlah produk.
- Status.
- Aksi menuju detail/edit.

##### 1.6 Halaman Detail UMKM
Halaman yang menampilkan seluruh informasi UMKM, meliputi:
- Profil UMKM.
- Daftar produk.
- Template yang dipilih.
- Slug/alamat web.
- Tanggal dibuat dan diperbarui.

##### 1.7 Halaman Edit/Update UMKM
Isi form sama dengan halaman create, tetapi digunakan untuk memperbarui data UMKM yang sudah ada. Validasi slug tetap berlaku, termasuk pengecualian terhadap slug milik UMKM itu sendiri.

##### 1.8 Halaman Contoh Template 1, 2, dan 3
Buat tiga halaman contoh template dengan layout berbeda.  
**Ketentuan penting:**
- Setiap halaman template wajib membaca data dari satu UMKM contoh (melalui slug atau query parameter, misalnya `?umkm_id=` atau `/contoh/nama-umkm`).
- Data yang ditampilkan minimal: nama UMKM, deskripsi profil, daftar produk, dan kontak.
- Template tidak boleh hanya statis/hardcoded; harus menunjukkan integrasi antara data `profil_umkm` dan `produk` dengan layout template.

##### 1.9 Halaman Tambahan Sesuai Kebutuhan
**Minimal tambahkan:**
- Halaman 404/error.
- Halaman kelola master template (opsional, tetapi disarankan).
- Halaman konfirmasi sebelum menghapus UMKM.
- Dan lain-lain.

---

#### 2. Desain Database

##### 2.1 Prinsip Desain
- Gunakan pendekatan *shared schema multi-tenant*: setiap data yang dimiliki UMKM diikat dengan `umkm_id` atau `tenant_id`.
- Pisahkan entitas agar data tidak menumpuk di satu tabel.
- Tabel admin terpisah dari tabel tenant/UMKM; admin adalah aktor platform, bukan bagian dari UMKM.
- Gunakan foreign key dan constraint yang jelas.
- Gunakan UNIQUE constraint pada slug.
- Tentukan kebijakan ON DELETE secara eksplisit:
  - Jika UMKM dihapus, data `profil_umkm`, `produk`, dan `umkm_template` ikut terhapus (`ON DELETE CASCADE`).
  - Jika template master dihapus, gunakan `ON DELETE RESTRICT` agar template yang sedang dipakai tidak hilang begitu saja, atau `SET NULL` jika UMKM diizinkan tanpa template.

##### 2.2 ERD (Deskripsi Tekstual)
**Relasi utama:**
- `admin` berdiri sendiri (tidak memiliki relasi tenant).
- `umkm` memiliki satu `profil_umkm` (relasi 1:1).
- `umkm` memiliki banyak `produk` (relasi 1:N).
- `umkm` memilih satu template melalui tabel `umkm_template` (relasi 1:1 atau 1:N jika menyimpan riwayat pemilihan).
- `template` adalah master data yang berdiri sendiri.

##### 2.3 Struktur Tabel Minimal

###### Tabel `admin`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | PK | |
| username | VARCHAR, UNIQUE | |
| password_hash | VARCHAR | Hash bcrypt/argon2 |
| role | VARCHAR | Misalnya `super_admin`, `admin` |
| created_at | DATETIME | |

###### Tabel `umkm`/`tenant`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | PK | |
| tenant_id | VARCHAR/UUID, UNIQUE | Identitas tenant |
| nama_umkm | VARCHAR | |
| slug | VARCHAR, UNIQUE | Alamat publik, unik global |
| status | VARCHAR | Misalnya `aktif`, `nonaktif` |
| created_at | DATETIME | |
| updated_at | DATETIME | |

###### Tabel `profil_umkm`
| Kolom | Tipe | Keterangan |
|---|---|---|
| umkm_id | PK, FK ke umkm.id, ON DELETE CASCADE | Relasi 1:1 |
| deskripsi | TEXT | |
| alamat | TEXT | |
| kontak | VARCHAR | |
| logo_url | VARCHAR | Opsional |

###### Tabel `produk`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | PK | |
| umkm_id | FK ke umkm.id, ON DELETE CASCADE | |
| nama | VARCHAR | |
| harga | DECIMAL | |
| stok | INT | |
| deskripsi | TEXT | |
| gambar_url | VARCHAR | Opsional |

###### Tabel `template`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | PK | |
| kode | VARCHAR, UNIQUE | Misalnya `template-1` |
| nama | VARCHAR | |
| deskripsi | TEXT | |
| file_path | VARCHAR | Lokasi file template |

###### Tabel `umkm_template`
| Kolom | Tipe | Keterangan |
|---|---|---|
| umkm_id | FK ke umkm.id, ON DELETE CASCADE | |
| template_id | FK ke template.id, ON DELETE RESTRICT | |
| dipilih_pada | DATETIME | |

**Index yang disarankan:**
- `umkm.slug` (UNIQUE).
- `produk.umkm_id`.
- `umkm_template.umkm_id`.
- `umkm.tenant_id`.

---

#### 3. Logika Program

Ada dua teknologi umum yang dipakai dalam web builder: *generating* dan *rendering*.  
Bandingkan keduanya, tetapi jangan hanya menuliskan "cepat vs lambat"; jelaskan nuansanya.

##### 3.1 Generating (Static Site Generation)
- **Cara kerja:** Halaman publik UMKM dibangun menjadi file statis pada saat build/redeploy.
- **Kelebihan:**
  - Loading cepat karena halaman disajikan sebagai file statis.
  - Beban server rendah saat runtime.
- **Kekurangan:**
  - Boros storage karena setiap UMKM memiliki file halaman sendiri.
  - Tidak otomatis berubah ketika data UMKM berubah. Jika UMKM mengubah harga produk atau profil, halaman tidak ikut berubah sampai dilakukan rebuild/redeploy.
  - Semakin banyak tenant dan produk, semakin lama proses build.

##### 3.2 Rendering (Server-Side Rendering)
- **Cara kerja:** Halaman publik UMKM dirender saat ada request dengan membaca data dari database.
- **Kelebihan:**
  - Hemat storage karena tidak perlu menyimpan banyak file halaman statis.
  - Perubahan data langsung terlihat tanpa rebuild.
- **Kekurangan:**
  - Beban server selalu aktif karena setiap request membaca database.
  - Waktu loading dapat lebih lama jika query tidak dioptimalkan.
  - Biaya komputasi lebih tinggi dibanding penyajian file statis.

##### 3.3 Pertanyaan Analisis Wajib
Jawab pertanyaan berikut dalam laporan:
1. Jika UMKM A mengubah harga produk, apakah halaman publik UMKM A langsung berubah pada pendekatan *generating*? Jelaskan konsekuensinya.
2. Jika terdapat 500 tenant aktif dan masing-masing memiliki 20 produk, pendekatan mana yang lebih realistis? Jelaskan alasanmu.
3. Kapan sebaiknya memilih *generating*, dan kapan sebaiknya memilih *rendering*, untuk web builder UMKM?
4. Jelaskan bagaimana *caching* atau *Incremental Static Regeneration* (ISR) dapat menjadi jalan tengah antara *generating* dan *rendering*.
5. Jika memilih *generating*, mekanisme apa yang harus disiapkan agar perubahan data UMKM dapat memicu rebuild halaman terkait?

---

### D. Deliverables

Kumpulkan:
1. Dokumen kebutuhan halaman.
2. ERD dan skema database (SQL atau diagram).
3. Mockup atau rancangan antarmuka untuk halaman utama.
4. Implementasi aplikasi (minimal halaman publik, login, dashboard, create, list, detail, edit, dan tiga contoh template).
5. Laporan perbandingan *generating* vs *rendering* beserta jawaban pertanyaan analisis.
6. Daftar edge case yang ditangani dan cara penanganannya.
