<?php

namespace NigeriaNSIA;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $now=\Carbon\Carbon::now()->format('Y-m-d H:i:s');
        DB::table('configs')->insert(['name'=>"api", "value"=>false, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp", "value"=>"The Nigeria Sovereign Investment Authority is a Nigerian establishment which manages the Nigeria sovereign wealth fund, into which the surplus income produced from Nigeria's excess oil reserves is deposited.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"homepage", "value"=>"http://nsia.com.ng/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"mail", "value"=>"webmaster@nsia.com.ng", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address", "value"=>"The Clan Place, 4th floor, Plot 1386A, Tigris Crescent Maitama, Abuja, Nigeria", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"phone", "value"=>"+234 (0)9 461 0400", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"linkedin", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"facebook", "value"=>"https://www.facebook.com/nsia.com.ng/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"twitter", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"instagram", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp_title", "value"=>"About Us", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_default", "value"=>"en", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_updated", "value"=>$now, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address_link", "value"=>"https://goo.gl/maps/HG9FimHPLS62", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"currency", "value"=>"NGN", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-x", "value"=>"9.082108", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-y", "value"=>"7.492838", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution", "value"=>"Nigeria Sovereign Investment Authority", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution_short", "value"=>"NSIA", "created_at"=>$now, "updated_at"=>$now]);
        /**
         *  OCID configuration. Unccomment the one that proceeds
         */
        // NSIA
        DB::table('configs')->insert(['name'=>"ocid", "value"=>"ocds-sgrrpz", "created_at"=>$now, "updated_at"=>$now]);
    }
}
