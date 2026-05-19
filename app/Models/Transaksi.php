<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $guarded = [];
    // If you want to be explicit, you can use $fillable
    // protected $fillable = ['status', 'catatan', ...];

    // Optionally, you can use $fillable if you want to be explicit
    // protected $fillable = ['status', ...];

    public function jasa()
    {
        return $this->belongsToMany(Jasa::class, 'jasa_transaksi', 'transaksi_id', 'jasa_id');
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'transaksi_barang', 'transaksi_id', 'barang_id')->withPivot('jumlah');
    }

    public function kapster()
    {
        return $this->belongsTo(Kapster::class, 'kapster_id');
    }

    /**
     * Status values: menunggu, proses, selesai
     */
    public static function statusList()
    {
        return ['menunggu', 'proses', 'selesai'];
    }
}
