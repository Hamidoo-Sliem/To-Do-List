<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();

        $insertions  = [
            [
                'name'                => 'Work',
                'created_at'          => DB::raw('NOW()'),
            ],[
                'name'                => 'Personal',
                'created_at'          => DB::raw('NOW()'),
            ],[
                'name'                => 'Urgent',
                'created_at'          => DB::raw('NOW()'),
            ],
];
   DB::table('categories')->insert($insertions);
    }
}
