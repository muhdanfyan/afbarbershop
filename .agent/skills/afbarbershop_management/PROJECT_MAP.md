Dokumen ini adalah acuan utama (Single Source of Truth) untuk pemetaan struktur MVC, Routing, dan Prosedur Testing sistem AF Barbershop. Proyek ini mengikuti skema **Everything Claude Code (ECC)**.

## 🛠️ ECC Schema & Rules
Sistem ini dikelola menggunakan subagent spesialis dan aturan baku:
- **Rules**: `.agent/rules/common/coding-style.md`, `.agent/rules/php/laravel.md`, `.agent/rules/php/testing.md`.
- **Agents**: `planner`, `architect`, `code-reviewer` (Lihat `.agent/agents/`).
- **Skills**: `browser-free-workflow`, `laravel-verification`, `booking-test`, `whatsapp-test`, `kasir-test`, `admin-crud-test` (Lihat `.agent/skills/`).

## 🗺️ Route Matrix
Mapping URL ke komponen logic (Controller/Livewire).

| Method | Endpoint | Controller/Livewire | View | Deskripsi |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/` | `FrontController@index` | `front.index` | Landing Page & Katalog Produk. |
| `POST` | `/booking` | `BookingController@store` | `-` | API submission booking (Form Biasa). |
| `GET` | `/display-antrian` | `FrontDisplayAntrian@index` | `front.displayantrian` | Layar Monitor Antrian (Real-time). |
| `GET` | `/login` | `LoginController@index` | `backend.auth.login` | Halaman Login Admin/Kasir. |
| `GET` | `/admin/kasir` | `Livewire\Admin\KasirTransaksi` | `livewire.admin.kasir-transaksi` | Dashboard Utama Kasir (POS). |
| `GET` | `/admin/barang` | `AdminBarangController@index` | `backend.admin.barang` | Manajemen Stok Produk. |
| `GET` | `/admin/kapster` | `Route::view` | `backend.admin.kapster` | Manajemen Data Barber. |

---

## 🏗️ Struktur MVC & Database
Relasi antar basis data dan model Eloquent.

### 1. Model: `Transaksi` (transaksis)
- **Primary Hub**: Menghubungkan pelanggan, layanan, produk, dan kapster.
- **Relationships**:
  - `jasa()`: `belongsToMany` (Jasa) via `jasa_transaksi`.
  - `barangs()`: `belongsToMany` (Barang) via `transaksi_barang` (with `jumlah` pivot).
  - `kapster()`: `belongsTo` (Kapster).
- **Status Flow**: `menunggu` ➔ `proses` ➔ `selesai`.

### 2. Model: `Barang` (barangs)
- **Stok**: Kolom `stok` dikurangi otomatis saat `Transaksi` di Kasir diset ke **Selesai**.

### 3. Model: `Kapster` (kapsters)
- **Status**: `bekerja` (aktif muncul di form) atau `libur`.

---

## 🔄 Alur Fitur Utama (Feature Flow)

### A. Reservasi Online (Frontend)
1. **View**: `Front/BookingForm` (Livewire Component).
2. **Logic**: `BookingForm.php@submit` melakukan validasi double booking (slot 30m).
3. **Action**: Data disimpan ke `transaksis`, menonaktifkan slot waktu di UI via `loadAvailableSlots`.

### B. Transaksi & Kasir (POS)
1. **View**: `Admin\KasirTransaksi` (Livewire Component).
2. **Logic**: `KasirTransaksi.php@simpanTransaksi`.
3. **Stock Reduction**: Loop `barangs()` pada transaksi tersebut dan kurangi `stok` di DB.
4. **WhatsApp**: Struk otomatis dikirim via `WA_GATEWAY_URL`.

---

## 🧪 Panduan Testing (Browser-Free)
Sesuai dengan `browser-free-workflow`, semua pengujian dilakukan via CLI. **Jangan gunakan Antigravity Browser Control kecuali diminta.**

### 1. Double Booking (Logic Check)
- **Tes**: Booking Kapster X di jam 10:00. Coba booking kembali Kapster X di jam 10:15.
- **Hasil**: Sistem harus menolak (Validation Error).

### 2. WhatsApp Reminders (CLI Check)
- **Tes**: Buat booking untuk 15 menit ke depan. Jalankan `php artisan wa:remind`.
- **Hasil**: Log "Reminder sent" muncul dan pesan diterima WhatsApp.

### 3. POS & Stok (Database Check)
- **Tes**: Beli 1 produk di kasir. Selesaikan transaksi.
- **Hasil**: Cek tabel `barangs`, jumlah stok harus berkurang -1.

### 4. Display Real-time (Polling Check)
- **Tes**: Pantau `/display-antrian`. Masukkan antrian baru dari Admin.
- **Hasil**: Data terupdate otomatis dalam 5-10 detik (Polling).

### 5. Antrian Future-Day (Sidebar Check)
- **Tes**: Buat booking untuk besok hari.
- **Hasil**: Cek sidebar kasir, nama harus muncul di kategori "Antrian Booking" (Bukan antrian hari ini).
