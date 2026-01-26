<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Kapster</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->invoice }}</td>
                <td>{{ $t->tanggal }}</td>
                <td>{{ $t->nama }}</td>
                <td>{{ $t->no_hp }}</td>
                <td>{{ optional($t->kapster)->nama ?? '-' }}</td>
                <td>{{ $t->total_harga }}</td>
            </tr>
        @endforeach
    </tbody>
</table>