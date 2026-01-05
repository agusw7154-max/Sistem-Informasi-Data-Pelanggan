@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @auth
        {{-- Authenticated User: Show Dashboard --}}
        <div class="page-header">
            <h1>
                <i class="fas fa-chart-line"></i>
                Dashboard
            </h1>
        </div>

        <div class="row mb-4">
            @if(Schema::hasTable('pelanggan'))
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card primary">
                        <h6><i class="fas fa-users"></i> Total Pelanggan</h6>
                        <div class="stat-value">{{ $totalPelanggan ?? 0 }}</div>
                    </div>
                </div>
            @endif

            @if(Schema::hasTable('produk'))
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card success">
                        <h6><i class="fas fa-box"></i> Total Produk</h6>
                        <div class="stat-value">{{ $totalProduk ?? 0 }}</div>
                    </div>
                </div>
            @endif

            @if(Schema::hasTable('transaksi'))
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card info">
                        <h6><i class="fas fa-receipt"></i> Total Transaksi</h6>
                        <div class="stat-value">{{ $totalTransaksi ?? 0 }}</div>
                    </div>
                </div>
            @endif

            @if(Schema::hasTable('pembayaran'))
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card warning">
                        <h6><i class="fas fa-credit-card"></i> Total Pembayaran</h6>
                        <div class="stat-value">{{ $totalPembayaran ?? 0 }}</div>
                    </div>
                </div>
            @endif
        </div>

        @if(Schema::hasTable('pelanggan'))
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-users"></i> Pelanggan Terbaru
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPelanggan ?? [] as $pelanggan)
                                        <tr>
                                            <td><span class="badge bg-primary">{{ $pelanggan->ID_PELANGGAN }}</span></td>
                                            <td><strong>{{ $pelanggan->NAMA_PELANGGAN }}</strong></td>
                                            <td><small>{{ substr($pelanggan->ALAMAT ?? '-', 0, 30) }}{{ strlen($pelanggan->ALAMAT ?? '') > 30 ? '...' : '' }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox"></i> Tidak ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if(Schema::hasTable('transaksi'))
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-receipt"></i> Transaksi Terbaru
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransaksi ?? [] as $transaksi)
                                        <tr>
                                            <td><span class="badge bg-info">{{ $transaksi->ID_TRANSAKSI }}</span></td>
                                            <td><small>{{ $transaksi->TANGGAL_TRANSAKSI }}</small></td>
                                            <td><strong>Rp {{ number_format($transaksi->total_bayar ?? 0, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox"></i> Tidak ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
    @else
        {{-- Unauthenticated User: Show Landing Page --}}
        <style>
            .landing-hero {
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
                border-radius: 20px;
                padding: 4rem 2rem;
                margin-bottom: 3rem;
                position: relative;
                overflow: hidden;
            }

            .landing-hero::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -10%;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
                border-radius: 50%;
            }

            .landing-hero::after {
                content: '';
                position: absolute;
                bottom: -30%;
                left: -5%;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(118, 75, 162, 0.1) 0%, transparent 70%);
                border-radius: 50%;
            }

            .hero-content {
                position: relative;
                z-index: 1;
            }

            .hero-title {
                font-size: 3rem;
                font-weight: 700;
                color: #333;
                margin-bottom: 1rem;
                line-height: 1.2;
            }

            .hero-subtitle {
                font-size: 1.3rem;
                color: #666;
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            .hero-cta {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
                margin-bottom: 2rem;
            }

            .btn-hero {
                padding: 0.9rem 2rem;
                font-size: 1.1rem;
                border-radius: 10px;
                border: none;
                font-weight: 600;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-hero-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .btn-hero-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
                color: white;
                text-decoration: none;
            }

            .btn-hero-secondary {
                background: white;
                color: #667eea;
                border: 2px solid #667eea;
            }

            .btn-hero-secondary:hover {
                background: #667eea;
                color: white;
                text-decoration: none;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
                margin-top: 3rem;
            }

            .feature-card {
                background: white;
                padding: 2rem;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                border-left: 5px solid #667eea;
                transition: all 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            }

            .feature-icon {
                font-size: 2.5rem;
                color: #667eea;
                margin-bottom: 1rem;
            }

            .feature-title {
                font-size: 1.3rem;
                font-weight: 700;
                color: #333;
                margin-bottom: 0.5rem;
            }

            .feature-desc {
                color: #666;
                line-height: 1.6;
            }

            .stats-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 3rem 2rem;
                border-radius: 15px;
                margin-top: 3rem;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
                margin-top: 2rem;
                text-align: center;
            }

            .stat-item h3 {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .stat-item p {
                opacity: 0.9;
            }
        </style>

        <div class="landing-hero">
            <div class="hero-content">
                <h1 class="hero-title">
                    <i class="fas fa-database" style="color: #667eea;"></i>
                    Sistem Informasi Data Pelanggan
                </h1>
                <p class="hero-subtitle">
                    Kelola data pelanggan, produk, transaksi, dan pembayaran dengan mudah dan efisien. 
                    Platform terintegrasi untuk bisnis modern Anda.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Login Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                        <i class="fas fa-user-plus"></i>
                        Daftar Akun
                    </a>
                </div>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3 class="feature-title">Manajemen Pelanggan</h3>
                <p class="feature-desc">
                    Kelola data pelanggan dengan mudah, termasuk informasi kontak, alamat, dan riwayat interaksi.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="feature-title">Katalog Produk</h3>
                <p class="feature-desc">
                    Atur inventaris produk Anda, pantau stok, harga, dan informasi produk secara real-time.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3 class="feature-title">Pencatatan Transaksi</h3>
                <p class="feature-desc">
                    Catat dan kelola semua transaksi penjualan dengan detail lengkap dan akurat.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3 class="feature-title">Manajemen Pembayaran</h3>
                <p class="feature-desc">
                    Lacak pembayaran pelanggan, metode pembayaran, dan status transaksi keuangan.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="feature-title">Laporan & Analytics</h3>
                <p class="feature-desc">
                    Buat laporan mendalam dan analisis data untuk keputusan bisnis yang lebih baik.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="feature-title">Keamanan Data</h3>
                <p class="feature-desc">
                    Sistem keamanan berlapis untuk melindungi data bisnis dan privasi pelanggan Anda.
                </p>
            </div>
        </div>

        <div class="stats-section">
            <h2 style="font-size: 2rem; margin-bottom: 0; text-align: center;">
                <i class="fas fa-chart-pie"></i>
                Dipercaya oleh Ribuan Pengguna
            </h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>10,000+</h3>
                    <p>Pengguna Aktif</p>
                </div>
                <div class="stat-item">
                    <h3>50,000+</h3>
                    <p>Data Terkelola</p>
                </div>
                <div class="stat-item">
                    <h3>99.9%</h3>
                    <p>Uptime</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>Customer Support</p>
                </div>
            </div>
        </div>
    @endauth

@endsection
