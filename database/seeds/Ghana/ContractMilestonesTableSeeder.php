<?php

namespace Ghana;

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
            'name' => 'Project milestone 1',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Project milestone 2',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Project milestone 3',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);
        DB::table('contract_milestones')->insert([
            'name' => 'Project milestone 4',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. EDITED',
            'milestone_type_id' => 1,
            'project_id' => 1,
            'date' => $date->subWeek(rand(1, 52))->format('Y-m-d H:i:s'),
        ]);

    }
}
