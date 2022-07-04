<?php

namespace App\Models;

use App\Models\Project\ProjectInformation;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class PPPDeliveryModel extends Model
{
    protected $table = 'ppp_delivery_models';
    /*public $timestamps = true;
    protected $fillable = ['name'];*/
    public function projectInformations(){
        return $this->hasMany(ProjectInformation::class);
    }

    public function countProjectInformations(){
        $this->projectInformations()->where('ppp_delivery_model_id', $this->id)->count();
    }

    // Left join!
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_information', 'ppp_delivery_model_id', 'project_id');
    }

}
