<?php

namespace App\Models\Project\ProjectDetails;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Announcement extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description'];

    protected static $logAttributes = ['project_details_id','name','description'];

    use Searchable;

    protected $table = "pd_announcements";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }

    /**
     * FULLTEXT fields for scout searching
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

    public function getPreviewUpdatedAt()
    {
        // if not null
        if ($this->updated_at) {
            $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->updated_at);
            return $datetime->format('m/d/Y g:i A');
        }

        return $this->updated_at;
    }

    public function getPreviewCreatedAt()
    {
        // if not null
        if ($this->created_at) {
            $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
            return $datetime->format('m/d/Y g:i A');
        }

        return $this->created_at;
    }
}
