<div class="page-head d-flex justify-content-between align-items-center">
    <div>
        <h4>Kategori</h4>
        <p>Kelola kategori produk</p>
    </div>
    <a href="/admin/kategori/create" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th style="width: 70px">No</th>
                    <th>Nama</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <div class="d-inline-flex">
                                <a href="/admin/kategori/{{ $item->id }}/edit"
                                   class="btn btn-soft-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="/admin/kategori/{{ $item->id }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-soft-danger btn-sm ml-1"
                                            onclick="return confirm('Yakin hapus kategori ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $kategori->links() }}
</div>