<?php

namespace App\Models\Project\ProjectDetails;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Procurement extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description','position'];

    protected static $logAttributes = ['project_details_id','name','description','position'];

    use Searchable;

    protected $table = "pd_procurement";

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
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
