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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ID_ADMIN)) {
                $lastAdmin = self::orderBy('ID_ADMIN', 'DESC')->first();
                $lastNumber = $lastAdmin ? (int)substr($lastAdmin->ID_ADMIN, 1) : 0;
                $model->ID_ADMIN = 'A' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

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
