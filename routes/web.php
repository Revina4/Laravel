<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Middleware\AdminOnly;
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

// HALAMAN AWAL
Route::get('/', function () {
    return redirect('/admin/dashboard');
})->middleware('auth');

// SEMUA USER YANG LOGIN
Route::prefix('/admin')->middleware('auth')->group(function () {

    // DASHBOARD
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

    // TRANSAKSI
    Route::resource('/transaksi', AdminTransaksiController::class);
    Route::delete('/transaksi-detail/{id}', [AdminTransaksiController::class, 'destroyDetail']);
    Route::get('/transaksi/{id}/struk', [AdminTransaksiController::class, 'struk']);
    Route::get('/transaksi/{id}/struk/pdf', [AdminTransaksiController::class, 'strukPdf']);
    Route::post('/transaksi/{id}/bayar', [AdminTransaksiController::class, 'bayar']);

    // HANYA ADMIN
    Route::middleware(AdminOnly::class)->group(function () {
        Route::resource('/user', AdminUserController::class);
        Route::resource('/kategori', AdminKategoriController::class);
        Route::resource('/produk', AdminProdukController::class);
    });
});