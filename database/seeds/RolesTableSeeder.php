<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => '1',
            'name' => 'role_admin',
            'alias' => 'Administrator',
            'description' => 'The main role for the application',
            'default' => true,
        ]);
        DB::table('roles')->insert([
            'id' => '2',
            'name' => 'role_viewer',
            'alias' => 'View only',
            'description' => 'Another role',
            'default' => true,

        ]);
        DB::table('roles')->insert([
            'id' => '3',
            'name' => 'role_data_entry_generic',
            'alias' => 'Data Entry',
            'description' => '.....',
            'default' => true,

        ]);
        DB::table('roles')->insert([
            'id' => '4',
            'name' => 'role_data_entry_project_coordinator',
            'alias' => 'Project Officer',
            'description' => '......',
            'default' => true,

        ]);

        DB::table('roles')->insert([
            'id' => '5',
            'name' => 'role_it',
            'alias' => 'IT user',
            'description' => '......',
            'default' => true,
        ]);

        DB::table('roles')->insert([
            'id' => '6',
            'name' => 'role_auditor',
            'alias' => 'Internal Auditor',
            'description' => '......',
            'default' => true,
        ]);

    }
}