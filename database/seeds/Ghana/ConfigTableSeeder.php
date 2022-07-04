<?php

namespace Ghana;

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
        DB::table('configs')->insert(['name'=>"aboutppp", "value"=>"The Ministry of Finance (MoF) in 2010 established the Public Investment Division (PID) as the Ghana PPP Advisory team to take a lead role over the PPP Programme in Ghana. The Division is led by a Director, comprises four units, two of which play particularly key roles in the PPP agenda: they include (i) the Project Finance and Analysis (PFA) Unit with gate keeping and upstream investment appraisal responsibilities and (ii) the PPP Advisory Unit (PAU) with technical expertise to support the relevant line Ministries, Departments and Agencies (MDAs) in the development and management of prospective PPP transactions that satisfy Government of Ghana public investment priorities.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"homepage", "value"=>"http://www.mofep.gov.gh/divisions/pid", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"mail", "value"=>"pid@mofep.gov.gh", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address", "value"=>"Public Investment Division, Ministry of Finance Post Office Box M.40, Accra", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"phone", "value"=>"+233 (0)30 274 7197", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"linkedin", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"facebook", "value"=>"https://www.facebook.com/Ministry-of-Finance-Ghana-177007319050640/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"twitter", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"instagram", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp_title", "value"=>"About Us", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_default", "value"=>"en", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_updated", "value"=>$now, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address_link", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"currency", "value"=>"GHS", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-x", "value"=>"5.5500025", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-y", "value"=>"-0.1979045", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution", "value"=>"Public Investment Division - Ministry of Finance", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution_short", "value"=>"Ministry of Finance", "created_at"=>$now, "updated_at"=>$now]);
        /**
         *  OCID configuration. Unccomment the one that proceeds
         */
        // Ghana
        DB::table('configs')->insert(['name'=>"ocid", "value"=>"ocds-2q8bt1", "created_at"=>$now, "updated_at"=>$now]);
    }
}
