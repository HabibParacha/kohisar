<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => null,
                'is_super_admin' => 1,
                'name' => 'Super Admin',
                'mobile_no' => '033309874587',
                'email' => 'super@extbooks.com',
                'type' => 'admin',
                'password' => Hash::make('123456'),
                'hint' => '123456',  
            ],

            [
                'role_id' => null,
                'is_super_admin' => 0,
                'name' => 'Admin',
                'mobile_no' => '033309874000',
                'email' => 'admin@extbooks.com',
                'type' => 'admin',
                'password' => Hash::make('123456'),
                'hint' => '123456',  
            ],
            
           
        ]);
    }
}
