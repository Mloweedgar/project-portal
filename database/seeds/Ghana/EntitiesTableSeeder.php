<?php

namespace Ghana;

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
            'name' => 'Ministry of Finance of Ghana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ',
            'url' => 'http://www.mofep.gov.gh/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);


        DB::table('entities')->insert([
            'id' => '2',
            'name' => 'Ministry of Energy of Ghana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ',
            'url' => 'http://www.energymin.gov.gh/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '3',
            'name' => 'Ministry of Transport of Ghana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ',
            'url' => 'http:/www.mot.gov.gh/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '4',
            'name' => 'Ministry of Trade and Industry of Ghana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae.',
            'url' => 'https://www.mti.gov.sg/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '5',
            'name' => 'Ministry of Environment, Science, Technology and Innovation of Ghana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ',
            'url' => 'http://mesti.gov.gh/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '6',
            'name' => 'Ministry of Water Resources, Works and Housing of Ghana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum diam non diam egestas consequat. Duis pharetra felis euismod dui dapibus tempor. Vivamus at ipsum id tellus elementum ultricies sed eu tellus. Curabitur eget tellus id enim ullamcorper laoreet in ut risus. Fusce et libero non lacus condimentum consequat dictum sit amet enim. Sed id nisi porttitor, imperdiet nisi quis, egestas tellus. Suspendisse facilisis, urna nec tincidunt ullamcorper, velit odio ultricies sem, vitae scelerisque ligula diam ut urna. Nunc lobortis vulputate tristique. Donec semper leo lacus, nec iaculis enim varius vitae. ',
            'url' => 'http//www.mwrwh.gov.gh/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '7',
            'name' => 'PPP Unit Ghana',
            'description' => 'The Ministry of Finance (MoF) in 2010 established the Public Investment Division (PID) as the Ghana PPP Advisory team to take a lead role over the PPP Programme in Ghana. The Division is led by a Director, comprises four units, two of which play particularly key roles in the PPP agenda: they include (i) the Project Finance and Analysis (PFA) Unit with gate keeping and upstream investment appraisal responsibilities and (ii) the PPP Advisory Unit (PAU) with technical expertise to support the relevant line Ministries, Departments and Agencies (MDAs) in the development and management of prospective PPP transactions that satisfy Government of Ghana public investment priorities.',
            'url' => 'http://www.mofep.gov.gh/divisions/pid',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);


    }
}
