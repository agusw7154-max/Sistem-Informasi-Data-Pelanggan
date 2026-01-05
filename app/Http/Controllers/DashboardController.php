<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $tablesExist = Schema::hasTable('pelanggan') && Schema::hasTable('produk') && Schema::hasTable('transaksi') && Schema::hasTable('pembayaran');

        if ($tablesExist) {
            $totalPelanggan = Pelanggan::count();
            $totalProduk = Produk::count();
            $totalTransaksi = Transaksi::count();
            $totalPembayaran = Pembayaran::count();

            $recentPelanggan = Pelanggan::orderBy('ID_PELANGGAN', 'desc')->limit(10)->get();
            $recentTransaksi = Transaksi::with('pelanggan')->orderBy('TANGGAL_TRANSAKSI','desc')->limit(10)->get();
        } else {
            $totalPelanggan = 0;
            $totalProduk = 0;
            $totalTransaksi = 0;
            $totalPembayaran = 0;
            $recentPelanggan = collect();
            $recentTransaksi = collect();
        }

        return view('dashboard', compact(
            'totalPelanggan', 'totalProduk', 'totalTransaksi', 'totalPembayaran', 'recentPelanggan', 'recentTransaksi', 'tablesExist'
        ));
    }
}
