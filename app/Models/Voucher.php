<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $fillable = [
        'code',
        'type',
        'reward',
        'min_spend',
        'quota',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function isValidPforAmount($amount)
    {
        if (!$this->is_active) return false;
        if ($this->quota > 0 && $this->used_count >= $this->quota) return false;
        if ($this->valid_from && now()->lt($this->valid_from)) return false;
        if ($this->valid_until && now()->gt($this->valid_until)) return false;
        if ($amount < $this->min_spend) return false;
        
        return true;
    }
}
