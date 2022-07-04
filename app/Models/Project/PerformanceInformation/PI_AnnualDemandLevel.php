<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_AnnualDemandLevel extends Model
{

    use LogsActivity;

    protected $fillable = ['year','value','type_id','pi_annual_demand_levels_main_id'];

    protected static $logAttributes = ['year','value','type_id','pi_annual_demand_levels_main_id'];

    protected $table = 'pi_annual_demand_levels';

    public function performance_information(){
        $this->belongsTo(PerformanceInformation::class);
    }

    public function values(){
        $this->hasMany(PI_AnnualDemandLevelValue::class);
    }
}
