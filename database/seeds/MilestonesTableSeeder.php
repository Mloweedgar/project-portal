<?php

use Illuminate\Database\Seeder;

class MilestonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('milestones_types')->insert([
            'id' => '1',
            'name' => 'Actual milestone',
        ]);
        DB::table('milestones_types')->insert([
            'id' => '2',
            'name' => 'Estimated milestone',
        ]);

    }
}
