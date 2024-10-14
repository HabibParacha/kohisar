<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variations')->insert([
            [
                'name' => 'Color',
                'values' => json_encode(['Red', 'Blue', 'Green']),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Size',
                'values' => json_encode(['Small', 'Medium', 'Large']),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
        ]);
    }
}
