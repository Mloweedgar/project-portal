<?php

namespace App\Models\Project\ProjectDetails;

use Illuminate\Database\Eloquent\Model;

class PD_FinancialCategory extends Model
{
    protected $table="pd_financial_categories";

    public function financial(){
        return $this->hasMany(PD_Financial::class);
    }

    public function award_financing(){
        return $this->hasMany(PD_AwardFinancing::class);
    }
}
