<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertions  = [
            [
                'name' => 'Hamdi',
                'email' => 'hamdi@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => DB::raw('NOW()')
            ],[
                'name' => 'Ahmed',
                'email' => 'ahmed@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => DB::raw('NOW()')
            ],[
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => DB::raw('NOW()')
            ],
];
   DB::table('users')->insert($insertions);
    }
}
