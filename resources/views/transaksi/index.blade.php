@extends('layouts.app')

@section('title','Daftar Transaksi')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-receipt"></i>
        Transaksi
    </h1>
    <a class="btn btn-primary" href="{{ route('transaksi.create') }}">
        <i class="fas fa-plus"></i> Buat Transaksi
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('transaksi.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari ID, Pelanggan, atau Admin..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Transaksi
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Admin</th>
                    <th>Tanggal</th>
                    <th>Total Bayar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($transaksis as $t)
                <tr>
                    <td><span class="badge bg-info">{{ $t->ID_TRANSAKSI }}</span></td>
                    <td><strong>{{ $t->pelanggan?->NAMA_PELANGGAN ?? $t->ID_PELANGGAN }}</strong></td>
                    <td>{{ $t->admin?->NAMA_ADMIN ?? $t->ID_ADMIN }}</td>
                    <td>{{ $t->TANGGAL_TRANSAKSI }}</td>
                    <td>Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <div class="btn-group-action justify-content-center">
                            <a class="btn btn-sm btn-info" href="{{ route('transaksi.show', $t->ID_TRANSAKSI) }}" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-warning" href="{{ route('transaksi.edit', $t->ID_TRANSAKSI) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('transaksi.destroy', $t->ID_TRANSAKSI) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus transaksi ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada data transaksi
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $transaksis->links() }}
    </div>
</div>
@endsection
