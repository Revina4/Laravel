<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Manajemen Transaksi',
            'transaksi' => Transaksi::latest()->paginate(10),
            'content' => 'admin/transaksi/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    // Buat transaksi kosong, lalu langsung ke halaman kasir
    public function create()
    {
        $data = [
            'user_id' => Auth::id(),
            'kasir_name' => Auth::user()->name,
            'total' => 0
        ];

        $transaksi = Transaksi::create($data);

        return redirect('/admin/transaksi/' . $transaksi->id . '/edit');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    // Halaman kasir
    public function edit(string $id)
    {
        $data = [
            'title'     => 'Transaksi',
            'transaksi' => Transaksi::findOrFail($id),
            'detail'    => TransaksiDetail::with('produk')->where('transaksi_id', $id)->get(),
            'produk'    => Produk::get(),
            'content'   => 'admin/transaksi/edit'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    // Tambah item ke transaksi (stok berkurang)
    public function update(Request $request, string $id)
    {
        $request->validate([
            'produk_id' => 'required',
            'qty'       => 'required|integer|min:1',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $pesanError = DB::transaction(function () use ($request, $transaksi) {
            $produk = Produk::lockForUpdate()->findOrFail($request->produk_id);

            if ($produk->stok < $request->qty) {
                return 'Stok ' . $produk->nama . ' tidak cukup (tersisa ' . $produk->stok . ').';
            }

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $produk->id,
                'qty'          => $request->qty,
                'harga'        => $produk->harga,
            ]);

            $produk->decrement('stok', $request->qty);

            return null;
        });

        if ($pesanError) {
            return redirect('/admin/transaksi/' . $id . '/edit')->with('error', $pesanError);
        }

        $this->hitungTotal($transaksi);

        return redirect('/admin/transaksi/' . $id . '/edit');
    }

    // Hapus transaksi (stok dikembalikan)
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $items = TransaksiDetail::where('transaksi_id', $id)->get();

            foreach ($items as $item) {
                Produk::where('id', $item->produk_id)->increment('stok', $item->qty);
            }

            TransaksiDetail::where('transaksi_id', $id)->delete();
            Transaksi::findOrFail($id)->delete();
        });

        return redirect('/admin/transaksi')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    // Hapus satu item (stok dikembalikan)
    public function destroyDetail(string $id)
    {
        $detail    = TransaksiDetail::findOrFail($id);
        $transaksi = Transaksi::findOrFail($detail->transaksi_id);

        DB::transaction(function () use ($detail) {
            Produk::where('id', $detail->produk_id)->increment('stok', $detail->qty);
            $detail->delete();
        });

        $this->hitungTotal($transaksi);

        // Total berubah, jadi pembayaran yang tersimpan sebelumnya dikosongkan
        $transaksi->update(['bayar' => null, 'kembalian' => null]);

        return redirect('/admin/transaksi/' . $transaksi->id . '/edit');
    }

    // Simpan uang bayar dan hitung kembalian
    public function bayar(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->total < 1) {
            return redirect('/admin/transaksi/' . $id . '/edit')
                ->with('error', 'Belum ada item di transaksi ini.');
        }

        $request->validate([
            'bayar' => 'required|integer|min:0',
        ]);

        if ($request->bayar < $transaksi->total) {
            return redirect('/admin/transaksi/' . $id . '/edit')
                ->with('error', 'Uang bayar kurang dari total belanja.');
        }

        $transaksi->update([
            'bayar'     => $request->bayar,
            'kembalian' => $request->bayar - $transaksi->total,
        ]);

        return redirect('/admin/transaksi/' . $id . '/struk')
            ->with('success', 'Pembayaran berhasil disimpan.');
    }

    // Halaman struk
    public function struk(string $id)
    {
        $data = [
            'title'     => 'Struk Transaksi',
            'transaksi' => Transaksi::findOrFail($id),
            'detail'    => TransaksiDetail::with('produk')->where('transaksi_id', $id)->get(),
            'content'   => 'admin/transaksi/struk'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    // Download struk sebagai PDF
    public function strukPdf(string $id)
    {
        $data = [
            'transaksi' => Transaksi::findOrFail($id),
            'detail'    => TransaksiDetail::with('produk')->where('transaksi_id', $id)->get(),
        ];

        return Pdf::loadView('admin.transaksi.struk-pdf', $data)
            ->setPaper('a6')
            ->download('struk-' . $id . '.pdf');
    }

    private function hitungTotal(Transaksi $transaksi)
    {
        $total = TransaksiDetail::where('transaksi_id', $transaksi->id)
            ->get()
            ->sum(fn ($d) => $d->qty * $d->harga);

        $transaksi->update(['total' => $total]);
    }
}