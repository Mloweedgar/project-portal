<?php

namespace App\Models\Project\ProjectDetails;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_ContractSummary extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description','position'];

    protected static $logAttributes = ['project_details_id','name','description','position'];

    use Searchable;

    protected $table = "pd_contract_summary";

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
