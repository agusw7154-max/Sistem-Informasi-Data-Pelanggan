@extends('layouts.app')

@section('title','Edit Produk')

@section('content')
<h1>Edit Produk</h1>

<form method="POST" action="{{ route('produk.update', $produk->ID_PRODUK) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input class="form-control" name="NAMA_PRODUK" value="{{ old('NAMA_PRODUK', $produk->NAMA_PRODUK) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input class="form-control" name="HARGA" type="number" value="{{ old('HARGA', $produk->HARGA) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Stok</label>
        <input class="form-control" name="STOK" type="number" value="{{ old('STOK', $produk->STOK) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ID Admin</label>
        <input class="form-control" name="ID_ADMIN" value="{{ old('ID_ADMIN', $produk->ID_ADMIN) }}" required>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('produk.index') }}">Batal</a>
</form>
@endsection