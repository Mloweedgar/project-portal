<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGlobalAnnouncementRequest;
use App\Models\GlobalAnnouncements;
use App\Models\Media;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;

class GlobalAnnouncementsController extends Controller
{
    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_it');
    }

    /**
     * Announcements Management index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.global-announcements.index');
    }

    public function newAnnouncement()
    {
        $next_id = $this->getNextAnnouncementID();
        return view('back.global-announcements.announcement',compact('next_id'));
    }

    public function edit($id)
    {
        $announcement = GlobalAnnouncements::find($id);

        if ($announcement==null){
            return redirect(route('admin.global-announcements'));
        }

        return view('back.global-announcements.announcement',compact('announcement'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {
        $announcements = GlobalAnnouncements::all();
        $datatables =  app('datatables')->of($announcements);

        return Datatables::of($announcements)->make(true);
    }


    public function delete(Request $request)
    {
        $flag = ["status" => true, "message" => ""];

        try {

            $id=$request->input('id');
            $announcement = GlobalAnnouncements::find($id);

            $this->removeMedia('ga', $id);

            $flag["message"]=trans('global-announcements.announcement-delete-success');

            $announcement->delete();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(
                PHP_EOL.
                "|- Action: GlobalAnnouncementsController@delete[".$request->get('id')."]".PHP_EOL.
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

    private function removeMedia($section, $project){

        $media = Media::where('section', $section)->where('project', $project)->first();

        if ($media) {

            try {
                $media_path = "../storage/app/" . $media->path;
                unlink($media_path);
                rmdir('../storage/app/vault/ga/'.$project);
                $media->delete();

            } catch (\Exception $fatal) {

                Log::info(
                    PHP_EOL .
                    "|- Action: WebsiteManagementController@removeMedia" . PHP_EOL .
                    "|- User ID: " . Auth::id() . PHP_EOL .
                    "|- Section: " . $section . PHP_EOL .
                    "|- Line number: " . $fatal->getLine() . PHP_EOL .
                    "|- Message: " . $fatal->getMessage() . PHP_EOL .
                    "|- File: " . $fatal->getFile()
                );

            }
        }

    }

    public function store(CreateGlobalAnnouncementRequest $request){

        $flag = ["status" => true,"message" => "","error" => ""];

        DB::beginTransaction();
        try {

            if ($request->get('id')){
                $announcement = GlobalAnnouncements::find($request->get('id'));
                $flag["message"]= trans('global-announcements.announcement-edit-success');
            } else {
                $announcement = new GlobalAnnouncements();
                $flag["message"]= trans('global-announcements.announcement-create-success');
            }
            $announcement->name = $request->get('name');
            $announcement->description = $request->get('description');

            $announcement->save();

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
        return redirect()->route('admin.global-announcements')->with(["message" => $flag['message'],"status"=>$flag["status"],"error"=>$flag["error"]]);

    }

    public function getNextAnnouncementID()
    {

        $statement = DB::select("show table status like 'global_announcements'");

        $statement = array_map(function ($value) {
            return (array)$value;
        }, $statement);

        return $statement[0]['Auto_increment'];
    }




}
