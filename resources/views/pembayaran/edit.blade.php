@extends('layouts.app')

@section('title','Edit Pembayaran')

@section('content')
<h1>Edit Pembayaran</h1>

<form method="POST" action="{{ route('pembayaran.update', $pembayaran->ID_PEMBAYARAN) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">ID Pelanggan</label>
        <input class="form-control" name="ID_PELANGGAN" value="{{ old('ID_PELANGGAN', $pembayaran->ID_PELANGGAN) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ID Admin</label>
        <input class="form-control" name="ID_ADMIN" value="{{ old('ID_ADMIN', $pembayaran->ID_ADMIN) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Tanggal Bayar</label>
        <input class="form-control" type="datetime-local" name="TANGGAL_BAYAR" value="{{ old('TANGGAL_BAYAR', $pembayaran->TANGGAL_BAYAR) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Metode Pembayaran</label>
        <input class="form-control" name="METODE_PEMBAYARAN" value="{{ old('METODE_PEMBAYARAN', $pembayaran->METODE_PEMBAYARAN) }}">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('pembayaran.index') }}">Batal</a>
</form>
@endsection
