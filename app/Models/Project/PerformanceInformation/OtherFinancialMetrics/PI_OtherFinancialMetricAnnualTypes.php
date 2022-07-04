<?php

namespace App\Models\Project\PerformanceInformation\OtherFinancialMetrics;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_OtherFinancialMetricAnnualTypes extends Model
{

    use LogsActivity;

    protected static $logAttributes = ['type_annual', 'unit'];

    protected $table = 'pi_other_financial_metrics_annual_types';

    protected $fillable = ['type_annual', 'unit'];


}
