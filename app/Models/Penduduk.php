<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $fillable = [
        'kartu_keluarga_id',
        'nama_lengkap',
        'nik',
        'Jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'jenis_pekerjaan',
        'golongan_darah',
        'status_perkawinan',
        'tanggal_perkawinan',
        'status_hubungan_keluarga',
        'kewarganegaraan',
        'no_paspor',
        'no_kitap',
        'nama_ayah',
        'nama_ibu',
    ];

    public function tanggalLahir(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y') 
        );
    }
    public function tanggalPerkawinan(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('d-m-Y') : ''
        );
    }
}
