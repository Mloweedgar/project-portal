<?php

namespace NigeriaNSIA;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 1
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 2
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 3,
            'project_information_id' => 3
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 3,
            'project_information_id' => 4
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 1,
            'project_information_id' => 5
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 6
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 7
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 8
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 3,
            'project_information_id' => 9
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 3,
            'project_information_id' => 10
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 11
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 12
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 2,
            'project_information_id' => 13
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 4,
            'project_information_id' => 14
        ]);
        DB::table('sector_project_information')->insert([
            'sector_id' => 5,
            'project_information_id' => 15
        ]);
    }
}
