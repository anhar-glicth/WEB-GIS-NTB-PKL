# 🌍 WEB-GIS-NTB-PKL
Sistem Informasi Geografi (SIG) Pemetaan Wilayah Pertambangan Provinsi NTB berbasis **CodeIgniter 4**, **Leaflet.js**, dan **SB Admin 2**.

---

## 🚀 Cara Menjalankan Aplikasi

Jika Anda ingin menjalankan server lokal dengan command line:

1. **Buka Terminal/CMD** di folder utama proyek.
2. Ketik perintah berikut:
   ```bash
   php spark serve
   ```
3. Buka browser di alamat: `http://localhost:8080`

*Atau, jika menggunakan XAMPP secara langsung:*
Akses via: `http://localhost/WEB-GIS-NTB-PKL/public`

---

## 🔐 Akun & Password (Terdaftar di Database)

Gunakan daftar akun di bawah ini untuk menguji masing-masing fitur sesuai hak aksesnya:

| Role | Username | Email | Password |
| :--- | :--- | :--- | :--- |
| **👑 Admin** | `admin` | `admin@admin.com` | `admin123` |
| **👮 Petugas** | `petugas` | `petugas@petugas.com` | `petugas123` |
| **🏢 User** | `user` | `user@user.com` | `user123` |

---

## 🛠️ Persiapan Database
1. Pastikan Apache dan MySQL menyala via **XAMPP**.
2. Buat database baru di phpMyAdmin dengan nama **`gis`**.
3. Impor file **`gis.sql`** (struktur dasar).
4. **PENTING**: Jalankan query di file **`database_fix.sql`** (melalui tab SQL) untuk sinkronisasi data relasi, CMS, dan fitur terbaru.

---

## 🗺️ Fitur Utama
- **SIG Area**: Menggambar poligon wilayah tambang langsung di peta.
- **CMS Landing Page**: Ganti foto latar dan judul website via Dashboard Admin.
- **Account Security**: Ganti Profil dan Password mandiri untuk semua Role.
- **Verification Flow**: Petugas bisa Memberi ACC atau Menolak laporan dengan catatan.

---

**Dikembangkan oleh:** Tim PKL - Dinas ESDM Prov. NTB.