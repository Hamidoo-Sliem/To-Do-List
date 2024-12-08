<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->delete();

        $insertions  = [
            [
                'name'                => 'pending',
                'created_at'          => DB::raw('NOW()'),
            ],[
                'name'                => 'completed',
                'created_at'          => DB::raw('NOW()'),
            ],
];
   DB::table('statuses')->insert($insertions);
    }
}
