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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ID_TRANSAKSI)) {
                $lastTransaksi = self::orderBy('ID_TRANSAKSI', 'DESC')->first();
                $lastNumber = $lastTransaksi ? (int)substr($lastTransaksi->ID_TRANSAKSI, 1) : 0;
                $model->ID_TRANSAKSI = 'T' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

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
