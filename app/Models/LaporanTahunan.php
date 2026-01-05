<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanTahunan extends Model
{
    protected $table = 'laporan_tahunan';
    protected $primaryKey = 'id_laporan';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan', 'tahun', 'total_penjualan', 'tanggal_rekap'
    ];
}
