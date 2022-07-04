<?php

namespace App\Models\Project\ProjectDetails;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Tariffs extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description','position','paidBy','value','startDate','endDate'];

    protected static $logAttributes = ['project_details_id','name','description','position','paidBy','value','startDate','endDate'];

    protected $dates = ['startDate', 'endDate'];

    use Searchable;

    protected $table = "pd_tariffs";

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
