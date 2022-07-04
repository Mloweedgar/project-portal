<?php

namespace Kenya;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            'id' => 1,
            'name' => '2nd Nyali Bridge',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://5.196.68.29/project/1',
            'active' => 1
        ]);

        DB::table('sliders')->insert([
            'id' => 2,
            'name' => 'Lamu Port Development Project',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://5.196.68.29/project/10',
            'active' => 1
        ]);

    }
}
