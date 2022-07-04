<?php

namespace App\Models\Project\PerformanceInformation\OtherFinancialMetrics;

use Illuminate\Database\Eloquent\Model;

class PI_OtherFinancialMetricTimelessMain extends Model
{

    protected $table = 'pi_other_financial_metrics_timeless_main';

    protected $fillable = ['name'];

    public function metricsTimeless(){
        return $this->hasMany(PI_OtherFinancialMetricTimeless::class, 'pi_other_main_id');
    }


}
