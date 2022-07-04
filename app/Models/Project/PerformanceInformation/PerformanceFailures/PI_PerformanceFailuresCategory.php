<?php

namespace App\Models\Project\PerformanceInformation\PerformanceFailures;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_PerformanceFailuresCategory extends Model
{

    use LogsActivity;

    protected static $logAttributes = ['name'];

    protected $table = 'pi_performance_failures_category';

    protected $fillable = ['name'];
    public function performance_information(){
        $this->belongsTo(PerformanceInformation::class);
    }

    public function category(){
        $this->belongsTo(CategoryFailures::class);
    }
}
