<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'id' => 1,
            'role_id' => '1',
            'name' => 'admin',
            'email' => 'admin@admin.com',
            // 'email' => 'transparency-admin@trashcanmail.com',
            'password' => bcrypt('123456'),
            'entity_id' => '1',
            'prefix_id' => '199',
            'telephone' => '612345678',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);



         DB::table('users')->insert([
             'id' => 2,
             'role_id' => 2,
             'name' => 'View only 1',
             'email' => 'transparency-viewer1@trashcanmail.com',
             'password' => bcrypt('123456'),
             'entity_id' => '1',
             'telephone' => '612345678',
             'prefix_id' => '150',
             'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         ]);




      DB::table('users')->insert([
          'id' => 3,
          'role_id' => 2,
          'name' => 'View only 2',
          'email' => 'transparency-viewer2@trashcanmail.com',
          'password' => bcrypt('123456'),
          'entity_id' => '1',
          'telephone' => '612345678',
          'prefix_id' => '150',
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);


        DB::table('users')->insert([
            'id' => 4,
            'role_id' => 3,
            'name' => 'Data Entry - Generic',
            'email' => 'transparency-dataentry@trashcanmail.com',
            'password' => bcrypt('123456'),
            'entity_id' => '1',
            'telephone' => '612345678',
            'prefix_id' => '199',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('users')->insert([
            'id' => 5,
            'role_id' => 4,
            'name' => 'Data Entry - Project Coordinator',
            'email' => 'transparency-projectcoordinator@trashcanmail.com',
            'password' => bcrypt('123456'),
            'entity_id' => '1',
            'telephone' => '612345678',
            'prefix_id' => '199',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('users')->insert([
            'id' => 6,
            'role_id' => 5,
            'name' => 'IT user',
            'email' => 'transparency-it@trashcanmail.com',
            'password' => bcrypt('123456'),
            'entity_id' => '1',
            'telephone' => '612345678',
            'prefix_id' => '199',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'role_id' => 6,
            'name' => 'Internal Auditor',
            'email' => 'transparency-auditor@trashcanmail.com',
            'password' => bcrypt('123456'),
            'entity_id' => '1',
            'telephone' => '612345478',
            'prefix_id' => '199',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


    }
}
