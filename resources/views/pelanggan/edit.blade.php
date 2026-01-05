@extends('layouts.app')

@section('title','Edit Pelanggan')

@section('content')
<h1>Edit Pelanggan</h1>

<form method="POST" action="{{ route('pelanggan.update', $pelanggan->ID_PELANGGAN) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input class="form-control" name="NAMA_PELANGGAN" value="{{ old('NAMA_PELANGGAN', $pelanggan->NAMA_PELANGGAN) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea class="form-control" name="ALAMAT">{{ old('ALAMAT', $pelanggan->ALAMAT) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">No. Telepon</label>
        <input class="form-control" name="NO_TELEPON" value="{{ old('NO_TELEPON', $pelanggan->NO_TELEPON) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" name="EMAIL" value="{{ old('EMAIL', $pelanggan->EMAIL) }}">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('pelanggan.index') }}">Batal</a>
</form>
@endsection