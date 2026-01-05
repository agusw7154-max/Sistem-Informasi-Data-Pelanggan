<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'ID_PRODUK';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_PRODUK', 'ID_ADMIN', 'ID_PELANGGAN', 'NAMA_PRODUK', 'HARGA', 'STOK', 'total_terjual'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ID_ADMIN', 'ID_ADMIN');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'ID_PRODUK', 'ID_PRODUK');
    }
}
