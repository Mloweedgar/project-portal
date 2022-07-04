<?php

namespace Ghana;

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
            'name' => 'Takoradi Port Rehabilitation and Expansion',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://35.176.31.109/project/1',
            'active' => 1
        ]);

        DB::table('sliders')->insert([
            'id' => 2,
            'name' => 'Establishment of a New National Airline',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://35.176.31.109/project/3',
            'active' => 1
        ]);

        DB::table('sliders')->insert([
            'id' => 3,
            'name' => 'Accra Plains Irrigation Project',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://35.176.31.109/project/2',
            'active' => 1
        ]);

    }
}
