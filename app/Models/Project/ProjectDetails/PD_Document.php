<?php

namespace App\Models\Project\ProjectDetails;

use App\Models\Project\ProjectDetails\ProjectDetail;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class PD_Document extends Model
{

    use LogsActivity;

    protected $fillable = ['project_details_id','name','description','position'];

    protected static $logAttributes = ['project_details_id','name','description','position'];

    use Searchable;

    protected $table = "pd_document";

    public function projectDetail(){
        return $this->belongsTo(ProjectDetail::class, 'project_details_id');
    }

    /**
     * TODO
     *
     * @param null $id
     * @return array|mixed
     */
    public static function getRequestDocumentsList($id = null)
    {
        $list = [
            'Prefeasibility Study', 'Request for information',
            'Request for qualification', 'Short-list bidders selected',
            'Request for proposal', 'Construction beggins',
            'Construction ends', 'Operation & Maintenance'
        ];

        if ($id !== null) {
            return $list[$id];
        }

        return $list;

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

}
