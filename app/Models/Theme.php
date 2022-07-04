<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Theme extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'active','custom'];

    protected static $logAttributes = ['name', 'active','custom'];


    function schema(){
        return $this->hasMany(Theme_schema::class);
    }

    function getActive(){
        return $this->where('active','1')->get()->first();
    }

    function getPrimaryColor(){
        return $this->schema()->where('name','primary_color')->first()->css_rule;
    }

    function getPrimaryHexColor(){
         $color=$this->schema()->where('name','primary_color')->first()->css_rule;
        return $this->hexToRgb($color);
    }

    function getSecondaryColor(){
        return $this->schema()->where('name','secondary_color')->get()->first()->css_rule;
    }

    function getBodyFontSize(){
        return $this->schema()->where('name','body_font_size')->get()->first()->css_rule;
    }

    function getTitleFontSize(){
        return $this->schema()->where('name','title_font_size')->get()->first()->css_rule;
    }

    function getTitleLetterSpacing(){
        return $this->schema()->where('name','title_letter_spacing')->get()->first()->css_rule;
    }

    function getSubtitleFontSize(){
        return $this->schema()->where('name','subtitle_font_size')->get()->first()->css_rule;
    }

    function getSubtitleLetterSpacing(){
        return $this->schema()->where('name','subtitle_letter_spacing')->get()->first()->css_rule;
    }

    function getTitleFontFamily(){
        return $this->schema()->where('name','title_font_family')->get()->first()->css_rule;
    }

    function getSubtitleFontFamily(){
        return $this->schema()->where('name','subtitle_font_family')->get()->first()->css_rule;
    }

    function getBodyFontFamily(){
        return $this->schema()->where('name','body_font_family')->get()->first()->css_rule;
    }

    function getBodyLetterSpacing(){
        return $this->schema()->where('name','body_letter_spacing')->get()->first()->css_rule;
    }

    function getLineHeight(){
        return $this->schema()->where('name','body_line_height')->get()->first()->css_rule;
    }

    function getBodySpacingParagraphs(){
        return $this->schema()->where('name','body_spacing_paragraphs')->get()->first()->css_rule;
    }



    private function hexToRgb($hex, $alpha = false) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ( $alpha ) {
            $rgb['a'] = $alpha;
        }
        return $rgb;
    }

}
