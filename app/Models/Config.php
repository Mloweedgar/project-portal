<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Config extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'value'];

    protected static $logAttributes = ['name', 'value'];

    public function getApiStatusAttribute($value){

        if($this->name == "api" && $this->value == "1"){

            return "Online";

        } else {

            return "Offline";

        }

    }

}
