<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Banner extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'description','url','active'];

    protected static $logAttributes = ['name', 'description','url','active'];
}
