<?php

namespace App\Models\Project\PerformanceInformation\OtherFinancialMetrics;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_OtherFinancialMetricTimeless extends Model
{

    use LogsActivity;

    protected $fillable = ['pi_other_main_id','type_id','value'];

    protected static $logAttributes = ['pi_other_main_id','type_id','value'];

    protected $table = 'pi_other_financial_metrics_timeless';

    public function type(){
        return $this->belongsTo(PI_OtherFinancialMetricTimelessTypes::class, 'type_id');
    }

}
