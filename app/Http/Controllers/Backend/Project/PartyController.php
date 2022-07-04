<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Project\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class PartyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $project=Project::find($id);

        // Check specific permissions
        if (Auth::user()->canAccessParties($project) === false) {
            return redirect('dashboard');
        }

        $parties=$project->parties()->get();
        $entities=Entity::whereNotIn('id', function ($query) use ($id) {
            $query->select('entity_id')
                ->from('entity_project')
                ->where('project_id', $id);
        })->get();

        /*$sponsors = $project->sponsor()->get();*/
        $project->load('projectInformation.sponsor');

        /**
         * COORDINATORS ASSIGNED TO THE PROJECT
         */
        $hasCoordinators = \App\User::join('permission_user_project','user_id','=','users.id')
            ->join('roles','role_id','=','roles.id')
            ->where('project_id',$project->id)
            ->where('roles.name','role_data_entry_project_coordinator')->count();

        return view('back.project.parties', compact('project', 'parties', 'entities', 'hasCoordinators'));
    }

    public function store(Request $request)
    {
        //TODO: requestvalidator
        DB::beginTransaction();

        try {
            $party=new Entity();
            $party->name=$request->name;
            $party->description=$request->description;
            $party->facebook=$request->facebook;
            $party->twitter=$request->twitter;
            $party->instagram=$request->instagram;
            $party->url=$request->url;
            $party->draft=1;
            $party->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect('/entities/')->withErrors('msg', __("messages.error_save"));
        }
        return redirect('/entities/')->with('status', __("messages.success_save"));
    }

    public function update($id, Request $request)
    {
        $project = Project::find($id);

        $party_id=$request->get('party');
        $entity=$project->entities()->where('entity_id', $party_id)->first();

        $party = Entity::select('name')->where('id',$party_id)->first();

        //TODO: requestvalidator
        DB::beginTransaction();
        try {
            if ($entity!== null) {
                $entity->pivot->party=1;
                $entity->pivot->save();
            } else {
                $entity = $project->entities()->attach($party_id, ['sponsor' => 0,'party' => 1]);
            }

            DB::commit();

            $rel = DB::table('entity_project')->get();

            activity()->log('updated');
            $activity_project = Activity::all()->last();
            $activity_project->subject_id = $rel->last()->id;
            $activity_project->subject_type = 'App\Models\Project\Entity';
            $attr = [
                'attributes' => [
                    'name' => $party->name
                ],
                'old' => [
                    'name' => ''
                ],
            ];
            $activity_project->properties = $attr;

            $activity_project->save();


        } catch (\Exception $e) {
            DB::rollback();

            return redirect('/project/'.$id.'/parties')->withErrors('msg', __("messages.error_save"));
        }
        return redirect('/project/'.$id.'/parties')->with('status', __("messages.success_save"));
    }


    public function delete(Request $request)
    {
        $flag = ["status" => true, "message" => ""];

        $project = Project::find($request->get('project_id'));

        /*if ($party->sponsor == 1) {
            $party->party = 0;
            $party->save();
        } else {
            $party->delete();
        }

        dd($party);*/

        try {
            DB::beginTransaction();

            $part = $project->entities()->newPivotStatement()
                ->where('entity_id',$request->get('entity_id'))
                ->where('project_id',$request->get('project_id'));

            $id = $part->first()->id;

            $part->delete();

            DB::commit();

            activity()->log('deleted');
            $activity_project = Activity::all()->last();
            $activity_project->subject_id = $id;
            $activity_project->subject_type = 'App\Models\Project\Entity';
            $activity_project->save();


        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: PartyController@delete[".$request->get('id')."]".PHP_EOL.
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


    public function publish(Request $request)
    {
        DB::beginTransaction();
        try {
            $entity=Entity::find($request->id);
            $entity->publish=1;
            $entity->draft=1;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect('/entities/')->withErrors('msg', __("messages.error_publish"));
        }

        return redirect('/entities/')->with('status', __("messages.success_save"));
    }
}
