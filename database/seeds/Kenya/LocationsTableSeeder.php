<?php

namespace Kenya;

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
            'name' => 'Baringo',
            'type' => 'region',
            'code' => 'KE-01'
        ]);

        DB::table('locations')->insert([
            'id' => 2,
            'name' => 'Bomet',
            'type' => 'region',
            'code' => 'KE-02'
        ]);

        DB::table('locations')->insert([
            'id' => 3,
            'name' => 'Bungoma',
            'type' => 'region',
            'code' => 'KE-03'
        ]);

        DB::table('locations')->insert([
            'id' => 4,
            'name' => 'Busia',
            'type' => 'region',
            'code' => 'KE-04'
        ]);

        DB::table('locations')->insert([
            'id' => 5,
            'name' => 'Elgeyo Marakwet',
            'type' => 'region',
            'code' => 'KE-05'
        ]);

        DB::table('locations')->insert([
            'id' => 6,
            'name' => 'Embu',
            'type' => 'region',
            'code' => 'KE-06'
        ]);

        DB::table('locations')->insert([
            'id' => 7,
            'name' => 'Garissa',
            'type' => 'region',
            'code' => 'KE-07'
        ]);

        DB::table('locations')->insert([
            'id' => 8,
            'name' => 'Homa Bay',
            'type' => 'region',
            'code' => 'KE-08'
        ]);

        DB::table('locations')->insert([
            'id' => 9,
            'name' => 'Isiolo',
            'type' => 'region',
            'code' => 'KE-09'
        ]);

        DB::table('locations')->insert([
            'id' => 10,
            'name' => 'Kajiado',
            'type' => 'region',
            'code' => 'KE-10'
        ]);

        DB::table('locations')->insert([
            'id' => 11,
            'name' => 'Kakamega',
            'type' => 'region',
            'code' => 'KE-11'
        ]);

        DB::table('locations')->insert([
            'id' => 12,
            'name' => 'Kericho',
            'type' => 'region',
            'code' => 'KE-12'
        ]);

        DB::table('locations')->insert([
            'id' => 13,
            'name' => 'Kiambu',
            'type' => 'region',
            'code' => 'KE-13'
        ]);

        DB::table('locations')->insert([
            'id' => 14,
            'name' => 'Kilifi',
            'type' => 'region',
            'code' => 'KE-14'
        ]);

        DB::table('locations')->insert([
            'id' => 15,
            'name' => 'Kirinyaga',
            'type' => 'region',
            'code' => 'KE-15'
        ]);

        DB::table('locations')->insert([
            'id' => 16,
            'name' => 'Kisii',
            'type' => 'region',
            'code' => 'KE-16'
        ]);

        DB::table('locations')->insert([
            'id' => 17,
            'name' => 'Kisumu',
            'type' => 'region',
            'code' => 'KE-17'
        ]);

        DB::table('locations')->insert([
            'id' => 18,
            'name' => 'Kitui',
            'type' => 'region',
            'code' => 'KE-18'
        ]);

        DB::table('locations')->insert([
            'id' => 19,
            'name' => 'Kwale',
            'type' => 'region',
            'code' => 'KE-19'
        ]);

        DB::table('locations')->insert([
            'id' => 20,
            'name' => 'Laikipia',
            'type' => 'region',
            'code' => 'KE-20'
        ]);

        DB::table('locations')->insert([
            'id' => 21,
            'name' => 'Lamu',
            'type' => 'region',
            'code' => 'KE-21'
        ]);

        DB::table('locations')->insert([
            'id' => 22,
            'name' => 'Machakos',
            'type' => 'region',
            'code' => 'KE-22'
        ]);

        DB::table('locations')->insert([
            'id' => 23,
            'name' => 'Makueni',
            'type' => 'region',
            'code' => 'KE-23'
        ]);

        DB::table('locations')->insert([
            'id' => 24,
            'name' => 'Mandera',
            'type' => 'region',
            'code' => 'KE-24'
        ]);

        DB::table('locations')->insert([
            'id' => 25,
            'name' => 'Marsabit',
            'type' => 'region',
            'code' => 'KE-25'
        ]);

        DB::table('locations')->insert([
            'id' => 26,
            'name' => 'Meru',
            'type' => 'region',
            'code' => 'KE-26'
        ]);

        DB::table('locations')->insert([
            'id' => 27,
            'name' => 'Migori',
            'type' => 'region',
            'code' => 'KE-27'
        ]);

        DB::table('locations')->insert([
            'id' => 28,
            'name' => 'Mombasa',
            'type' => 'region',
            'code' => 'KE-28'
        ]);

        DB::table('locations')->insert([
            'id' => 29,
            'name' => "Murang'a",
            'type' => 'region',
            'code' => 'KE-29'
        ]);

        DB::table('locations')->insert([
            'id' => 30,
            'name' => 'Nairobi',
            'type' => 'region',
            'code' => 'KE-30'
        ]);

        DB::table('locations')->insert([
            'id' => 31,
            'name' => 'Nakuru',
            'type' => 'region',
            'code' => 'KE-31'
        ]);

        DB::table('locations')->insert([
            'id' => 32,
            'name' => 'Nandi',
            'type' => 'region',
            'code' => 'KE-32'
        ]);

        DB::table('locations')->insert([
            'id' => 33,
            'name' => 'Narok',
            'type' => 'region',
            'code' => 'KE-33'
        ]);

        DB::table('locations')->insert([
            'id' => 34,
            'name' => 'Nyamira',
            'type' => 'region',
            'code' => 'KE-34'
        ]);

        DB::table('locations')->insert([
            'id' => 35,
            'name' => 'Nyandarua',
            'type' => 'region',
            'code' => 'KE-35'
        ]);

        DB::table('locations')->insert([
            'id' => 36,
            'name' => 'Nyeri',
            'type' => 'region',
            'code' => 'KE-36'
        ]);

        DB::table('locations')->insert([
            'id' => 37,
            'name' => 'Samburu',
            'type' => 'region',
            'code' => 'KE-37'
        ]);

        DB::table('locations')->insert([
            'id' => 38,
            'name' => 'Siaya',
            'type' => 'region',
            'code' => 'KE-38'
        ]);

        DB::table('locations')->insert([
            'id' => 39,
            'name' => 'Taita Taveta',
            'type' => 'region',
            'code' => 'KE-39'
        ]);

        DB::table('locations')->insert([
            'id' => 40,
            'name' => 'Tana River',
            'type' => 'region',
            'code' => 'KE-40'
        ]);

        DB::table('locations')->insert([
            'id' => 41,
            'name' => 'Tharaka Nithi',
            'type' => 'region',
            'code' => 'KE-41'
        ]);

        DB::table('locations')->insert([
            'id' => 42,
            'name' => 'Trans Nzoia',
            'type' => 'region',
            'code' => 'KE-42'
        ]);

        DB::table('locations')->insert([
            'id' => 43,
            'name' => 'Turkana',
            'type' => 'region',
            'code' => 'KE-43'
        ]);

        DB::table('locations')->insert([
            'id' => 44,
            'name' => 'Uasin Gishu',
            'type' => 'region',
            'code' => 'KE-44'
        ]);

        DB::table('locations')->insert([
            'id' => 45,
            'name' => 'Vihiga',
            'type' => 'region',
            'code' => 'KE-45'
        ]);

        DB::table('locations')->insert([
            'id' => 46,
            'name' => 'Wajir',
            'type' => 'region',
            'code' => 'KE-46'
        ]);

        DB::table('locations')->insert([
            'id' => 47,
            'name' => 'West Pokot',
            'type' => 'region',
            'code' => 'KE-47'
        ]);


    }
}
