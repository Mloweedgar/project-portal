<?php

namespace App\Models;

use App\Models\Project\ProjectInformation;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public function projectInformations(){
        return $this->hasMany(ProjectInformation::class);
    }

    public function countProjectInformations(){
        $this->projectInformations()->where('stage_id', $this->id)->count();
    }

    // Left join!
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_information', 'stage_id', 'project_id');
    }
}
