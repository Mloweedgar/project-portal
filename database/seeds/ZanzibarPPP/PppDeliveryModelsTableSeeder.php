<?php

namespace ZanzibarPPP;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PppDeliveryModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Design Build Finance Operate Transfer (DBFOT)'
        ]);
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Design Build Finance Operate Maintain (DBFOM)'
        ]);
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Design Build Finance (DBF)'
        ]);
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Design build Finance Operate (DBFO)'
        ]);
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Design Build Finance Maintain (DBFM)'
        ]);
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Build Finance Operate Maintain (BFOM)'
        ]);
        DB::table('ppp_delivery_models')->insert([
            'name' => 'Operation & Maintenance (O&M)'
        ]);
    }
}
