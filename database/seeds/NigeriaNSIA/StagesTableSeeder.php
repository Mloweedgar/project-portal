<?php

namespace NigeriaNSIA;

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
            'name' => 'Post appraisal',
            'color' => 'E53935'
        ]);
        DB::table('stages')->insert([
            'name' => 'Post contract',
            'color' => 'f4d35e'
        ]);
    }
}
