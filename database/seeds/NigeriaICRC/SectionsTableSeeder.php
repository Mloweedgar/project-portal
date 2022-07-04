<?php

namespace NigeriaICRC;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        /**
         * Sections
         *
         */
        DB::table('sections')->insert([
            'id' => 1,
            'name' => 'Basic project information',
            'code_lang' => 'section_project_basic_information',
            'section_code' => 'i',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sections')->insert([
            'id' => 2,
            'name' => 'Project milestones',
            'code_lang' => 'section_contract_milestones',
            'section_code' => 'cm',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sections')->insert([
            'id' => 3,
            'name' => 'Parties',
            'code_lang' => 'section_parties',
            'section_code' => 'par',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        /*
         * Performance information
         * id 4
         */
        DB::table('sections')->insert([
            'id' => 4,
            'name' => 'Performance information',
            'code_lang' => 'section_perfomance_information',
            'section_code' => 'pi',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        /*
         * Performance information sub-sections
         * Id 4 is used to indicate that the following records belongs to the main section(performance information)
         */
        //id 5
        DB::table('sections')->insert([
            'id' => 5,
            'name' => 'Annual demand levels',
            'code_lang' => 'section_perfomance_information_annual_demands',
            'section_code' => 'dl',
            'description' => '',
            'parent' => 4,
            'active' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 7
        DB::table('sections')->insert([
            'id' => 6,
            'name' => 'Income statements metrics',
            'code_lang' => 'section_perfomance_information_income_statements_metrics',
            'section_code' => 'ism',
            'description' => '',
            'parent' => 4,
            'active' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 6
        DB::table('sections')->insert([
            'id' => 7,
            'name' => 'Other financial metrics',
            'code_lang' => 'section_perfomance_information_other_financial_metrics',
            'section_code' => 'of',
            'description' => '',
            'parent' => 4,
            'active' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 8
        DB::table('sections')->insert([
            'id' => 8,
            'name' => 'Key performance indicators',
            'code_lang' => 'section_perfomance_information_key_indicators',
            'section_code' => 'kpi',
            'description' => '',
            'parent' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 9
        DB::table('sections')->insert([
            'id' => 9,
            'name' => 'Performance failures',
            'code_lang' => 'section_perfomance_information_failures',
            'section_code' => 'pf',
            'description' => '',
            'parent' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 10
        DB::table('sections')->insert([
            'id' => 10,
            'name' => 'Performance assessments',
            'code_lang' => 'section_perfomance_information_assessements',
            'section_code' => 'pa',
            'description' => '',
            'parent' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 11
        DB::table('sections')->insert([
            'id' => 11,
            'name' => 'Gallery',
            'code_lang' => 'section_gallery',
            'section_code' => 'g',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 12
        DB::table('sections')->insert([
            'id' => 12,
            'name' => 'Contract Information',
            'code_lang' => 'section_project_details',
            'section_code' => 'pd',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        /**
         * Sub-sections
         *
         */

        /*
         * Project details sub-sections
         * Id 6 is used to indicate that the following records belongs to the main section(project details)
         */
        //id 13
        DB::table('sections')->insert([
            'id' => 13,
            'name' => 'Redacted PPP Agreement',
            'code_lang' => 'section_project_details_documents',
            'section_code' => 'd',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 14
        DB::table('sections')->insert([
            'id' => 14,
            'name' => 'Announcements',
            'code_lang' => 'section_project_details_announcements',
            'section_code' => 'a',
            'description' => '',
            'parent' => null,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 15
        DB::table('sections')->insert([
            'id' => 15,
            'name' => 'Procurement documents',
            'code_lang' => 'section_procurement',
            'section_code' => 'pri',
            'description' => '',
            'parent' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 16
        DB::table('sections')->insert([
            'id' => 16,
            'name' => 'Risks',
            'code_lang' => 'section_project_details_risks',
            'section_code' => 'ri',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 17
        DB::table('sections')->insert([
            'id' => 17,
            'name' => 'Evaluation of PPP',
            'code_lang' => 'section_project_details_evaulation_ppp',
            'section_code' => 'e',
            'description' => '',
            'parent' => 12,
            'active' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 18
        DB::table('sections')->insert([
            'id' => 18,
            'name' => 'Financial Structure',
            'code_lang' => 'section_project_details_financial_support',
            'section_code' => 'fi',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 19
        DB::table('sections')->insert([
            'id' => 19,
            'name' => 'Government support',
            'code_lang' => 'section_project_details_government_support',
            'section_code' => 'gs',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 20
        DB::table('sections')->insert([
            'id' => 20,
            'name' => 'Tariffs',
            'code_lang' => 'section_project_details_tariffs',
            'section_code' => 't',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 21
        DB::table('sections')->insert([
            'id' => 21,
            'name' => 'Terminal Provisions',
            'code_lang' => 'section_project_details_contract_termination',
            'section_code' => 'ct',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //id 22
        DB::table('sections')->insert([
            'id' => 22,
            'name' => 'Renegotiations',
            'code_lang' => 'section_project_details_renegotiation',
            'section_code' => 'r',
            'description' => '',
            'parent' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

    }
}
