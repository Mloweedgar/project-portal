<?php

namespace ZanzibarPPP;

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
            'name' => 'Uganda People’s Defence Forces housing accommodation PPP project',
            'description' => 'The project involves the construction of housing accommodation for UPDF (Uganda People’s Defence Forces) personnel, chief’s office block and redevelopment of Acacia Mess through Public Private Partnership (PPP) Arrangements.',
            'url' => 'https://www.infrapppworld.com/project/uganda-people-s-defence-forces-housing-accommodation-ppp-project',
            'active' => 0
        ]);

        DB::table('banners')->insert([
            'id' => 2,
            'name' => 'Justice Law and Order Sector (JLOS) office building on BOT',
            'description' => 'The project involves the provision of approximately 102,000 square meters of office space.',
            'url' => 'https://www.infrapppworld.com/project/justice-law-and-order-sector-jlos-office-building-on-bot',
            'active' => 0
        ]);

        DB::table('banners')->insert([
            'id' => 3,
            'name' => 'Kampala - Jinja Expressway PPP project',
            'description' => 'The project involves the development of a six-lane, 77km limited access toll road between Kampala, the capital of Uganda, and Jinja.',
            'url' => 'https://www.infrapppworld.com/project/kampala-jinja-expressway-ppp-project',
            'active' => 1
        ]);

    }
}
