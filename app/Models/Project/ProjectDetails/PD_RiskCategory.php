<?php

namespace App\Models\Project\ProjectDetails;

use Illuminate\Database\Eloquent\Model;

class PD_RiskCategory extends Model
{
    protected $table="pd_risks_categories";

    public function risks(){
        return $this->hasMany(PD_Risk::class);
    }
}
