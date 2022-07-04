<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\RolesPermissionsRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesPermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:role_admin');
    }

    /**
     * Index page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {

        $roles= Role::all();

        return view('back.role-management.rolespermissions', compact('roles'));
    }

    /**
     * Saves an edition
     * @param RolesPermissionsRequest $request
     * @return array
     */
    public function save(RolesPermissionsRequest $request){

        $flag = ["status" => true, "message" => trans("roles-permissions.edit-success")];

        //1st - Get the role

        $role = Role::find($request->id);

        DB::beginTransaction();

        try {

            $role->alias = $request->alias;
            $role->description = $request->description;
            $role->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $flag = ["status" => false, "message" => trans("roles-permissions.edit-error")];

        }

        return $flag;


    }

    public function delete(Request $request)
    {
        $flag = ["status" => true, "message" => trans('roles-permissions.delete-success')];

        DB::beginTransaction();

        try {

            $role = Role::find($request->id);

            // Delete
            $role->delete();

            // Commit the changes
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $flag = ["status" => false, "message" => trans('roles-permissions.delete-error')];
        }

        return $flag;
    }

    public function saveNew(Request $request){

        $status = false;

            $role = new Role();

            $role->alias = $request->alias;
            $role->name = $request->name;
            $role->description = $request->description;

            if ($role->save()){
                $status = true;
            }


        return redirect(route('roles.roles-permissions'))->with('status',$status);

    }

    public function checkRole(Request $request){

        $flag = "true";

        if (Role::where("alias",$request->alias)->first()){
            $flag = "false";
        }

        echo $flag;

    }


}
