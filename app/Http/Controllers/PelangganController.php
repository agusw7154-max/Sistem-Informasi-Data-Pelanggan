<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('pelanggan')) {
            return view('errors.no_database');
        }

        $query = Pelanggan::query();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ID_PELANGGAN', 'like', "%{$search}%")
                  ->orWhere('NAMA_PELANGGAN', 'like', "%{$search}%")
                  ->orWhere('NO_TELEPON', 'like', "%{$search}%")
                  ->orWhere('EMAIL', 'like', "%{$search}%");
        }
        
        $pelanggans = $query->paginate(15)->appends($request->query());
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ID_PELANGGAN' => 'nullable|string|max:5',
            'NAMA_PELANGGAN' => 'required|string|max:100',
            'ALAMAT' => 'nullable|string',
            'NO_TELEPON' => 'nullable|string|max:16',
            'EMAIL' => 'nullable|email|max:100',
        ]);

        Pelanggan::create($data);
        return redirect()->route('pelanggan.index');
    }

    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            'NAMA_PELANGGAN' => 'required|string|max:100',
            'ALAMAT' => 'nullable|string',
            'NO_TELEPON' => 'nullable|string|max:16',
            'EMAIL' => 'nullable|email|max:100',
        ]);

        $pelanggan->update($data);
        return redirect()->route('pelanggan.index');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index');
    }
}
