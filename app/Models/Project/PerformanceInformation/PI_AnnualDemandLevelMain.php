<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_AnnualDemandLevelMain extends Model
{

    use LogsActivity;

    protected $fillable = ['id','performance_information_id'];

    protected static $logAttributes = ['id','performance_information_id'];

    protected $table = 'pi_annual_demand_levels_main';

    public function performance_information(){
        $this->belongsTo(PerformanceInformation::class);
    }

    public function values(){
        $this->hasMany(PI_AnnualDemandLevelValue::class);
    }
}
