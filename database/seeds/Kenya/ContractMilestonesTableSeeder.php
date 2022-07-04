<?php

namespace Kenya;

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
        $date = Carbon::create(2017, 1, 31, 0);

        DB::table('contract_milestones')->insert([
            'name' => 'Project proposal received',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Project proposal screened',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Enters national priority list',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Feasibility study starts',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Feasibility study approved',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'RFQ',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'RFP',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Award',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Commercial close',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Financial close',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Construction started',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Construction completed',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Commissioning',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Contract expiry',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);

    }
}
