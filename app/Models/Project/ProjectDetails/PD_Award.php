<?php

namespace App\Models\Project\ProjectDetails;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Award extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id', 'financial_close_date', 'contract_signature_date', 'award_date', 'name', 'description', 'total_amount', 'award_status_id'];
    protected $dates = ['award_date_end', 'contract_signature_date', 'award_date', 'contract_signature_date_end'];
    protected $table = "pd_award";
    protected static $logAttributes = ['pd_award'];

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }

    public function status(){
        return $this->belongsTo(PD_AwardStatus::class, 'award_status_id');
    }

}
