@extends('layouts.app')

@section('title','Edit Admin')

@section('content')
<h1>Edit Admin</h1>

<form method="POST" action="{{ route('admin.update', $admin->ID_ADMIN) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="USERNAME" value="{{ old('USERNAME', $admin->USERNAME) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" name="PASSWORD" value="{{ old('PASSWORD', $admin->PASSWORD) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Admin</label>
        <input class="form-control" name="NAMA_ADMIN" value="{{ old('NAMA_ADMIN', $admin->NAMA_ADMIN) }}">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('admin.index') }}">Batal</a>
</form>
@endsection
