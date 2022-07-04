<?php

namespace ZanzibarPPP;

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
      /*DB::table('locations')->insert([
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
      ]);*/
        //Zanzibar west
      DB::table('locations')->insert([
          'name' => 'Mjini Magharibi',
          'type' => 'region',
          'code' => 'TZ-15'
      ]);
      /*DB::table('locations')->insert([
          'name' => 'Lindi',
          'type' => 'region',
          'code' => 'TZ-12'
      ]);*/
      //Pemba north
      DB::table('locations')->insert([
          'name' => 'Kaskazini Pemba',
          'type' => 'region',
          'code' => 'TZ-06'
      ]);
      /*DB::table('locations')->insert([
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
      ]);*/
      //Zanzibar south
      DB::table('locations')->insert([
          'name' => 'Kusini Unguja',
          'type' => 'region',
          'code' => 'TZ-11'
      ]);
      /*DB::table('locations')->insert([
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
      ]);*/
      // Zanzibar north
      DB::table('locations')->insert([
          'name' => 'Kaskazini Unguja',
          'type' => 'region',
          'code' => 'TZ-07'
      ]);
      //Pemba south
      DB::table('locations')->insert([
          'name' => 'Kusini Pemba',
          'type' => 'region',
          'code' => 'TZ-10'
      ]);
      /*DB::table('locations')->insert([
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
      ]);*/

    }
}
