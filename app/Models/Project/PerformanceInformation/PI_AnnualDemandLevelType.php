<?php

namespace App\Models\Project\PerformanceInformation;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PI_AnnualDemandLevelType extends Model
{
    use LogsActivity;

    protected $fillable = ['type', 'unit'];

    protected static $logAttributes = ['type', 'unit'];

    protected $table = 'pi_annual_demand_level_type';

    /**
     * Always capitalize the type attribute when we save it to the database
     */
    public function setTypeAttribute($value) {
        $this->attributes['type'] = ucfirst($value);
    }


    /**
     * Always capitalize the unit when we save it to the database
     */
    public function setUnitAttribute($value) {
        $this->attributes['unit'] = ucfirst($value);
    }

}
