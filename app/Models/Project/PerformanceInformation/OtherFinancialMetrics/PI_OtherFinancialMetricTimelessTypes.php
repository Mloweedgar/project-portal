<?php

namespace App\Models\Project\PerformanceInformation\OtherFinancialMetrics;

use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricTimeless;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_OtherFinancialMetricTimelessTypes extends Model
{

    use LogsActivity;

    protected static $logAttributes = ['name'];

    protected $table = 'pi_other_financial_metrics_timeless_types';

    protected $fillable = ['name'];



    /**
     * Relationships.
     *
     * @var
     */
    public function timeless(){
        return $this->hasOne(PI_OtherFinancialMetricTimeless::class, 'type_id');
    }
}
