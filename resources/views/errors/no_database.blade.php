@extends('layouts.app')

@section('title','Database belum terpasang')

@section('content')
<div class="alert alert-danger">
    <h4 class="alert-heading">Database belum terpasang</h4>
    <p>Tabel database yang diperlukan belum ditemukan. Silakan impor file <code>data_pelanggan.sql</code> ke database Anda atau periksa konfigurasi koneksi di <code>.env</code>.</p>
    <p>
        - Jika Anda menggunakan XAMPP/WAMP, buka <strong>phpMyAdmin</strong> lalu impor file tersebut.<br>
        - Atau gunakan MySQL CLI: <code>mysql -u root -p db_c050424021 &lt; data_pelanggan.sql</code>
    </p>
    <a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    </div>

@endsection
