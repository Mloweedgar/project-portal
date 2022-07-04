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

    protected $fillable = ['project_id','sponsor_id','ocid','stage_id','project_need','description_services','reasons_ppp','stakeholder_consultation','description_asset','project_value_usd','project_value_second'];

    protected static $logAttributes = ['project_id','sponsor_id','ocid','stage_id','project_need','description_services','reasons_ppp','stakeholder_consultation','description_asset','project_value_usd','project_value_second'];

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
            'description_services' => $this->description_services,
            'reasons_ppp' => $this->reasons_ppp,
            'stakeholder_consultation' => $this->stakeholder_consultation,
        ];
    }

    public function getInformation()
    {
        $projectInfo = $this;

        $basicInfo = collect([
            1 => __("project/project-information.project-need"),
            2 => __("project/project-information.description-asset"),
            3 => __("project/project-information.description-services"),
            4 => __("project/project-information.reasons-ppp"),
            5 => __("project/project-information.stakeholder-consultation"),
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
                    $info['value'] = $projectInfo['description_services'];
                    break;
                case 4:
                    $info['value'] = $projectInfo['reasons_ppp'];
                    break;
                case 5:
                    $info['value'] = $projectInfo['stakeholder_consultation'];
                    break;
            }

            return $info;
        });

        return $basicInfo;
    }

}
