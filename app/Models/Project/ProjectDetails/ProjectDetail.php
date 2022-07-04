<?php

namespace App\Models\Project\ProjectDetails;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $fillable = [
        'name',
        'contract_summary_active',
        'documents_active',
        'environment_active',
        'procurement_active',
        'risks_active',
        'evaluation_ppp_active',
        'financial_active',
        'government_support_active',
        'tariffs_active',
        'contract_termination_active',
        'renegotiations_active',
        'award_active'
    ];

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function announcements(){
        return $this->hasMany(PD_Announcement::class, 'project_details_id');
    }
    public function contractTerminations(){
        return $this->hasMany(PD_ContractTermination::class, 'project_details_id');
    }
    public function documents(){
        return $this->hasMany(PD_Document::class, 'project_details_id');
    }
    public function evaluationsPPP(){
        return $this->hasMany(PD_EvaluationPPP::class, 'project_details_id');
    }
    public function financials(){
        return $this->hasMany(PD_Financial::class, 'project_details_id');
    }
    public function governmentSupports(){
        return $this->hasMany(PD_GovernmentSupport::class, 'project_details_id');
    }
    public function contractSummaries(){
        return $this->hasMany(PD_ContractSummary::class, 'project_details_id');
    }
    public function renegotiations(){
        return $this->hasMany(PD_Renegotiations::class, 'project_details_id');
    }
    public function financing(){
        return $this->hasMany(PD_AwardFinancing::class, 'project_details_id');
    }
    public function risks(){
        return $this->hasMany(PD_Risk::class, 'project_details_id');
    }
    public function tariffs(){
        return $this->hasMany(PD_Tariffs::class, 'project_details_id');
    }
    public function award(){
        return $this->hasOne(PD_Award::class, 'project_details_id');
    }
    public function environment(){
        return $this->hasOne(PD_Environment::class, 'project_details_id');
    }

    // This hasn't got visibility by itself but the Award section
    public function awardFinancing(){
        return $this->hasMany(PD_AwardFinancing::class, 'project_details_id');
    }
}
