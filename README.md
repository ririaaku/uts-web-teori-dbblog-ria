# 📝 Sistem Manajemen Blog (CMS) - UTS Pemrograman Web

Project ini adalah Sistem Manajemen Konten (CMS) sederhana untuk mengelola artikel blog, dikembangkan sebagai tugas UTS mata kuliah Pemrograman Web.

## 🚀 Fitur Utama
* **Kelola Penulis:** CRUD data penulis dengan enkripsi password menggunakan **BCRYPT** dan manajemen foto profil.
* **Kelola Kategori:** Manajemen kategori artikel secara dinamis.
* **Kelola Artikel:** Penulisan artikel dengan fitur upload gambar wajib/opsional dan format tanggal otomatis dalam Bahasa Indonesia.
* **Relasi Database:** Implementasi JOIN antar tabel (Artikel, Penulis, Kategori).

## 🛡️ Keamanan & Validasi (Security Focus)
* **SQL Injection Prevention:** Menggunakan **Prepared Statements** (mysqli) untuk seluruh operasi database.
* **Secure File Upload:** * Validasi tipe file menggunakan **finfo** (MIME Type check).
    * Pembatasan ukuran file maksimal **2 MB**.
    * Proteksi folder upload menggunakan **.htaccess** (Deny PHP execution).
* **XSS Protection:** Sanitasi output menggunakan `htmlspecialchars()`.

## 🛠️ Tech Stack
* **Language:** PHP (Native)
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
* **Tools:** Laragon / XAMPP

## ⚙️ Cara Instalasi
1. Clone repository ini.
2. Buat database baru bernama `db_blog` (atau sesuaikan dengan file koneksi).
3. Import file `db_blog.sql` ke dalam phpMyAdmin Anda.
4. Pastikan folder `uploads_penulis/` dan `uploads_artikel/` tersedia dan memiliki izin akses tulis (write permission).
5. Jalankan project melalui server lokal.

---
**Developed by:** [Ria Kurniawati](https://github.com/username_kamu)  
**Jurusan:** Teknik Informatika - UIN Maulana Malik Ibrahim Malang
