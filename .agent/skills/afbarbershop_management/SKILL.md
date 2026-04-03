# AF Barbershop Management Skill

Pemandu teknis untuk pengembangan dan manajemen sistem AF Barbershop. Dokumentasi ini ditujukan untuk tim teknis (FE, BE, DevOps) dan agen AI.

## 🗄️ Kredensial & Lingkungan (DevOps)
> [!IMPORTANT]
> **Akses VPS Utama**
> - **Host IP**: `157.10.252.74`
> - **User**: `sipanda`
> - **Password**: `MpadSecure2026!`
> - **Path Proyek Server**: `/home/sipanda/afbarbershop`

**Konfigurasi Database (Produksi)**
- **DB Name**: `afbarbershop`
- **User**: `afbarbershop_user`
- **Pass**: `AfBarberSecure2026!`

---

## 🎨 Frontend (FE)
Sistem menggunakan **TALL Stack** dengan desain kustom *Gold & Black*.

### Arsitektur UI
- **Livewire Components**:
  - `Front/BookingForm`: Form reservasi pelanggan dengan validasi slot waktu real-time.
  - `Admin/KasirTransaksi`: Dashboard POS kasir premium.
  - `Admin/SettingIndex`: Pengaturan sistem termasuk YouTube Playlist ID.
- **Blade Templates**: Terpusat di `resources/views/front` (User) dan `resources/views/livewire/admin` (Admin).
- **Tema**: Sistem tema dinamis (Dark/Light) dikendalikan via `app.js` dan Tailwind CSS `dark:` mode.

---

## ⚙️ Backend (BE)
Logika bisnis terpusat pada manajemen antrian dan integrasi pihak ketiga.

### Fitur Kunci
1.  **Pencegahan Double Booking**:
    - Validasi dilakukan di `BookingForm.php` dengan mengecek slot 30 menit di sekitar waktu yang dipilih untuk kapster tertentu.
2.  **Otomatisasi WhatsApp**:
    - **Gateway**: Menggunakan Node.js gateway di port `3001` (lihat folder `wagateway`).
    - **Reminders**: Command `wa:remind` mengirim pesan pada menit ke-15, 10, dan 5 sebelum booking.
    - **Scheduler**: Terdaftar di `routes/console.php` untuk dijalankan setiap menit.
3.  **Manajemen Stok**:
    - Relasi *many-to-many* antara `Transaksi` dan `Barang` via tabel `transaksi_barang`.
    - Stok otomatis berkurang di `KasirTransaksi.php@simpanTransaksi`.

---

## 🚀 Panduan Deployment (DevOps)
1.  **Local Setup**:
    - Pastikan `.env` memiliki kredensial VPS yang benar.
    - Jalankan `npm run build` sebelum push aset.
2.  **Database Migration**:
    - Gunakan `php artisan migrate --force` di server untuk sinkronisasi skema produk & transaksi.
3.  **WhatsApp Gateway**:
    - Pastikan service node berjalan di latar belakang server (menggunakan `pm2` atau `systemd`).

---

## 📋 Audit Pekerjaan (Selesai Apr 2026)
- [x] Fitur 1-7 (Booking, Reminder, Queue, Product, Sort).
- [x] Integrasi YouTube Playlist di Display Antrian.
- [x] Tema Dark/Light pada Landing Page.
- [x] Setup environment deployment di `.env`.

---

## 🧪 Panduan Testing (Verification)
Gunakan panduan ini untuk memverifikasi fungsionalitas sistem secara manual.

### 1. Booking & Double Booking
- **Langkah**: Lakukan booking untuk Kapster A pada jam 10:00. Coba lakukan booking kembali untuk Kapster A pada jam 10:00 atau 10:15.
- **Ekspektasi**: Sistem menolak booking kedua dengan pesan error "Jadwal sudah terisi".

### 2. WhatsApp Reminders (CLI)
- **Langkah**: Buat booking untuk 15 menit dari sekarang. Jalankan `php artisan wa:remind`.
- **Ekspektasi**: Muncul log "Reminder sent" di terminal dan pesan masuk ke WhatsApp tujuan.

### 3. POS Kasir & Stok Produk
- **Langkah**: Buat transaksi di Dashboard Kasir, pilih layanan dan 1 produk (misal: Pomade). Klik "Simpan & Selesai".
- **Ekspektasi**: Stok Pomade di menu **Admin > Barang** berkurang 1 secara otomatis.

### 4. Display Antrian (Real-time)
- **Langkah**: Buka halaman `/display-antrian`. Lakukan booking baru dari HP lain.
- **Ekspektasi**: Nama pelanggan baru muncul di layar TV/Display dalam maks 5 detik tanpa refresh.

### 5. Antrian Hari Esok
- **Langkah**: Buat booking untuk tanggal besok. Cek sidebar antrian di layar Kasir.
- **Ekspektasi**: Nama pelanggan untuk besok muncul di bagian "Antrian Booking".

---

## 🔍 Verifikasi & Monitoring WA Gateway
Gunakan panduan ini untuk memastikan layanan WhatsApp tetap aktif dan terhubung.

### 1. Cek Status Service (Health Check)
- **Endpoint**: `GET http://localhost:3001/`
- **Output Penting**:
  - `status: "connected"` ➔ Layanan aktif dan terhubung ke WhatsApp.
  - `status: "initializing"` atau `"closed"` ➔ Layanan sedang proses atau terputus.
  - `hasQr: true` ➔ Perlu scan QR (lihat `/api/qr`).

### 2. Startup Terpadu (Development)
Gunakan perintah berikut untuk menjalankan Laravel dan WA Gateway secara bersamaan:
```bash
php artisan dev
```
Perintah ini akan menjalankan `php artisan serve` dan `node index.js` secara paralel dalam satu terminal.

### 3. Log Aktivitas
Pantau terminal saat menjalankan `php artisan dev` untuk melihat log dengan prefix:
- `[WA Gateway]` ➔ Log dari Baileys/Node.js.
- `[Laravel]` ➔ Log dari server PHP.

### 4. Troubleshooting Koneksi
- **Restart Manual**: Jika koneksi terputus, kirim request `POST http://localhost:3001/api/reconnect` dengan API Key.
- **Reset Sesi**: Jika QR tidak muncul atau error persisten, hapus folder `wagateway/auth_info_baileys` dan jalankan ulang service.
