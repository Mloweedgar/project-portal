<?php

namespace App\Http\Controllers\Backend\Project\PerformanceInformation;


use App\Http\Controllers\Controller;
use App\Http\Requests\Project\PerformanceInformation\IncomeMetricStatementMetricUpdateRequest;
use App\Http\Requests\Project\PerformanceInformation\IncomeStatementMetricDeleteRequest;
use App\Http\Requests\Project\PerformanceInformation\IncomeStatementMetricStoreRequest;
use App\Http\Requests\Project\PerformanceInformation\IncomeStatementMetricTypeStore;
use App\Models\Project\Currency;
use App\Models\Project\PerformanceInformation\PerformanceInformation;
use App\Models\Project\PerformanceInformation\PI_IncomeStatementMain;
use App\Models\Project\PerformanceInformation\PI_IncomeStatementMetricType;
use App\Models\Project\PerformanceInformation\PI_IncomeStatementMetrics;
use App\Models\Project\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class IncomeStatementsMetricsController extends Controller
{

    public $project;
    public $income_statement_metric;

    public function __construct(Project $project, PI_IncomeStatementMetrics $income_statement_metric)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');

        $this->project = $project;
        $this->income_statement_metric = $income_statement_metric;

    }

    public function index($id){

      $project = $this->project->findOrFail($id);

      // Check specific permissions
      if (Auth::user()->canAccessPIIncomeStatementsMetrics($project) === false) {
          return redirect('dashboard');
      }

      $exists = false;
      $year = Carbon::now()->year;
      $currencies = Currency::all();
      $types = PI_IncomeStatementMetricType::with('currency')->get();

      $pi_income_statement_main_id =  $project->performanceInformation->incomeStatementMain;


      //If the record doesn't exists, create a new object.
      if(!$pi_income_statement_main_id){
          $obje = new PI_IncomeStatementMain();
          $project->performanceInformation->incomeStatementMain()->save($obje);
          $pi_income_statement_main_id = $obje->id;

      }else{
          $pi_income_statement_main_id = $pi_income_statement_main_id->id;
      }

      $tables = $this->getTable($pi_income_statement_main_id);


        $project->load('performanceInformation');

        $draft = PI_IncomeStatementMain::where('id',$pi_income_statement_main_id)->first()->draft;

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.performance-information.income-statements-metrics', compact('exists', 'project', 'year', 'currencies', 'tables', 'types','draft','hasCoordinators'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(IncomeStatementMetricStoreRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];


        DB::beginTransaction();
        try {

            $type = $request->get('type');

            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $income_statement_metric = $this->income_statement_metric;

            $pi_income_statement_main_id = $project->performanceInformation->incomeStatementMain->id;

            $previousRecord = $this->income_statement_metric->where('pi_income_statement_main_id', $pi_income_statement_main_id)->where('year', $request->get('year'))->where('type_id', $request->get('income_metric'))->count();
            if($previousRecord > 0){
                throw new \Exception(trans('project/performance-information/annual_demand_levels.error_duplicate_entry'));
            }

            $income_statement_metric->pi_income_statement_main_id = $pi_income_statement_main_id;

            $income_statement_metric->type_id = $request->get('income_metric');
            $income_statement_metric->year = $request->get('year');
            $income_statement_metric->value = $request->get('value');

            $income_statement_metric->save();
            $flag["message"] = trans('project/performance-information/income_statements_metrics.success');

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

    public function storeType(IncomeStatementMetricTypeStore $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];


        DB::beginTransaction();
        try {

            /*dd($request->all());*/

            $type = $request->get('type');

            $project = Project::findOrFail($request->get('project_id'));


            PI_IncomeStatementMetricType::create(['currency_id' => $request->get('currency_id'), 'name' => $request->get('name')]);
            $flag["message"] = trans('project/performance-information/income_statements_metrics.success');


            DB::commit();
            // all good
        } catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
            // something went wrong
        }
        /*dd($flag);*/

        return back()->with($flag);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(IncomeMetricStatementMetricUpdateRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {
          $project = Project::findOrFail($request->get('project_id'));
          $project->touch();

          if($request->get('incomes')){
            foreach ($request->get('incomes') as $key => $value) {
              $this->income_statement_metric = $this->income_statement_metric->find($value["id"]);
              $this->income_statement_metric->value = $value["value"];
              $this->income_statement_metric->save();
            }
          }
            $flag["message"] = trans('project/performance-information/income_statements_metrics.success');
            $flag["status"] = true;

          $type = $request->get('submit_type');

            if($type == 'publish'){
                $project->performanceInformation->incomeStatementMain->published = 1;
                $project->performanceInformation->incomeStatementMain->draft = 0;
            }else if($type == 'save_draft'){
                $project->performanceInformation->incomeStatementMain->draft = 1;
                $project->performanceInformation->incomeStatementMain->published = 0;

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
                $project->performanceInformation->incomeStatementMain->request_modification = 1;
            }
            $project->performanceInformation->incomeStatementMain->save();
            $project->save();


          DB::commit();
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

    public function delete(IncomeStatementMetricDeleteRequest $request)
    {

        $flag = ["status" => true, "message" => "", "record" => false];
        DB::beginTransaction();
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $project->touch();

            $this->income_statement_metric = $this->income_statement_metric->find($request->get('income_statemet_id'));
            $this->income_statement_metric->delete();

            DB::commit();
            $flag["message"] = trans('project/performance-information/income_statements_metrics.deleted');
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
     * @param income statement metric main table id
     * @return array
     */
    public static function getTable($pi_income_statement_main_id){

      $types = PI_IncomeStatementMetricType::with('currency')->get();

      $tables = [];

      if(PI_IncomeStatementMetrics::where('pi_income_statement_main_id', $pi_income_statement_main_id)->count() > 0){
        foreach ($types as $key => $value) {
          $records = PI_IncomeStatementMetrics::where('pi_income_statement_main_id', $pi_income_statement_main_id)->where('type_id', $value->id)->select('id','value', 'year')->orderBy('year')->get();
          if(count($records) > 0){
              $tables [] = ["type" => $value->name, "currency" => $value->currency->symbol, "records" => array_chunk($records->toArray(), 5)];
          }
        }
      }

      return $tables;
    }


}
