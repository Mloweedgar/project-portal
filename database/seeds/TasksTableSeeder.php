<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Sections
         *
         */
        // DB::table('tasks')->insert([
        //     'id' => 1,
        //     'user_id' => 1,
        //     'project_id' => 1,
        //     'section' => 'i',
        //     'position' => 0,
        //     'status' => null,
        //     'reason_declined' => null,
        //     'name' => 'Task 1',
        //     'reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',
        //     'deadline' => '2018-05-02 11:43:10'
        // ]);
        //
        // DB::table('tasks')->insert([
        //     'id' => 2,
        //     'user_id' => 1,
        //     'project_id' => 1,
        //     'section' => 'i',
        //     'position' => 0,
        //     'status' => 0,
        //     'reason_declined' => 'Because Im an undercovered troll.',
        //     'name' => 'Task 1',
        //     'reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',
        //     'deadline' => '2018-05-02 11:43:10'
        // ]);
    }
}
