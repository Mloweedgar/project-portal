<?php

namespace App\Http\Controllers\Backend\Project\PerformanceInformation;


use App\Http\Controllers\Controller;
use App\Http\Requests\Project\PerformanceInformation\KeyPerformanceIndicatorsStoreRequest;
use App\Http\Requests\Project\PerformanceInformation\KeyPerformanceIndicatorsTypeStoreRequest;
use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator;
use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorKpiType;
use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain;
use App\Models\Project\PerformanceInformation\PerformanceInformation;
use App\Models\Project\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class KeyPerformanceIndicatorsController extends Controller
{

    public $project;
    public $key_performance_indicator;

    public function __construct(Project $project, PI_KeyPerformanceIndicator $key_performance_indicator)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->key_performance_indicator = $key_performance_indicator;

    }


    /**
     * Returns the view page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id)
    {
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPIKeyPerformanceIndicators($project) === false) {
            return redirect('dashboard');
        }

        $exists = false;

        $pi_key_performance_main_id = $project->performanceInformation->keyPerformanceIndicators;

        //If the record doesn't exists, create a new object.
        if(!$pi_key_performance_main_id){
            $obje = new PI_KeyPerformanceIndicatorMain();
            $project->performanceInformation->keyPerformanceIndicators()->save($obje);
            $pi_key_performance_main_id = $obje->id;

        }else{
            $pi_key_performance_main_id = $pi_key_performance_main_id->id;
        }

        $years = $this->key_performance_indicator->where('pi_key_performance_main_id', $pi_key_performance_main_id)->select('year')->groupBy('year')->orderBy('year')->get();
        $project_inf_id = $project->performanceInformation->id;

        $types = PI_KeyPerformanceIndicatorKpiType::all();

        $arrays = $this->getTable($pi_key_performance_main_id);
        $year = Carbon::now()->year;

        $project->load('performanceInformation');

        $draft = PI_KeyPerformanceIndicatorMain::where('id',$pi_key_performance_main_id)->first()->draft;

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.performance-information.key-performance-indicators', compact('exists', 'project', 'year', 'types', 'arrays','draft', 'hasCoordinators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(KeyPerformanceIndicatorsStoreRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];


        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();
            $pi_key_performance_main_id = $project->performanceInformation->keyPerformanceIndicators->id;

            $previousRecord = $this->key_performance_indicator->where('pi_key_performance_main_id', $pi_key_performance_main_id)->where('year', $request->get('year'))->where('type_id', $request->get('kpi_type'))->count();
            if($previousRecord > 0){
                throw new \Exception(trans('project/performance-information/annual_demand_levels.error_duplicate_entry'));
            }
            $key_performance_indicator = $this->key_performance_indicator;
            $key_performance_indicator->pi_key_performance_main_id = $pi_key_performance_main_id;

            $key_performance_indicator->type_id = $request->get('kpi_type');
            $key_performance_indicator->achievement = $request->get('achievement');
            $key_performance_indicator->year = $request->get('year');
            $key_performance_indicator->target = $request->get('target');

            $key_performance_indicator->save();

            DB::commit();
            $flag["message"] = trans('project/performance-information/key_performance_indicators.success');
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return back()->with($flag);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeType(KeyPerformanceIndicatorsTypeStoreRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];

        DB::beginTransaction();
        try {

            PI_KeyPerformanceIndicatorKpiType::create(['name' => $request->get('name'), 'unit' => $request->get('unit')]);
            DB::commit();
            $flag["message"] = trans('project/performance-information/key_performance_indicators.success');
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return back()->with($flag);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function updateStore(Request $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];

        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();
            $pi_key_performance_main_id = $project->performanceInformation->keyPerformanceIndicators->id;

            //Update
            if($request->get('newRecords')){
                foreach ($request->get('newRecords') as $key => $value) {

                    $this->key_performance_indicator = new $this->key_performance_indicator;
                    $this->key_performance_indicator->type_id = $value["type"];
                    $this->key_performance_indicator->achievement = $value["achievement"];
                    $this->key_performance_indicator->pi_key_performance_main_id = $pi_key_performance_main_id;
                    $this->key_performance_indicator->year = $value["year"];
                    $this->key_performance_indicator->target = $value["target"];
                    $this->key_performance_indicator->save();
                }
            }
            if($request->get('existingRecords')){
                foreach ($request->get('existingRecords') as $key => $value) {
                    $this->key_performance_indicator = $this->key_performance_indicator->find($value['id']);
                    if($value["achievement"] == "" && $value["target"] == ""){
                        $this->key_performance_indicator->delete();
                    }else{
                        $this->key_performance_indicator->achievement = $value["achievement"];
                        $this->key_performance_indicator->target = $value["target"];
                        $this->key_performance_indicator->save();
                    }
                }
            }

            $project->performanceInformation->keyPerformanceIndicators->published = 1;
            $project->performanceInformation->keyPerformanceIndicators->draft = 0;

            $project->performanceInformation->keyPerformanceIndicators->save();
            $project->save();

            DB::commit();
            $flag["message"] = trans('project/performance-information/key_performance_indicators.success');
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }
        return $flag;
    }

    /**
     * Delete
     *
     * @param  AnnualDemandLevelDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();
            /*return $request->all();*/

            $this->key_performance_indicator = $this->key_performance_indicator->where('type_id', $request->get('type_id'))->whereIn('year', $request->get('years'));
            $this->key_performance_indicator->delete();

            DB::commit();
            $flag["message"] = trans('project/performance-information/key_performance_indicators.deleted');

            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        return back()->with($flag);
    }

     /**
     * Get table method
     * @param annual demands main table id
     * @param  $cols cols to be divided
     * @return array
     */
    public static function getTable($pi_key_performance_main_id, $cols = 5){

       $years = PI_KeyPerformanceIndicator::where('pi_key_performance_main_id', $pi_key_performance_main_id)->select('year')->groupBy('year')->orderBy('year')->get();

       $types = PI_KeyPerformanceIndicatorKpiType::all();

       $final = [];
       $kpis = [];
       if ($cols) {
            $years = array_chunk($years->toArray(), $cols);
       } else {
            $years = [ $years->toArray() ];
       }
       
       $arrays = [];

       foreach ($years as $key => $groupyear) {
           $yy = [];
           foreach ($groupyear as $key => $year) {
               $yy[] = $year["year"];
           }
           $kpis = PI_KeyPerformanceIndicator::where('pi_key_performance_main_id', $pi_key_performance_main_id)->whereIn('year', $yy)->select('type_id')->with('type')->groupBy('type_id')->orderBy('type_id')->get();
           $arrays[] = ["years" => $groupyear, "kpis" => $kpis];
       }

       $pp2 = [];
       foreach ($arrays as $key => $value) {
           $pp = [];
           foreach ($value["years"] as $key => $value2) {
               foreach ($value["kpis"] as $key => $value3) {
                   $var = PI_KeyPerformanceIndicator::where('pi_key_performance_main_id', $pi_key_performance_main_id)->where('year', $value2)->where('type_id', $value3->type_id)->select('target', 'achievement', 'id')->first();
                   if(!$var){
                       $var = [];
                   }
                   $pp[$value3->type_id][] = $var;
               }
           }
           $pp2[] = ["years" => $value["years"], "kpis" => $value["kpis"], "records" => $pp];
       }
       return $pp2;
    }

}
