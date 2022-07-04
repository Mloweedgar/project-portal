<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    public function users(){
        $this->hasMany(User::class);
    }
}
