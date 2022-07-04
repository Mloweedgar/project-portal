<?php

namespace TanzaniaPPPNode;

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
        DB::table('configs')->insert(['name'=>"aboutppp", "value"=>"The PPPU is an institution established by an Act of Parliament within the Ministry of Finance, Planning and Economic Development (MOFPED) of Uganda. The Unit has existed since 2015 and its major role is to serve as the secretariat and technical arm of the PPP Committee.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"homepage", "value"=>"https://pppunit.go.ug/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"mail", "value"=>"info@pppunit.go.ug", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address", "value"=>"Rwenzori Towers, Ground Floor, Wing A, Plot 4B & 6, Nakasero Road, Kampala, Uganda", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"phone", "value"=>"(+256) 417 104200", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"linkedin", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"facebook", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"twitter", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"instagram", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp_title", "value"=>"About Us", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_default", "value"=>"en", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_updated", "value"=>$now, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address_link", "value"=>"https://goo.gl/maps/A3mwtxby71D2", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"currency", "value"=>"UGX", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-x", "value"=>"0.317571", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-y", "value"=>"32.579880", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution", "value"=>"Uganda PPP Unit", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution_short", "value"=>"TanzaniaPPPNode", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"password_expiry_days", "value"=>"30", "created_at"=>$now, "updated_at"=>$now]);
        /**
         *  OCID configuration. Unccomment the one that proceeds
         */
        DB::table('configs')->insert(['name'=>"ocid", "value"=>"ocds-aaaaaa", "created_at"=>$now, "updated_at"=>$now]);
    }
}
