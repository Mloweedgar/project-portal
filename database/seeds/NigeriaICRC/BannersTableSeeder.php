<?php

namespace NigeriaICRC;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            'id' => 1,
            'name' => 'Lagos to Ibadan Expressway. Reconstrution, Rehabilitation and Expansion Work',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://example.com',
            'active' => 1
        ]);

        DB::table('banners')->insert([
            'id' => 2,
            'name' => 'Development of inland container depot (ICD) in Nnewi, Anambra State',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://example.com',
            'active' => 0
        ]);

        DB::table('banners')->insert([
            'id' => 3,
            'name' => 'Owena multi-purpose dam water supply',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras scelerisque leo purus, non viverra mi ornare in. Etiam fermentum nibh ex, ut euismod massa bibendum nec. Nullam at vestibulum ex. Suspendisse diam leo, hendrerit a nulla sit amet, sollicitudin facilisis elit. Donec in urna in turpis tempor imperdiet dignissim eu sapien. Donec non purus nec nibh lobortis varius at et justo. Nullam dictum libero eget iaculis tempor.',
            'url' => 'http://example.com',
            'active' => 0
        ]);
    }
}
