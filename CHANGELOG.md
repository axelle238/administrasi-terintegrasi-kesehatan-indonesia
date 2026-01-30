# Changelog Pengembangan Sistem

## [Unreleased] - 2026-01-30

### Ditambahkan
- **Dashboard Terintegrasi:**
  - **Dashboard Admin:** Redesign UI Executive dengan ApexCharts untuk monitoring KPI real-time.
  - **Dashboard Medis:** Fitur analitik BOR, tren kunjungan, dan top diagnosa penyakit.
  - **Dashboard Farmasi:** Monitoring stok obat, valuasi aset, deteksi kedaluwarsa, dan tren penggunaan obat.
  - **Dashboard Keuangan:** Analisis arus kas (Income/Expense), margin laba, dan distribusi pendapatan per poli.
  - **Dashboard Aset:** Tracking kondisi aset, lokasi, dan jadwal pemeliharaan.
  - **Dashboard HRD:** Visualisasi komposisi SDM, tren kinerja kolektif, dan monitoring dokumen STR/SIP.
  - **Dashboard Keamanan (SOC):** Mode Lockdown, Firewall IP manual, Session Kill, dan Audit Log forensik.
  - **Dashboard Publik:** Monitoring IKM (Indeks Kepuasan Masyarakat) dan tren pengaduan.

- **Halaman Depan (Landing Page):**
  - Redesign total menggunakan Tailwind CSS modern.
  - Integrasi konten dinamis dengan Pengaturan Sistem.
  - Fitur "Ambil Antrean" dan "Cek Jadwal" yang lebih responsif.
  - Penambahan animasi dan transisi halus (Alpine.js).

- **Sistem Pengaturan:**
  - Panel konfigurasi terpusat untuk identitas instansi, tampilan, operasional, dan keamanan.

### Diubah
- **Navigasi Sidebar:** Pembaruan tautan menu untuk mengarah ke dashboard spesifik masing-masing modul.
- **Visualisasi Data:** Mengganti chart statis/CSS dengan ApexCharts interaktif di seluruh modul.
- **Bahasa:** Standardisasi seluruh antarmuka menggunakan Bahasa Indonesia baku.

### Keamanan
- Implementasi fitur "Lockdown Mode" untuk situasi darurat.
- Penambahan log aktivitas audit trail yang lebih terperinci.
