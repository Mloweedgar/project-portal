<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'permission_user', 'user_id', 'permission_id');
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class, 'permission_project', 'project_id', 'permission_id');
    }



}
