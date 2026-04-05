# 🗺️ AF Barbershop — Development Roadmap

> Dokumen ini berisi rencana pengembangan fitur AF Barbershop yang disusun berdasarkan prioritas dan dampak bisnis.

---

## Phase 1: Core Business (Selesai ✅)

- [x] Booking Online (halaman utama)
- [x] Manajemen Jasa (CRUD)
- [x] Manajemen Kapster (CRUD)
- [x] Manajemen Kursi / Seat (CRUD + booking integration)
- [x] Kasir / POS (transaksi, pembayaran tunai/QRIS)
- [x] Display Antrian (real-time)
- [x] Manajemen Member
- [x] Manajemen Barang / Produk
- [x] Laporan Transaksi
- [x] Gallery
- [x] Playlist Studio (YouTube + Spotify)
- [x] WhatsApp Gateway (auto-reply, pengingat)
- [x] Dark/Light Mode (time-based default)
- [x] Setting Umum (profil usaha, jam operasional)

---

## Phase 2: Customer Retention & Revenue 🔥

### 2.1 Loyalty & Poin Member
- [ ] Sistem poin per transaksi (misal: Rp10.000 = 1 poin)
- [ ] Tukar poin dengan diskon / layanan gratis
- [ ] Level member (Silver, Gold, Platinum) berdasarkan total kunjungan
- [ ] Tampilkan poin di halaman booking & struk kasir
- [ ] Riwayat poin (penambahan & penukaran)

### 2.2 Promo & Voucher
- [ ] CRUD kode promo (diskon %, potongan Rp, gratis jasa)
- [ ] Validasi kode promo saat booking & di kasir
- [ ] Masa berlaku promo (tanggal mulai/selesai)
- [ ] Kuota penggunaan promo (misal: 50x pakai)
- [ ] Promo khusus member level tertentu

### 2.3 Rating & Review Kapster
- [ ] Form rating (1-5 bintang) setelah transaksi selesai
- [ ] Kirim link rating via WhatsApp otomatis
- [ ] Tampilkan rata-rata rating di halaman booking
- [ ] Dashboard rating per kapster di admin
- [ ] Filter kapster berdasarkan rating

---

## Phase 3: Operasional & HR 💼

### 3.1 Komisi Kapster
- [ ] Setting komisi per kapster (% atau flat per jasa)
- [ ] Hitung komisi otomatis dari transaksi
- [ ] Laporan komisi per periode (harian/mingguan/bulanan)
- [ ] Export laporan komisi (PDF / Excel)

### 3.2 Absensi Kapster
- [ ] Check-in / Check-out harian (tombol atau QR)
- [ ] Otomatis update status kapster (bekerja/libur)
- [ ] Jadwal shift mingguan
- [ ] Rekap absensi bulanan
- [ ] Integrasi dengan perhitungan komisi

### 3.3 Laporan Keuangan Detail
- [ ] Dashboard grafik pendapatan (harian/mingguan/bulanan)
- [ ] Perbandingan performa antar kapster
- [ ] Jasa & produk terlaris
- [ ] Tren pelanggan (customer growth)
- [ ] Export laporan (PDF / Excel)
- [ ] Pengeluaran operasional (opsional)

---

## Phase 4: Customer Experience 🎯

### 4.1 Riwayat Booking Customer
- [ ] Halaman riwayat kunjungan per customer (via nomor WA)
- [ ] Repeat order: "Pesan lagi seperti terakhir"
- [ ] Layanan favorit customer

### 4.2 Estimasi Waktu Tunggu Real-time
- [ ] Hitung estimasi berdasarkan antrian aktif + durasi jasa
- [ ] Tampilkan di halaman booking: "Estimasi tunggu: ~15 menit"
- [ ] Tampilkan di display antrian

### 4.3 Galeri Before/After
- [ ] Upload foto hasil potongan per kapster
- [ ] Kategorisasi gaya rambut
- [ ] Tampilkan sebagai portofolio di halaman utama
- [ ] Customer bisa pilih gaya saat booking

### 4.4 Notifikasi WA Lanjutan
- [ ] Reminder otomatis H-1 booking
- [ ] Ucapan ulang tahun member
- [ ] Broadcast promo bulanan
- [ ] Notifikasi poin mendekati reward
- [ ] Follow-up "Sudah lama tidak berkunjung"

---

## Phase 5: Skalabilitas 🚀

### 5.1 Multi-Cabang
- [ ] Manajemen cabang (nama, alamat, jam operasional)
- [ ] Kapster & kursi per cabang
- [ ] Booking pilih cabang
- [ ] Laporan per cabang & konsolidasi
- [ ] Admin per cabang (role-based)

### 5.2 API & Integrasi
- [ ] REST API untuk integrasi pihak ketiga
- [ ] Google Calendar sync untuk booking
- [ ] Integrasi pembayaran online (Midtrans/Xendit)
- [ ] Instagram feed integration di halaman utama

---

## Catatan Teknis

> [!TIP]
> **Urutan pengerjaan yang disarankan:**
> Phase 2.1 (Loyalty) → Phase 2.3 (Rating) → Phase 3.1 (Komisi) → Phase 2.2 (Promo)
> Ini memberikan dampak bisnis terbesar dengan effort yang terukur.

> [!IMPORTANT]
> Setiap fitur baru harus mengikuti **Premium Admin CRUD Standard** yang sudah diterapkan di semua modul existing.
