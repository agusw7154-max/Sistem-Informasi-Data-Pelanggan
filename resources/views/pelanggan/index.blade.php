@extends('layouts.app')

@section('title','Daftar Pelanggan')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-users"></i>
        Pelanggan
    </h1>
    <a class="btn btn-primary" href="{{ route('pelanggan.create') }}">
        <i class="fas fa-plus"></i> Tambah Pelanggan
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('pelanggan.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari ID, Nama, Telepon, atau Email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Pelanggan
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pelanggans as $p)
                <tr>
                    <td><span class="badge bg-primary">{{ $p->ID_PELANGGAN }}</span></td>
                    <td><strong>{{ $p->NAMA_PELANGGAN }}</strong></td>
                    <td>{{ $p->NO_TELEPON }}</td>
                    <td>{{ $p->EMAIL }}</td>
                    <td class="text-center">
                        <div class="btn-group-action justify-content-center">
                            <a class="btn btn-sm btn-info" href="{{ route('pelanggan.show', $p->ID_PELANGGAN) }}" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-warning" href="{{ route('pelanggan.edit', $p->ID_PELANGGAN) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pelanggan.destroy', $p->ID_PELANGGAN) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pelanggan ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada data pelanggan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $pelanggans->links() }}
    </div>
</div>
@endsection