<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class AdminProdukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Manajemen Produk',
            'produk' => Produk::paginate(10),
            'content' => 'admin/produk/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'kategori' => Kategori::get(),
            'content' => 'admin/produk/create'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required',
            'kategori_id' => 'required',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->simpanFoto($request->file('foto'));
        } else {
            unset($data['foto']);
        }

        Produk::create($data);

        return redirect('/admin/produk')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title'    => 'Edit Produk',
            'produk'   => Produk::findOrFail($id),
            'kategori' => Kategori::get(),
            'content'  => 'admin/produk/create'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $data = $request->validate([
            'nama'        => 'required',
            'kategori_id' => 'required',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $this->hapusFoto($produk->foto);
            $data['foto'] = $this->simpanFoto($request->file('foto'));
        } else {
            unset($data['foto']);
        }

        $produk->update($data);

        return redirect('/admin/produk')
            ->with('success', 'Produk berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        $this->hapusFoto($produk->foto);
        $produk->delete();

        return redirect('/admin/produk')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // Simpan file foto ke public/uploads/produk, kembalikan nama filenya
    private function simpanFoto($file)
    {
        $nama = $file->hashName();
        $file->move(public_path('uploads/produk'), $nama);

        return $nama;
    }

    // Hapus file foto lama (kalau ada)
    private function hapusFoto($nama)
    {
        if ($nama) {
            $path = public_path('uploads/produk/' . $nama);

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}