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
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class DeletedUsersController extends Controller
{

    public $user;


    public function __construct(User $user)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin');

    }


    /**
     * Show the view for creating and updating users.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('back.admin.deleted_users');

    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {

        $deletedUsers = DeletedUser::all();

        $datatables =  app('datatables')->of($deletedUsers);

        return Datatables::of($deletedUsers)->make(true);

    }


}
