<?php

namespace NigeriaNSIA;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ContractMilestonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lorem_ipsum_short = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

        
        for ($i=1; $i < 13; $i++) {
            $date = Carbon::create(2017, 1, 31, 0);

            DB::table('contract_milestones')->insert([
                'name' => 'Project proposal received',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Project proposal screened',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Project proposal enters list of published projects pipeline',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Transaction Advisors appointed',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Project feasibility study approved',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'OBC compliance certificate issued',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'FEC approval for OBC',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'EOI',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'RFP',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Award',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'FBC compliance certificate issued',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'FEC approval for FBC',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Commercial close',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Financial close',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Beginning of construction or development',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Completion of construction or development',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Commissioning of project',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Expiry of contract',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);

        }

    }
}
