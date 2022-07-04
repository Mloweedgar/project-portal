<?php

namespace App\Http\Controllers\Frontend;
use App;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalAnnouncements;
use App\Models\Project\ProjectDetails\PD_Announcement;
use App\Http\Controllers\Controller;

class GlobalAnnouncementsController extends Controller
{
    public function __construct()
    {
        /*
         * Middleware define
         * It's used to define that all the methods in this controller the user must be authenticated
         */
        /*$this->middleware('auth');*/
    }

    public function index(){

        $data['global_announcements'] = DB::table('global_announcements')->orderBy('updated_at','desc')->paginate(5, ['*'], 'global');

        $announcements_active = App\Models\Section::where('section_code', 'a')->where('active', 1)->first();
        if ($announcements_active) {
            $data['announcements'] = DB::table('pd_announcements')->select('project_details.project_id','pd_announcements.created_at','pd_announcements.name','pd_announcements.description', 'projects.name as projectname')->leftJoin(
                'project_details',
                'project_details.id', '=', 'pd_announcements.project_details_id'
            )
                ->leftJoin('projects', 'projects.id', '=', 'project_details.id')
                ->where('projects.active', 1)
                ->where('projects.announcements_active', 1)
                ->where('pd_announcements.published', 1)
                ->orderBy('pd_announcements.created_at', 'desc')
                ->paginate(5, ['*'], 'project');

        }
        $data['announcements_active'] = $announcements_active;

        return view('front.announcements',$data);

    }

    public function single($slug){

        $data['announcement'] = GlobalAnnouncements::where("slug", $slug)->first();

        if ($data['announcement']){

            $data['media'] = Media::where("section","ga")->where("project",$data['announcement']["id"])->get();

            return view('front.announcements-single',$data);

        } else {

            return abort(404);

        }

    }

}
