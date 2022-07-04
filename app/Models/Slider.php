<?php

namespace App\Models;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Slider extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'description','url','white','active'];

    protected static $logAttributes = ['name', 'description','url','white','active'];


    public function project(){
        return $this->belongsTo(Project::class);
    }
}
