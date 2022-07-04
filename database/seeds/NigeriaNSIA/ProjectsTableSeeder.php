<?php

namespace NigeriaNSIA;

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
            'name' => 'Lagos to Ibadan Expressway',
            'user_id' => 2,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Concession and leasing of grain storage facilities',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Ibom Deep Seaport Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Kirikiri Port Lighter Terminal I & II',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Development of Inland Container Depot (ICD) in Onitsha',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'PPP High Voltage Transmission For TCN',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Bakalori Irrigation Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Peremabiri Irrigation and Land reclamation',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Reconstruction, Rehabilitation and Expansion Of Lagos- Ibadan Dual Carriageway',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Abuja-Kaduna- Kano Dual Carriage way',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'name' => 'Ibom Deepsea Port',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
            'id' => 12,
            'name' => '2nd Niger Bridge',
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

        DB::table('projects')->insert([
            'id' => 13,
            'name' => 'NSIA-PPP Post-procurement Project',
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

        DB::table('projects')->insert([
            'id' => 14,
            'name' => 'NSIA-to-Private Post-procurement Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
            'performance_information_private' => 0,
            'gallery_active' => 1,
            'gallery_private' => 0,
            'active' => 1,
            'private' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('projects')->insert([
            'id' => 15,
            'name' => 'NSIA-to-Public Post-procurement Project',
            'user_id' => 1,
            'project_information_active' => 1,
            'project_information_private' => 0,
            'contract_milestones_active' => 1,
            'contract_milestones_private' => 0,
            'parties_active' => 1,
            'parties_private' => 0,
            'project_details_active' => 1,
            'project_details_private' => 0,
            'performance_information_active' => 0,
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
