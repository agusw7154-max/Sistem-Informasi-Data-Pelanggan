<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('produk')) {
            return view('errors.no_database');
        }

        $query = Produk::query();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ID_PRODUK', 'like', "%{$search}%")
                  ->orWhere('NAMA_PRODUK', 'like', "%{$search}%");
        }
        
        $produks = $query->paginate(15)->appends($request->query());
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ID_PRODUK' => 'required|string|max:5',
            'ID_ADMIN' => 'required|string|max:5',
            'ID_PELANGGAN' => 'nullable|string|max:5',
            'NAMA_PRODUK' => 'required|string|max:100',
            'HARGA' => 'required|numeric',
            'STOK' => 'required|integer',
        ]);

        Produk::create($data);
        return redirect()->route('produk.index');
    }

    public function show(Produk $produk)
    {
        $produk->load('detailTransaksis.transaksi.pelanggan');
        $pembeli = $produk->detailTransaksis;
        return view('produk.show', compact('produk', 'pembeli'));
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'ID_ADMIN' => 'required|string|max:5',
            'ID_PELANGGAN' => 'nullable|string|max:5',
            'NAMA_PRODUK' => 'required|string|max:100',
            'HARGA' => 'required|numeric',
            'STOK' => 'required|integer',
        ]);

        $produk->update($data);
        return redirect()->route('produk.index');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index');
    }
}
