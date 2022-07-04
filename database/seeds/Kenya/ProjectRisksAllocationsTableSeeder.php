<?php

namespace Kenya;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectRisksAllocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pd_risks_allocation')->insert([
            'name' => 'Public Sector'
        ]);
        DB::table('pd_risks_allocation')->insert([
            'name' => 'Private Sector'
        ]);
        DB::table('pd_risks_allocation')->insert([
            'name' => 'Public and Private Sectors'
        ]);
    }
}
