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
        DB::table('configs')->insert(['name'=>"aboutppp", "value"=>"About Zanzibar PPP Node.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"homepage", "value"=>"http://3.8.208.143/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"mail", "value"=>"info@aninver.com", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address", "value"=>"Treasury Square Building, 18 Jakaya Kikwete Road, Dodoma", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"phone", "value"=>"(+255) 26 2963110", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"linkedin", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"facebook", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"twitter", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"instagram", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp_title", "value"=>"About Us", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_default", "value"=>"en", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_updated", "value"=>$now, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address_link", "value"=>"https://goo.gl/maps/EgCZMLY1NYUSLdNr7", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"currency", "value"=>"TZS", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-x", "value"=>"-6.1872165", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-y", "value"=>"35.758735", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution", "value"=>"Tanzania PPP Node", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution_short", "value"=>"ZanzibarPPP", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"password_expiry_days", "value"=>"30", "created_at"=>$now, "updated_at"=>$now]);
        /**
         *  OCID configuration. Unccomment the one that proceeds
         */
        DB::table('configs')->insert(['name'=>"ocid", "value"=>"ocds-aaaaaa", "created_at"=>$now, "updated_at"=>$now]);
    }
}
