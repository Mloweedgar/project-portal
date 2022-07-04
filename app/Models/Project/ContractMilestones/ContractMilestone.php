<?php

namespace App\Models\Project\ContractMilestones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class ContractMilestone extends Model
{

    use LogsActivity;

    protected $fillable = ['project_id','name', 'milestone_type_id', 'date', 'description', 'milestone_category_id'];

    protected static $logAttributes = ['project_id','name', 'milestone_type_id', 'date', 'description', 'milestone_category_id'];

    use Searchable;

    protected $dates = ['date', 'deadline'];

    public function type(){
        return $this->belongsTo(MilestonesType::class, 'milestone_type_id');
    }

    public function category(){
        return $this->belongsTo(MilestonesCategory::class, 'milestone_category_id');
    }

    public function types(){
        return $this->hasMany(MilestonesType::class);
    }

    public function categories(){
        return $this->hasMany(MilestonesCategory::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
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

    public static function transformToApiArray(Collection $collection)
    {
        $transformed = [];

        foreach ($collection->toArray() as $value) {
            $transformed[] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'state' => $value['type']['id'] == 1 ? 'accomplished' : 'future',
                'date' => (new \DateTime($value['date']))->format('Y-m-d'),
                'description' => $value['description']
            ];
        }

        return $transformed;
    }

    public static function normalizeToSimpleArray(Collection $collection)
    {
        $transformed = [];

        foreach ($collection->toArray() as $value) {
            $transformed[] = [
                'name' => $value['name'],
                'state' => $value['type']['id'] == 1 ? 'Accomplished' : 'Future',
                'date' => (new \DateTime($value['date']))->format('Y-m-d'),
                'description' => $value['description']
            ];
        }

        return $transformed;
    }
}
