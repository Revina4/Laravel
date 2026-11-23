<style>
    #struk {
        width: 320px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        color: #000;
        font-family: 'Courier New', monospace;
        font-size: 13px;
    }
    #struk h4, #struk .center { text-align: center; }
    #struk hr { border-top: 1px dashed #000; }
    #struk table { width: 100%; }
    #struk td { vertical-align: top; padding: 2px 0; }
    #struk .right { text-align: right; }
</style>

<div class="p-3">

    <div class="mb-3 text-center">
        <a href="/admin/transaksi" class="btn btn-light">Kembali</a>
    </div>

    <div id="struk">
        <h4><b>STRUK TRANSAKSI</b></h4>
        <hr>
        <table>
            <tr><td>No</td><td>: #{{ $transaksi->id }}</td></tr>
            <tr><td>Tanggal</td><td>: {{ $transaksi->created_at->format('d/m/Y H:i') }}</td></tr>
            <tr><td>Kasir</td><td>: {{ $transaksi->kasir_name }}</td></tr>
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
        </table>
        <hr>
        <p class="center">Terima kasih atas kunjungan Anda</p>
    </div>

</div>