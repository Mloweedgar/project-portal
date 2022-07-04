<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Theme_schema extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'css_key','css_rule','theme_id'];

    protected static $logAttributes = ['name', 'css_key','css_rule','theme_id'];

    protected static $recordEvents = ['updated'];


    function Theme(){
        return $this->belongsTo(Theme::class);
    }
}
