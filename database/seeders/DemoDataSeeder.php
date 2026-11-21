<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteGrade;
use App\Models\WasteTransaction;
use App\Models\PointRedemption;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $budi = User::where('email', 'budi@ecopoint.test')->first();
        $siti = User::where('email', 'siti@ecopoint.test')->first();

        $botol = WasteCategory::where('name', 'Botol')->first();
        $kaleng = WasteCategory::where('name', 'Kaleng')->first();

        $gradeA = WasteGrade::where('grade_code', 'A')->first();
        $gradeB = WasteGrade::where('grade_code', 'B')->first();

        if ($budi && $botol && $admin) {
            // 1 Approved transaction: 25 botol + Grade A (4) = 29 poin
            WasteTransaction::firstOrCreate(
                ['user_id' => $budi->id, 'quantity_or_weight' => 25],
                [
                    'category_id' => $botol->id,
                    'grade_id' => $gradeA->id,
                    'earned_points' => 29,
                    'status' => 'approved',
                    'verified_by' => $admin->id,
                    'notes' => 'Kondisi botol bersih dan sudah dipipihkan.',
                ]
            );

            // 1 Approved transaction: 600 gram kaleng (6) + Grade B (3) = 9 poin
            WasteTransaction::firstOrCreate(
                ['user_id' => $budi->id, 'quantity_or_weight' => 600],
                [
                    'category_id' => $kaleng->id,
                    'grade_id' => $gradeB->id,
                    'earned_points' => 9,
                    'status' => 'approved',
                    'verified_by' => $admin->id,
                    'notes' => 'Kaleng bersih, grade B bagus.',
                ]
            );

            // 1 Pending transaction: 12 botol
            WasteTransaction::firstOrCreate(
                ['user_id' => $budi->id, 'quantity_or_weight' => 12],
                [
                    'category_id' => $botol->id,
                    'grade_id' => null,
                    'earned_points' => 0,
                    'status' => 'pending',
                    'verified_by' => null,
                    'notes' => null,
                ]
            );

            // Set Budi total points: 29 + 9 = 38 points
            $budi->update(['total_points' => 38]);
        }

        if ($siti && $kaleng) {
            // Siti has 1 pending transaction: 450 gram kaleng
            WasteTransaction::firstOrCreate(
                ['user_id' => $siti->id, 'quantity_or_weight' => 450],
                [
                    'category_id' => $kaleng->id,
                    'grade_id' => null,
                    'earned_points' => 0,
                    'status' => 'pending',
                    'verified_by' => null,
                    'notes' => null,
                ]
            );
        }
    }
}
