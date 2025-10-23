<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{

    protected $table = 'inventaris';
    protected $fillable = [
        'nama_barang',
        'asal_barang',
        'tanggal',
        'jumlah',
        'satuan',
        'tempat_penyimpanan',
        'kondisi_barang',
        'keterangan',
    ];
}
