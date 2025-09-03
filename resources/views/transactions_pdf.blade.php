<h2>Laporan Transaksi</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trx)
            <tr>
                <td>{{ $trx->date }}</td>
                <td>{{ $trx->category->name }}</td>
                <td>Rp{{ number_format($trx->amount, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
