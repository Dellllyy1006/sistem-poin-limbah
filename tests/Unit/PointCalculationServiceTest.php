<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PointCalculationService;
use App\Models\WasteCategory;
use App\Models\WasteGrade;

class PointCalculationServiceTest extends TestCase
{
    protected PointCalculationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PointCalculationService();
    }

    public function test_calculate_base_points_for_botol(): void
    {
        $botol = new WasteCategory([
            'name' => 'Botol',
            'unit_type' => 'pcs',
            'unit_divisor' => 1,
            'base_point' => 1,
        ]);

        $this->assertEquals(0, $this->service->calculateBasePoints($botol, 0));
        $this->assertEquals(5, $this->service->calculateBasePoints($botol, 5));
        $this->assertEquals(25, $this->service->calculateBasePoints($botol, 25));
    }

    public function test_calculate_base_points_for_kaleng(): void
    {
        $kaleng = new WasteCategory([
            'name' => 'Kaleng',
            'unit_type' => 'gram',
            'unit_divisor' => 100,
            'base_point' => 1,
        ]);

        $this->assertEquals(0, $this->service->calculateBasePoints($kaleng, 0));
        $this->assertEquals(0, $this->service->calculateBasePoints($kaleng, 99));
        $this->assertEquals(1, $this->service->calculateBasePoints($kaleng, 100));
        $this->assertEquals(1, $this->service->calculateBasePoints($kaleng, 199));
        $this->assertEquals(2, $this->service->calculateBasePoints($kaleng, 200));
        $this->assertEquals(3, $this->service->calculateBasePoints($kaleng, 350));
    }

    public function test_calculate_bonus_points_for_grades(): void
    {
        $gradeA = new WasteGrade(['grade_code' => 'A', 'label' => 'Sangat Bagus', 'bonus_point' => 4]);
        $gradeB = new WasteGrade(['grade_code' => 'B', 'label' => 'Bagus', 'bonus_point' => 3]);
        $gradeC = new WasteGrade(['grade_code' => 'C', 'label' => 'Cukup', 'bonus_point' => 2]);
        $gradeD = new WasteGrade(['grade_code' => 'D', 'label' => 'Kurang Layak', 'bonus_point' => 1]);

        $this->assertEquals(4, $this->service->calculateBonusPoints($gradeA));
        $this->assertEquals(3, $this->service->calculateBonusPoints($gradeB));
        $this->assertEquals(2, $this->service->calculateBonusPoints($gradeC));
        $this->assertEquals(1, $this->service->calculateBonusPoints($gradeD));
    }

    public function test_calculate_total_points(): void
    {
        $botol = new WasteCategory([
            'name' => 'Botol',
            'unit_type' => 'pcs',
            'unit_divisor' => 1,
            'base_point' => 1,
        ]);
        $gradeA = new WasteGrade(['grade_code' => 'A', 'bonus_point' => 4]);

        // 10 Botol + Grade A (4) = 14 Poin
        $this->assertEquals(14, $this->service->calculateTotalPoints($botol, 10, $gradeA));

        $kaleng = new WasteCategory([
            'name' => 'Kaleng',
            'unit_type' => 'gram',
            'unit_divisor' => 100,
            'base_point' => 1,
        ]);
        $gradeB = new WasteGrade(['grade_code' => 'B', 'bonus_point' => 3]);

        // 350 gram Kaleng (3) + Grade B (3) = 6 Poin
        $this->assertEquals(6, $this->service->calculateTotalPoints($kaleng, 350, $gradeB));
    }

    public function test_convert_points_to_rupiah_greedy_algorithm(): void
    {
        // 20 Poin = Rp 1.000, 10 Poin = Rp 500, 1 Poin = Rp 100
        $this->assertEquals(0, $this->service->convertPointsToRupiah(0));
        $this->assertEquals(100, $this->service->convertPointsToRupiah(1));
        $this->assertEquals(900, $this->service->convertPointsToRupiah(9));
        $this->assertEquals(500, $this->service->convertPointsToRupiah(10));
        $this->assertEquals(600, $this->service->convertPointsToRupiah(11));
        $this->assertEquals(1000, $this->service->convertPointsToRupiah(20));
        $this->assertEquals(1100, $this->service->convertPointsToRupiah(21));
        $this->assertEquals(2000, $this->service->convertPointsToRupiah(35)); // 1x20 (1000) + 1x10 (500) + 5x1 (500) = 2000
        $this->assertEquals(2500, $this->service->convertPointsToRupiah(50)); // 2x20 (2000) + 1x10 (500) = 2500
    }

    public function test_calculate_rupiah_breakdown(): void
    {
        $breakdown = $this->service->calculateRupiahBreakdown(35);

        $this->assertEquals(35, $breakdown['points']);
        $this->assertEquals(1, $breakdown['chunk_20_count']);
        $this->assertEquals(1000, $breakdown['chunk_20_rupiah']);
        $this->assertEquals(1, $breakdown['chunk_10_count']);
        $this->assertEquals(500, $breakdown['chunk_10_rupiah']);
        $this->assertEquals(5, $breakdown['chunk_1_count']);
        $this->assertEquals(500, $breakdown['chunk_1_rupiah']);
        $this->assertEquals(2000, $breakdown['total_rupiah']);
    }
}
