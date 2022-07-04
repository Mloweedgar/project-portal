<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class role_alias extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
