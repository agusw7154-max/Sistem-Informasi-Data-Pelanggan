<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('pembayaran')) {
            return view('errors.no_database');
        }

        $query = Pembayaran::with('pelanggan','admin');
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ID_PEMBAYARAN', 'like', "%{$search}%")
                  ->orWhere('ID_PELANGGAN', 'like', "%{$search}%")
                  ->orWhere('ID_ADMIN', 'like', "%{$search}%")
                  ->orWhere('METODE_PEMBAYARAN', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function($q) use ($search) {
                      $q->where('NAMA_PELANGGAN', 'like', "%{$search}%");
                  })
                  ->orWhereHas('admin', function($q) use ($search) {
                      $q->where('NAMA_ADMIN', 'like', "%{$search}%");
                  });
        }
        
        $pembayarans = $query->paginate(15)->appends($request->query());
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        return view('pembayaran.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ID_PEMBAYARAN' => 'required|string|max:5',
            'ID_PELANGGAN' => 'required|string|max:5',
            'ID_ADMIN' => 'required|string|max:5',
            'TANGGAL_BAYAR' => 'nullable|date',
            'METODE_PEMBAYARAN' => 'nullable|string|max:30',
        ]);

        Pembayaran::create($data);
        return redirect()->route('pembayaran.index');
    }

    public function show(Pembayaran $pembayaran)
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        return view('pembayaran.edit', compact('pembayaran'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $data = $request->validate([
            'ID_PELANGGAN' => 'required|string|max:5',
            'ID_ADMIN' => 'required|string|max:5',
            'TANGGAL_BAYAR' => 'nullable|date',
            'METODE_PEMBAYARAN' => 'nullable|string|max:30',
        ]);

        $pembayaran->update($data);
        return redirect()->route('pembayaran.index');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index');
    }
}
