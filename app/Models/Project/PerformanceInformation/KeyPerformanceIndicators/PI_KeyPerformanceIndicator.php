<?php

namespace App\Models\Project\PerformanceInformation\KeyPerformanceIndicators;

use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorKpiType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_KeyPerformanceIndicator extends Model
{

    use LogsActivity;

    protected $fillable = ['year','target','achievement','type_id','pi_key_performance_main_id'];

    protected static $logAttributes = ['year','target','achievement','type_id','pi_key_performance_main_id'];

    protected $table = 'pi_key_performance_indicators';

    public function performance_information(){
        $this->belongsTo(PerformanceInformation::class);
    }

    public function pi_key_performance_main() {
        $this->belongsTo(PI_KeyPerformanceIndicatorMain::class, 'pi_key_performance_main_id');
    }

    public function type(){
        return $this->belongsTo(PI_KeyPerformanceIndicatorKpiType::class, 'type_id');
    }


}
