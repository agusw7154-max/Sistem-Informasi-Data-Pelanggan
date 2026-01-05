@extends('layouts.app')

@section('title','Detail Produk')

@section('content')
<div class="page-header mb-4">
    <h1>
        <i class="fas fa-box"></i>
        Detail Produk
    </h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Produk
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td><span class="badge bg-primary">{{ $produk->ID_PRODUK }}</span></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><strong>{{ $produk->NAMA_PRODUK }}</strong></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp {{ number_format($produk->HARGA, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>
                            <span class="badge bg-{{ $produk->STOK > 10 ? 'success' : ($produk->STOK > 0 ? 'warning' : 'danger') }}">
                                {{ $produk->STOK }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Terjual</th>
                        <td><strong>{{ $produk->detailTransaksis->sum('JUMLAH') ?? 0 }} unit</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <i class="fas fa-shopping-cart"></i> Riwayat Pembeli
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Telepon</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah Unit</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pembeli as $item)
                <tr>
                    <td><span class="badge bg-info">{{ $item->transaksi->ID_TRANSAKSI ?? '-' }}</span></td>
                    <td><strong>{{ $item->transaksi->pelanggan->NAMA_PELANGGAN ?? '-' }}</strong></td>
                    <td>{{ $item->transaksi->pelanggan->NO_TELEPON ?? '-' }}</td>
                    <td>{{ $item->transaksi->TANGGAL_TRANSAKSI ?? '-' }}</td>
                    <td>
                        <span class="badge bg-success">{{ $item->JUMLAH }} unit</span>
                    </td>
                    <td>Rp {{ number_format($item->JUMLAH * $produk->HARGA, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Belum ada pembelian untuk produk ini
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <a class="btn btn-secondary" href="{{ route('produk.index') }}">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <a class="btn btn-primary" href="{{ route('produk.edit', $produk->ID_PRODUK) }}">
        <i class="fas fa-edit"></i> Edit
    </a>
</div>

@endsection