<?php

namespace App\Models\Project\PerformanceInformation\OtherFinancialMetrics;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_OtherFinancialMetricAnnual extends Model
{

    use LogsActivity;

    protected $fillable = ['pi_other_main_id','type_id','value','year'];

    protected static $logAttributes = ['pi_other_main_id','type_id','value','year'];

    protected $table = 'pi_other_financial_metrics_annual';

}
