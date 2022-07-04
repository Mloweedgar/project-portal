<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LangField extends Model
{
    public function files(){
        return $this->belongsTo(LangFile::class, 'file_id', 'id');
    }

    public function lang(){
        return $this->belongsTo(Lang::class, 'lang_id', 'id');
    }

    public function childrens(){
        return $this->hasMany(LangField::class, 'parent_id', 'id')->with('childrens');

    }

    public function parent(){
        return $this->hasMany(LangField::class, 'id', 'parent_id')->with('parent');
    }


    /**
     * Returns the list of all parent fields
     *
     * @param
     * @return  \App\Models\LangField
     */

    public static function getParentFields(){
        return self::where('parent_id', 0);
    }

    public function hasChildrens(){
        return $this->childrens()->count() > 0;
    }
}
