<?php

namespace App\Models\Project;

use App\Models\Entity;
use App\Models\Location;
use App\Models\Sector;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectInformation extends Model
{

    use LogsActivity;

    protected $fillable = ['project_id','sponsor_id','ocid','stage_id','project_need','description_asset','rationale_ppp','name_transaction_advisor','unsolicited_project','project_summary','project_value_usd','project_value_second'];

    protected static $logAttributes = ['project_id','sponsor_id','ocid','stage_id','project_need','description_asset','rationale_ppp','name_transaction_advisor','unsolicited_project','project_summary','project_value_usd','project_value_second'];

    protected static $recordEvents = ['updated'];

    use Searchable;

    protected $table = 'project_information';

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function stage(){
        return $this->belongsTo(Stage::class);
    }

    public function regions(){
        return $this->belongsToMany(Location::class, 'location_project_information', 'project_information_id', 'location_id');
    }

    public function sectors(){
        return $this->belongsToMany(Sector::class, 'sector_project_information', 'project_information_id', 'sector_id');
    }
    public function sponsor(){
        return $this->belongsTo(Entity::class);
    }


    /**
     * FULLTEXT fields for scout searching
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'project_need' => $this->project_need,
            'description_asset' => $this->description_asset,
            'rationale_ppp' => $this->rationale_ppp,
            'name_transaction_advisor' => $this->name_transaction_advisor,
            'unsolicited_project' => $this->unsolicited_project,
            'project_summary' => $this->project_summary,
        ];
    }

    public function getInformation()
    {
        $projectInfo = $this;

        $basicInfo = collect([
            1 => __("project/project-information.project-need"),
            2 => __("project/project-information.description_asset"),
            3 => __("project/project-information.rationale_ppp"),
            4 => __("project/project-information.name_transaction_advisor"),
            5 => __("project/project-information.unsolicited_project"),
            6 => __("project/project-information.project_summary"),
        ])->map(function ($name, $id) use($projectInfo) {
            $info = [];
            $info['id'] = $id;
            $info['name'] = $name;

            switch ($id) {
                case 1:
                    $info['value'] = $projectInfo['project_need'];
                    break;
                case 2:
                    $info['value'] = $projectInfo['description_asset'];
                    break;
                case 3:
                    $info['value'] = $projectInfo['rationale_ppp'];
                    break;
                case 4:
                    $info['value'] = $projectInfo['name_transaction_advisor'];
                    break;
                case 5:
                    $info['value'] = $projectInfo['unsolicited_project'];
                    break;
                case 6:
                    $info['value'] = $projectInfo['project_summary'];
                    break;
            }

            return $info;
        });

        return $basicInfo;
    }

}
