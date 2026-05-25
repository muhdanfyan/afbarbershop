<?php

namespace App\Services;

use App\Models\Member;
use App\Models\PointHistory;
use App\Models\Transaksi;

class LoyaltyService
{
    /**
     * Dasar perhitungan: Rp 10.000 = 1 Poin
     */
    public function calculateEarnedPoints($amount)
    {
        return floor($amount / 10000);
    }

    /**
     * Menambah poin ke member dan mencatat riwayat
     */
    public function addPoints(Member $member, $amount, $type = 'earn', $transaksiId = null, $description = null)
    {
        if ($amount <= 0) return;

        $member->increment('poin', $amount);

        PointHistory::create([
            'member_id' => $member->id,
            'transaksi_id' => $transaksiId,
            'amount' => $amount,
            'type' => $type,
            'description' => $description,
        ]);

        $this->updateMemberLevel($member);
    }

    /**
     * Mengurangi poin member saat redeem
     */
    public function redeemPoints(Member $member, $amount, $transaksiId = null)
    {
        if ($amount <= 0) return;
        if ($member->poin < $amount) throw new \Exception("Saldo poin tidak mencukupi.");

        $member->decrement('poin', $amount);

        PointHistory::create([
            'member_id' => $member->id,
            'transaksi_id' => $transaksiId,
            'amount' => -$amount,
            'type' => 'redeem',
            'description' => "Penukaran poin untuk pembayaran",
        ]);
    }

    /**
     * Update Level berdasarkan total kunjungan
     * Silver: 0-10, Gold: 11-30, Platinum: >30
     */
    public function updateMemberLevel(Member $member)
    {
        $visits = $member->total_kunjungan;
        $newLevel = 'Silver';

        if ($visits > 30) {
            $newLevel = 'Platinum';
        } elseif ($visits > 10) {
            $newLevel = 'Gold';
        }

        if ($member->level !== $newLevel) {
            $member->update(['level' => $newLevel]);
        }
    }
}
