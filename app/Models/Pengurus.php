<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected $guarded = [];

    public $timestamps = false;

    public function list()
    {
        return $this->hasMany(Penduduk::class);
    }
}
