<?php

namespace Ghana;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Transport - Accra/Western Region -
        DB::table('projects')->insert([
            'id' => 1,
            'name' => 'Takoradi Port Rehabilitation and Expansion',
            'user_id' => 2,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'private' => 0,
        ]);


        // Transport - Accra / Western Region
        DB::table('projects')->insert([
            'id' => 2,
            'name' => 'Accra-Takoradi Highway Dualisation',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Heal - Accra
        DB::table('projects')->insert([
            'id' => 3,
            'name' => 'Korle-Bu Teaching Hospital - Diagnostic Services',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Social - Accra
        DB::table('projects')->insert([
            'id' => 4,
            'name' => 'Modern Pedestrian Foot Bridges',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Water - Accra
        DB::table('projects')->insert([
            'id' => 5,
            'name' => 'Asutsuake Bulk Water Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Social - Accra
        DB::table('projects')->insert([
            'id' => 6,
            'name' => 'Martey-Tsuru Community Development',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Social - Accra
        DB::table('projects')->insert([
            'id' => 7,
            'name' => 'Kantamanto Market Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Social - Accra
        DB::table('projects')->insert([
            'id' => 8,
            'name' => 'Kwasiadwaso Market Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Social - Central
        DB::table('projects')->insert([
            'id' => 9,
            'name' => 'Development of Sports and Residential Facilities',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Social - Accra/Volta
        DB::table('projects')->insert([
            'id' => 10,
            'name' => 'Accra Plains Irrigation Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




        // Transport - Western
        DB::table('projects')->insert([
            'id' => 11,
            'name' => 'Establishment of a New National Airline',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 1,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);




    }
}
