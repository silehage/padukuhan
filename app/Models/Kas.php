<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{

    protected $table = 'kas';

    protected $fillable = [
        'tanggal',
        'in_out',
        'jumlah',
        'keterangan',
    ];

    const Masuk = 'IN';
    const Keluar = 'OUT';

}
