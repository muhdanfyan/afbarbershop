@push('styles')
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cashier-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
        }

        .cashier-header {
            background: #2c3e50;
            color: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .cashier-body {
            flex: 1;
            display: flex;
            padding: 1.5rem;
            gap: 1.5rem;
            max-height: calc(100vh - 70px);
            width: 100%;
            box-sizing: border-box;
        }

        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: #3498db;
        }

        .customer-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.6rem 0.75rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            max-height: 200px;
            overflow-y: auto;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .service-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 0.5rem;
            background: white;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .service-card.selected {
            border-color: #3498db;
            background: rgba(52, 152, 219, 0.05);
        }

        .service-card.selected::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            background: #3498db;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .service-card img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }

        .service-card h6 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            max-height: 200px;
            overflow-y: auto;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .staff-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 0.5rem;
            background: white;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .staff-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .staff-card.selected {
            border-color: #3498db;
            background: rgba(52, 152, 219, 0.05);
        }

        .staff-card.selected::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            background: #3498db;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .staff-card img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }

        .staff-card .staff-name {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .payment-section {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 2px solid #e9ecef;
        }

        .payment-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .payment-input {
            position: relative;
        }

        .payment-input label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        .payment-input .form-control {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-save {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(46, 204, 113, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(46, 204, 113, 0.4);
        }

        .receipt-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px dashed #e9ecef;
        }

        .receipt-header h5 {
            margin: 0;
            color: #2c3e50;
            font-weight: 700;
        }

        .receipt-header p {
            margin: 0.25rem 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .receipt-items {
            flex: 1;
            overflow-y: auto;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table th {
            text-align: left;
            padding: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            color: #495057;
            font-weight: 600;
        }

        .receipt-table td {
            padding: 0.5rem;
            border-bottom: 1px solid #f1f3f5;
        }

        .receipt-table .text-right {
            text-align: right;
        }

        .receipt-table .text-center {
            text-align: center;
        }

        .receipt-footer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed #e9ecef;
        }

        .receipt-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .invoice-display {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 992px) {
            .cashier-body {
                flex-direction: column;
                max-height: none;
            }

            .form-section,
            .receipt-section {
                max-height: none;
            }
        }

        @media (max-width: 768px) {

            .customer-info,
            .payment-row {
                grid-template-columns: 1fr;
            }

            .service-grid,
            .staff-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .cashier-body {
                padding: 1rem;
            }

            .service-grid,
            .staff-grid {
                grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
            }
        }
    </style>
@endpush
<div class="cashier-container">
    <div class="w-100 bg-dark d-flex align-items-center justify-content-between px-3 py-2"
        style="border-radius:0 0 1.5rem 1.5rem;">
        <span class="fw-bold text-warning" style="font-size:1.2rem;letter-spacing:1px;">TOTAL</span>
        <span class="fw-bold text-warning" style="font-size:2.1rem;">Rp
            {{ is_numeric($total) ? number_format($total, 0, ',', '.') : 0 }}</span>
    </div>

    <div class="cashier-body center" style="margin-left:auto; margin-right:auto;">
        <!-- Sidebar Transaksi Hari Ini -->
        <div class="col-lg-3 col-md-12 mb-3">
            <div class="form-section" wire:poll.5s style="min-height:300px; max-height:80vh; overflow-y:auto;">
                <div class="section-title"><i class="fas fa-list"></i> Transaksi Hari Ini</div>
                <div class="mb-2"><span class="badge bg-warning text-dark">Booking</span></div>
                <ul class="list-group mb-3">
                    @php
                        $estimasiPerOrang = 30;
                        $bookingIds = collect($transaksiBooking)->sortBy('created_at')->pluck('id')->values();
                    @endphp
                    @forelse($transaksiBooking as $trx)
                        @php
                            $antrian = $bookingIds->search($trx->id) !== false ? $bookingIds->search($trx->id) + 1 : 1;
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="cursor:pointer;" wire:click="isiFormDariTransaksi({{ $trx->id }})">
                            <div>
                                <span class="fw-bold">#{{ $antrian }} {{ $trx->nama }}
                                    @if($trx->status === 'menunggu' && $trx->invoice)
                                        <span class="text-muted small">&nbsp;({{ substr($trx->invoice, -4) }})</span>
                                    @endif
                                </span>
                                @if($trx->kapster && $trx->kapster->nama)
                                    <div class="text-muted small">Kapster: {{ $trx->kapster->nama }}</div>
                                @endif
                                @if($trx->waktu)
                                    <div class="text-muted small">Waktu: {{ $trx->waktu }}</div>
                                @endif
                                <div class="text-muted small">Estimasi menunggu: {{ ($antrian - 1) * $estimasiPerOrang }}
                                    menit</div>
                            </div>
                            <span class="badge bg-warning text-dark">{{ $trx->status }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada booking</li>
                    @endforelse
                </ul>
                <div class="mb-2"><span class="badge bg-primary">Proses</span></div>
                <ul class="list-group mb-3">
                    @forelse($transaksiProses as $trx)
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="cursor:pointer;" wire:click="isiFormDariTransaksi({{ $trx->id }})">
                            <div>
                                <span>{{ $trx->nama }}</span>
                                @if($trx->kapster && $trx->kapster->nama)
                                    <div class="text-muted small">Kapster: {{ $trx->kapster->nama }}</div>
                                @endif
                            </div>
                            <span class="badge bg-primary">{{ $trx->status }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada proses</li>
                    @endforelse
                </ul>
                <div class="mb-2"><span class="badge bg-success">Selesai</span></div>
                <ul class="list-group">
                    @forelse($transaksiSelesai as $trx)
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="cursor:pointer;" wire:click="isiFormDariTransaksi({{ $trx->id }})">
                            <span>{{ $trx->nama }}</span>
                            <span class="badge bg-success">{{ $trx->status }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada selesai</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <!-- Form Section -->
        <div class="col-lg-5 col-md-12 form-section">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form wire:submit.prevent="simpanTransaksi">
                <div class="invoice-display">
                    @if(isset($showRandomInvoice) && $showRandomInvoice && isset($randomInvoiceDisplay))
                        {{ $randomInvoiceDisplay }} | {{ date('d-m-Y') }}
                    @else
                        {{ $invoice }} | {{ date('d-m-Y') }}
                    @endif
                </div>

                <div class="section-title">
                    <i class="fas fa-user"></i> Informasi Pelanggan
                </div>

                <div class="customer-info">
                    <div>
                        <input type="text" class="form-control" wire:model.defer="nama" required
                            placeholder="Nama Pelanggan" list="datalist-member" id="input-nama-member">
                        <datalist id="datalist-member">
                            @foreach($listMember as $member)
                                <option value="{{ $member->nama }}" data-wa="{{ $member->nomor_wa }}">{{ $member->nama }} -
                                    {{ $member->nomor_wa }}
                                </option>
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <input type="text" class="form-control" wire:model.defer="no_hp" placeholder="Nomor WA" required
                            id="input-wa-member">
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const inputNama = document.getElementById('input-nama-member');
                        const inputWa = document.getElementById('input-wa-member');
                        const datalist = document.getElementById('datalist-member');
                        inputNama.addEventListener('input', function () {
                            const val = inputNama.value;
                            const option = Array.from(datalist.options).find(opt => opt.value === val);
                            if (option && option.dataset.wa) {
                                inputWa.value = option.dataset.wa;
                                // Untuk Livewire agar sinkron
                                inputWa.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                        });
                    });
                </script>

                <div class="section-title">
                    <i class="fas fa-cut"></i> Pilih Layanan
                </div>

                <div class="service-grid">
                    @foreach($listJasa as $j)
                        <div class="service-card{{ in_array($j->id, (array) $jasa) ? ' selected' : '' }}"
                            wire:click="toggleJasa({{ $j->id }})">
                            @if($j->foto)
                                <img src="{{ asset('storage/' . $j->foto) }}" alt="{{ $j->nama }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($j->nama) }}" alt="{{ $j->nama }}">
                            @endif
                            <h6>{{ $j->nama }}</h6>
                        </div>
                    @endforeach
                </div>

                <div class="section-title">
                    <i class="fas fa-user-tie"></i> Pilih Kapster
                </div>

                <div class="staff-grid">
                    @foreach($listKapster as $k)
                        <div class="staff-card{{ $kapster == $k->id ? ' selected' : '' }}"
                            wire:click="$set('kapster', {{ $k->id }})">
                            @if($k->foto)
                                <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}" alt="{{ $k->nama }}">
                            @endif
                            <div class="staff-name">{{ $k->nama }}</div>
                        </div>
                    @endforeach
                </div>
                @error('kapster') <div class="text-danger small mt-1">{{ $message }}</div> @enderror



        </div>

        <!-- Receipt Section -->
        <div class="col-lg-4 col-md-12 receipt-section">
            <div class="receipt-header">
                <h5>STRUK PEMBAYARAN</h5>
                <p>POSEIDON BARBERSHOP</p>
                <p>Tanggal: {{ date('d-m-Y') }}</p>
            </div>

            <div class="receipt-items">
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listJasa as $j)
                            @if(in_array($j->id, (array) $jasa))
                                <tr>
                                    <td>{{ $j->nama }}</td>
                                    <td class="text-center">1</td>
                                    <td class="text-right">Rp {{ number_format($j->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="receipt-footer">
                <div class="receipt-total">
                    <span>Total:</span>
                    <span>Rp {{ is_numeric($total) ? number_format($total, 0, ',', '.') : 0 }}</span>
                </div>

                <div class="mt-3 text-center">
                    <p class="mb-1">Terima Kasih</p>
                    <p class="mb-0">Silakan Datang Kembali</p>
                </div>
            </div>

            <div class="payment-section">
                <div class="section-title">
                    <i class="fas fa-credit-card"></i> Pembayaran
                </div>

                <div class="div">
                    <div class="col-12">
                        <label class="fw-bold">Uang Bayar</label>
                        <input type="number" class="form-control form-control-lg text-end" wire:model.live="uang_bayar"
                            min="0" value="0">
                    </div>
                    <div class="col-12">
                        <label class="fw-bold">Uang Kembali</label>
                        <input type="text" class="form-control form-control-lg text-end bg-light"
                            value="Rp {{ is_numeric($uang_kembali) ? number_format($uang_kembali, 0, ',', '.') : 0 }}"
                            readonly>
                    </div>
                    <div class="col-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100 py-2 me-2">Simpan & Print</button>
                        <button type="button" class="btn btn-warning w-100 py-2 ms-2" wire:click="prosesTransaksi"
                            name="proses" @if(isset($status) && $status === 'selesai') disabled @endif>Proses</button>
                        <button type="button" class="btn btn-secondary w-100 py-2 ms-2" wire:click="menungguTransaksi"
                            name="menunggu" @if(isset($status) && $status === 'selesai') disabled @endif>Menunggu</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('transaksi-updated', () => {
                Livewire.emit('refresh');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal-success', function (e) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: e.detail && e.detail.message ? e.detail.message : 'Transaksi berhasil disimpan!',
                timer: 1800,
                showConfirmButton: false
            });
        });
        window.addEventListener('swal-error', function (e) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: e.detail && e.detail.message ? e.detail.message : 'Transaksi gagal!',
                timer: 2200,
                showConfirmButton: false
            });
        });
        window.addEventListener('print-struk', function (e) {
            window.print();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[wire\:submit\.prevent="simpanTransaksi"]');
            if (form) {
                form.addEventListener('click', function (e) {
                    // Cek status selesai dari input hidden atau variabel JS jika perlu
                    var status = @json($status ?? null);
                    if (status === 'selesai') {
                        if (e.target && (e.target.name === 'proses' || e.target.name === 'menunggu')) {
                            e.preventDefault();
                            return false;
                        }
                    }
                    if (e.target && e.target.name === 'proses') {
                        e.preventDefault();
                        Livewire.find(form.closest('[wire\:id]').getAttribute('wire:id')).call('prosesTransaksi');
                    }
                    if (e.target && e.target.name === 'menunggu') {
                        e.preventDefault();
                        Livewire.find(form.closest('[wire\:id]').getAttribute('wire:id')).call('menungguTransaksi');
                    }
                });
            }
        });
    </script>
@endpush