<?php

namespace App\Services;

use App\Models\WasteCategory;
use App\Models\WasteGrade;

class PointCalculationService
{
    /**
     * Hitung poin dasar berdasarkan kategori dan jumlah/berat limbah.
     * Formula:
     * - Botol: (Jumlah pcs / 1) * 1 Poin
     * - Kaleng: (Berat gram / 100) * 1 Poin (menggunakan pembagian bulat floor / intdiv)
     */
    public function calculateBasePoints(WasteCategory $category, int $quantityOrWeight): int
    {
        if ($quantityOrWeight <= 0) {
            return 0;
        }

        $divisor = $category->unit_divisor > 0 ? $category->unit_divisor : 1;
        $units = intdiv($quantityOrWeight, $divisor);

        return $units * $category->base_point;
    }

    /**
     * Hitung poin grade kelayakan:
     * Grade A: 4 Poin
     * Grade B: 3 Poin
     * Grade C: 2 Poin
     * Grade D: 1 Poin
     */
    public function calculateBonusPoints(WasteGrade $grade): int
    {
        return (int) $grade->bonus_point;
    }

    /**
     * Total Poin Transaksi = Poin Dasar + Poin Grade Kelayakan
     */
    public function calculateTotalPoints(WasteCategory $category, int $quantityOrWeight, WasteGrade $grade): int
    {
        $base = $this->calculateBasePoints($category, $quantityOrWeight);
        $bonus = $this->calculateBonusPoints($grade);

        return $base + $bonus;
    }

    /**
     * Konversi Penukaran Poin ke Nilai Rupiah menggunakan algoritma greedy pecahan denominasi terbesar:
     * - 20 Poin = Rp 1.000
     * - 10 Poin = Rp 500
     * - 1 Poin  = Rp 100
     */
    public function convertPointsToRupiah(int $points): int
    {
        if ($points <= 0) {
            return 0;
        }

        $breakdown = $this->calculateRupiahBreakdown($points);
        return $breakdown['total_rupiah'];
    }

    /**
     * Rincian kalkulasi greedy konversi poin ke Rupiah.
     */
    public function calculateRupiahBreakdown(int $points): array
    {
        if ($points <= 0) {
            return [
                'points' => 0,
                'chunk_20_count' => 0,
                'chunk_20_rupiah' => 0,
                'chunk_10_count' => 0,
                'chunk_10_rupiah' => 0,
                'chunk_1_count' => 0,
                'chunk_1_rupiah' => 0,
                'total_rupiah' => 0,
            ];
        }

        $remaining = $points;

        // Pecahan 20 Poin -> Rp 1.000
        $chunk20 = intdiv($remaining, 20);
        $rupiah20 = $chunk20 * 1000;
        $remaining %= 20;

        // Pecahan 10 Poin -> Rp 500
        $chunk10 = intdiv($remaining, 10);
        $rupiah10 = $chunk10 * 500;
        $remaining %= 10;

        // Pecahan 1 Poin -> Rp 100
        $chunk1 = $remaining;
        $rupiah1 = $chunk1 * 100;

        $totalRupiah = $rupiah20 + $rupiah10 + $rupiah1;

        return [
            'points' => $points,
            'chunk_20_count' => $chunk20,
            'chunk_20_rupiah' => $rupiah20,
            'chunk_10_count' => $chunk10,
            'chunk_10_rupiah' => $rupiah10,
            'chunk_1_count' => $chunk1,
            'chunk_1_rupiah' => $rupiah1,
            'total_rupiah' => $totalRupiah,
        ];
    }
}
