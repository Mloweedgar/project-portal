<?php

use Illuminate\Database\Seeder;

class GraphTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('graphs')->insert([
            [ 'id' => 1, 'section' => 'sectors', 'graph_type' =>'bar'],
            [ 'id' => 2, 'section' => 'stages',  'graph_type' =>'pie']
        ]);

        DB::table('graph_pos')->insert([
            [ 'id' => 1, 'graph_id' => 1, 'pos_group' => 'Home', 'pos' =>1],
            [ 'id' => 2, 'graph_id' => 2, 'pos_group' => 'Home', 'pos' =>2]
        ]);

    }

}
