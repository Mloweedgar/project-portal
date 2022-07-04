<?php

namespace App\Models;


use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Section extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'code_lang','section_code','description','parent','active'];

    protected static $logAttributes = ['name', 'code_lang','section_code','description','parent','active'];

    public function newsletters(){
        return $this->hasMany(Newsletter::class);
    }

    public function permissions(){
        return $this->hasMany(Permissions::class);
    }

    public function usersPermissions(){
        return $this->belongsToMany('App\User', 'permission_user_section', 'section_id', 'user_id');
    }

}
