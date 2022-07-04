<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class NavMenuLink extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'link'];

    protected static $logAttributes = ['name', 'link'];

}
