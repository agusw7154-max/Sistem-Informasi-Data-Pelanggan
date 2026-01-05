@extends('layouts.app')

@section('title','Tambah Produk')

@section('content')
<h1>Tambah Produk</h1>

<form method="POST" action="{{ route('produk.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">ID Produk</label>
        <input class="form-control" name="ID_PRODUK" value="{{ old('ID_PRODUK') }}" placeholder="Auto-generated" readonly>
        <small class="text-muted">ID akan digenerate otomatis</small>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input class="form-control" name="NAMA_PRODUK" value="{{ old('NAMA_PRODUK') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input class="form-control" name="HARGA" type="number" value="{{ old('HARGA') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Stok</label>
        <input class="form-control" name="STOK" type="number" value="{{ old('STOK',0) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ID Admin</label>
        <input class="form-control" name="ID_ADMIN" value="{{ old('ID_ADMIN') }}" required>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('produk.index') }}">Batal</a>
</form>
@endsection