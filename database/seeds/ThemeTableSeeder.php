<?php

use Illuminate\Database\Seeder;

class ThemeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('themes')->insert(['name'=>"default", "active"=>1, "custom"=>0, "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('theme_schemas')->insert($this->schemaFields());
        DB::table('theme_fonts')->insert($this->fonts());

    }

    private function schemaFields(){

        return [
            ["theme_id"=>"1", "name"=>"primary_color","css_key"=>"@primary-color", "css_rule"=>"#00a3dd", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"secondary_color","css_key"=>"@secondary-color", "css_rule"=>"#1eb53a", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"body_font_size","css_key"=>"@main-font-size", "css_rule"=>"14px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"title_font_family","css_key"=>"@title-font-family", "css_rule"=>"'Roboto Slab'", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"title_font_size","css_key"=>"@title-font-size", "css_rule"=>"48px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"title_letter_spacing","css_key"=>"@title-letter-spacing", "css_rule"=>"0px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"subtitle_font_size","css_key"=>"@subtitle-font-size", "css_rule"=>"18px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"subtitle_letter_spacing","css_key"=>"@subtitle-letter-spacing", "css_rule"=>"0px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"body_font_family","css_key"=>"@body-font-family", "css_rule"=>"Roboto", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"body_letter_spacing","css_key"=>"@body-letter-spacing", "css_rule"=>"0px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"body_line_height","css_key"=>"@line-height", "css_rule"=>"20px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ["theme_id"=>"1", "name"=>"body_spacing_paragraphs","css_key"=>"@spacing-paragraphs", "css_rule"=>"20px", "created_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'), "updated_at"=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')],
        ];

    }


    private function fonts(){

        return [
            ['name' => 'PT_Serif', 'file'=> ''],
            ['name' => 'Droid_Serif', 'file'=> ''],
            ['name' => 'Merriweather', 'file'=> ''],
            ['name' => "'Roboto Slab'", 'file'=> ''],
            ['name' => 'Roboto', 'file'=> ''],
            ['name' => 'Oswald', 'file'=> ''],
            ['name' => 'Source_sans_Pro', 'file'=> ''],
            ['name' => 'Lato', 'file'=> ''],
            ['name' => 'Open_sans', 'file'=> ''],
        ];

    }
}
