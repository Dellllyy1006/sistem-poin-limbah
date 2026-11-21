<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteCategory;

class WasteCategorySeeder extends Seeder
{
    public function run(): void
    {
        WasteCategory::updateOrCreate(
            ['name' => 'Botol'],
            [
                'unit_type' => 'pcs',
                'unit_divisor' => 1,
                'base_point' => 1,
            ]
        );

        WasteCategory::updateOrCreate(
            ['name' => 'Kaleng'],
            [
                'unit_type' => 'gram',
                'unit_divisor' => 100,
                'base_point' => 1,
            ]
        );
    }
}
