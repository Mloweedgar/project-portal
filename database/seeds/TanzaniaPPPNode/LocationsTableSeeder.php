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
          'name' => 'Mwanza',
          'type' => 'region',
          'code' => 'TZ-18'
      ]);
      DB::table('locations')->insert([
          'name' => 'Kagera',
          'type' => 'region',
          'code' => 'TZ-05'
      ]);
      DB::table('locations')->insert([
          'name' => 'Arusha',
          'type' => 'region',
          'code' => 'TZ-01'
      ]);
      DB::table('locations')->insert([
          'name' => 'Iringa',
          'type' => 'region',
          'code' => 'TZ-04'
      ]);
      DB::table('locations')->insert([
          'name' => 'Dar es Salaam',
          'type' => 'region',
          'code' => 'TZ-02'
      ]);
      DB::table('locations')->insert([
          'name' => 'Ruvuma',
          'type' => 'region',
          'code' => 'TZ-21'
      ]);
      DB::table('locations')->insert([
          'name' => 'Tanga',
          'type' => 'region',
          'code' => 'TZ-25'
      ]);
      DB::table('locations')->insert([
          'name' => 'Tabora',
          'type' => 'region',
          'code' => 'TZ-24'
      ]);
      DB::table('locations')->insert([
          'name' => 'Zanzibar west',
          'type' => 'region',
          'code' => 'TZ-15'
      ]);
      DB::table('locations')->insert([
          'name' => 'Lindi',
          'type' => 'region',
          'code' => 'TZ-12'
      ]);
      DB::table('locations')->insert([
          'name' => 'Pemba north',
          'type' => 'region',
          'code' => 'TZ-06'
      ]);
      DB::table('locations')->insert([
          'name' => 'Mtwara',
          'type' => 'region',
          'code' => 'TZ-17'
      ]);
      DB::table('locations')->insert([
          'name' => 'Rukwa',
          'type' => 'region',
          'code' => 'TZ-20'
      ]);
      DB::table('locations')->insert([
          'name' => 'Shinyanga',
          'type' => 'region',
          'code' => 'TZ-22'
      ]);
      DB::table('locations')->insert([
          'name' => 'Zanzibar south',
          'type' => 'region',
          'code' => 'TZ-11'
      ]);
      DB::table('locations')->insert([
          'name' => 'Coast',
          'type' => 'region',
          'code' => 'TZ-19'
      ]);
      DB::table('locations')->insert([
          'name' => 'Kilimanjaro',
          'type' => 'region',
          'code' => 'TZ-09'
      ]);
      DB::table('locations')->insert([
          'name' => 'Kigoma',
          'type' => 'region',
          'code' => 'TZ-08'
      ]);
      DB::table('locations')->insert([
          'name' => 'Dodoma',
          'type' => 'region',
          'code' => 'TZ-03'
      ]);
      DB::table('locations')->insert([
          'name' => 'Mara',
          'type' => 'region',
          'code' => 'TZ-13'
      ]);
      DB::table('locations')->insert([
          'name' => 'Zanzibar north',
          'type' => 'region',
          'code' => 'TZ-07'
      ]);
      DB::table('locations')->insert([
          'name' => 'Pemba south',
          'type' => 'region',
          'code' => 'TZ-10'
      ]);
      DB::table('locations')->insert([
          'name' => 'Morogoro',
          'type' => 'region',
          'code' => 'TZ-16'
      ]);
      DB::table('locations')->insert([
          'name' => 'Mbeya',
          'type' => 'region',
          'code' => 'TZ-14'
      ]);
      DB::table('locations')->insert([
          'name' => 'Manyara',
          'type' => 'region',
          'code' => 'TZ-26'
      ]);
      DB::table('locations')->insert([
          'name' => 'Singida',
          'type' => 'region',
          'code' => 'TZ-23'
      ]);

    }
}
