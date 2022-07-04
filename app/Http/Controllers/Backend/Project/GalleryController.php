<?php

namespace App\Http\Controllers\Backend\Project;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploaderController;
use App\Models\Media;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $project=Project::find($id);


        // Check specific permissions
        if (Auth::user()->canAccessGallery($project) === false) {
            return redirect('dashboard');
        }


        $dirs = array_filter(glob('../public/img/samples/gallery/*'), 'is_dir');

        $samples= array();
        foreach ($dirs as $dir){
            $samples[basename(($dir))]=array_diff(scandir($dir), array('..','.'));
        }



        $project_path="../storage/app/public/img/p/".$this->get_project_path($id).'g/';


        $images=Media::where('section', 'g')->where('project', $project->id)->get();


        return view('back.project.gallery',compact('project', 'samples' , 'images'));
    }

    public function remove(Request $request){


        $this->validate($request, [
            'id' => 'required|integer',
            'project_id' => 'required|integer'
        ]);

        $flag = ["status" => true, "message" => ""];

        $id=$request->input('id');
        $project_id=$request->input('project_id');
        $media=Media::find($id);

        $remove=explode('/',$media->path)[1];


        if($media && $remove=='vault'){

            $media_path="../storage/app/".$media->path;

            if(unlink($media_path)){
                $media->delete();
            }else{
                $flag["status"] = false;
                $flag["error"] = "gallery.error_delete_image";
            }

        }else{
            if($media && $remove!='vault'){
                $media->delete();

            }else{
                $flag["status"] = false;
                $flag["error"] = "gallery.error_delete_image";

            }

        }

        return $flag;


    }

    public function addFile(){
        return back();
    }


    public function addFromGallery(Request $request){


        $this->validate($request, [
            'project_id' => 'required|integer',
            'img' => 'required',
            'sector' => 'required'
        ]);

        $img=$request->input('img');
        $sector=$request->input('sector');
       $path="../public/img/samples/gallery/".$sector."/".$img;
       $project_id=$request->input('project_id');

       $position=$this->getNextPosition($project_id);
        $project_path=$this->get_project_path($project_id);
        $dest_folder='../storage/app/vault/'.$project_path.'g/'.$position.'/';
        $extension=pathinfo(basename($img), PATHINFO_EXTENSION);
        $new_name=uniqid();


        $media=new Media();
        $media->name=$new_name;
        $media->old_name=pathinfo(basename($img), PATHINFO_FILENAME);
        $media->extension=$extension;
        $media->mime_type=mime_content_type($path);
        $sizes=getimagesize($path);
        $media->width=$sizes[0];
        $media->height=$sizes[1];
        $media->path="/vault/".$project_path.'g/'.$position.'/'.$new_name.'.'.$extension;
        $media->section='g';
        $media->project=$project_id;
        $media->position=$position;
        $media->save();

        if(!file_exists($dest_folder)) {
            mkdir($dest_folder, 0777, true);
        }
        copy($path, $dest_folder.$new_name.'.'.$extension);
        return redirect('/project/'.$project_id.'/gallery')->with('success', __("messages.success_save"));

    }

    private function get_project_path($project_id){
        $array = str_split($project_id) ;
        $project_path ='';

        foreach($array as $arr){
            $project_path=$arr.'/';
        }
        return $project_path;
    }
    private function getNextPosition($project_id){

        $statement = DB::table('media')
            ->where('project', $project_id)
            ->where('section', 'g')
            ->max('position');

        return $statement+1;

    }




}
