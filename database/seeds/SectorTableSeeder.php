<?php

use Illuminate\Database\Seeder;

class SectorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sectors')->insert([
        'id' => 1,
        'name' => 'Energy',
        'code_lang' => 'sector_energy'
      ]);
      DB::table('sectors')->insert([
        'id' => 2,
        'name' => 'Industrial',
        'code_lang' => 'sector_industrial'
      ]);
      DB::table('sectors')->insert([
        'id' => 3,
        'name' => 'Social & Health',
        'code_lang' => 'sector_social'
      ]);
      DB::table('sectors')->insert([
        'id' => 4,
        'name' => 'Telecom',
        'code_lang' => 'sector_telecom'
      ]);
      DB::table('sectors')->insert([
        'id' => 5,
        'name' => 'Transport',
        'code_lang' => 'sector_transport'
      ]);
      DB::table('sectors')->insert([
        'id' => 6,
        'name' => 'Water & Waste',
        'code_lang' => 'sector_water'
      ]);
    }
}
