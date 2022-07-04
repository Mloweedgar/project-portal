<?php

namespace NigeriaICRC;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsEntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entity_project')->insert([
            'id' => 1,
            'entity_id' => 2,
            'project_id' => 2,
            'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 2,
            'entity_id' => 3,
            'project_id' => 1,
            'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 3,
            'entity_id' => 1,
            'project_id' => 3,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 4,
            'entity_id' => 1,
            'project_id' => 4,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 5,
            'entity_id' => 1,
            'project_id' => 5,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 6,
            'entity_id' => 1,
            'project_id' => 6,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 7,
            'entity_id' => 1,
            'project_id' => 7,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 8,
            'entity_id' => 1,
            'project_id' => 8,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 9,
            'entity_id' => 1,
            'project_id' => 9,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 10,
            'entity_id' => 1,
            'project_id' => 10,
			'sponsor' => 1,
            'party' => 1,
        ]);
        DB::table('entity_project')->insert([
            'id' => 11,
            'entity_id' => 1,
            'project_id' => 11,
			'sponsor' => 1,
            'party' => 1,
        ]);
    }
}
