<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangFile extends Model
{

    public function fields(){
        return $this->hasMany(LangField::class, 'file_id', 'id');
    }
}
