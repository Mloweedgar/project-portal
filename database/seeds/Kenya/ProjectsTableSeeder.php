<?php

namespace Kenya;

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
            'name' => '2nd Nyali Bridge',
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
            'name' => 'Mombasa - Nairobi Dual Carriageway Toll Road Project',
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
            'name' => 'Nairobi-Thika Highway O&M Toll Road',
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
            'name' => 'Nairobi – Nakuru- Mau Summit Highway',
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
            'name' => 'Phase 1 - Roads 10,000 Annuity Programme',
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
            'name' => 'Mombasa Port Development Project (MPDP)-2nd Container Terminal Phase II & III',
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
            'name' => 'Kisumu Sea Port',
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
            'name' => 'Development of the Shimoni Port',
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
            'name' => 'Conversion of Berth 11 - 14 into container terminals (Port of Mombasa)',
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
            'name' => 'Lamu Port Development Project',
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
            'name' => 'Multi-Storey Terminal at Likoni',
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
