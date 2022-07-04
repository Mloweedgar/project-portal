<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Media extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'old_name','extension','mime_type','width','height','section','project','path','position','size','uniqueToken'];

    protected static $logAttributes = ['name', 'old_name','extension','mime_type','width','height','section','project','path','position','size','uniqueToken'];

    public function getMediaPath(){

    }
}
