<?php

namespace TanzaniaPPPNode;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('location_project_information')->insert([
            'id' => 1,
            'location_id' => 1,
            'project_information_id' => 1
        ]);
        DB::table('location_project_information')->insert([
            'id' => 2,
            'location_id' => 2,
            'project_information_id' => 1
        ]);
        DB::table('location_project_information')->insert([
            'id' => 3,
            'location_id' => 3,
            'project_information_id' => 2
        ]);
        DB::table('location_project_information')->insert([
            'id' => 4,
            'location_id' => 4,
            'project_information_id' => 2
        ]);
        DB::table('location_project_information')->insert([
            'id' => 5,
            'location_id' => 1,
            'project_information_id' => 3
        ]);
        DB::table('location_project_information')->insert([
            'id' => 6,
            'location_id' => 2,
            'project_information_id' => 4
        ]);
        DB::table('location_project_information')->insert([
            'id' => 7,
            'location_id' => 3,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 8,
            'location_id' => 4,
            'project_information_id' => 6
        ]);
        DB::table('location_project_information')->insert([
            'id' => 9,
            'location_id' => 1,
            'project_information_id' => 7
        ]);
        DB::table('location_project_information')->insert([
            'id' => 10,
            'location_id' => 2,
            'project_information_id' => 8
        ]);
        DB::table('location_project_information')->insert([
            'id' => 11,
            'location_id' => 3,
            'project_information_id' => 9
        ]);
    }
}
