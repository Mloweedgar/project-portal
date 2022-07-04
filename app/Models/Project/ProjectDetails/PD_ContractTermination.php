<?php

namespace App\Models\Project\ProjectDetails;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_ContractTermination extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','party_type','name','description','termination_payment','position'];

    protected static $logAttributes = ['project_details_id','party_type','name','description','termination_payment','position'];

    use Searchable;

    protected $table = "pd_contract_termination";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }

    public function entity(){
        return $this->belongsTo(Entity::class);
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
            'termination_payment' => $this->termination_payment
        ];
    }


    public static function normalizeToSimpleArray($cms)
    {
        $new = [];

        foreach ($cms->toArray() as $value) {
            $new[] = [
                'party' => $value['party_type'] == 'operator' ? trans('project/project-details/contract-termination.party_operator') : trans('project/project-details/contract-termination.party_authority'),
                'name' => $value['name'],
                'description' => $value['description'],
                'termination_payment' => $value['termination_payment']
            ];
        }

        return $new;
    }

}
