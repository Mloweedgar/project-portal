<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DeletedUser extends Model
{
    use LogsActivity;

    protected $fillable = ['email','description'];

    protected static $logAttributes = ['email','description'];

    protected static $recordEvents = ['created'];

    protected $table = 'deleted_users';
}
