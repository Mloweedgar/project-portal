<?php

namespace App\Models\Project\ContractMilestones;

use Illuminate\Database\Eloquent\Model;

class MilestonesType extends Model
{
    public function contract(){
        return $this->belongsTo(ContractMilestone::class);
    }
}
