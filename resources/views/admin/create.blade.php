@extends('layouts.app')

@section('title','Tambah Admin')

@section('content')
<h1>Tambah Admin</h1>

<form method="POST" action="{{ route('admin.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">ID Admin</label>
        <input class="form-control" name="ID_ADMIN" value="{{ old('ID_ADMIN') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="USERNAME" value="{{ old('USERNAME') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" name="PASSWORD" value="{{ old('PASSWORD') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Admin</label>
        <input class="form-control" name="NAMA_ADMIN" value="{{ old('NAMA_ADMIN') }}">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('admin.index') }}">Batal</a>
</form>
@endsection
