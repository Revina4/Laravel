<div class="page-head d-flex justify-content-between align-items-center">
    <div>
        <h4>Produk</h4>
        <p>Kelola daftar produk</p>
    </div>
    <a href="/admin/produk/create" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 60px">No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->foto)
                                    <img src="{{ asset('uploads/produk/' . $item->foto) }}"
                                         alt="{{ $item->nama }}" class="thumb">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><b>{{ $item->nama }}</b></td>
                            <td>
                                <span class="badge badge-soft-indigo">
                                    {{ $item->kategori->name ?? '-' }}
                                </span>
                            </td>
                            <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->stok > 0 ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td>
                                <div class="d-inline-flex">
                                    <a href="/admin/produk/{{ $item->id }}/edit"
                                       class="btn btn-soft-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="/admin/produk/{{ $item->id }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-soft-danger btn-sm ml-1"
                                                onclick="return confirm('Yakin hapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $produk->links() }}
</div>