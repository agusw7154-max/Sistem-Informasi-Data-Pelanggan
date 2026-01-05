<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'ID_TRANSAKSI';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_TRANSAKSI', 'ID_ADMIN', 'ID_PELANGGAN', 'ID_PEMBAYARAN', 'TANGGAL_TRANSAKSI', 'total_bayar'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ID_ADMIN', 'ID_ADMIN');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'ID_PEMBAYARAN', 'ID_PEMBAYARAN');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'ID_TRANSAKSI', 'ID_TRANSAKSI');
    }
}
