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

</div>