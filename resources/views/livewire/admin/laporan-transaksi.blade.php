<div class="main-panel">
    <div class="content-wrapper">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="font-weight-bold text-dark">Laporan</h4>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8 d-flex gap-2 flex-wrap align-items-center">
                <select wire:model.live="mode" class="form-select form-select-sm w-auto">
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
                @if($mode === 'harian')
                    <input type="date" wire:model.live="tanggal" class="form-control form-control-sm w-auto">
                @elseif($mode === 'mingguan')
                    <input type="number" min="1" max="53" wire:model="minggu" class="form-control form-control-sm w-auto"
                        placeholder="Minggu">
                    <input type="number" min="2020" max="2100" wire:model="tahun"
                        class="form-control form-control-sm w-auto" placeholder="Tahun">
                @else
                    <input type="number" min="1" max="12" wire:model="bulan" class="form-control form-control-sm w-auto"
                        placeholder="Bulan">
                    <input type="number" min="2020" max="2100" wire:model="tahun"
                        class="form-control form-control-sm w-auto" placeholder="Tahun">
                @endif
                <button class="btn btn-success btn-sm ms-2" wire:click="exportExcel"><i class="mdi mdi-file-excel"></i>
                    Export Excel</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-4">
                            <h5>Penghasilan Kapster (40% dari Jasa Cukur)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Kapster</th>
                                            <th class="text-end">Penghasilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($penghasilanKapster as $kapster)
                                            <tr>
                                                <td style="width:60px">
                                                    @if(!empty($fotoKapster[$kapster['nama']]))
                                                        <img src="{{ asset('storage/' . $fotoKapster[$kapster['nama']]) }}"
                                                            alt="{{ $kapster['nama'] }}"
                                                            style="width:40px;height:40px;object-fit:cover;border-radius:50%">
                                                    @else
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($kapster['nama']) }}"
                                                            alt="{{ $kapster['nama'] }}"
                                                            style="width:40px;height:40px;object-fit:cover;border-radius:50%">
                                                    @endif
                                                </td>
                                                <td>{{ $kapster['nama'] }}</td>
                                                <td class="text-end">Rp {{ number_format($kapster['fee'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($mode === 'mingguan' || $mode === 'bulanan')
                            <div class="mb-2">
                                <span class="badge bg-info">Jumlah Transaksi: {{ $data->total() }}</span>
                            </div>
                        @endif
                        <div class="table-responsive mt-4">
                            <table class="table table-striped table-bordered align-middle mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Kapster</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $i => $t)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $t->invoice }}</td>
                                            <td>{{ $t->created_at }}</td>
                                            <td>{{ $t->nama }}</td>
                                            <td>{{ $t->no_hp }}</td>
                                            <td>{{ optional($t->kapster)->nama ?? '-' }}</td>
                                            <td class="text-end">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end">Total Omzet</th>
                                        <th class="text-end text-success">Rp {{ number_format($total, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>