<?php

namespace App\Models;
use App\Models\Project\Project;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Entity extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'name_representative','address','tel','fax','email','description','facebook','twitter','instagram','url'];

    protected static $logAttributes = ['name', 'name_representative','address','tel','fax','email','description','facebook','twitter','instagram','url'];


    use Searchable;

    public function projects(){
        return $this->belongsToMany(Project::class, 'entity_project', 'entity_id', 'project_id');
    }

    public function hasProjects(){
        return $this->projects()->count()>0;
    }

    /**
     * FULLTEXT fields for scout searching
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

}
