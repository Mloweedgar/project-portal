<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'alias','description','default'];

    protected static $logAttributes = ['name', 'alias','description','default'];


    /**
     * The roles for this model are:
     * id   role
     * ----------------------
     * 1    admin
     * 2
     */
    /*protected $table = 'roles';*/

    public function Users(){
        return $this->hasMany(User::class);
    }

    public function aliases(){
        return $this->hasMany(Alias::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permissions::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
