<?php

namespace App\Models\Project\ProjectDetails;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Financial extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description','position','financial_category_id'];

    protected static $logAttributes = ['project_details_id','name','description','position','financial_category_id'];


    use Searchable;

    protected $table = "pd_financial";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }

    public function category(){
        return $this->belongsTo(PD_FinancialCategory::class, 'financial_category_id');
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
