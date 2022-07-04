<?php

namespace App\Models\Project\PerformanceInformation\KeyPerformanceIndicators;

use Illuminate\Database\Eloquent\Model;

class PI_KeyPerformanceIndicatorMain extends Model
{
    protected $table = 'pi_key_performance_main';

    public function indicators(){
        return $this->hasMany(PI_KeyPerformanceIndicator::class, 'pi_key_performance_main_id');
    }

}
