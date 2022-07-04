<?php

namespace Kenya;

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
        DB::table('configs')->insert(['name'=>"aboutppp", "value"=>"The PPP Unit is a Specialized Unit within the National Treasury established under Section 8 of the PPP Act 2013. The PPPU serves as the secretariat to the PPP Committee and is responsible for the systematic coordination of all the PPP projects review and approval process, geered towards promoting the flow of bankable, viable and sustainable projects that further the National Policy on PPP. It is the specific responsibility of the PPP Unit to assist each contracting authority to identify, select, appraise, approve, negotiate and monitor PPP projects throughout their life cycle.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"homepage", "value"=>"http://www.pppunit.go.ke/", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"mail", "value"=>"info@pppunit.go.ke", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address", "value"=>"Public Private Partnership (PPP) Unit, National Treasury P.O BOX 30007 - 00100, Nairobi, Kenya.", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"phone", "value"=>"+254 20 2252299", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"linkedin", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"facebook", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"twitter", "value"=>"https://twitter.com/pppunitke", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"instagram", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"aboutppp_title", "value"=>"About Us", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_default", "value"=>"en", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"lang_updated", "value"=>$now, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"address_link", "value"=>null, "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"currency", "value"=>"KSh", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-x", "value"=>"-1.270676", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"coord-y", "value"=>"36.824320", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution", "value"=>"Public Private Partnership Unit - National Treasury of the Government of Kenya", "created_at"=>$now, "updated_at"=>$now]);
        DB::table('configs')->insert(['name'=>"institution_short", "value"=>"National Treasury", "created_at"=>$now, "updated_at"=>$now]);

        /**
         *  OCID configuration. Unccomment the one that proceeds
         */
        // Kenya
        DB::table('configs')->insert(['name'=>"ocid", "value"=>"ocds-b17p2m", "created_at"=>$now, "updated_at"=>$now]);
    }
}
