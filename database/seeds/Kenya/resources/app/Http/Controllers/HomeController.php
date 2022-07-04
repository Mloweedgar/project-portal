<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Config;
use App\Models\GraphPos;

use App\Models\Location;
use App\Models\Media;
use App\Models\PerformanceInformation;
use App\Models\ProjectDetail;
use App\Models\Project\Project;
use App\Models\Section;
use App\Models\Slider;
use App\Models\Sector;
use App\Models\Stage;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use MikeAlmond\Color\Color;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Banner
        $data['banner'] = Banner::leftJoin("media","media.position","=","banners.id")->where('media.section','b')->where('active', 1)->first(['banners.*']);

        // Regions
        $data['regions'] = Location::leftJoin(
            'location_project_information',
            'location_project_information.location_id', '=', 'locations.id'
        )
            ->leftJoin('projects', function ($join) {
                $join->on('projects.id', '=', 'location_project_information.project_information_id')
                    ->where('projects.active', '=', 1);
            })
            ->where("type","region")
            ->groupBy('locations.id', 'locations.name', 'locations.code')
            ->get([
                'locations.id',
                'locations.name',
                'locations.code',
                DB::raw('ifnull(count(projects.id),0) as num_projects')
            ]);

        // Sectors
        $data['sectors'] = Sector::query()
            ->leftJoin(
                'sector_project_information',
                'sector_project_information.sector_id', '=', 'sectors.id'
            )
            ->groupBy('sectors.id', 'sectors.name')
            ->get([
                'sectors.id',
                'sectors.name',
                DB::raw('count(sector_project_information.project_information_id) as num_projects')
            ]);
        $data['sectors_js_labels'] = '["'.implode('", "', array_column($data['sectors']->toArray(), 'name')).'"]';
        $data['sectors_js_data'] = '["'.implode('", "', array_column($data['sectors']->toArray(), 'num_projects')).'"]';

        // Stages
        $data['stages'] = Stage::leftJoin(
            'project_information',
            'project_information.stage_id', '=', 'stages.id'
        )
            ->groupBy('stages.id', 'stages.name', 'stages.color')
            ->get([
                'stages.id',
                'stages.name',
                'stages.color',
                DB::raw('count(project_information.id) as num_projects')
            ]);
        $data['stages_js_labels'] = '["'.implode('", "', array_column($data['stages']->toArray(), 'name')).'"]';
        $data['stages_js_data'] = '["'.implode('", "', array_column($data['stages']->toArray(), 'num_projects')).'"]';

        // Country Code
        // $data['country_code'] = strtolower(explode('-', $data['regions']->first()->code)[0]);
        $data['country_code'] = getCountryCode();

        // Active theme
        $activeTheme = (new \App\Models\Theme)->getActive();

        // 16 colors (8 primary, 8 secondary)
        $relatedColors = [];

        $primaryColor = Color::fromHex($activeTheme->getPrimaryColor());
        /*
        $primaryPalette = (new PaletteGenerator($primaryColor))->tetrad();

        foreach ($primaryPalette as $color) {
            $randomColor = Color::fromHex($color->getHex());
            $randasdomPalette = (new PaletteGenerator($randomColor))->adjacent();

            foreach ($randomPalette as $color2) {
                if ($color->getHex() !== $color2->getHex()) {
                    $relatedColors[] = CssGenerator::hex($color2);
                }
            }
        }
        */

        $secondaryColor = Color::fromHex($activeTheme->getSecondaryColor());
        /*hey
        $secondaryPalette = (new PaletteGenerator($secondaryColor))->tetrad();

        foreach ($secondaryPalette as $color) {
            $randomColor = Color::fromHex($color->getHex());
            $randomPalette = (new PaletteGenerator($randomColor))->adjacent();

            foreach ($randomPalette as $color2) {
                if ($color->getHex() !== $color2->getHex()) {
                    $relatedColors[] = CssGenerator::hex($color2);
                }
            }
        }
        */

        $numNeededColorsForSectors = count($data['sectors']);
        $numNeededColorsForStages = count($data['stages']);

        $data['sectors_js_colors'] = '["'.implode('", "', array_slice($relatedColors, 0, $numNeededColorsForSectors)).'"]';
        $data['stages_js_colors'] = '["'.implode('", "', array_slice($relatedColors, 0, $numNeededColorsForStages)).'"]';
        $data['primaryColor'] = $primaryColor;
        $data['secondaryColor'] = $secondaryColor;
        //data for the graphs on home partial
        $graphs = GraphPos::where('pos_group', 'Home')->get();
        foreach($graphs as $g){
            $g->graph=$g->graph()->first();
            $info=$this->getGraphDataBySection($g->graph->section);

            $g->graph->labels=$info['labels'];
            $g->graph->data=$info['data'];

            $g->graph->label_suffix=$g->graph->section;
        }

        $data['posgroup'] = $graphs;

        // Latest updates

        $data['announcementActive'] = Section::where('section_code','a')->first()->active;

        $data['latest_updates'] = Project::whereHas('projectInformation')
           ->where('projects.active', 1)
           ->orderBy('updated_at', 'desc')
           ->take(6)
           ->get();

        // Get project images
        foreach($data['latest_updates'] as &$projectImage){

            $projectGallery = Media::where("project",$projectImage->id)->where("section","g")->get();

            $project = Project::find($projectImage->id);

            $arrayImages = array("sector_transport", "sector_water", "sector_telecom", "sector_social", "sector_industrial");
            $randomImage = rand(0,4);

            if (count($projectGallery)>0){

                $projectBG = route('uploader.g',['id_image'=>$projectGallery->first()->id]);

            } else {

                if(!isset($project->projectInformation->sectors)){

                    $projectBG = "/img/samples/project/".$arrayImages[$randomImage].".jpg";

                } else {

                    $projectBG = "/img/samples/project/".$project->projectInformation->sectors->first()->code_lang.".jpg";

                }

            }

            $projectImage["project_image"] = $projectBG;
            $projectImage["project_sector"] = $project->projectInformation->sectors->first()->name;

        }

        // Announcements
        if ($data['announcementActive']){

            $data['announcements'] = DB::table('pd_announcements')->select('project_details.project_id','pd_announcements.created_at','pd_announcements.name','pd_announcements.description', 'projects.name as projectname')->leftJoin(
                'project_details',
                'project_details.id', '=', 'pd_announcements.project_details_id'
            )
                ->leftJoin('projects', 'projects.id', '=', 'project_details.id')
                ->where('projects.active', 1)
                ->where('projects.announcements_active', 1)
                ->where('pd_announcements.published', 1)
                ->orderBy('pd_announcements.created_at', 'desc')
                ->take(5)
                ->get();

        }

       $data['sliders'] = Slider::leftJoin("media","media.position","=","sliders.id")->where('media.section','s')->where('active', 1)->take(10)->get(['sliders.*']);

       $data['currency'] = Config::where('name','currency')->first()->value;


        $highestNumRegion = 0;
        $numProjects = 0;
        foreach($data['regions'] as $region){
            $numProjects = $numProjects + $region->num_projects;
            if ($region->num_projects > $highestNumRegion) {
                $highestNumRegion = $region->num_projects;
            }
        }

        $data['mapColors'] = [];

        $data['mapColors'][] = [
            "Color" => $primaryColor->lighten(60)->getHex(),
            "To" => 0
        ];

        $totalDivision = $highestNumRegion / 5;
        $totalDivisionInit = 0;

        $previousTo = 1;

        $colorArray = [
            $primaryColor->lighten(50)->getHex(),
            $primaryColor->lighten(40)->getHex(),
            $primaryColor->lighten(30)->getHex(),
            $primaryColor->lighten(20)->getHex(),
            $primaryColor->getHex(),
        ];

        for($i = 1; $i < 5; $i++) {

            $totalDivisionInit += $totalDivision;

            $data['mapColors'][] = [
                "Color" => $colorArray[$i],
                "From" => round($previousTo, 0),
                "To" => round($totalDivisionInit, 0)+1
            ];

            $previousTo = round($totalDivisionInit, 0) + 1;

        }

        $data['totalProjectNum'] = $numProjects;

        return view('front.index', $data);
    }

    public function newsletterconfirm(){
        return view('front.newsletter-confirmation');
    }

    public function table(Request $request)
    {

        $projects = Project::with('projectInformation.sponsor', 'projectInformation.sectors', 'projectInformation.regions', 'projectInformation.stage')
        ->select('projects.*');
        $projects->where('active', 1);

        $regions = $request->get('regions_array');
        $sectors = $request->get('sectors_array');
        $stages = $request->get('stages_array');
        $sponsor = $request->get('sponsor');
        $project_name = $request->get('name');

        if ($project_name) {
            $projects->where('projects.name', 'like', '%' . $project_name . '%');
        }
        if ($regions) {
            $projects->whereHas('projectInformation.regions', function($q) use($regions){
                $q->whereIn('location_project_information.location_id', $regions);
            });
        }
        if ($sectors) {
            $projects->whereHas('projectInformation.sectors', function($q) use($sectors){
                $q->whereIn('sector_project_information.sector_id', $sectors);
            });
        }
        if ($stages) {
            $projects->whereHas('projectInformation.stage', function($q) use($stages){
                $q->whereIn('stages.id', $stages);
            });
        }

        $datatables =  app('datatables')->of($projects)

            ->addColumn('sectors', function (Project $project) {
                if(count($project->projectInformation)){
                    return $project->projectInformation->sectors->map(function($sector) {
                        return str_limit($sector->name);
                    })->implode(', ');
                }
            })->addColumn('regions', function (Project $project) {
                if(count($project->projectInformation)){
                    return $project->projectInformation->regions->map(function($region) {
                        return str_limit($region->name);
                    })->implode(', ');
                }
            })->addColumn('slug', function (Project $project) {
                return str_slug($project->name);
            })->addColumn('stage', function (Project $project) {
                if(count($project->projectInformation)){
                    return $project->projectInformation->stage->name;
                }
            })->addColumn('sponsor', function (Project $project) {
                if(count($project->projectInformation)){
                    return $project->projectInformation->sponsor->name;
                }
            })->addColumn('project_value_usd', function (Project $project) {
                if(count($project->projectInformation)){
                    return $project->projectInformation->project_value_usd;
                }
            })->addColumn('project_value_second', function (Project $project) {
                if(count($project->projectInformation)){
                    return $project->projectInformation->project_value_second;
                }
            })->editColumn('updated_at', function ($project) {
                return $project->updated_at->format('Y/m/d');
            })
            ->filterColumn('updated_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
            })
            ->filterColumn('sponsor', function ($query, $keyword) {
                $query->whereRaw("entities.name like ?", ["%$keyword%"]);
            });

        return $datatables->make(true);

    }

    private function getGraphDataBySection($section){
        $labels = array();
        $data = array();

        switch($section){
            case 'sectors':
                $sectors = Sector::with(['projects' => function($q) {
                    $q->where('projects.active', 1);
                }, 'projects.projectInformation'])->get();

                foreach ($sectors as $key_sector => $sector) {
                    $labels[] = __('catalogs/sectors.'.$sector->code_lang);

                    // separate project information
                    $projects_information =  [];
                    foreach ($sector->projects as $project) {
                        $projects_information[] = $project->projectInformation;
                    }

                    $data[] = [
                        'value' => $sector->projects->count(),
                        'meta' => trans('frontpage.total_value').': ' . Sector::getSumOfProjectsUsdValue($projects_information) . ' million USD'
                    ];
                }

                break;

            case 'stages':
                $stages=Stage::with(['projects' => function($q) {
                    $q->where('projects.active', 1);
                }, 'projects.projectInformation'])->get();

                $totalProjects = Project::where('active', 1)->count();

                foreach ($stages as $stage) {
                    $labels[] = $stage->name;
                    $data[] = [
                        'value' => $stage->projects->count(),
                        'meta' => 'Projects: ' . $stage->projects->count(),
                        'total' => $totalProjects
                    ];
                }

                break;
        }

        $result['labels']=json_encode($labels);
        $result['data']=json_encode($data);

        return $result;
    }

    /**
     * Show main frontpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {

        return view('front.index');
    }

    public function projectInfo ($environment, $type){

        $data['environment'] = $environment;
        $data['type'] = $type;
        $data['search'] = [];

        if($environment == 'region'){
            $data["search"] = Location::where('name', $type)->first();


        }elseif($environment == 'stage'){
            $data["search"] = Stage::where('name', $type)->first();

        }elseif($environment == 'sector'){
            $data["search"] = Sector::where('name', $type)->first();
        }

        if(count($data["search"]) == 0){
            return redirect('/');
        }

        $data['currency'] = Config::where('name','currency')->first()->value;

        return view('front.project-info', $data);
    }

}
