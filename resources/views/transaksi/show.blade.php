@extends('layouts.app')

@section('title','Detail Transaksi')

@section('content')
    <div class="page-header mb-3">
        <h1><i class="fas fa-receipt"></i> Detail Transaksi</h1>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr><th style="width:180px">ID</th><td>{{ $transaksi->ID_TRANSAKSI }}</td></tr>
                <tr><th>Pelanggan</th><td>{{ $transaksi->pelanggan?->NAMA_PELANGGAN ?? $transaksi->ID_PELANGGAN }}</td></tr>
                <tr><th>Admin</th><td>{{ $transaksi->admin?->NAMA_ADMIN ?? $transaksi->ID_ADMIN }}</td></tr>
                <tr><th>Pembayaran</th><td>{{ $transaksi->ID_PEMBAYARAN }}</td></tr>
                <tr><th>Tanggal</th><td>{{ $transaksi->TANGGAL_TRANSAKSI }}</td></tr>
                <tr><th>Total Bayar</th><td><strong>Rp {{ number_format($transaksi->total_bayar ?? 0, 0, ',', '.') }}</strong></td></tr>
            </table>
        </div>
    </div>

    @if($transaksi->detailTransaksis && $transaksi->detailTransaksis->count())
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list"></i> Detail Item Transaksi
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; $calcTotal = 0; @endphp
                        @foreach($transaksi->detailTransaksis as $item)
                            @php
                                $harga = $item->produk?->HARGA ? (int) $item->produk->HARGA : 0;
                                $jumlah = $item->JUMLAH ?? 0;
                                $subtotal = $harga * $jumlah;
                                $calcTotal += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->produk?->NAMA_PRODUK ?? $item->ID_PRODUK }}</td>
                                <td class="text-end">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th class="text-end">Rp {{ number_format($calcTotal, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

    <div class="d-flex gap-2">
        <a class="btn btn-secondary" href="{{ route('transaksi.index') }}">Kembali</a>
        <a class="btn btn-primary" href="{{ route('transaksi.edit', $transaksi->ID_TRANSAKSI) }}">Edit</a>
    </div>

@endsection
