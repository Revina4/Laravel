<div class="page-head d-flex justify-content-between align-items-center">
    <div>
        <h4>Transaksi</h4>
        <p>Riwayat transaksi kasir</p>
    </div>
    <a href="/admin/transaksi/create" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Transaksi Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 60px">No</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kasir_name }}</td>
                            <td><b>Rp. {{ number_format($item->total, 0, ',', '.') }}</b></td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-inline-flex">
                                    <a href="/admin/transaksi/{{ $item->id }}/struk"
                                       class="btn btn-soft-gray btn-sm" title="Struk">
                                        <i class="fas fa-receipt"></i>
                                    </a>

                                    <a href="/admin/transaksi/{{ $item->id }}/edit"
                                       class="btn btn-soft-info btn-sm ml-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="/admin/transaksi/{{ $item->id }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-soft-danger btn-sm ml-1"
                                                onclick="return confirm('Yakin hapus transaksi ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $transaksi->links() }}
</div>