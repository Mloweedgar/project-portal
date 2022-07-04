<?php

namespace NigeriaNSIA;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resourcesPath = realpath(__DIR__.DIRECTORY_SEPARATOR.'resources').DIRECTORY_SEPARATOR;

        $resourcesImg = $resourcesPath.'img'.DIRECTORY_SEPARATOR;
        $publicImg = public_path('img'.DIRECTORY_SEPARATOR);
        // $logo = 'logo.png';
        $this->recurse_copy($resourcesImg, $publicImg);

        // Langs
        $langSeeder = $resourcesPath.'lang'.DIRECTORY_SEPARATOR;
        $langLocal = resource_path().DIRECTORY_SEPARATOR.'lang';
        $this->recurse_copy($langSeeder, $langLocal);

        // App
        $appSeeder = $resourcesPath.'app';
        $appLocal = app_path();
        $this->recurse_copy($appSeeder, $appLocal);

        // Views
        $viewsSeeder = $resourcesPath.'views';
        $viewsLocal = resource_path().DIRECTORY_SEPARATOR.'views';
        $this->recurse_copy($viewsSeeder, $viewsLocal);

        // Storage
        $storageSeeder = $resourcesPath.'storage';
        $storageLocal = storage_path().DIRECTORY_SEPARATOR;
        $this->recurse_copy($storageSeeder, $storageLocal);

        // Logo
        DB::table('media')->insert(['name'=>"logo", "old_name"=>"logo", "extension"=>"png", "mime_type"=>"image/png", "width" => "316px", "height"=>"65px", "section" => "lg", "path" => "/img/logo.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);

        // Sliders
        DB::table('media')->insert(['name'=>"1", "old_name"=>"1", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "s", "position" => 1, "path" => "/img/sliders/1.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);

        // Entities media
        DB::table('media')->insert(['name'=>"SealNigerianPresident", "old_name"=>"SealNigerianPresident.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 1, "path" => "/img/parties/1.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"fcda", "old_name"=>"fcda.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 2, "path" => "/img/parties/2.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"fmrw", "old_name"=>"waterresources.jpg", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 3, "path" => "/img/parties/3.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"fma", "old_name"=>"fma.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "par", "position" => 4, "path" => "/img/parties/4.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"fmot", "old_name"=>"fmot.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 5, "path" => "/img/parties/5.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"npa", "old_name"=>"npa.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "par", "position" => 6, "path" => "/img/parties/6.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"nsia", "old_name"=>"nsia.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 7, "path" => "/img/parties/7.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);


        // Banners
        DB::table('media')->insert(['name'=>"banner1", "old_name"=>"1.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "b", "position" => 1, "path" => "/img/banners/1.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"banner2", "old_name"=>"2.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "b", "position" => 2, "path" => "/img/banners/2.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"banner3", "old_name"=>"3.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "b", "position" => 3, "path" => "/img/banners/3.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);

        // Default Sliders

        DB::table('media')->insert(['name'=>"1.jpg", "old_name"=>"1.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/1.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"2.jpg", "old_name"=>"2.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/2.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"3.jpg", "old_name"=>"3.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/3.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"4.jpg", "old_name"=>"4.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/4.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"5.jpg", "old_name"=>"5.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/5.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"6.jpg", "old_name"=>"6.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/6.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"7.jpg", "old_name"=>"7.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/7.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"8.jpg", "old_name"=>"8.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/8.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"9.jpg", "old_name"=>"9.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/9.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"10.jpg", "old_name"=>"10.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/10.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"11.jpg", "old_name"=>"11.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/11.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"12.jpg", "old_name"=>"12.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/12.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"13.jpg", "old_name"=>"13.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/13.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"14.jpg", "old_name"=>"14.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/14.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"15.jpg", "old_name"=>"15.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/15.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"16.jpg", "old_name"=>"16.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "sample-sl", "position" => 0, "path" => "/img/samples/slider/16.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);

    }

    protected function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
