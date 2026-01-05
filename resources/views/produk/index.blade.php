@extends('layouts.app')

@section('title','Daftar Produk')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-box"></i>
        Produk
    </h1>
    <a class="btn btn-primary" href="{{ route('produk.create') }}">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('produk.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari ID atau Nama Produk..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Produk
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Total Terjual</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($produks as $p)
                <tr>
                    <td><span class="badge bg-primary">{{ $p->ID_PRODUK }}</span></td>
                    <td><strong>{{ $p->NAMA_PRODUK }}</strong></td>
                    <td>Rp {{ number_format($p->HARGA, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $p->STOK > 10 ? 'success' : ($p->STOK > 0 ? 'warning' : 'danger') }}">
                            {{ $p->STOK }}
                        </span>
                    </td>
                    <td>{{ $p->detailTransaksis->sum('JUMLAH') ?? 0 }} unit</td>
                    <td class="text-center">
                        <div class="btn-group-action justify-content-center">
                            <a class="btn btn-sm btn-info" href="{{ route('produk.show', $p->ID_PRODUK) }}" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-warning" href="{{ route('produk.edit', $p->ID_PRODUK) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('produk.destroy', $p->ID_PRODUK) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox"></i> Tidak ada data produk
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $produks->links() }}
    </div>
</div>
@endsection