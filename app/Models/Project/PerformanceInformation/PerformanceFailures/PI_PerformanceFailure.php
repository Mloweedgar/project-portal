<?php

namespace App\Models\Project\PerformanceInformation\PerformanceFailures;

use App\Models\Project\PerformanceInformation\PerformanceInformation;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_PerformanceFailure extends Model
{

    use LogsActivity;

    protected $fillable = ['performance_information_id','category_failure_id','title','number_events','penalty_contract','penalty_imposed','penalty_paid','position'];

    protected static $logAttributes = ['performance_information_id','category_failure_id','title','number_events','penalty_contract','penalty_imposed','penalty_paid','position'];


    protected $table = 'pi_performance_failures';

    public function performance_information(){
        return $this->belongsTo(PerformanceInformation::class);
    }

    public function category(){
        return $this->belongsTo(PI_PerformanceFailuresCategory::class, 'category_failure_id');
    }

    public static function normalizeToSimpleArray($cms)
    {
        $new = [];

        foreach ($cms->toArray() as $value) {
            $new[] = [
                'title' => $value['title'],
                'category' => $value['category']['name'],
                'number_events' => $value['number_events'],
                'penalty_contract' => $value['penalty_contract'],
                'penalty_imposed' => $value['penalty_imposed'],
                'penalty_paid' => $value['penalty_paid'] == 1 ? trans('general.yes') : trans('general.no')
            ];
        }

        return $new;
    }
}
