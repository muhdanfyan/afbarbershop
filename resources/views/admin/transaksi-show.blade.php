@extends('layouts.admin')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Detail Transaksi</h1>
        <div class="bg-white rounded shadow p-6 max-w-xl mx-auto">
            <table class="w-full mb-4">
                <tr>
                    <td class="font-semibold py-2 pr-4">Tanggal</td>
                    <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 pr-4">Nama</td>
                    <td>{{ $trx->nama }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 pr-4">Layanan</td>
                    <td>
                        @if($trx->jasa && $trx->jasa->count())
                            <ul>
                                @foreach($trx->jasa as $j)
                                    <li>{{ $j->nama }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 pr-4">Kapster</td>
                    <td>{{ $trx->kapster->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 pr-4">Status</td>
                    <td>{{ ucfirst($trx->status) }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 pr-4">Catatan</td>
                    <td>{{ $trx->catatan ?? '-' }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.transaksi', ['status' => $trx->status]) }}"
                class="inline-block px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
        </div>
    </div>
@endsection