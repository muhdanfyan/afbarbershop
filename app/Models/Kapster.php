<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kapster extends Model
{
    protected $table = 'kapster';

    protected $fillable = [
        'nama',
        'status',
        'nik',
        'no_wa',
        'alamat',
        'foto',
        'sertifikat'
    ];

    public function transaksis()
    {
        return $this->hasMany(\App\Models\Transaksi::class, 'kapster_id');
    }
}
