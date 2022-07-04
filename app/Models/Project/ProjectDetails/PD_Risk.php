<?php

namespace App\Models\Project\ProjectDetails;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Risk extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','risk_allocation_id','name','description','mitigation','position','risk_category_id'];

    protected static $logAttributes = ['project_details_id','risk_allocation_id','name','description','mitigation','position','risk_category_id'];

    use Searchable;

    protected $table = "pd_risks";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }

    public function allocation(){
        return $this->belongsTo(PD_RiskAllocation::class, 'risk_allocation_id');
    }

    public function category(){
        return $this->belongsTo(PD_RiskCategory::class, 'risk_category_id');
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
            'description' => $this->description,
            'mitigation' => $this->mitigation
        ];
    }


    public static function normalizeToSimpleArray($risks)
    {
        $new = [];

        foreach ($risks->toArray() as $value) {
            $new[] = [
                'name' => $value['name'],
                'description' => $value['description'],
                'allocation' => $value['allocation']['name'],
                'date' => $value['mitigation'],
            ];
        }

        return $new;
    }
}
