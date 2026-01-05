@extends('layouts.app')

@section('title','Detail Admin')

@section('content')
<h1>Detail Admin</h1>

<table class="table">
    <tr><th>ID</th><td>{{ $admin->ID_ADMIN }}</td></tr>
    <tr><th>Username</th><td>{{ $admin->USERNAME }}</td></tr>
    <tr><th>Nama</th><td>{{ $admin->NAMA_ADMIN }}</td></tr>
</table>

<a class="btn btn-secondary" href="{{ route('admin.index') }}">Kembali</a>
<a class="btn btn-primary" href="{{ route('admin.edit', $admin->ID_ADMIN) }}">Edit</a>

@endsection
