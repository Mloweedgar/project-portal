<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    public function fields(){
        return $this->hasMany(LangFields::class);
    }
}