<?php

namespace TanzaniaPPPNode;

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
        DB::table('media')->insert(['name'=>"2", "old_name"=>"2", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "s", "position" => 2, "path" => "/img/sliders/2.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"3", "old_name"=>"3", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "s", "position" => 3, "path" => "/img/sliders/3.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);

        // Entities media
        DB::table('media')->insert(['name'=>"Unra-Logo", "old_name"=>"Unra-Logo.jpg", "extension"=>"jpg", "mime_type"=>"image/jpeg", "section" => "par", "position" => 1, "path" => "/img/parties/Unra-Logo.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"Uganda_People's_Defence_Force_emblem.png", "old_name"=>"Uganda_People's_Defence_Force_emblem.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 2, "path" => "/img/parties/Uganda_People's_Defence_Force_emblem.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"Ministry-of-Works-Logo.jpg", "old_name"=>"Ministry-of-Works-Logo.jpg", "extension"=>"jpg", "mime_type"=>"image/jpeg", "section" => "par", "position" => 3, "path" => "/img/parties/Ministry-of-Works-Logo.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"180px-Uganda_Wildlife_Authority_Logo.jpg", "old_name"=>"180px-Uganda_Wildlife_Authority_Logo.jpg", "extension"=>"jpeg", "mime_type"=>"image/jpeg", "section" => "par", "position" => 4, "path" => "/img/parties/180px-Uganda_Wildlife_Authority_Logo.jpg", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"logo_0", "old_name"=>"logo_0.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 5, "path" => "/img/parties/logo_0.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('media')->insert(['name'=>"ursb", "old_name"=>"ursb.png", "extension"=>"png", "mime_type"=>"image/png", "section" => "par", "position" => 6, "path" => "/img/parties/ursb.png", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);

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

        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (30, 'd45c88c0-0d7e-4f36-a801-68eee538a319', 'Kampala-Jinja-Espressway-PPP-project.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 1, '/vault/1/g/1/Kampala-Jinja-Espressway-PPP-project-d45c88c0-0d7e-4f36-a801-68eee538a319.jpeg', 1, 362963, 'g8orba688mfsobnyurwu9m', 0, '2019-02-21 17:41:24', '2019-02-21 17:41:24')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (31, 'b168d517-9fb1-4d4b-9802-42c6d2fed70f', 'kampala-waste-to-energy-ppp-plant.JPG', 'jpeg', 'image/jpeg', null, null, 'g', 2, '/vault/2/g/1/kampala-waste-to-energy-ppp-plant-b168d517-9fb1-4d4b-9802-42c6d2fed70f.jpeg', 1, 422835, 'g1oevwy03i2evhwi4tc8n', 0, '2019-02-21 17:41:24', '2019-02-21 17:41:24')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (32, '43757aa6-0a98-4c22-99c9-581200c7a99a', 'Uganda-people-defence-forces-housing-accommodation-ppp-project.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 3, '/vault/3/g/1/Uganda-people-defence-forces-housing-accommodation-ppp-project-43757aa6-0a98-4c22-99c9-581200c7a99a.jpeg', 1, 93148, 'j527wgm5legp2m8q69kjr', 0, '2019-02-21 17:41:57', '2019-02-21 17:41:57')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (33, '54ae7ac3-1428-45ac-84cd-b9ac8d0d86ac', 'jlos-office-building-on-bot.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 4, '/vault/4/g/1/jlos-office-building-on-bot-54ae7ac3-1428-45ac-84cd-b9ac8d0d86ac.jpeg', 1, 240959, '048nzo4p46gc6fiuegxqzwu', 0, '2019-02-21 17:42:13', '2019-02-21 17:42:13')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (34, 'be4990a3-f447-42f1-93cd-3fd293d57d37', 'national-data-centre-and-disaster-recovery-site-ppp-project.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 5, '/vault/5/g/1/national-data-centre-and-disaster-recovery-site-ppp-project-be4990a3-f447-42f1-93cd-3fd293d57d37.jpeg', 1, 373611, '7720fji1joal4ghdddlbsh', 0, '2019-02-21 17:42:16', '2019-02-21 17:42:16')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (35, '7b59e8bf-d1af-46ac-a126-3f12c70d84e4', 'it-parks-ppp-project.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 6, '/vault/6/g/1/it-parks-ppp-project-7b59e8bf-d1af-46ac-a126-3f12c70d84e4.jpeg', 1, 272028, 'q2eo8jbz03ffhil3l2yd', 0, '2019-02-21 17:42:27', '2019-02-21 17:42:27')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (36, '8b07e972-2083-4e79-aa38-820277751cad', 'makerere-university-ppp-project.JPG', 'jpeg', 'image/jpeg', null, null, 'g', 7, '/vault/7/g/1/makerere-university-ppp-project-8b07e972-2083-4e79-aa38-820277751cad.jpeg', 1, 503681, 'fl5q5ddti3o8ydoys2vndd', 0, '2019-02-21 17:42:30', '2019-02-21 17:42:30')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (37, '50073418-ed7a-410d-accb-a6b272d55ac5', 'Uganda-people-defence-forces-updf-housing-ppp-project.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 8, '/vault/8/g/1/Uganda-people-defence-forces-updf-housing-ppp-project-50073418-ed7a-410d-accb-a6b272d55ac5.jpeg', 1, 349773, 'k510isphuafpl19ag39en', 0, '2019-02-21 17:42:43', '2019-02-21 17:42:43')");
        DB::statement("INSERT INTO media (id, name, old_name, extension, mime_type, width, height, section, project, path, position, size, uniqueToken, to_delete, created_at, updated_at) VALUES (38, 'c06a4d5d-3f18-4949-a8c7-34f58df33cd5', 'Public-key-infrastructure-ppp-project.jpg', 'jpeg', 'image/jpeg', null, null, 'g', 9, '/vault/9/g/1/Public-key-infrastructure-ppp-project-c06a4d5d-3f18-4949-a8c7-34f58df33cd5.jpeg', 1, 392421, 'f20vh11797sqfxm1h4s7v', 0, '2019-02-21 17:42:44', '2019-02-21 17:42:44')");

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
