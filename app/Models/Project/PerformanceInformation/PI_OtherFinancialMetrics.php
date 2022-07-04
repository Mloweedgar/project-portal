<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;

class PI_OtherFinancialMetrics extends Model
{
    public function performance_information(){
        $this->belongsTo(PerformanceInformation::class);
    }

    protected $table = "pi_other_financial_metrics";

}
