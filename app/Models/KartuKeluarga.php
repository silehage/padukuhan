<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'nomor',
        'kepala_keluarga',
        'alamat',
        'rt_rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kodepos',
    ];

    public function items()
    {
        return $this->hasMany(Penduduk::class);
    }
}
