<style>
    #struk {
        width: 320px;
        margin: 0 auto;
        padding: 24px 20px;
        background: #fff;
        color: #000;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(17, 24, 39, .08);
        font-family: 'Courier New', monospace;
        font-size: 13px;
    }
    #struk h4, #struk .center { text-align: center; }
    #struk hr { border-top: 1px dashed #000; }
    #struk table { width: 100%; }
    #struk td { vertical-align: top; padding: 2px 0; }
    #struk .right { text-align: right; }
    #struk .label { width: 70px; }

    @media print {
        body * { visibility: hidden; }
        #struk, #struk * { visibility: visible; }
        #struk { position: absolute; left: 0; top: 0; box-shadow: none; }
    }
</style>

<div id="struk">
    <h4><b>STRUK TRANSAKSI</b></h4>
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
            <tr>
                <td colspan="2">{{ $d->produk->nama ?? '-' }}</td>
            </tr>
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
</div>