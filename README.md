# 💰 Sistem Pengelolaan Kas Internal (E-Kas)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Soft UI Dashboard](https://img.shields.io/badge/Soft%20UI%20Dashboard-Creative%20Tim-cb0c9f?style=for-the-badge)

**Sistem Pengelolaan Kas Internal** adalah aplikasi berbasis web yang dirancang untuk mempermudah pencatatan, pelacakan, dan pelaporan arus kas (pemasukan dan pengeluaran) operasional perusahaan secara digital.

Proyek ini dikembangkan sebagai bagian dari **Proyek Magang (Internship)** di **PT. Electronic Data Interchange Indonesia (EDII)**.

---

## ✨ Fitur Utama

### 📊 Dashboard Interaktif
- Ringkasan total saldo kas saat ini.
- Grafik arus kas (Pemasukan vs Pengeluaran).
- Statistik transaksi harian/bulanan.

### 💸 Manajemen Transaksi
- **Pencatatan Kas Masuk & Keluar:** Form input yang mudah digunakan untuk mencatat transaksi.
- **Upload Bukti Transaksi:** Lampirkan foto/file bukti pembayaran (struk/nota) pada setiap transaksi.
- **Status Transaksi:** Verifikasi transaksi (Pending/Approved/Rejected) oleh admin/supervisor.

### 📄 Laporan & Cetak
- **Riwayat Transaksi:** Tabel data transaksi yang dapat difilter berdasarkan tanggal.
- **Cetak Laporan:** Fitur `Print Report` untuk mencetak laporan keuangan dalam format siap cetak (*print-friendly view*).

### 🔐 Manajemen Pengguna (Auth)
- **Multi-Role:** Pembagian hak akses antara Admin (Penyetuju) dan Staff (Penginput).
- **Profil Pengguna:** Update informasi profil dan password.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP, Laravel Framework
- **Frontend:** Blade Templates, [Soft UI Dashboard](https://www.creative-tim.com/product/soft-ui-dashboard) (Bootstrap 5)
- **Database:** MySQL
- **Assets Management:** Vite

---

## 🚀 Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Clone Repositori
```bash
git clone [https://github.com/TeguhAldianto/pengelolaan-kas-internal-magang-ediii.git](https://github.com/TeguhAldianto/pengelolaan-kas-internal-magang-ediii.git)
cd pengelolaan-kas-internal-magang-ediii

```

### 2. Install Dependencies

```bash
composer install
npm install

```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env` dan atur database:

```bash
cp .env.example .env

```

Buka file `.env` dan sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kas_internal_db
DB_USERNAME=root
DB_PASSWORD=

```

### 4. Generate Key & Migrasi

```bash
php artisan key:generate
php artisan migrate --seed

```

*(Gunakan `--seed` jika kamu memiliki UserSeeder untuk akun admin default)*

### 5. Link Storage

Agar bukti transaksi (gambar) dapat diakses publik:

```bash
php artisan storage:link

```

### 6. Build Assets & Jalankan Server

```bash
npm run build
php artisan serve

```

Akses aplikasi di: `http://localhost:8000`

---

## 📂 Struktur Proyek Penting

* `app/Http/Controllers/TransactionController.php` - Logika utama pencatatan kas.
* `app/Models/Transaction.php` - Model data transaksi.
* `resources/views/report-print.blade.php` - Template cetak laporan.
* `public/assets/` - Aset tema Soft UI Dashboard.

---

## 👨‍💻 Author

**Teguh Aldianto**

* 📧 Email: [aldinamanya08@gmail.com](mailto:aldinamanya08@gmail.com)
* 💼 LinkedIn: [Teguh Aldianto](https://www.linkedin.com/in/teguh-aldianto-705653298)

---

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT License](https://opensource.org/licenses/MIT).
