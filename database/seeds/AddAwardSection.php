<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddAwardSection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
            'name' => 'Award & Financing',
            'code_lang' => 'section_project_details_award',
            'section_code' => 'aw',
            'description' => '',
            'parent' => 12,
            'active' => 0
        ]);
        DB::table('sections')->insert([
            'name' => 'Award & Financing - Financing',
            'code_lang' => 'section_project_details_award_financing',
            'section_code' => 'awf',
            'description' => '',
            'parent' => 12,
            'active' => 1
        ]);
        DB::table('sections')->insert([
            'name' => 'Contract Summary',
            'code_lang' => 'section_project_details_contract_summary',
            'section_code' => 'cs',
            'description' => '',
            'parent' => 12,
            'active' => 1
        ]);
    }
}
