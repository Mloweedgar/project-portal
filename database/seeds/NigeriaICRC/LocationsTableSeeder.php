<?php

namespace NigeriaICRC;

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
            'name' => 'Federal Capital Territory',
            'type' => 'region',
            'code' => 'NG-FC'
        ]);
        DB::table('locations')->insert([
            'name' => 'Abia',
            'type' => 'region',
            'code' => 'NG-AB'
        ]);
        DB::table('locations')->insert([
            'name' => 'Adamawa',
            'type' => 'region',
            'code' => 'NG-AD'
        ]);
        DB::table('locations')->insert([
            'name' => 'Akwa Ibom',
            'type' => 'region',
            'code' => 'NG-AK'
        ]);
        DB::table('locations')->insert([
            'name' => 'Anambra',
            'type' => 'region',
            'code' => 'NG-AN'
        ]);
        DB::table('locations')->insert([
            'name' => 'Bauchi',
            'type' => 'region',
            'code' => 'NG-BA'
        ]);
        DB::table('locations')->insert([
            'name' => 'Bayelsa',
            'type' => 'region',
            'code' => 'NG-BY'
        ]);
        DB::table('locations')->insert([
            'name' => 'Benue',
            'type' => 'region',
            'code' => 'NG-BE'
        ]);
        DB::table('locations')->insert([
            'name' => 'Borno',
            'type' => 'region',
            'code' => 'NG-BO'
        ]);
        DB::table('locations')->insert([
            'name' => 'Cross River',
            'type' => 'region',
            'code' => 'NG-CR'
        ]);
        DB::table('locations')->insert([
            'name' => 'Delta',
            'type' => 'region',
            'code' => 'NG-DE'
        ]);
        DB::table('locations')->insert([
            'name' => 'Ebonyi',
            'type' => 'region',
            'code' => 'NG-EB'
        ]);
        DB::table('locations')->insert([
            'name' => 'Edo',
            'type' => 'region',
            'code' => 'NG-ED'
        ]);
        DB::table('locations')->insert([
            'name' => 'Ekiti',
            'type' => 'region',
            'code' => 'NG-EK'
        ]);
        DB::table('locations')->insert([
            'name' => 'Enugu',
            'type' => 'region',
            'code' => 'NG-EN'
        ]);
        DB::table('locations')->insert([
            'name' => 'Gombe',
            'type' => 'region',
            'code' => 'NG-GO'
        ]);
        DB::table('locations')->insert([
            'name' => 'Imo',
            'type' => 'region',
            'code' => 'NG-IM'
        ]);
        DB::table('locations')->insert([
            'name' => 'Jigawa',
            'type' => 'region',
            'code' => 'NG-JI'
        ]);
        DB::table('locations')->insert([
            'name' => 'Kaduna',
            'type' => 'region',
            'code' => 'NG-KD'
        ]);
        DB::table('locations')->insert([
            'name' => 'Kano',
            'type' => 'region',
            'code' => 'NG-KN'
        ]);
        DB::table('locations')->insert([
            'name' => 'Katsina',
            'type' => 'region',
            'code' => 'NG-KT'
        ]);
        DB::table('locations')->insert([
            'name' => 'Kebbi',
            'type' => 'region',
            'code' => 'NG-KE'
        ]);
        DB::table('locations')->insert([
            'name' => 'Kogi',
            'type' => 'region',
            'code' => 'NG-FC'
        ]);
        DB::table('locations')->insert([
            'name' => 'Kwara',
            'type' => 'region',
            'code' => 'NG-KW'
        ]);
        DB::table('locations')->insert([
            'name' => 'Lagos',
            'type' => 'region',
            'code' => 'NG-LA'
        ]);
        DB::table('locations')->insert([
            'name' => 'Nasarawa',
            'type' => 'region',
            'code' => 'NG-NA'
        ]);
        DB::table('locations')->insert([
            'name' => 'Niger',
            'type' => 'region',
            'code' => 'NG-NI'
        ]);
        DB::table('locations')->insert([
            'name' => 'Ogun',
            'type' => 'region',
            'code' => 'NG-OG'
        ]);
        DB::table('locations')->insert([
            'name' => 'Ondo',
            'type' => 'region',
            'code' => 'NG-ON'
        ]);
        DB::table('locations')->insert([
            'name' => 'Osun',
            'type' => 'region',
            'code' => 'NG-OS'
        ]);
        DB::table('locations')->insert([
            'name' => 'Oyo',
            'type' => 'region',
            'code' => 'NG-OY'
        ]);
        DB::table('locations')->insert([
            'name' => 'Plateau',
            'type' => 'region',
            'code' => 'NG-PL'
        ]);
        DB::table('locations')->insert([
            'name' => 'Rivers',
            'type' => 'region',
            'code' => 'NG-RI'
        ]);
        DB::table('locations')->insert([
            'name' => 'Sokoto',
            'type' => 'region',
            'code' => 'NG-SO'
        ]);
        DB::table('locations')->insert([
            'name' => 'Taraba',
            'type' => 'region',
            'code' => 'NG-TA'
        ]);
        DB::table('locations')->insert([
            'name' => 'Yobe',
            'type' => 'region',
            'code' => 'NG-YO'
        ]);
        DB::table('locations')->insert([
            'name' => 'Zamfara',
            'type' => 'region',
            'code' => 'NG-ZA'
        ]);
        


    }
}
