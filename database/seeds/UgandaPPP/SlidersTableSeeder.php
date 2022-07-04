<?php

namespace TanzaniaPPPNode;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            'id' => 1,
            'name' => 'Kampala - Jinja Expressway PPP project',
            'description' => 'The project involves the development of a six-lane, 77km limited access toll road between Kampala, the capital of Uganda, and Jinja.',
            'url' => '/project/1/kampala-jinja-expressway-ppp-project',
            'white' => 0,
            'active' => 1
        ]);

        DB::table('sliders')->insert([
            'id' => 2,
            'name' => 'Uganda People’s Defence Forces housing accommodation PPP project',
            'description' => 'The project involves the construction of housing accommodation for UPDF (Uganda People’s Defence Forces) personnel, chief’s office block and redevelopment of Acacia Mess through Public Private Partnership (PPP) Arrangements.',
            'url' => '/project/3/uganda-peoples-defence-forces-housing-accommodation-ppp-project',
            'white' => 1,
            'active' => 1
        ]);

        DB::table('sliders')->insert([
            'id' => 3,
            'name' => 'Kampala waste-to-energy PPP plant',
            'description' => 'The project will be developed on design, build, finance and operate (DBFO) basis. The concession will be for period of 20 years.',
            'url' => '/project/2/kampala-waste-to-energy-ppp-plant',
            'white' => 1,
            'active' => 1
        ]);

    }
}
