<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; }
        h3, .center { text-align: center; }
        hr { border: 0; border-top: 1px dashed #000; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .right { text-align: right; }
        .label { width: 50px; }
    </style>
</head>
<body>
    <h3>STRUK TRANSAKSI</h3>
    <hr>
    <table>
        <tr><td class="label">No</td><td>: #{{ $transaksi->id }}</td></tr>
        <tr><td class="label">Tanggal</td><td>: {{ $transaksi->created_at->format('d/m/Y H:i') }}</td></tr>
        @if ($transaksi->jenis === 'online')
            <tr><td class="label">Pembeli</td><td>: {{ $transaksi->kasir_name }}</td></tr>
            <tr><td class="label">Bayar</td><td>: COD (bayar di tempat)</td></tr>
            <tr><td class="label">No. HP</td><td>: {{ $transaksi->no_hp }}</td></tr>
            <tr><td class="label">Alamat</td><td>: {{ $transaksi->alamat }}</td></tr>
        @else
            <tr><td class="label">Kasir</td><td>: {{ $transaksi->kasir_name }}</td></tr>
        @endif
    </table>
    <hr>
    <table>
        @foreach ($detail as $d)
            <tr><td colspan="2">{{ $d->produk->nama ?? '-' }}</td></tr>
            <tr>
                <td>{{ $d->qty }} x {{ number_format($d->harga, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($d->harga * $d->qty, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
    <table>
        <tr>
            <td><b>TOTAL</b></td>
            <td class="right"><b>Rp. {{ number_format($transaksi->total, 0, ',', '.') }}</b></td>
        </tr>
        @if (!is_null($transaksi->bayar))
            <tr>
                <td>Bayar</td>
                <td class="right">Rp. {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="right">Rp. {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
            </tr>
        @endif
    </table>
    <hr>
    <p class="center">Terima kasih atas kunjungan Anda</p>
</body>
</html>