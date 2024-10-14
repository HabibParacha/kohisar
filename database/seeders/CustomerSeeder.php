<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name' => 'Customer 1',
                'contact_person' => 'John Doe',
                'mobile_no' => '1234567890',
                'image' => NULL,
            ],
            [
                'name' => 'Customer 2',
                'contact_person' => 'Jane Smith',
                'mobile_no' => '0987654321',
                'image' => NULL,
            ],
            [
                'name' => 'Customer 3',
                'contact_person' => 'David Brown',
                'mobile_no' => '1122334455',
                'image' => NULL,
            ],
        ]);
    }
}
