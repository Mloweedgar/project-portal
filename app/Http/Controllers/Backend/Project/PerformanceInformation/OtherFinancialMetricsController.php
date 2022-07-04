<?php

namespace App\Http\Controllers\Backend\Project\PerformanceInformation;


use App\Http\Controllers\Controller;
use App\Http\Requests\Project\PerformanceInformation\OtherFinancialMetricDeleteRequest;
use App\Http\Requests\Project\PerformanceInformation\OtherFinancialMetricsAnnualStoreRequest;
use App\Http\Requests\Project\PerformanceInformation\OtherFinancialMetricsRequest;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricAnnual;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricAnnualMain;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricAnnualTypes;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricTimeless;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricTimelessMain;
use App\Models\Project\PerformanceInformation\OtherFinancialMetrics\PI_OtherFinancialMetricTimelessTypes;
use App\Models\Project\PerformanceInformation\PerformanceInformation;
use App\Models\Project\PerformanceInformation\PI_ActualInternalRateReturn;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevelMain;
use App\Models\Project\PerformanceInformation\PI_OtherFinancialMetrics;
use App\Models\Project\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtherFinancialMetricsController extends Controller
{

    public $project;
    public $other_financial_metrics_timeless;

    public function __construct(Project $project, PI_OtherFinancialMetricTimeless $other_financial_metrics_timeless)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');

        $this->project = $project;
        $this->other_financial_metrics_timeless = $other_financial_metrics_timeless;

    }


    /**
     * Returns the view page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id)
    {
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPIOtherFinancialMetrics($project) === false) {
            return redirect('dashboard');
        }

        $exists = false;
        $year = Carbon::now()->year;
        $project = $this->project->findOrFail($id);

        // Check if the record exists, if not, save a new one.
        $pi_other_main_timeless_id = $project->performanceInformation->otherFinancialMetricTimelessMain;
        if(!$pi_other_main_timeless_id){
            $obj = new PI_OtherFinancialMetricTimelessMain();
            $project->performanceInformation->otherFinancialMetricTimelessMain()->save($obj);
            $pi_other_main_timeless_id = $obj->id;
        }else{
            $pi_other_main_timeless_id = $project->performanceInformation->otherFinancialMetricTimelessMain->id;
        }

        $timelessVariables = PI_OtherFinancialMetricTimelessTypes::with(array('timeless' => function($query) use ($pi_other_main_timeless_id)
        {
            $query->where('pi_other_financial_metrics_timeless.pi_other_main_id', $pi_other_main_timeless_id);

        }))->get()->toArray();

        $annualTypes = PI_OtherFinancialMetricAnnualTypes::select('type_annual', 'unit', 'id')->get();

        // Check if the record exists, if not, save a new one.
        $pi_other_main_annual_id = $project->performanceInformation->otherFinancialMetricAnnualMain;
        if(!$pi_other_main_annual_id){
            $obj = new PI_OtherFinancialMetricAnnualMain();
            $project->performanceInformation->otherFinancialMetricAnnualMain()->save($obj);
            $pi_other_main_annual_id = $obj->id;
        }else{
            $pi_other_main_annual_id = $pi_other_main_annual_id->id;
        }

        //Generate the table
        $tables = [];
        if(PI_OtherFinancialMetricAnnual::where('pi_other_main_id', $pi_other_main_annual_id)->count() > 0){
            foreach ($annualTypes as $key => $value) {
                $records = PI_OtherFinancialMetricAnnual::where('pi_other_main_id', $pi_other_main_annual_id)->where('type_id', $value->id)->select('id','value', 'year')->orderBy('year')->get();
                if(count($records) > 0){
                    $tables [] = ["type" => $value->type_annual, "unit" => $value->unit, "records" => array_chunk($records->toArray(), 5)];
                }
            }
        }
        /*dd($tables);*/
        $project->load('performanceInformation');

        $draft_annual = PI_OtherFinancialMetricAnnualMain::where('id',$pi_other_main_annual_id)->first()->draft;
        $draft_timeless = PI_OtherFinancialMetricTimelessMain::where('id',$pi_other_main_timeless_id)->first()->draft;

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.performance-information.other-financial-metrics',compact('exists', 'project', 'other_financial_metrics', 'timelessVariables', 'year', 'annualTypes', 'tables','draft_timeless','draft_annual', 'hasCoordinators'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeTimeless(Request $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];

        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $pi_other_main_timeless_id = $project->performanceInformation->otherFinancialMetricTimelessMain->id;


            if($request->get('variablesDelete')){
                $this->other_financial_metrics_timeless->where('pi_other_main_id', $pi_other_main_timeless_id)->whereIn('type_id', $request->get('variablesDelete'))->delete();
            }

            if($request->get('variables')){
                foreach ($request->get('variables') as $key => $value) {
                    $object = $this->other_financial_metrics_timeless->where('pi_other_main_id', $pi_other_main_timeless_id)->where('type_id', $value['id'])->first();
                    if(!$object)
                        $object = new $this->other_financial_metrics_timeless;
                    $object->pi_other_main_id = $pi_other_main_timeless_id;
                    $object->type_id = $value['id'];
                    $object->value = $value['value'];
                    $object->save();
                }
            }

            $flag["message"] = trans('project/performance-information/other_financial_metrics.success');
            DB::commit();
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }

        /*return back()->with($flag);*/
        return $flag;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeAnnual(OtherFinancialMetricsAnnualStoreRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];

        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $pi_other_main_annual_id = $project->performanceInformation->otherFinancialMetricAnnualMain->id;
            $previousRecord = PI_OtherFinancialMetricAnnual::where('pi_other_main_id', $pi_other_main_annual_id)->where('year', $request->get('year'))->where('type_id', $request->get('income_metric'))->count();


            if($previousRecord > 0){
                throw new \Exception(trans('project/performance-information/annual_demand_levels.error_duplicate_entry'));
            }

            $otherFinancialMetric = new PI_OtherFinancialMetricAnnual();
            $otherFinancialMetric->year = $request->get('year');
            $otherFinancialMetric->value = $request->get('value');
            $otherFinancialMetric->type_id = $request->get('income_metric');
            $otherFinancialMetric->pi_other_main_id = $pi_other_main_annual_id;
            $otherFinancialMetric->save();


            $flag["message"] = trans('project/performance-information/other_financial_metrics.success');
            DB::commit();
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

    public function updateAnnual(Request $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            foreach ($request->get('variables') as $key => $value) {

                $otherFinancialAnnual = PI_OtherFinancialMetricAnnual::find($value["id"]);

                $otherFinancialAnnual->value = $value["value"];
                $otherFinancialAnnual->save();
          }

            $flag["message"] = trans('project/performance-information/other_financial_metrics.success');
            $flag["status"] = true;

            $type = $request->get('submit_type');

            $otherMetricsMain = PI_OtherFinancialMetricAnnualMain::where("perf_inf_id",$project->performanceInformation->id)->first();

            if($type == 'publish'){
                $otherMetricsMain->published = 1;
                $otherMetricsMain->draft = 0;
            }else if($type == 'save_draft'){
                $otherMetricsMain->draft = 1;
                $otherMetricsMain->published = 0;

                $subject = trans('emails/tasks.publish_subject');

                $emailData = [
                    'name' => Auth::user()->name,
                    'subject' => $subject,
                ];

                Mail::send('back.emails.tasks.completeRFM', $emailData, function ($message) use ($subject) {
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->subject($subject);
                    $message->to(Auth::user()->email);
                });

            }else if($type == 'request_modification'){
                $otherMetricsMain->request_modification = 1;
            }
            $otherMetricsMain->save();
            $project->save();


            DB::commit();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeTimelessType(Request $request)
    {
        $flag = ["status" => true, "message" => "", "record" => false];

        $this->validate($request, [
            'type_timeless' => 'required|unique:pi_other_financial_metrics_timeless_types,name'
        ]);
        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));

            /*$other_financial_metrics = $this->other_financial_metrics->where('perf_inf_id', $project->performanceInformation->id)->first();*/
            PI_OtherFinancialMetricTimelessTypes::create(['name' => $request->get('type_timeless')]);


            $flag["message"] = trans('project/performance-information/other_financial_metrics.success');
            DB::commit();
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

    public function storeAnnualType(Request $request)
    {
        $flag = ["status" => true, "message" => "", "record" => false];

        $this->validate($request, [
            'type_annual' => 'required|unique_with:pi_other_financial_metrics_annual_types,unit'
        ]);
        DB::beginTransaction();
        try {

            $project = Project::findOrFail($request->get('project_id'));

            PI_OtherFinancialMetricAnnualTypes::create(['type_annual' => $request->get('type_annual'), 'unit' => $request->get('unit')]);

            $flag["message"] = trans('project/performance-information/other_financial_metrics.success');
            DB::commit();
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
     * Delete
     *
     * @param  AnnualDemandLevelDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteAnnual(OtherFinancialMetricDeleteRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $otherFinancialMetric = PI_OtherFinancialMetricAnnual::find($request->get('other_financial_id'));
            $otherFinancialMetric->delete();

            $flag["message"] = trans('project/performance-information/other_financial_metrics.success');
            DB::commit();
            $flag["message"] = trans('project/performance-information/other_financial_metrics.deleted');
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }
        /*return $flag;*/

        return back()->with($flag);
    }

    /**
     * Get table method
     * @param income statement metric main table id
     * @return array
     */
    public static function getAnnualTable($pi_other_main_annual_id){

        $tables = [];
        $annualTypes = PI_OtherFinancialMetricAnnualTypes::select('type_annual', 'unit', 'id')->get();

        if(PI_OtherFinancialMetricAnnual::where('pi_other_main_id', $pi_other_main_annual_id)->count() > 0){
             foreach ($annualTypes as $key => $value) {
                 $records = PI_OtherFinancialMetricAnnual::where('pi_other_main_id', $pi_other_main_annual_id)->where('type_id', $value->id)->select('id','value', 'year')->orderBy('year')->get();
                if(count($records) > 0){
                     $tables [] = ["type" => $value->type_annual, "unit" => $value->unit, "records" => array_chunk($records->toArray(), 5)];
                }
            }
        }

      return $tables;
    }




}
