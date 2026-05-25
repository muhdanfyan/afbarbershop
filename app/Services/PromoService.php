<?php

namespace App\Services;

use App\Models\Voucher;

class PromoService
{
    /**
     * Valdidasi voucher
     */
    public function validateVoucher($code, $amount)
    {
        $code = strtoupper($code);
        $voucher = Voucher::where('code', $code)->where('is_active', true)->first();

        if (!$voucher) {
            throw new \Exception("Kode promo tidak ditemukan atau tidak aktif.");
        }

        if ($voucher->quota > 0 && $voucher->used_count >= $voucher->quota) {
            throw new \Exception("Kuota promo sudah habis.");
        }

        if ($voucher->valid_from && now()->lt($voucher->valid_from)) {
            throw new \Exception("Promo belum dimulai.");
        }

        if ($voucher->valid_until && now()->gt($voucher->valid_until)) {
            throw new \Exception("Promo sudah berakhir.");
        }

        if ($amount < $voucher->min_spend) {
            throw new \Exception("Minimal transaksi untuk promo ini adalah Rp " . number_format($voucher->min_spend, 0, ',', '.'));
        }

        return $voucher;
    }

    /**
     * Hitung Nominal Diskon
     */
    public function calculateDiscount(Voucher $voucher, $amount)
    {
        if ($voucher->type === 'fixed') {
            return min($voucher->reward, $amount);
        } else {
            return ($voucher->reward / 100) * $amount;
        }
    }
}
