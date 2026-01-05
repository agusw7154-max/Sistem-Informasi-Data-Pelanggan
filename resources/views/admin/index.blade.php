@extends('layouts.app')

@section('title','Daftar Admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-shield-alt"></i>
        Admin
    </h1>
    <a class="btn btn-primary" href="{{ route('admin.create') }}">
        <i class="fas fa-plus"></i> Tambah Admin
    </a>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Admin
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($admins as $a)
                <tr>
                    <td><span class="badge bg-danger">{{ $a->ID_ADMIN }}</span></td>
                    <td><strong>{{ $a->USERNAME }}</strong></td>
                    <td>{{ $a->NAMA_ADMIN }}</td>
                    <td class="text-center">
                        <div class="btn-group-action justify-content-center">
                            <a class="btn btn-sm btn-info" href="{{ route('admin.show', $a->ID_ADMIN) }}" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-warning" href="{{ route('admin.edit', $a->ID_ADMIN) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.destroy', $a->ID_ADMIN) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus admin ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada data admin
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $admins->links() }}
    </div>
</div>
@endsection
