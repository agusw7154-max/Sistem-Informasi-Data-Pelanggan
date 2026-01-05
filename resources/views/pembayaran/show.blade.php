@extends('layouts.app')

@section('title','Detail Pembayaran')

@section('content')
<h1>Detail Pembayaran</h1>

<table class="table">
    <tr><th>ID</th><td>{{ $pembayaran->ID_PEMBAYARAN }}</td></tr>
    <tr><th>Pelanggan</th><td>{{ $pembayaran->pelanggan?->NAMA_PELANGGAN ?? $pembayaran->ID_PELANGGAN }}</td></tr>
    <tr><th>Admin</th><td>{{ $pembayaran->admin?->NAMA_ADMIN ?? $pembayaran->ID_ADMIN }}</td></tr>
    <tr><th>Tanggal Bayar</th><td>{{ $pembayaran->TANGGAL_BAYAR }}</td></tr>
    <tr><th>Metode</th><td>{{ $pembayaran->METODE_PEMBAYARAN }}</td></tr>
</table>

<a class="btn btn-secondary" href="{{ route('pembayaran.index') }}">Kembali</a>
<a class="btn btn-primary" href="{{ route('pembayaran.edit', $pembayaran->ID_PEMBAYARAN) }}">Edit</a>

@endsection
