@php
    $adaFoto = isset($produk) && $produk->foto;
@endphp

<div class="page-head">
    <h4>{{ $title }}</h4>
    <p>{{ isset($produk) ? 'Ubah data produk' : 'Tambahkan produk baru' }}</p>
</div>

<div class="card form-card">
    <div class="card-body p-4">

        <form action="{{ isset($produk) ? '/admin/produk/' . $produk->id : '/admin/produk' }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($produk))
                @method('put')
            @endif

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama"
                       value="{{ old('nama', $produk->nama ?? '') }}"
                       class="form-control @error('nama') is-invalid @enderror">
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id"
                        class="form-control @error('kategori_id') is-invalid @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kategori_id', $produk->kategori_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga"
                               value="{{ old('harga', $produk->harga ?? '') }}"
                               class="form-control @error('harga') is-invalid @enderror">
                        @error('harga') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok"
                               value="{{ old('stok', $produk->stok ?? '') }}"
                               class="form-control @error('stok') is-invalid @enderror">
                        @error('stok') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="d-block">Foto Produk</label>

                <img id="preview" class="foto-preview"
                     @if ($adaFoto) src="{{ asset('uploads/produk/' . $produk->foto) }}"
                     @else style="display: none" @endif>

                <input type="file" id="foto" name="foto" accept="image/*"
                       class="form-control-file @error('foto') is-invalid @enderror">
                @error('foto')
                    <span class="text-danger d-block">{{ $message }}</span>
                @enderror
                <small class="text-muted">
                    JPG, PNG, atau WEBP, maksimal 2 MB.
                    @if ($adaFoto) Pilih file baru hanya kalau ingin mengganti foto. @endif
                </small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Simpan
            </button>
            <a href="/admin/produk" class="btn btn-soft-gray">Batal</a>
        </form>

    </div>
</div>

<script>
    document.getElementById('foto').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (file) {
            var img = document.getElementById('preview');
            img.src = URL.createObjectURL(file);
            img.style.display = 'block';
        }
    });
</script>