<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'ID_PEMBAYARAN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_PEMBAYARAN', 'ID_PELANGGAN', 'ID_ADMIN', 'TANGGAL_BAYAR', 'METODE_PEMBAYARAN'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ID_PEMBAYARAN)) {
                $lastPembayaran = self::orderBy('ID_PEMBAYARAN', 'DESC')->first();
                $lastNumber = $lastPembayaran ? (int)substr($lastPembayaran->ID_PEMBAYARAN, 2) : 0;
                $model->ID_PEMBAYARAN = 'PB' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ID_ADMIN', 'ID_ADMIN');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'ID_PEMBAYARAN', 'ID_PEMBAYARAN');
    }
}
