<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;

class PI_IncomeStatementMain extends Model
{
    protected $table = 'pi_income_statements_main';

    public function metricsTimeless(){
        return $this->hasMany(PI_OtherFinancialMetricTimeless::class, 'pi_other_main_id');
    }

}
