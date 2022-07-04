<?php

namespace TanzaniaPPPNode;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->insert([
            'id' => '1',
            'name' => 'Uganda National Roads Authority (UNRA)',
            'description' => 'The Uganda National Roads Authority (UNRA) was established by the National Authority Act, No. 15 of 2006. UNRA became operational on 1st July 2008. The mandate of UNRA is to develop and maintain the national roads network, advise Government on general roads policy and contribute to addressing of transport concerns.',
            'url' => 'https://www.unra.go.ug/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);


        DB::table('entities')->insert([
            'id' => '2',
            'name' => 'Ministry of Defence',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ',
            'url' => 'http://www.defence.go.ug/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '3',
            'name' => 'Ministry of Works and Transport',
            'description' => 'On behalf of the Government of Uganda, we engage in monitoring and provisioning of transport infrastructure support functions, regulatory functions and research activities related to roads, rail, water or air transport & other engineering works.',
            'url' => 'https://www.works.go.ug/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '4',
            'name' => 'Uganda Wildlife Authority',
            'description' => 'Uganda Wildlife Authority (UWA) is a semi-autonomous government agency that conserves and manages Uganda’s wildlife for the people of Uganda and the whole world.',
            'url' => 'http://www.ugandawildlife.org/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '5',
            'name' => 'Mbale District Local Government',
            'description' => 'Mbale District is a district in Eastern Uganda. It is named after the largest city in the district, Mbale, which also serves as the main administrative and commercial center in the sub-region.',
            'url' => 'https://www.mbale.go.ug/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '6',
            'name' => 'Uganda Registration Services Bureau',
            'description' => 'The Uganda Registration Services Bureau (URSB) is a semi-autonomous government agency, established by Act of Parliament in 1998 in Uganda. URSB is responsible for civil registrations (including marriages and divorces but not including births, adoptions, or deaths), business registrations (setups and liquidations), registration of patents and intellectual property rights, and any other registrations required by law.',
            'url' => 'https://ursb.go.ug/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);


    }
}
