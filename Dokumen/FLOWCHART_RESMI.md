# DIAGRAM ALUR (FLOWCHART) RESMI UJIKOM
## Platform Web Portofolio UMKM — CMS Web Builder
**Penyusun:** Hanan Aria Santagama (Kelas XII RPL 1 — SMKN 1 Majalengka)  
**Standar Pengujian:** Soal Uji Kompetensi Keahlian (Nomor 3) & Panduan Teknis PT Sawala Inovasi Indonesia

---

## 3.a. Proses Login Admin ke Dashboard

![Flowchart Login Admin](Flowchart_3a_Login_Admin.png)

```mermaid
flowchart LR
    A([Mulai]) --> B["Input Username & Password"]
    B --> C{"Data login<br/>valid?"}
    
    C -- "Tidak" --> D["Tampilkan pesan<br/>login gagal"]
    D -.-> B
    
    C -- "Ya" --> E["Buat session login<br/>& Catat audit log"]
    E --> F["Dashboard<br/>Admin"]
    F --> G{"Pilih<br/>tindakan?"}
    
    G -- "Logout" --> H["Hapus session<br/>& invalidate"]
    H --> I["Redirect ke<br/>halaman login"]
    I --> J([Selesai])
```

---

## 3.b. Proses Input Data, Validasi Ketersediaan Slug/URL, dan Penerbitan (Publish) Halaman Portofolio UMKM

![Flowchart Input Validasi Publish](Flowchart_3b_Input_Validasi_Publish.png)

```mermaid
flowchart LR
    A([Mulai]) --> B["Dashboard Admin<br/>> Buat Web Baru"]
    B --> C["Pilih Template Visual,<br/>Input Profil, Kontak,<br/>Logo, Produk & Slug"]
    C --> D{"Data input<br/>valid?"}
    
    D -- "Tidak" --> E["Tampilkan pesan<br/>kesalahan form"]
    E -.-> C
    
    D -- "Ya" --> F{"Cek Database:<br/>Slug tersedia?"}
    
    F -- "Tidak" --> G["Tampilkan notifikasi<br/>slug sudah dipakai"]
    G -.-> C
    
    F -- "Ya" --> H["Set status<br/>'publish'"]
    H --> I["Simpan data ke<br/>database MySQL"]
    I --> J["Catat aktivitas<br/>audit trail"]
    J --> K["Tampilkan URL<br/>web aktif"]
    K --> L([Selesai])
```

---

## 3.c. Proses Akses Publik Halaman Portofolio Berdasarkan Slug/URL & Penanganan Error 404

![Flowchart Akses Publik dan Penanganan 404](Flowchart_3c_Akses_Publik_404.png)

```mermaid
flowchart LR
    A([Mulai]) --> B["Pengunjung<br/>membuka URL/slug"]
    B --> C["Ambil slug<br/>dari URL request"]
    C --> D["Cari portofolio<br/>berdasarkan slug"]
    D --> E{"Data ditemukan<br/>& status published?"}
    
    E -- "Ya" --> F["Tampilkan halaman<br/>portofolio web UMKM"]
    F --> I([Selesai])
    
    E -- "Tidak" --> G{"Cek Riwayat:<br/>Ada di slug lama?"}
    
    G -- "Ya (SEO 301)" --> H1["Redirect HTTP 301<br/>ke slug baru"]
    H1 --> I
    
    G -- "Tidak" --> H2["Tampilkan halaman<br/>Error 404 Not Found"]
    H2 --> I
```
