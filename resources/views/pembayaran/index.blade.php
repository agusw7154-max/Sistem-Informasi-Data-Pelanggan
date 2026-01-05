@extends('layouts.app')

@section('title','Daftar Pembayaran')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-credit-card"></i>
        Pembayaran
    </h1>
    <a class="btn btn-primary" href="{{ route('pembayaran.create') }}">
        <i class="fas fa-plus"></i> Tambah Pembayaran
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('pembayaran.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari ID, Pelanggan, Admin, atau Metode..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Pembayaran
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Admin</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pembayarans as $p)
                <tr>
                    <td><span class="badge bg-warning">{{ $p->ID_PEMBAYARAN }}</span></td>
                    <td><strong>{{ $p->pelanggan?->NAMA_PELANGGAN ?? $p->ID_PELANGGAN }}</strong></td>
                    <td>{{ $p->admin?->NAMA_ADMIN ?? $p->ID_ADMIN }}</td>
                    <td>{{ $p->TANGGAL_BAYAR }}</td>
                    <td><span class="badge bg-secondary">{{ $p->METODE_PEMBAYARAN }}</span></td>
                    <td class="text-center">
                        <div class="btn-group-action justify-content-center">
                            <a class="btn btn-sm btn-info" href="{{ route('pembayaran.show', $p->ID_PEMBAYARAN) }}" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-warning" href="{{ route('pembayaran.edit', $p->ID_PEMBAYARAN) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pembayaran.destroy', $p->ID_PEMBAYARAN) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pembayaran ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada data pembayaran
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $pembayarans->links() }}
    </div>
</div>
@endsection
