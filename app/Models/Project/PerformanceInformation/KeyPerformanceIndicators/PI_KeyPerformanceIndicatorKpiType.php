<?php

namespace App\Models\Project\PerformanceInformation\KeyPerformanceIndicators;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_KeyPerformanceIndicatorKpiType extends Model
{

    use LogsActivity;

    protected static $logAttributes = ['name', 'unit'];

    protected $table = 'pi_key_performance_indicators_kpi_types';

    protected $fillable = ['name', 'unit'];


}
