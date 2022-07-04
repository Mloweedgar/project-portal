<?php

namespace App\Models\Project\PerformanceInformation;

use App\Models\Project\Project;
use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricAnnualMain;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricTimelessMain;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevelMain;
use App\Models\Project\PerformanceInformation\PI_IncomeStatementMain;
use App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure;
use Illuminate\Database\Eloquent\Model;

class PerformanceInformation extends Model
{
    protected $fillable = [
        'key_performance_active',
        'performance_failures_active',
        'performance_assessment_active',
    ];
    protected $table = 'performance_information';

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function annual_demand(){
        return $this->hasOne(PI_AnnualDemandLevelMain::class, 'performance_information_id');
    }

    public function incomeStatementMain(){
        return $this->hasOne(PI_IncomeStatementMain::class, 'performance_information_id');
    }

    public function keyPerformanceIndicators(){
        return $this->hasOne(PI_KeyPerformanceIndicatorMain::class, 'performance_information_id');
    }

    public function otherFinancialMetricAnnualMain(){
        return $this->hasOne(PI_OtherFinancialMetricAnnualMain::class, 'perf_inf_id');
    }
    public function otherFinancialMetricTimelessMain(){
        return $this->hasOne(PI_OtherFinancialMetricTimelessMain::class, 'perf_inf_id');
    }

    public function performanceAssessments(){
        return $this->hasMany(PI_PerformanceAssessment::class, 'performance_information_id');
    }
    public function performanceFailures(){
        return $this->hasMany(PI_PerformanceFailure::class, 'performance_information_id');
    }


}
