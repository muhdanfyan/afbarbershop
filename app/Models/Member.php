<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = [
        'nama',
        'nomor_wa',
        'alamat',
        'poin',
        'total_kunjungan',
        'level',
    ];

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
