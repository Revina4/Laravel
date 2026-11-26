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
                        @error('harga')