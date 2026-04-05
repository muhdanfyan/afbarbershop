<div>
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ee0979, #ff6a00);">
                    <i class="mdi mdi-history text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Antrean & Transaksi</h4>
                    <p class="text-muted small mb-0">Monitor layanan aktif dan kelola klaim transaksi hari ini</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button wire:click.prevent="$set('status', 'menunggu')" 
                    class="btn btn-sm {{ $status == 'menunggu' ? 'btn-warning font-weight-bold shadow-sm' : 'btn-outline-warning' }}" style="border-radius: 8px; padding: 0.5rem 1rem;">
                    Menunggu
                </button>
                <button wire:click.prevent="$set('status', 'proses')" 
                    class="btn btn-sm {{ $status == 'proses' ? 'btn-primary font-weight-bold shadow-sm' : 'btn-outline-primary' }}" style="border-radius: 8px; padding: 0.5rem 1rem;">
                    Proses
                </button>
                <button wire:click.prevent="$set('status', 'selesai')" 
                    class="btn btn-sm {{ $status == 'selesai' ? 'btn-success font-weight-bold shadow-sm' : 'btn-outline-success' }}" style="border-radius: 8px; padding: 0.5rem 1rem;">
                    Selesai
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background: #111827; color: #fff;">
                                <tr>
                                    <th class="border-0 px-4 py-3" style="border-top-left-radius: 12px; border-bottom-left-radius: 12px;">#</th>
                                    <th class="border-0 px-4 py-3">Tanggal</th>
                                    <th class="border-0 px-4 py-3">Nama</th>
                                    <th class="border-0 px-4 py-3">Layanan</th>
                                    <th class="border-0 px-4 py-3">Kapster</th>
                                    <th class="border-0 px-4 py-3">Status</th>
                                    <th class="border-0 px-4 py-3" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px; text-align:right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $trx)
                                    <tr>
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <span class="text-muted"><i class="mdi mdi-calendar-range me-1"></i> {{ $trx->created_at->format('d-m-Y') }}</span>
                                            <div class="small text-muted">{{ $trx->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-4 py-3 fw-bold">{{ $trx->nama }}</td>
                                        <td class="px-4 py-3">
                                            @if($trx->jasa && $trx->jasa->count())
                                                @foreach($trx->jasa as $j)
                                                    <span class="badge" style="background: rgba(212, 175, 55, 0.1); color: #b8972e; border: 1px solid rgba(212, 175, 55, 0.2); margin-right: 2px;">{{ $j->nama }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($trx->kapster)
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $trx->kapster->foto ? asset('storage/' . $trx->kapster->foto) : 'https://ui-avatars.com/api/?name='.urlencode($trx->kapster->nama).'&background=333&color=fff' }}" 
                                                        class="rounded-circle me-2" width="30" height="30">
                                                    <span>{{ $trx->kapster->nama }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($trx->status == 'menunggu')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @elseif($trx->status == 'proses')
                                                <span class="badge badge-primary">Proses</span>
                                            @elseif($trx->status == 'selesai')
                                                <span class="badge badge-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <a href="{{ route('admin.transaksi.show', $trx->id) }}" class="btn btn-premium-view">
                                                <i class="mdi mdi-eye-outline"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-cash-multiple mdi-48px d-block mb-3 opacity-25"></i>
                                            <p class="mb-0">Tidak ada transaksi yang ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>