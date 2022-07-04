<?php

namespace ZanzibarPPP;

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
        
        for ($i=1; $i < 10; $i++) {
            $date = Carbon::create(2017, 1, 31, 0);

            DB::table('contract_milestones')->insert([
                'name' => 'Project proposal registered',
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
                'name' => 'Project proposal approved',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Project feasibility study under development',
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
                'name' => 'Request for Prequalification (RPQ)',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);
            DB::table('contract_milestones')->insert([
                'name' => 'Request for Proposals (RFB)',
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
                'name' => 'Execution of project agreement (commercial close)',
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
                'name' => 'Commencement of construction or development',
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
                'name' => 'Contract expiry',
                'description' => $lorem_ipsum_short,
                'milestone_type_id' => 1,
                'project_id' => $i,
                'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
            ]);

        }

    }
}
