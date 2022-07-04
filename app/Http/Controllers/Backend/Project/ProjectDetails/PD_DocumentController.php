<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_DocumentAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_DocumentEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_DocumentDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Document;
use App\Models\Project\ProjectDetails\ProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $pd_document;
    public $project;

    public function __construct(Project $project, PD_Document $pd_document)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->pd_document = $pd_document;

    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id)
    {

        // Check if the project exists
        $project = $this->project->findOrFail($id);

        // Check specific permissions
        if (Auth::user()->canAccessPDDocuments($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_documents
        if($projectDetail){

            if(Auth::user()->isAdmin()){

                $pd_document = PD_Document::where('project_details_id', $projectDetail->id)->orderBy('position')->get();

            } else {

                $pd_document = PD_Document::where('project_details_id', $projectDetail->id)->where('published', 1)->orderBy('position')->get();

            }

        } else {

            $pd_document = null;

        }

        $exists = false;

        if($pd_document){

            $exists = true;

        }

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.projectdetails.pd_document',compact('project', 'projectDetail', 'exists', 'pd_document', 'hasCoordinators'));
    }


    /**
     * @param PD_DocumentAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_DocumentAddRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $document = new PD_Document();
            $document->project_details_id = $request->input('project_details_id');
            $document->name = $request->input('name');
            $document->description = $request->input('description');

            // Draft
            $document->draft = 1;

            $maxProc = PD_Document::where('project_details_id',$request->input('project_details_id'))->orderBy('position','desc')->first();

            if (!$maxProc){

                $document->position = 1;

            }else{

                $document->position = $maxProc->position+1;

            }

            // Save the data to the database
            $document->save();

            //Update the project date
            $document->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }

    /**
     * @param PD_DocumentEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_DocumentEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $document = PD_Document::find($request->input('id'));
            $document->name = $request->input('name');
            $document->description = $request->input('description');

            // Save the data to the database
            $document->save();

            //Update the project date
            $document->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {

            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return back()->with($flag);

    }

    /**
     * @param PD_DocumentDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_DocumentDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $tariffs = PD_Document::find($request->input('id'));

            // Delete
            $tariffs->delete();

            //Update the project date
            $tariffs->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: DocumentController@delete[".$request->get('id')."]".PHP_EOL.
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

    /**
     * @param PD_ProcurementAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function order(Request $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            $documents = PD_Document::where('project_details_id',$request->get('project_id'))->get();
            $order = $request->get('order');

            foreach ($documents as $document){

                $key = array_search($document->position,$order);
                $key++;

                if ($document->position!=$key){
                    $document->position = $key;
                    $document->save();
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
            $data = PD_Document::where('project_details_id', $project)->where('id', $position)->first();

            // Update the field
            $visibilityToEdit = filter_var($request->get('visibility'), FILTER_VALIDATE_BOOLEAN);
            $data->published = $visibilityToEdit;

            // Save the data
            $data->save();

            // If visibility transition was from Draft to Published
            // we perform a touch to the project.
            if($visibilityToEdit){

                // Project PUSH
                $data->projectDetail->project->touch();

            }

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
