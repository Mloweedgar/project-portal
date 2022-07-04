<?php

namespace NigeriaICRC;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stages')->insert([
            'name' => 'Development',
            'color' => 'E53935'
        ]);
        DB::table('stages')->insert([
            'name' => 'Procurement',
            'color' => 'f4d35e'
        ]);
        DB::table('stages')->insert([
            'name' => 'Implementation',
            'color' => '3f51b5'
        ]);
    }
}
