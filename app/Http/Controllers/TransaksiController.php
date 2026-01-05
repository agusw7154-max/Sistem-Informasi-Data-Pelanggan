<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Admin;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('transaksi')) {
            return view('errors.no_database');
        }

        $query = Transaksi::with('pelanggan','admin','detailTransaksis');
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ID_TRANSAKSI', 'like', "%{$search}%")
                  ->orWhere('ID_PELANGGAN', 'like', "%{$search}%")
                  ->orWhere('ID_ADMIN', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function($q) use ($search) {
                      $q->where('NAMA_PELANGGAN', 'like', "%{$search}%");
                  })
                  ->orWhereHas('admin', function($q) use ($search) {
                      $q->where('NAMA_ADMIN', 'like', "%{$search}%");
                  });
        }
        
        $transaksis = $query->paginate(15)->appends($request->query());
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $products = Produk::all();
        $admins = Admin::all();
        $pelanggans = Pelanggan::all();
        $pembayarans = Pembayaran::all();
        return view('transaksi.create', compact('products', 'admins', 'pelanggans', 'pembayarans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ID_TRANSAKSI' => 'nullable|string|max:5',
            'ID_ADMIN' => 'required|string|max:5',
            'ID_PELANGGAN' => 'required|string|max:5',
            'ID_PEMBAYARAN' => 'nullable|string|max:5',
            'TANGGAL_TRANSAKSI' => 'nullable|date',
            'details' => 'nullable|array',
            'details.*.ID_PRODUK' => 'required_with:details|string',
            'details.*.JUMLAH' => 'required_with:details|integer|min:1',
        ]);

        DB::transaction(function() use ($data, $request) {
            $transaksi = Transaksi::create($data);

            // insert detail rows if provided
            $details = $request->input('details', []);
            foreach ($details as $row) {
                if (empty($row['ID_PRODUK']) || empty($row['JUMLAH'])) continue;
                DetailTransaksi::create([
                    'ID_PRODUK' => $row['ID_PRODUK'],
                    'ID_TRANSAKSI' => $transaksi->ID_TRANSAKSI,
                    'JUMLAH' => (int) $row['JUMLAH'],
                ]);
            }
        });

        return redirect()->route('transaksi.index');
    }

    public function show(Transaksi $transaksi)
    {
        // eager load related models to avoid N+1 and ensure detail items are available
        $transaksi->load('detailTransaksis.produk', 'pelanggan', 'admin');
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksis');
        $products = Produk::all();
        return view('transaksi.edit', compact('transaksi','products'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'ID_ADMIN' => 'required|string|max:5',
            'ID_PELANGGAN' => 'required|string|max:5',
            'ID_PEMBAYARAN' => 'nullable|string|max:5',
            'TANGGAL_TRANSAKSI' => 'nullable|date',
            'details' => 'nullable|array',
            'details.*.ID_PRODUK' => 'required_with:details|string',
            'details.*.JUMLAH' => 'required_with:details|integer|min:1',
        ]);

        DB::transaction(function() use ($data, $request, $transaksi) {
            $transaksi->update($data);

            // remove existing detail rows
            DB::table('detail_transaksi')->where('ID_TRANSAKSI', $transaksi->ID_TRANSAKSI)->delete();

            // insert new detail rows
            $details = $request->input('details', []);
            foreach ($details as $row) {
                if (empty($row['ID_PRODUK']) || empty($row['JUMLAH'])) continue;
                DetailTransaksi::create([
                    'ID_PRODUK' => $row['ID_PRODUK'],
                    'ID_TRANSAKSI' => $transaksi->ID_TRANSAKSI,
                    'JUMLAH' => (int) $row['JUMLAH'],
                ]);
            }
        });

        return redirect()->route('transaksi.index');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index');
    }
}
