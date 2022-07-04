<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangValue extends Model
{
    public function lang(){
        return $this->belongsTo(Lang::class);
    }
}
