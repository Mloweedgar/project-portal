<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\VisibilityStoreRequest;
use App\Models\Entity;
use App\Models\Location;
use App\Models\Project\Project;
use App\Models\Project\ProjectInformation;
use App\Models\Sector;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;


class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

   public function changeVisibility(VisibilityStoreRequest $request){

       $flag = ["status" => true, "message" => ""];

       //First, check the section and get the required column

       $section = $request->get('section');

       $visible_field = "";

       switch ($section){
           case "i":
               $visible_field="project_information_active";
               break;
           case "cm":
               $visible_field="contract_milestones_active";
               break;
           case "cs":
               $visible_field="contract_summary_active";
               break;
           case "par":
               $visible_field="parties_active";
               break;
           case "g":
               $visible_field="gallery_active";
               break;
           case "pd":
               $visible_field="project_details_active";
               break;
           case "d":
               $visible_field="documents_active";
               break;
           case "a":
               $visible_field="announcements_active";
               break;
           case "pri":
               $visible_field="procurement_active";
               break;
           case "ri":
               $visible_field="risks_active";
               break;
           case "e":
               $visible_field="evaluation_ppp_active";
               break;
           case "fi":
               $visible_field="financial_active";
               break;
           case "gs":
               $visible_field="government_support_active";
               break;
           case "t":
               $visible_field="tariffs_active";
               break;
           case "ct":
               $visible_field="contract_termination_active";
               break;
           case "r":
               $visible_field="renegotiations_active";
               break;
           case "pi":
               $visible_field="performance_information_active";
               break;
           case "dl":
               $visible_field="annual_demmand_active";
               break;
           case "ism":
               $visible_field="income_statements_active";
               break;
           case "kpi":
               $visible_field="key_performance_active";
               break;
           case "pf":
               $visible_field="performance_failures_active";
               break;
           case "pa":
               $visible_field="performance_assessment_active";
               break;
           case "af":
               $visible_field="annual_financial_active";
               break;
           case "tf":
               $visible_field="timeless_financial_active";
               break;
           case "env":
               $visible_field="environment_active";
               break;
           case "aw":
               $visible_field="award_active";
               break;
       }

       $visibility = 0;

       if ($request->input('visibility')=='true'){
           $visibility = 1;
       }

       try {
           DB::beginTransaction();

           if ($section=="d" || $section=="ri" || $section=="e" || $section=="fi" || $section=="gs" || $section=="t" || $section=="ct" || $section=="r" || $section=="env" || $section == "cs" || $section=="aw"){

               DB::table('project_details')->where('id', $request->get('project_id'))->update([$visible_field => $visibility]);

           }else{

               if($section=="dl" || $section=="ism" || $section=="kpi" || $section=="pf" || $section=="pa" || $section=="af" || $section=="tf"){

                   DB::table('performance_information')->where('id', $request->get('project_id'))->update([$visible_field => $visibility]);

               } else {

                   DB::table('projects')->where('id', $request->get('project_id'))->update([$visible_field => $visibility]);

               }


           }

           DB::commit();

       } catch (\Exception $e) {
           Log::error(
               PHP_EOL.
               "|- Action: TaskController@store".PHP_EOL.
               "|- User ID: ".Auth::id().PHP_EOL.
               "|- Line number: ".$e->getLine().PHP_EOL.
               "|- Message: ".$e->getMessage().PHP_EOL.
               "|- File: ".$e->getFile()
           );
           $flag["status"] = false;
           $flag["error"] = __('errors.internal_error');
           DB::rollback();
       }

       return $flag;

   }

    public function changeName(Request $request){

        $flag = ["status" => true, "message" => ""];

        $project = Project::find($request->project_id);

        // Check if the name is unique before

        if (Project::where("name",$request->project_name)->where("id","!=",$request->project_id)->count()>0){

            $flag["message"] = trans("project.save-name-duplicated");
            $flag["status"] = false;

        } else if (strlen($request->project_name)==0) {

            $flag["message"] = trans("messages.empty_name");
            $flag["status"] = false;


        }else{

                try {
                    DB::beginTransaction();

                    $old_name = $project->name;

                    $project->name = strip_tags($request->project_name);
                    $project->save();

                    DB::commit();

                    $flag["message"] = trans("project.save-name-success");

                    activity()->log('updated');
                    $activity_project = Activity::all()->last();
                    $activity_project->subject_id = $project->id;
                    $activity_project->subject_type = 'App\Models\Project\Project';
                    $attr = [
                        'attributes' => [
                            'name' => $old_name
                        ],
                        'old' => [
                            'name' => $project->name
                        ],
                    ];
                    $activity_project->properties = $attr;
                    $activity_project->save();

                } catch (\Exception $e) {
                    Log::error(
                        PHP_EOL.
                        "|- Action: ProjectController@changeName".PHP_EOL.
                        "|- User ID: ".Auth::id().PHP_EOL.
                        "|- Line number: ".$e->getLine().PHP_EOL.
                        "|- Message: ".$e->getMessage().PHP_EOL.
                        "|- File: ".$e->getFile()
                    );
                    $flag["status"] = false;
                    $flag["error"] = __('errors.internal_error');
                    DB::rollback();

                    $flag["message"] = trans("project.save-name-error");

                }

            }
        return $flag;

    }

    public function ocidExists(Request $request)
    {

        return ProjectInformation::where('ocid',$request->get('ocid'))->where('id','!=',$request->get('projectInfo'))->count() ? "false" : "true";
    }


}
