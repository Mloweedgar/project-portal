<?php

namespace App\Models\Project\ProjectDetails;

use Illuminate\Database\Eloquent\Model;

class PD_RiskAllocation extends Model
{
    protected $table="pd_risks_allocation";

    public function risks(){
        return $this->hasMany(PD_Risk::class);
    }
}
