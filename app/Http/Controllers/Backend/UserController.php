<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Entity;
use App\Models\Prefix;
use App\Models\Project\Project;
use App\Models\Role;
use App\Models\Section;
use App\Models\Sector;
use App\Models\User\DeletedUser;
use App\User;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; 

class UserController extends Controller
{

    public $user;

    public $procurementSectionsIds = [1, 2, 3, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 23];
    public $performanceSectionsIds = [2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 21, 22];

    public function __construct(User $user)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin', ['except' => ['findPermissions', 'passwordChange', 'storePassword']]);

        $this->user = $user;

    }


    /**
     * Show the view for creating and updating users.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $sectors = Sector::all();
        $roles = Role::all();
        $entities = Entity::all();
        $sections = Section::all()->toArray();

        //Split the sections into half in order to organize the permissions table.
        $sectionsPart1 = array_slice($sections, 0, 11);
        $sectionsPart2 = array_slice($sections, 11, 22);



        /*
         * Get the current language
         * Get just the two frist characters of the language, for example:
         * es-ES get just es.
         */
        $locale = substr(\App::getLocale(), 0, 2);

        /*
         * Get the list of countries using the current language.
         * Change the key to lower in order to work with the international input and
         * change the countries language.
         * json_decode convert the json given by the country class to an array
         * json_encode convert the array again to json
         */
        $countries = array_change_key_case(json_decode(\Countries::getList($locale, 'json'), true), CASE_LOWER);
        $countries = json_encode($countries);


        return view('back.role-management.users', compact(
            'sectors', 'roles', 'entities',
            'sectionsPart1', 'sectionsPart2', 'countries'));

    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {

        $users = $this->user->select([
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
            ->leftJoin('prefixes','users.prefix_id','=','prefixes.id');

        $datatables =  app('datatables')->of($users);

        return Datatables::of($users)->make(true);

    }

    /**
     * Remote validation to check if the email exists
     *
     * @param  Request $request
     * @return boolean
     */
    public function emailExists(Request $request)
    {
        return $this->user->where('email', $request->get('email'))->count() ? "false" : "true";
    }

    /**
     * Remote validation to check if the email exists
     *
     * @param  Request $request
     * @return boolean
     */
    public function emailExistsEdit(Request $request)
    {
        $userExists = $this->user->find($request->get('user_id'));
        if($request->get('email') == $userExists->email){
            return "true";
        }

        return $this->user->where('email', $request->get('email'))->count() ? "false" : "true";
    }

    /**
     * Inactivate the user - POST method
     *
     * @return \Illuminate\Http\Response
     */
    public function inactive(Request $request)
    {
        $this->user = $this->user->find($request->get('id'));
        $this->user->inactive = $request->get('inactive') == 1 ? 0 : 1;

        if($this->user->inactive === 0){
            $newPass = generatePassword();
            $this->user->password = $newPass;
            $this->user->password_updated_at = Carbon::now()->toDateTimeString();
            $this->user->save();
            return ["status" => true, "message" => "", "newPass" => $newPass];
        }

        $this->user->save();

    }


    /**
     * Store a new user. @STORE
     *
     * @param  Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();
        try {
            $password = generatePassword(8);
            $flag["password"] = $password;
            $user = $this->user;
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->telephone = $request->get('telephone');
            $user->entity_id = $request->get('entity');
            $user->role_id = Role::where('name', $request->get('role'))->first()->id;
            $user->password = $password;

            if($request->get('telephone')){
                $user->prefix_id = Prefix::where('iso', $request->get('country'))->first()->id;
            }

            $user->save();
            $role = $request->get('role');

            $sections = $request->get('sections');
            $projects = $request->get('projects');


            /*
             * Attach user permissions
             * If the role is admin don't attach any permissions
             */


            if($role != 'role_admin' && $role != 'role_it' && $role != 'role_auditor'){

                /* Attach sections */

                foreach ($sections as $value) {
                    $user->sections()->attach($value);
                }
                /* Attach projects */

                foreach ($projects as $value) {
                    $user->projectsPermissions()->attach($value);
                }

            }


            $user->save();

            $emailData = [
                "password" => $password,
                "email" => $user->email,
                "name" => $user->name,
                "subject" => trans('emails/registration_email.subject')
            ];
            
            Mail::send('back.emails.user.registrationEmail', $emailData, function ($message) use ($user) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject(trans('emails/registration_email.subject'));
                $message->to($user->email);
            });


            if(count(Mail::failures()) > 0){
                throw new \Exception(trans('user.mail_error'));
            }

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
     * Find a user by role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Eloquent
     */
    public function findByRole(Request $request)
    {
        $data = ["status" => true, "message" => ""];

        $this->validate($request, ['role_id' => 'required']);

        try {
            $rolesId = Role::where('name', $request->get('role_id'))->select('id')->get()->toArray();

            $data["data"] = $this->user->whereIn('role_id', $rolesId)->select('email', 'name', 'id')->get();
        }
        catch (\Exception $e) {
            $data["status"] = false;
            $data["error"] = $e->getMessage();
        }

        return $data;
    }

    /**
     * Find a user by role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Eloquent
     */
    public function findByRoleAndAdmin(Request $request)
    {
        $data = ["status" => true, "message" => "", "data" => ""];

        $this->validate($request, ['role_id' => 'required']);

        try {

            $data["data"] = $rolesUsers = Role::whereIn('name' ,[$request->get('role_id'), 'role_admin'])->with('users.role')->get();


        }
        catch (\Exception $e) {
            $data["status"] = false;
            $data["error"] = $e->getMessage();
        }


        return $data;
    }

    /**
     * Find user permissions
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Eloquent
     */
    public function findPermissions( Request $request )
    {
        $flag = ["status" => true, "message" => ""];

        $this->validate($request, ['user_id' => 'required|exists:users,id']);

        try {

            $flag["data"] = $this->user->find($request->get('user_id'))->load('sections', 'projectsPermissions');
        }
        catch (\Exception $e) {
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
        }

        return $flag;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {

        $this->validate($request, ['user_id' => 'required|exists:users,id', 'email' => 'required']);

        if($request->get('email') != $this->user->find($request->get('user_id'))->email){
            $this->validate($request, ['email' => 'unique:users']);
        }

        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();
        try {

            $user = $this->user->find($request->get('user_id'));
            /*return $user;*/
            $user->name = $request->get('name');
            $user->email = $request->get('email');

            $user->telephone = $request->get('telephone');
            $user->entity_id = $request->get('entity');

            $user->role_id = Role::where('name', $request->get('role'))->first()->id;

            if($request->get('telephone')){
                $user->prefix_id = Prefix::where('iso', $request->get('country'))->first()->id;
            }

            $role = $user->role->name;

            if($role != 'role_admin'){

                $user->sections()->sync($request->get('sections'));
                $user->projectsPermissions()->sync($request->get('projects'));
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

    function getSyncUpdated($data){
        return (count($data["attached"]) + count($data["detached"]) + count($data["updated"])) > 0 ? true : false;

    }
    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $this->validate($request, ['user_id' => 'required|exists:users,id']);

        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();
        try {

            $user = $this->user->find($request->get('user_id'));

            $deleted = new DeletedUser();
            $deleted->email = $user->email;
            $deleted->description = $request->get('description');
            $deleted->save();


            $role = Role::where('id', $user->role_id)->first()->name;
            /**
             * If if the information was assign to an other user.
             */
            if($request->get('deleteType') == 2){

                $user_assigned = $this->user->find($request->get('user_assign'));


                /*Assign all the related projects to the user*/
                foreach ($user->projects as $project) {
                    $project->user_id = $user_assigned->id;
                    $project->save();
                }

            }

            $user->save();

            /*return "Hello";*/

            /*Delete records*/
            $user->projectsPermissions()->sync([]);
            $user->sections()->sync([]);
            $user->tasks()->delete();

            $user->delete();

            /*return $user;*/

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
     * Change password view
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function passwordChange()
    {
        return view('back.user.password');
    }


    /**
     * Change password functionality.
     *
     * @return \Illuminate\Http\Response
     */
    public function storePassword(ChangePasswordRequest $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {
            DB::beginTransaction();

            if (Auth::attempt(['email' => Auth::User()->email, 'password' => $request->get('current_password')]))
            {
                $password = $request->get('password');

                /**
                 * Checking password complexity:
                 *   Min 8 characteres
                 *   At least one lower case
                 *   Atleast one upper case
                 *   At least one digit
                 *   At least one special char
                 */
                if(!preg_match("/(?=.*[a-z]).*(?=.*[A-Z]).*(?=.*\d).*(?=.*[-!@#$%^&*()_=+?]).{8,}/", $password))
                    return redirect()->route('change-password')->with(["changed" => "password-insecure"]); 

                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = $password;
                $obj_user->save();
            } 
            else 
                return redirect()->route('change-password')->with(["changed" => "password-mismatch"]); 

            DB::commit();

            return redirect()->route('change-password')->with(["changed" => "success"]);

        } catch (\Exception $e) {
            Log::error(
                PHP_EOL.
                "|- Action: UserController@store".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag["status"] = false;
            $flag["error"] = __('errors.internal_error');
            DB::rollback();
        }

    }

    /**
     * Find a user by role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Eloquent
     */
    public function findDataEntriesGeneric(Request $request)
    {
        $data = ["status" => true, "message" => ""];

        $this->validate($request, ['project_coordinator_id' => 'required']);

        try {


            $rolesId = Role::where('name', 'role_data_entry_generic')->select('id')->get()->toArray();

            $data["users"] = $this->user->whereIn('role_id', $rolesId)->whereDoesntHave('data_entries')->select('email', 'name', 'id')->get();
            $data["assigned"] = $this->user->find($request->get('project_coordinator_id'))->projectCoordinatorDataEntries;

        }
        catch (\Exception $e) {
            $data["status"] = false;
            $data["error"] = $e->getMessage();
        }

        return $data;
    }

}
