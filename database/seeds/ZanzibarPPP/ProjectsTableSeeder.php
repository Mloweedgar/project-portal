<?php

namespace ZanzibarPPP;

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
            'name' => 'Kampala - Jinja Expressway PPP project',
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
            'name' => 'Kampala waste-to-energy PPP plant',
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
            'name' => 'Uganda People’s Defence Forces housing accommodation PPP project',
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
            'name' => 'Justice Law and Order Sector (JLOS) office building on BOT',
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
            'name' => 'National Data Centre and Disaster Recovery Site PPP project',
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
            'name' => 'IT Parks PPP project',
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
            'name' => 'Makerere University PPP project',
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
            'name' => 'Uganda People’s Defence Forces (UPDF) housing PPP project',
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
            'name' => 'Public Key Infrastructure PPP project',
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
