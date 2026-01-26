<div>
    <div class="mb-3">
        <a wire:click.prevent="$set('status', 'menunggu')" href="#"
            class="btn btn-warning btn-sm mr-2 {{ $status == 'menunggu' ? 'font-weight-bold' : '' }}">Menunggu</a>
        <a wire:click.prevent="$set('status', 'proses')" href="#"
            class="btn btn-primary btn-sm mr-2 {{ $status == 'proses' ? 'font-weight-bold' : '' }}">Proses</a>
        <a wire:click.prevent="$set('status', 'selesai')" href  ="#"
            class="btn btn-success btn-sm {{ $status == 'selesai' ? 'font-weight-bold' : '' }}">Selesai</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Layanan</th>
                    <th>Kapster</th>
                    <th>Status</th>
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
                            @if($trx->status == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($trx->status == 'proses')
                                <span class="badge badge-primary">Proses</span>
                            @elseif($trx->status == 'selesai')
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.transaksi.show', $trx->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>