<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntityStoreRequest;
use App\Models\Entity;
use App\Models\Media;
use App\Models\Role;
use App\Models\Section;
use App\Models\Sector;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectCoordinatorController extends Controller{

  public function __construct(){

    $this->middleware('auth');

    $this->middleware('role:role_data_entry_project_coordinator');

  }


  public function index(){

    $data = [];
    $data["sectors"] = Sector::all();
    $data["roles"] = Role::all();

    $data["sections"] = $sections = Section::all()->toArray();

    //Split the sections into half in order to organize the permissions table.
    $data["sectionsPart1"] = array_slice($sections, 0, 11);
    $data["sectionsPart2"] = array_slice($sections, 11, 21);


    $id = Auth::user()->id;

    $data["sections"] = $sections =  Section::whereDoesntHave('usersPermissions', function($query) use($id) {
        $query->where('user_id', $id);
    })->get();

    $data["project_coordinator"] = $project_coordinator = Auth::user()->load('projectsPermissions', 'sections', 'sectors')->toJson();



    return view('back.role-management.project_coordinator')->with($data);



  }
  /**
   * Process datatables ajax request.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function table(Request $request)
  {


    $users = Auth::user()
    ->select([
      'users.id',
      'users.name',
      'users.email',
      \DB::raw('entities.name as entity'),
      'users.telephone',
      \DB::raw('roles.alias as role'),
      'users.created_at',
      'users.inactive',
      \DB::raw('entities.id as entity_id'),
      \DB::raw('roles.id as role_id'),
      \DB::raw('prefixes.dial_code as dial_code'),
      \DB::raw('roles.name as role_name'),
    ])->join('entities','users.entity_id','=','entities.id')
      ->join('roles','users.role_id','=','roles.id')
      ->join('prefixes','users.prefix_id','=','prefixes.id')
      ->join('coordinator_assigned_data_entries', 'coordinator_assigned_data_entries.de_generic_id', 'users.id')
      ->where('coordinator_assigned_data_entries.project_coordinator', Auth::user()->id);

    /*$users->whereHas(['data_entries' => function($query){
      $query->where('id', 1);

    }]);*/

    $datatables =  app('datatables')->of($users);

    return $datatables->make(true);

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateDataEntry(Request $request)
  {
      $this->validate($request, ['user_id' => 'required|exists:users,id']);

      $flag = ["status" => true, "message" => ""];

      DB::beginTransaction();
      try {



          $user = User::find($request->get('user_id'));
          $project_coordinator = Auth::user();

          $role = $user->role->name;

          /*
           * Attach user permissions
           */

          /*
           * Attach user permissions
           * 1 Sectors
           * 2 Projects
           */



          $sections = Auth::user()->sections();

          $user->sections()->sync($request->get('sections'));

          /* Sectors */
          if($user->permission == 1){

            //Validate if the user has selected an invalid sector.
            $sectors = array_intersect ( $this->getIds($project_coordinator->sectors), $request->get('sectors'));
            $user->sectors()->sync($sectors);


          }
          /* Projects */
          else if($user->permission == 2) {

            $projects = array_intersect ( $this->getIds($project_coordinator->projectsPermissions), $request->get('projects'));
            $user->projectsPermissions()->sync($projects);

          }

          $user->save();


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

    public function getIds($collection){

      $arr = [];

      foreach ($collection as $value) {

        $arr[] = $value->id;
      }

      return $arr;
    }





}
