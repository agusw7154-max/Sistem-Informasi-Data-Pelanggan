@extends('layouts.app')

@section('title','Tambah Pembayaran')

@section('content')
<h1>Tambah Pembayaran</h1>

<form method="POST" action="{{ route('pembayaran.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">ID Pembayaran</label>
        <input class="form-control" name="ID_PEMBAYARAN" value="{{ old('ID_PEMBAYARAN') }}" placeholder="Auto-generated" readonly>
        <small class="text-muted">ID akan digenerate otomatis</small>
    </div>
    <div class="mb-3">
        <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
        <select class="form-select" name="ID_PELANGGAN" required>
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->ID_PELANGGAN }}" {{ old('ID_PELANGGAN') == $pelanggan->ID_PELANGGAN ? 'selected' : '' }}>
                    {{ $pelanggan->ID_PELANGGAN }} - {{ $pelanggan->NAMA_PELANGGAN }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Admin <span class="text-danger">*</span></label>
        <select class="form-select" name="ID_ADMIN" required>
            <option value="">-- Pilih Admin --</option>
            @foreach($admins as $admin)
                <option value="{{ $admin->ID_ADMIN }}" {{ old('ID_ADMIN') == $admin->ID_ADMIN ? 'selected' : '' }}>
                    {{ $admin->ID_ADMIN }} - {{ $admin->NAMA_ADMIN }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Tanggal Bayar</label>
        <input class="form-control" type="datetime-local" name="TANGGAL_BAYAR" value="{{ old('TANGGAL_BAYAR') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Metode Pembayaran</label>
        <input class="form-control" name="METODE_PEMBAYARAN" value="{{ old('METODE_PEMBAYARAN') }}">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('pembayaran.index') }}">Batal</a>
</form>
@endsection
