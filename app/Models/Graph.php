<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    public function pos(){
        return $this->hasOne(GraphPos::class);
    }
}
