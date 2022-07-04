<?php

namespace Ghana;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'id' => 1,
            'name' => 'Ashanti',
            'type' => 'region',
            'code' => 'GH-AH'
        ]);
        DB::table('locations')->insert([
            'id' => 2,
            'name' => 'Brong-Ahafo',
            'type' => 'region',
            'code' => 'GH-BA'
        ]);
        DB::table('locations')->insert([
            'id' => 3,
            'name' => 'Central',
            'type' => 'region',
            'code' => 'GH-CP'
        ]);
        DB::table('locations')->insert([
            'id' => 4,
            'name' => 'Eastern',
            'type' => 'region',
            'code' => 'GH-EP'
        ]);
        DB::table('locations')->insert([
            'id' => 5,
            'name' => 'Greater Accra',
            'type' => 'region',
            'code' => 'GH-AA'
        ]);
        DB::table('locations')->insert([
            'id' => 6,
            'name' => 'Northern',
            'type' => 'region',
            'code' => 'GH-NP'
        ]);
        DB::table('locations')->insert([
            'id' => 7,
            'name' => 'Upper East',
            'type' => 'region',
            'code' => 'GH-UE'
        ]);
        DB::table('locations')->insert([
            'id' => 8,
            'name' => 'Upper West',
            'type' => 'region',
            'code' => 'GH-UW'
        ]);
        DB::table('locations')->insert([
            'id' => 9,
            'name' => 'Volta',
            'type' => 'region',
            'code' => 'GH-TV'
        ]);
        DB::table('locations')->insert([
            'id' => 10,
            'name' => 'Western',
            'type' => 'region',
            'code' => 'GH-WP'
        ]);
    }
}
