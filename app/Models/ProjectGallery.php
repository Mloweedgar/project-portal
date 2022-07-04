<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    public function project(){
        $this->belongsTo(Project::class);
    }
}
