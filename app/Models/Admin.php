<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'ID_ADMIN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_ADMIN', 'USERNAME', 'PASSWORD', 'NAMA_ADMIN'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'ID_ADMIN', 'ID_ADMIN');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'ID_ADMIN', 'ID_ADMIN');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'ID_ADMIN', 'ID_ADMIN');
    }
}
