<?php

namespace App\Http\Controllers\Backend\Project\PerformanceInformation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\PerformanceInformation\PerformanceAssessmentDeleteRequest;
use App\Http\Requests\Project\PerformanceInformation\PerformanceAssessmentsStoreRequest;
use App\Http\Requests\Project\PerformanceInformation\PerformanceAssessmentsUpdateRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\PerformanceInformation\PI_PerformanceAssessment;
use App\Models\Project\Project;
use App\performance_information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PerformanceAssessmentsController extends Controller
{

    public $project;
    public $performance_assessments;

    public function __construct(Project $project, PI_PerformanceAssessment $performance_assessments)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');

        $this->project = $project;
        $this->performance_assessments = $performance_assessments;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPIPerformanceAssessments($project) === false) {
            return redirect('dashboard');
        }

        if(Auth::user()->isAdmin()){

            $performance_assessments = $this->performance_assessments->where('performance_information_id', $project->performanceInformation->id)->orderBy('position')->get();

        } else {

            $performance_assessments = $this->performance_assessments->where('performance_information_id', $project->performanceInformation->id)->where('published', 1)->orderBy('position')->get();

        }

        $project->load('performanceInformation');

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();


        return view('back.project.performance-information.performance-assessments',compact('project', 'performance_assessments', 'tables', 'hasCoordinators'));
    }

    /**
     * @param OtherFinancialMetricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PerformanceAssessmentsStoreRequest $request)
    {

        $flag = [];

        DB::beginTransaction();
        try {
            $project = Project::findOrFail($request->get('project_id'));

            /*$performance_failure = $this->performance_failure;*/
            /*$this->performance_assessments = new $this->performance_assessments;*/
            $this->performance_assessments->performance_information_id = $project->performanceInformation->id;
            $this->performance_assessments->name = $request->get('title');
            $this->performance_assessments->description = $request->get('description');
            $this->performance_assessments->draft = 1;
            $maxProc = PI_PerformanceAssessment::where('performance_information_id',$project->performanceInformation->id)->orderBy('position','desc')->first();

            if (!$maxProc){

                $this->performance_assessments->position = 1;

            }else{

                $this->performance_assessments->position = $maxProc->position+1;

            }
            $this->performance_assessments->save();

            $flag["status"] = true;
           DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            // Ouuuupsss... something wrong here!
            DB::rollback();

        }
        // Load the view again
        return back()->with($flag);

      }


    /**
     * @param OtherFinancialMetricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PerformanceAssessmentsUpdateRequest $request)
    {

        $flag = [];

        DB::beginTransaction();
        try {

           $this->performance_assessments = $this->performance_assessments->find($request->get('performance_assessment_id'));
           $this->performance_assessments->name = $request->get('title');
           $this->performance_assessments->description = $request->get('description');

           $this->performance_assessments->save();

           $flag["status"] = true;
           DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }


    /**
     * @param OtherFinancialMetricsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(Request $request)
    {

      $flag = [];
      $this->validate($request, [
        'category_name' => 'required|unique:pi_performance_failures_category,name'
      ]);

      DB::beginTransaction();
      try {

        $flag["status"] = true;

        DB::commit();

      } catch (\Exception $e) {

          $flag["error"] = $e->getMessage();

          // Ouuuupsss... something wrong here!
          DB::rollback();

      }

      // Load the view again
      return back()->with($flag);

    }

    /**
     * Remove the specified resource from storage.
     * @param PerformanceAssessmentDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PerformanceAssessmentDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Find
            $this->performance_assessments = $this->performance_assessments->find($request->get('id'));

            // Delete
            $this->performance_assessments->delete();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: ContractMilestonesController@delete[".$request->get('id')."]".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag["status"] = false;
            $flag["error"] = __('errors.internal_error');
        }

        return $flag;
    }

    public function order(Request $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $assessments = PI_PerformanceAssessment::where('performance_information_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($assessments as $assessment){

                $key = array_search($assessment->position,$order);
                $key++;

                if ($assessment->position!=$key){
                    $assessment->position = $key;
                    $assessment->save();
                }


            }

            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again

        return json_encode($flag);

    }

    /**
     * @param ChangeIndividualVisibilityRequest $request
     * @return array
     */
    public function visibility(ChangeIndividualVisibilityRequest $request){

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $project = $request->get('project');
            $position = $request->get('position');

            // Find Project Information
            $data = PI_PerformanceAssessment::where('performance_information_id', $project)->where('id', $position)->first();

            // Update the field
            $visibilityToEdit = filter_var($request->get('visibility'), FILTER_VALIDATE_BOOLEAN);
            $data->published = $visibilityToEdit;

            // Save the data
            $data->save();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            Log::debug($e->getMessage());

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return $flag;

    }

}
