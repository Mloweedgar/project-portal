<?php

namespace App\Models\Project\ProjectDetails;

use App\Models\Project\ProjectDetails\ProjectDetail;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Environment extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','description'];

    protected static $logAttributes = ['project_details_id','description'];

    protected static $recordEvents = ['updated','deleted'];

    use Searchable;

    protected $table = "pd_environment";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }
}
