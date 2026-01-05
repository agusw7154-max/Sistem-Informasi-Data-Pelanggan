@extends('layouts.app')

@section('title','Buat Transaksi')

@section('content')
<h1>Buat Transaksi</h1>

<form method="POST" action="{{ route('transaksi.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">ID Transaksi</label>
        <input class="form-control" name="ID_TRANSAKSI" value="{{ old('ID_TRANSAKSI') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ID Admin</label>
        <input class="form-control" name="ID_ADMIN" value="{{ old('ID_ADMIN') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ID Pelanggan</label>
        <input class="form-control" name="ID_PELANGGAN" value="{{ old('ID_PELANGGAN') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ID Pembayaran</label>
        <input class="form-control" name="ID_PEMBAYARAN" value="{{ old('ID_PEMBAYARAN') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Tanggal Transaksi</label>
        <input class="form-control" type="datetime-local" name="TANGGAL_TRANSAKSI" value="{{ old('TANGGAL_TRANSAKSI') }}">
    </div>

    <h5>Detail Item</h5>
    <div class="card mb-3">
        <div class="card-body">
            <table class="table table-sm" id="details-table">
                <thead>
                    <tr>
                        <th style="width:40%">Produk</th>
                        <th style="width:15%" class="text-end">Harga</th>
                        <th style="width:15%" class="text-center">Jumlah</th>
                        <th style="width:20%" class="text-end">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div>
                <button type="button" id="add-row" class="btn btn-sm btn-outline-primary">Tambah Item</button>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="{{ route('transaksi.index') }}">Batal</a>
    </div>
</form>

<script>
    const products = @json($products->map(function($p){ return ['id'=>$p->ID_PRODUK,'name'=>$p->NAMA_PRODUK,'harga'=> (int) $p->HARGA]; }));
    let idx = 0;

    function formatRupiah(num){
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function addRow(item = null){
        const tbody = document.querySelector('#details-table tbody');
        const tr = document.createElement('tr');
        const rowIndex = idx++;
        const prodOptions = products.map(p => `<option value="${p.id}" ${item && item.ID_PRODUK==p.id ? 'selected' : ''}>${p.name} (${p.id})</option>`).join('');
        const selectedHarga = item ? (products.find(p=>p.id==item.ID_PRODUK)?.harga || 0) : 0;
        const jumlahVal = item ? item.JUMLAH : '';
        const subtotal = selectedHarga * (jumlahVal || 0);

        tr.innerHTML = `
            <td>
                <select name="details[${rowIndex}][ID_PRODUK]" class="form-select prod-select">${prodOptions}</select>
            </td>
            <td class="text-end price-cell">${formatRupiah(selectedHarga)}</td>
            <td class="text-center"><input type="number" min="1" name="details[${rowIndex}][JUMLAH]" class="form-control form-control-sm qty-input" value="${jumlahVal}"></td>
            <td class="text-end subtotal-cell">${formatRupiah(subtotal)}</td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row">×</button></td>
        `;

        tbody.appendChild(tr);

        // attach listeners
        tr.querySelector('.prod-select').addEventListener('change', function(){
            const id = this.value;
            const p = products.find(x=>x.id==id);
            const price = p ? p.harga : 0;
            tr.querySelector('.price-cell').textContent = formatRupiah(price);
            const qty = parseInt(tr.querySelector('.qty-input').value) || 0;
            tr.querySelector('.subtotal-cell').textContent = formatRupiah(price * qty);
        });
        tr.querySelector('.qty-input').addEventListener('input', function(){
            const qty = parseInt(this.value) || 0;
            const id = tr.querySelector('.prod-select').value;
            const p = products.find(x=>x.id==id);
            const price = p ? p.harga : 0;
            tr.querySelector('.subtotal-cell').textContent = formatRupiah(price * qty);
        });
        tr.querySelector('.remove-row').addEventListener('click', function(){ tr.remove(); });
    }

    document.getElementById('add-row').addEventListener('click', function(){ addRow(); });

    // add one empty row by default
    addRow();
</script>
</form>
@endsection
