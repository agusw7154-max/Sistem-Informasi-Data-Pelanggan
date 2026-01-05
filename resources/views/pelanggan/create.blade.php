@extends('layouts.app')

@section('title','Tambah Pelanggan')

@section('content')
<h1>Tambah Pelanggan</h1>

<form method="POST" action="{{ route('pelanggan.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">ID Pelanggan</label>
        <input class="form-control" name="ID_PELANGGAN" value="{{ old('ID_PELANGGAN') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input class="form-control" name="NAMA_PELANGGAN" value="{{ old('NAMA_PELANGGAN') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea class="form-control" name="ALAMAT">{{ old('ALAMAT') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">No. Telepon</label>
        <input class="form-control" name="NO_TELEPON" value="{{ old('NO_TELEPON') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" name="EMAIL" value="{{ old('EMAIL') }}">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('pelanggan.index') }}">Batal</a>
</form>
@endsection