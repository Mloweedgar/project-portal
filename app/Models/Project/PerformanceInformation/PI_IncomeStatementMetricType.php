<?php

namespace App\Models\Project\PerformanceInformation;

use App\Models\Project\Currency;
use Illuminate\Database\Eloquent\Model;

class PI_IncomeStatementMetricType extends Model
{
    protected $table = 'pi_income_statements_metrics_types';

    protected $fillable = ['currency_id', 'name'];

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

}
