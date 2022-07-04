<?php

namespace App\Models\Project\ProjectDetails;

use Illuminate\Database\Eloquent\Model;

class PD_AwardStatus extends Model
{
    protected $table="pd_award_status";

    public function award(){
        return $this->hasMany(PD_Award::class);
    }

}
