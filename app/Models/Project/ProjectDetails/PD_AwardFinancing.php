<?php

namespace App\Models\Project\ProjectDetails;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_AwardFinancing extends Model
{

    use LogsActivity;

    protected $fillable = ['award_id','name','start_date','end_date','financing_category_id','amount','description','financing_party_id'];

    protected static $logAttributes = ['award_id','name','start_date','end_date','financing_category_id','amount','description','financing_party_id'];

    protected $dates = ['start_date', 'end_date'];

    use Searchable;

    protected $table = "pd_award_financing";

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
