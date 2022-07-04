<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function project_informations(){
        return $this->belongsToMany(ProjectInformation::class, 'location_project_information', 'project_information_id', 'location_id');
    }
}
