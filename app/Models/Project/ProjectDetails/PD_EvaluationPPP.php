<?php

namespace App\Models\Project\ProjectDetails;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_EvaluationPPP extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description'];

    protected static $logAttributes = ['project_details_id','name','description'];

    use Searchable;

    protected $table = "pd_evaluation";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
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
