<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_IncomeStatementMetrics extends Model
{

    use LogsActivity;

    protected $fillable = ['pi_income_statement_main_id','year','value','type_id'];

    protected static $logAttributes = ['pi_income_statement_main_id','year','value','type_id'];

    protected $table = 'pi_income_statements_metrics';
    public function performance_information(){
        $this->belongsTo(PerformanceInformation::class);
    }

    public function currency(){
        $this->belongsTo(Currency::class);
    }

    public function values(){
        $this->hasMany(PI_AnnualRevenueValue::class);
    }
}
