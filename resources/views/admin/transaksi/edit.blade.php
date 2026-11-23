<div class="page-head">
    <h4>Transaksi #{{ $transaksi->id }}</h4>
    <p>Kasir: {{ $transaksi->kasir_name }}</p>
</div>

<div class="row">

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <form action="/admin/transaksi/{{ $transaksi->id }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="col-md-6 mb-2">
                            <select name="produk_id" class="form-control" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}" {{ $item->stok < 1 ? 'disabled' : '' }}>
                                        {{ $item->nama }} (Rp. {{ number_format($item->harga, 0, ',', '.') }}) - stok {{ $item->stok }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" name="qty" value="1" min="1"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-plus mr-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th style="width: 60px">No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th style="width: 70px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->produk->nama ?? '-' }}</td>
                                    <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td><b>Rp. {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</b></td>
                                    <td>
                                        <form action="/admin/transaksi-detail/{{ $item->id }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-soft-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada item, pilih produk di atas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body p-4">

                <div class="stat-label">Total Belanja</div>
                <div class="total-box mb-3">
                    Rp. {{ number_format($transaksi->total, 0, ',', '.') }}
                </div>

                <form action="/admin/transaksi/{{ $transaksi->id }}/bayar" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Total Bayar</label>
                        <input type="number" name="bayar" id="bayar" min="0"
                               value="{{ old('bayar', $transaksi->bayar) }}"
                               placeholder="Uang yang diterima"
                               class="form-control @error('bayar') is-invalid @enderror">
                        @error('bayar') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <button type="button" id="uangPas" class="btn btn-soft-gray btn-sm mt-2">
                            Uang pas
                        </button>
                    </div>

                    <div class="form-group">
                        <label>Kembalian</label>
                        <input type="text" id="kembalian" class="form-control" readonly
                               placeholder="Terhitung otomatis">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-receipt mr-1"></i> Bayar & Lihat Struk
                    </button>
                </form>

                <a href="/admin/transaksi" class="btn btn-soft-gray btn-block mt-2">Kembali</a>

            </div>
        </div>
    </div>

</div>

<script>
    (function () {
        var total   = {{ (int) $transaksi->total }};
        var bayar   = document.getElementById('bayar');
        var kembali = document.getElementById('kembalian');

        function rupiah(n) {
            return 'Rp. ' + n.toLocaleString('id-ID');
        }

        function hitung() {
            var nilai = parseInt(bayar.value) || 0;

            if (nilai === 0) {
                kembali.value = '';
                return;
            }

            var selisih = nilai - total;
            kembali.value = selisih >= 0 ? rupiah(selisih) : 'Kurang ' + rupiah(Math.abs(selisih));
            kembali.classList.toggle('text-danger', selisih < 0);
        }

        bayar.addEventListener('input', hitung);

        document.getElementById('uangPas').addEventListener('click', function () {
            bayar.value = total;
            hitung();
        });

        hitung();
    })();
</script>