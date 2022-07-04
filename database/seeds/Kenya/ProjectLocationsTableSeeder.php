<?php

namespace Kenya;

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
        // 1
        DB::table('location_project_information')->insert([
            'id' => 1,
            'location_id' => 28,
            'project_information_id' => 1
        ]);

        // 2
        DB::table('location_project_information')->insert([
            'id' => 2,
            'location_id' => 28,
            'project_information_id' => 2
        ]);
        DB::table('location_project_information')->insert([
            'id' => 3,
            'location_id' => 30,
            'project_information_id' => 2
        ]);

        // 3
        DB::table('location_project_information')->insert([
            'id' => 4,
            'location_id' => 30,
            'project_information_id' => 3
        ]);

        // 4
        DB::table('location_project_information')->insert([
            'id' => 5,
            'location_id' => 30,
            'project_information_id' => 4
        ]);
        DB::table('location_project_information')->insert([
            'id' => 6,
            'location_id' => 31,
            'project_information_id' => 4
        ]);

        //5
        DB::table('location_project_information')->insert([
            'id' => 7,
            'location_id' => 1,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 8,
            'location_id' => 2,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 9,
            'location_id' => 3,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 10,
            'location_id' => 4,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 11,
            'location_id' => 5,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 12,
            'location_id' => 6,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 13,
            'location_id' => 7,
            'project_information_id' => 5
        ]);
        DB::table('location_project_information')->insert([
            'id' => 14,
            'location_id' => 8,
            'project_information_id' => 5
        ]);

        // 6
        DB::table('location_project_information')->insert([
            'id' => 15,
            'location_id' => 28,
            'project_information_id' => 6
        ]);

        // 7
        DB::table('location_project_information')->insert([
            'id' => 16,
            'location_id' => 17,
            'project_information_id' => 7
        ]);

        // 8
        DB::table('location_project_information')->insert([
            'id' => 17,
            'location_id' => 19,
            'project_information_id' => 8
        ]);

        // 9
        DB::table('location_project_information')->insert([
            'id' => 18,
            'location_id' => 28,
            'project_information_id' => 9
        ]);

        // 10
        DB::table('location_project_information')->insert([
            'id' => 19,
            'location_id' => 21,
            'project_information_id' => 10
        ]);

        // 11
        DB::table('location_project_information')->insert([
            'id' => 20,
            'location_id' => 28,
            'project_information_id' => 11
        ]);

    }
}
