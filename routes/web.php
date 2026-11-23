<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;

// LOGIN
Route::get('/login', [AdminAuthController::class, 'index'])
    ->name('login')
    ->middleware('guest');

Route::post('/login/do', [AdminAuthController::class, 'doLogin'])
    ->middleware('guest');

Route::get('/logout', [AdminAuthController::class, 'logout'])
    ->middleware('auth');

// DASHBOARD
Route::get('/', function () {
    return redirect('/admin/dashboard');
})->middleware('auth');

// ADMIN
Route::prefix('/admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $data = [
            'total_produk'         => Produk::count(),
            'total_kategori'       => Kategori::count(),
            'pendapatan_bulan_ini' => Transaksi::whereYear('created_at', now()->year)
                                        ->whereMonth('created_at', now()->month)
                                        ->sum('total'),
            'total_pendapatan'     => Transaksi::sum('total'),
            'riwayat'              => Transaksi::where('total', '>', 0)
                                        ->latest()
                                        ->take(8)
                                        ->get(),
            'content'              => 'admin.dashboard.index'
        ];

        return view('admin.layouts.wrapper', $data);
    });

    // USER
    Route::resource('/user', AdminUserController::class);

    // KATEGORI
    Route::resource('/kategori', AdminKategoriController::class);

    // PRODUK
    Route::resource('/produk', AdminProdukController::class);

    // TRANSAKSI
    Route::resource('/transaksi', AdminTransaksiController::class);

    // HAPUS ITEM DI TRANSAKSI
    Route::delete('/transaksi-detail/{id}', [AdminTransaksiController::class, 'destroyDetail']);

    // STRUK
    Route::get('/transaksi/{id}/struk', [AdminTransaksiController::class, 'struk']);
    Route::get('/transaksi/{id}/struk/pdf', [AdminTransaksiController::class, 'strukPdf']);

    // BAYAR (total bayar & kembalian)
    Route::post('/transaksi/{id}/bayar', [AdminTransaksiController::class, 'bayar']);
});