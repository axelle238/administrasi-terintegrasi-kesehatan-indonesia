# SATRIA - Sistem Administrasi Terintegrasi Kesehatan Indonesia

**SATRIA (Sistem Administrasi Terintegrasi Kesehatan Indonesia)** adalah platform manajemen kesehatan enterprise yang dirancang untuk Fasilitas Kesehatan Tingkat Pertama (FKTP), Rumah Sakit, dan Unit Kerja Perangkat Daerah (UKPD) di sektor kesehatan. Sistem ini mengintegrasikan seluruh operasional mulai dari pelayanan medis, manajemen sumber daya manusia, keuangan, hingga aset dan logistik dalam satu ekosistem terpadu.

## 🚀 Fitur Utama & Arsitektur Dashboard

Sistem ini dibangun dengan pendekatan modular, memisahkan fungsi-fungsi vital ke dalam dashboard spesifik untuk efisiensi dan fokus kerja:

1.  **Dashboard Utama (Executive Command Center)**
    *   Ringkasan eksekutif seluruh operasional.
    *   Sistem Peringatan Dini (EWS) untuk logistik dan perizinan.
    *   Statistik pendapatan dan kunjungan real-time.

2.  **Dashboard Kesehatan (Medical Center)**
    *   Manajemen Rekam Medis Elektronik (RME).
    *   Monitoring Rawat Inap & Bed Occupancy Rate (BOR).
    *   Analisis tren penyakit dan demografi pasien.

3.  **Dashboard Kesehatan Masyarakat (UKM)**
    *   Surveilans penyakit berbasis wilayah.
    *   Manajemen kegiatan penyuluhan dan program komunitas.
    *   Pemetaan risiko kesehatan geografis.

4.  **Dashboard Kepegawaian (HRIS)**
    *   Database pegawai dan monitoring STR/SIP.
    *   Presensi digital, manajemen cuti, dan lembur.
    *   Evaluasi kinerja (KPI) dan pengembangan kompetensi.

5.  **Dashboard Keuangan (Finance)**
    *   Point of Sales (Kasir) & Billing System.
    *   Laporan pendapatan harian/bulanan.
    *   Manajemen arus kas.

6.  **Dashboard Aset & Logistik**
    *   Inventaris barang medis dan non-medis.
    *   Manajemen stok opname dan mutasi barang.
    *   Jadwal pemeliharaan aset dan fasilitas.

7.  **Dashboard Sistem (System Admin)**
    *   Konfigurasi global aplikasi.
    *   Manajemen pengguna dan hak akses (RBAC).
    *   Integrasi sistem eksternal (BPJS/SATUSEHAT).

8.  **Dashboard Keamanan (Security)**
    *   Audit trail dan log aktivitas user.
    *   Monitoring anomali akses dan keamanan data.
    *   Manajemen backup dan restore database.

## 🛠 Teknologi

*   **Backend:** Laravel 12 (PHP 8.2+)
*   **Frontend:** Livewire 4, Alpine.js 3, Tailwind CSS 4
*   **Database:** MySQL / MariaDB
*   **Testing:** Pest PHP
*   **Tools:** Spatie Permissions, ApexCharts

## 📦 Instalasi

1.  Clone repository:
    ```bash
    git clone https://github.com/axelle238/administrasi-terintegrasi-kesehatan-indonesia.git
    ```
2.  Install dependencies:
    ```bash
    composer install
    npm install
    ```
3.  Konfigurasi Environment:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  Setup Database & Migrations:
    ```bash
    php artisan migrate --seed
    ```
5.  Jalankan Aplikasi:
    ```bash
    npm run dev
    php artisan serve
    ```

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

---
*Dikembangkan dengan ❤️ untuk Kesehatan Indonesia.*