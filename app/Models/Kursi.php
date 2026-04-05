<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursi extends Model
{
    protected $table = 'kursis';

    protected $fillable = [
        'nama',
        'lokasi',
        'deskripsi',
        'status',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kursi_id');
    }
}
