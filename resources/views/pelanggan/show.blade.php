@extends('layouts.app')

@section('title','Detail Pelanggan')

@section('content')
<h1>Detail Pelanggan</h1>

<table class="table">
    <tr><th>ID</th><td>{{ $pelanggan->ID_PELANGGAN }}</td></tr>
    <tr><th>Nama</th><td>{{ $pelanggan->NAMA_PELANGGAN }}</td></tr>
    <tr><th>Alamat</th><td>{{ $pelanggan->ALAMAT }}</td></tr>
    <tr><th>No. Telepon</th><td>{{ $pelanggan->NO_TELEPON }}</td></tr>
    <tr><th>Email</th><td>{{ $pelanggan->EMAIL }}</td></tr>
</table>

<a class="btn btn-secondary" href="{{ route('pelanggan.index') }}">Kembali</a>
<a class="btn btn-primary" href="{{ route('pelanggan.edit', $pelanggan->ID_PELANGGAN) }}">Edit</a>

@endsection