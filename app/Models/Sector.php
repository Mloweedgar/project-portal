<?php

namespace App\Models;

use App\Models\Project\ProjectInformation;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sector extends Model
{
    public function project_informations()
    {
        return $this->belongsToMany(ProjectInformation::class,'sector_project_information', 'project_information_id', 'sector_id');
    }

    public function projectsInformation()
    {
        return $this->belongsToMany(ProjectInformation::class, 'sector_project_information', 'project_information_id', 'sector_id');
    }

    public function projectsInformationCount()
    {
        return DB::table('sector_project_information')->where('sector_id', $this->id )->count();
    }

    // Left join!
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'sector_project_information', 'sector_id', 'project_information_id');
    }

    public static function getSumOfProjectsUsdValue($projects)
    {
        $total = 0;

        foreach ($projects as $project) {
            $total += $project->project_value_usd;
        }

        return $total;
    }

    public static function getSumOfProjectsSecondValue($projects)
    {
        $total = 0;

        foreach ($projects as $project) {
            $total += $project->project_value_second;
        }

        return $total;
    }
}
