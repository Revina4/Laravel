<div class="page-head">
    <h4>{{ $title }}</h4>
    <p>{{ isset($kategori) ? 'Ubah nama kategori' : 'Tambahkan kategori baru' }}</p>
</div>

<div class="card form-card">
    <div class="card-body p-4">

        <form action="{{ isset($kategori) ? '/admin/kategori/' . $kategori->id : '/admin/kategori' }}"
              method="POST">
            @csrf
            @if (isset($kategori))
                @method('put')
            @endif

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name"
                       value="{{ old('name', $kategori->name ?? '') }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Simpan
            </button>
            <a href="/admin/kategori" class="btn btn-soft-gray">Batal</a>
        </form>

    </div>
</div>