<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_PerformanceAssessment extends Model
{

    use LogsActivity;

    protected $fillable = ['performance_information_id','name','description','position'];

    protected static $logAttributes = ['performance_information_id','name','description','position'];

    protected $table = 'pi_performance_assessment';

    public function performance_information(){
        return $this->belongsTo(PerformanceInformation::class);
    }

}
