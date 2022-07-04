<?php

namespace NigeriaICRC;

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
        DB::table('configs')->insert(['name'=>"aboutppp", "value"=>"The ICRC was established to regulate Public Private Partnership (PPP) endeavours of the Federal government aimed at addressing Nigeria’s physical infrastructure deficit which hampers economic development.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"homepage", "value"=>"http://www.icrc.gov.ng/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"mail", "value"=>"info@icrc.gov.ng", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address", "value"=>"Plot 1270, Ayangba Street, Near FCDA Headquarters, Area 11, Garki, Abuja.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"phone", "value"=>"+234 9 4604900", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"linkedin", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"facebook", "value"=>"https://www.facebook.com/icrcnigeria/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"twitter", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"instagram", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp_title", "value"=>"About Us", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_default", "value"=>"en", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_updated", "value"=>$now, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address_link", "value"=>"https://goo.gl/GpTW9v", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"currency", "value"=>"NGN", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-x", "value"=>"9.0431844", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-y", "value"=>"7.501121399999988", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution", "value"=>"Infrastructure Concession Regulatory Commission", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution_short", "value"=>"Infrastructure Concession Regulatory Commission", "created_at"=>$now, "updated_at"=>$now]);
        /**
         *  OCID configuration. Unccomment the one that proceeds
         */
        DB::table('configs')->insert(['name'=>"ocid", "value"=>"ocds-12btn8", "created_at"=>$now, "updated_at"=>$now]);
    }
}
