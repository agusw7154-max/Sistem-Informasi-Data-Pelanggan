<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'ID_PELANGGAN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_PELANGGAN', 'NAMA_PELANGGAN', 'ALAMAT', 'NO_TELEPON', 'EMAIL'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ID_PELANGGAN)) {
                $lastPelanggan = self::orderBy('ID_PELANGGAN', 'DESC')->first();
                $lastNumber = $lastPelanggan ? (int)substr($lastPelanggan->ID_PELANGGAN, 1) : 100;
                $model->ID_PELANGGAN = 'B' . ($lastNumber + 1);
            }
        });
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }
}
