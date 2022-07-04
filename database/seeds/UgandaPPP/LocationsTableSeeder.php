<?php

namespace TanzaniaPPPNode;

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
            'name' => 'Central',
            'type' => 'region',
            'code' => 'UG-C'
        ]);
        DB::table('locations')->insert([
            'name' => 'Eastern',
            'type' => 'region',
            'code' => 'UG-E'
        ]);
        DB::table('locations')->insert([
            'name' => 'Northern',
            'type' => 'region',
            'code' => 'UG-N'
        ]);
        DB::table('locations')->insert([
            'name' => 'Western',
            'type' => 'region',
            'code' => 'UG-W'
        ]);

    }
}
