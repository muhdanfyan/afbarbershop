<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Data Transaksi</h4>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" wire:model.live="search" class="form-control" placeholder="Cari nama...">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="?status=menunggu"
                                class="btn btn-warning btn-sm mr-2 {{ $status == 'menunggu' ? 'font-weight-bold' : '' }}">Menunggu</a>
                            <a href="?status=proses"
                                class="btn btn-primary btn-sm mr-2 {{ $status == 'proses' ? 'font-weight-bold' : '' }}">Proses</a>
                            <a href="?status=selesai"
                                class="btn btn-success btn-sm {{ $status == 'selesai' ? 'font-weight-bold' : '' }}">Selesai</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Layanan</th>
                                        <th>Kapster</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Nominal Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $trx)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                                            <td>{{ $trx->nama }}</td>
                                            <td>
                                                @if($trx->jasa && $trx->jasa->count())
                                                    <ul class="mb-0 pl-3">
                                                        @foreach($trx->jasa as $j)
                                                            <li>{{ $j->nama }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $trx->kapster->nama ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $statusColor = [
                                                        'menunggu' => 'warning',
                                                        'proses' => 'primary',
                                                        'selesai' => 'success',
                                                    ][$trx->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $statusColor }}">
                                                    {{ ucfirst($trx->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $trx->catatan ?? '-' }}</td>
                                            <td>Rp{{ number_format($trx->uang_bayar ?? 0, 0, ',', '.') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary" wire:click="$set('detailId', {{ $trx->id }})">
                                                    Detail
                                                </button>
                                            </td>
                                            @if(isset($detailId) && $detailId)
                                                @php
                                                    $detailTrx = $transaksis->where('id', $detailId)->first();
                                                @endphp
                                                @if($detailTrx)
                                                    <div style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(128,128,128,0.3);z-index:1040;"></div>
                                                    <div class="modal d-block" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Transaksi</h5>
                                                                    <button type="button" class="close" wire:click="$set('detailId', null)">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-2"><strong>Invoice:</strong> {{ $detailTrx->invoice ?? '-' }}</div>
                                                                    <div class="mb-2"><strong>Nominal Pembayaran:</strong> Rp{{ number_format($detailTrx->uang_bayar ?? 0, 0, ',', '.') }}</div>
                                                                    <div class="mb-2"><strong>Uang Kembali:</strong> Rp{{ number_format($detailTrx->uang_kembali ?? 0, 0, ',', '.') }}</div>
                                                                    <div class="mb-2"><strong>Total Harga:</strong> Rp{{ number_format($detailTrx->total_harga ?? 0, 0, ',', '.') }}</div>
                                                                    <div class="mb-2"><strong>Status:</strong> {{ ucfirst($detailTrx->status) }}</div>
                                                                    <div class="mb-2"><strong>Catatan:</strong> {{ $detailTrx->catatan ?? '-' }}</div>
                                                                    <div class="mb-2"><strong>Tanggal:</strong> {{ $detailTrx->created_at->format('d-m-Y H:i') }}</div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" wire:click="$set('detailId', null)">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Tidak ada transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {{ $transaksis->links() }}
            </div>
        </div>
        @include('backend.template.footer')
    </div>
</div>