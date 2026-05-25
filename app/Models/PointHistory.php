<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    protected $table = 'point_histories';
    protected $fillable = [
        'member_id',
        'transaksi_id',
        'amount',
        'type',
        'description',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
