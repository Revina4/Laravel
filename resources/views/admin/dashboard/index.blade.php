@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<div class="page-head">
    <h4>Dashboard</h4>
    <p>Selamat datang, {{ auth()->user()->name }} 👋</p>
</div>

<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon ic-indigo"><i class="fas fa-box"></i></div>
                <div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-value">{{ $total_produk }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon ic-amber"><i class="fas fa-list"></i></div>
                <div>
                    <div class="stat-label">Total Kategori</div>
                    <div class="stat-value">{{ $total_kategori }}</div>
                </div>
            </div>
        </div>
    </div>

    @if ($isAdmin)

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon ic-green"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <div class="stat-label">Pendapatan Bulan Ini</div>
                        <div class="stat-value">Rp. {{ number_format($pendapatan_bulan_ini, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon ic-rose"><i class="fas fa-wallet"></i></div>
                    <div>
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-value">Rp. {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pt-3">
        <h6 class="font-weight-bold mb-0">Riwayat Transaksi Terbaru</h6>
        <a href="/admin/transaksi" class="btn btn-soft-gray btn-sm">Lihat semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th style="width: 70px">Struk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->kasir_name }}</td>
                            <td><b>Rp. {{ number_format($item->total, 0, ',', '.') }}</b></td>
                            <td>
                                <a href="/admin/transaksi/{{ $item->id }}/struk" class="btn btn-soft-gray btn-sm">
                                    <i class="fas fa-receipt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>