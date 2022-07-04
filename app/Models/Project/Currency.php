<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function annual_revenues(){
        return $this->hasMany(PI_AnnualRevenue::class);
    }
}
