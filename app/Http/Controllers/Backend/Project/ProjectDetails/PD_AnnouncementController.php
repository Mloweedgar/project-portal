<?php

namespace App\Http\Controllers\Backend\Project\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\PD_AnnouncementAddRequest;
use App\Http\Requests\Project\ProjectDetails\PD_AnnouncementEditRequest;
use App\Http\Requests\Project\ProjectDetails\PD_AnnouncementDeleteRequest;
use App\Http\Requests\Project\ChangeIndividualVisibilityRequest;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Announcement;
use App\Models\Project\ProjectDetails\ProjectDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PD_AnnouncementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $announcement;
    public $project;

    public function __construct(Project $project, PD_Announcement $announcement)
    {

        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->project = $project;
        $this->announcement = $announcement;
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
        if (Auth::user()->canAccessPDAnnouncements($project) === false) {
            return redirect('dashboard');
        }

        // Check if there are ProjectDetails
        $projectDetail = ProjectDetail::where('project_id', $project->id)->first();

        // IF there are projectDetails, check if there is a record for PD_documents
        if($projectDetail){

            if(Auth::user()->isAdmin()){

                $announcements = PD_Announcement::where('project_details_id', $projectDetail->id)->get();

            } else {

                $announcements = PD_Announcement::where('project_details_id', $projectDetail->id)->where('published', 1)->get();

            }

        } else {

            $announcements = null;

        }

        $exists = false;

        if($announcements){

            $exists = true;

        }

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.projectdetails.pd_announcement',compact('project', 'projectDetail', 'exists', 'announcements', 'hasCoordinators'));
    }


    /**
     * @param PD_AnnouncementAddRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PD_AnnouncementAddRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $announcement = new PD_Announcement();

            $announcement->project_details_id = $request->input('project_details_id');
            $announcement->name = $request->input('name');
            $announcement->description = $request->input('description');

            $datetime = \DateTime::createFromFormat('m/d/Y g:i A', $request->updated_at);
            $announcement->created_at = $datetime->format('Y-m-d H:i:s');
            $announcement->updated_at = $datetime->format('Y-m-d H:i:s');

            // Draft
            $announcement->draft = 0;
            $announcement->published = 1;

            // Save the data to the database
            $announcement->save();

            //Update the project date
            $announcement->projectDetail->project->touch();

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
     * @param PD_AnnouncementEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PD_AnnouncementEditRequest $request)
    {

        $flag = ["status" => true];

        DB::beginTransaction();
        try {

            // Create and populate the data
            $announcement = PD_Announcement::find($request->input('id'));
            $announcement->name = $request->input('name');
            $announcement->description = $request->input('description');

            $datetime = \DateTime::createFromFormat('m/d/Y g:i A', $request->updated_at);
            $announcement->created_at = $datetime->format('Y-m-d H:i:s');

            // Save the data to the database
            $announcement->save();

            //Update the project date
            $announcement->projectDetail->project->touch();

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
     * @param PD_AnnouncementDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PD_AnnouncementDeleteRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();

        try {
            // Create and populate the data
            $announcement = PD_Announcement::find($request->input('id'));

            // Delete
            $announcement->delete();

            //Update the project date
            $announcement->projectDetail->project->touch();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: AnnouncementController@delete[".$request->get('id')."]".PHP_EOL.
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
            $data = PD_Announcement::where('project_details_id', $project)->where('id', $position)->first();

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
