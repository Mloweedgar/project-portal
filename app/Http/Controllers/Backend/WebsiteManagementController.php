<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\AboutPPPStoreRequest;
use App\Http\Requests\ContactInfoStoreRequest;
use App\Http\Requests\SliderPageStoreRequest;
use App\Models\Config;
use App\Models\Graph;
use App\Models\GraphPos;
use App\Models\GraphTypes;
use App\Models\Media;
use App\Models\Sector;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Stage;
use App\Models\Theme;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerPageStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Array_;

class WebsiteManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_it');
    }

    public function sliderIndex()
    {

        $sliders = Slider::all();

        foreach($sliders as $slider){
            $slider->image = Media::where('project', '0')->where('section', 's')->where('position', $slider->id)->first();
        }

        $samples= Media::where('section','sample-sl')->get()->pluck('name');

        return view('back.sliders', compact('sliders', '$sliders','samples'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sliderStore(SliderPageStoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $flag["status"] = trans('sliders.sucess-create');

            // Create and populate the data
            $slide = new Slider;
            $slide->name = $request->input('name');
            $slide->description = $request->input('description');
            $slide->url = $request->input('url');
            $slide->white = $request->input('white');
            $active = $request->input('active');

            if ($active == 'on') {
                $slide->active = true;
            } else {
                $slide->active = false;
            }

            // Save the data to the database
            $slide->save();

            // Check if gallery

            if ($request->input('img')){

                $this->removeMedia('s', $slide->id);

                $file_array = explode("/",$request["img"]);
                $file_name = end($file_array);

                $dbFile = new Media();
                $dbFile->name = $file_name;
                $dbFile->old_name = $file_name;
                $dbFile->extension = "jpeg";
                $dbFile->mime_type = "image/jpeg";
                $dbFile->project = 0;
                $dbFile->section = "s";
                $dbFile->path = $request["img"];
                $dbFile->position = $slide->id;
                $dbFile->uniqueToken = str_random(22);

                $dbFile->save();

            } else {

                // Remove all but the latest



            }

            // all good
            DB::commit();

        }catch(\Exception $e){
            // something went wrong
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();
        }


        return redirect('/sliders/')->with('status', __("messages.success_save"));

    }

    public function getProjectInfo(Request $request){

      $this->validate($request, ['project_id' => 'required | integer']);

      $id=$request->input('project_id');


      $project=Project::find($id)->load('projectInformation');


      return $project;
    }



    private function removeMedia($section, $position){

        $media = Media::where('section', $section)->where('position', $position)->first();

        if ($media) {

            try {
                $media_path = "../storage/app/" . $media->path;
                unlink($media_path);
                rmdir('../storage/app/vault/0/'.$section.'/'.$position);
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

    public function sliderEdit(SliderPageStoreRequest $request)
    {

        //TODO: TRANSANCTIONAL
        // Create and populate the data
        $slide = Slider::find($request->input('id'));

        $slide->name = $request->input('name');
        $slide->description = $request->input('description');
        $slide->url = $request->input('url');
        $slide->white = $request->input('white');

        if ($request->input('img')){

            DB::beginTransaction();

            $file_array = explode("/",$request["img"]);
            $file_name = end($file_array);

            $dbFile = new Media();
            $dbFile->name = $file_name;
            $dbFile->old_name = $file_name;
            $dbFile->extension = "jpeg";
            $dbFile->mime_type = "image/jpeg";
            $dbFile->project = 0;
            $dbFile->section = "s";
            $dbFile->path = $request["img"];
            $dbFile->position = $request->input('id');
            $dbFile->uniqueToken = str_random(22);

            $dbFile->save();

            DB::commit();

        }

        $slide->save();

        return redirect('/sliders/')->with('status', __("messages.success_save"));


    }

    public function sliderRemove(Request $request)
    {
        $flag = ["status" => true, "message" => ""];
        $slide = Slider::find($request->input('id'));


        if (!$slide->active || Slider::where('active', 1)->count() > 1) {
            //remove the image
            $this->removeMedia('s', $slide->id);

                //remove the slide
                $slide->delete();

            } else {
                $flag["status"] = false;
                $flag["message"] = __('sliders.error_one_active');
            }


            return $flag;


    }


    public function sliderActive(Request $request){

        $this->validate($request, [
            'id' => 'required | integer'
        ]);

        $flag = ["status" => true, "message" => ""];

        $slide = Slider::find($request->input('id'));


        $active= $request->input('active')=="true" ;

        $slide->active = $active;

        if ($active || Slider::where('active', 1)->count() > 1){

            if ($active){
                $flag["message"] = trans('sliders.sucess-activate');
            } else {
                $flag["message"] = trans('sliders.sucess-deactivate');
            }

            $slide->save();
        }else{
            $flag["status"] = false;
            $flag["message"] = __("sliders.error_one_active");
        }

        return $flag;
    }


    public function bannerIndex()
    {

        $banners = Banner::all();

        foreach($banners as $banner){
            $banner->image = Media::where('project', '0')->where('section', 'b')->where('position', $banner->id)->first();
        }






        return view('back.banners', compact('banners'));

    }

    public function bannerStore(BannerPageStoreRequest $request)
    {

        //TODO: TRANSANCTIONAL
        // Create and populate the data
        $banner = new Banner;
        $banner->name = $request->input('name');
        $banner->description = $request->input('description');
        $banner->url = $request->input('url');

        if($request->input('active')){
            $active=true;
        }else{
            $active=false;
        }

        if($active){
            $bannerActive = Banner::where('active',1)->get();
            foreach($bannerActive as $b){
                $b->active=0;
                $b->save();
            }
        }

        $banner->active=$active;
        // Save the data to the database

        $banner->save();

        return redirect('/banners/')->with('status', __("messages.success_save"));

    }

    public function bannerEdit(BannerPageStoreRequest $request)
    {
        //TODO: TRANSANCTIONAL
        // Create and populate the data
        $banner = Banner::find($request->input('id'));
        $banner->name = $request->input('name');
        $banner->description = $request->input('description');
        $banner->url = $request->input('url');

        // Save the data to the database
        $banner->save();

        return redirect('/banners/')->with('status', __("messages.success_save"));

    }

    public function bannerActive(Request $request){

        $this->validate($request, [
            'id' => 'required | integer'
        ]);

        $flag = ["status" => true, "message" => ""];
        $id=$request->input('id');



        $banner = Banner::where('active',1)->get();
        foreach($banner as $b){
            $b->active=0;
            $b->save();
        }


        $banner = Banner::find($id);


        $active= $request->input('active')=="true" ;

        $banner->active = $active;


        if(!$banner->save()){
            $flag["status"] = false;
            $flag["message"] = __("sliders.error_one_active");
        }

        return $flag;
    }



    public function bannerRemove(Request $request)
    {
        $flag = ["status" => true, "message" => ""];
        $id=$request->input('id');
        $banner = Banner::find($id);

        $this->removeMedia('b', $id);

        if($banner->active){
            $flag["status"]=false;
            $flag["message"]=__('banners.error_one_active');
        }else{
            $banner->delete();
        }


        return $flag;

    }

    /**
     * Footer section
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function footer()
    {
        $aboutppp = DB::table('configs')->select('name', 'value')->where('name', 'aboutppp')->first();
        $homepage = DB::table('configs')->select('name', 'value')->where('name', 'homepage')->first();
        $mail = DB::table('configs')->select('name', 'value')->where('name', 'mail')->first();
        $address = DB::table('configs')->select('name', 'value')->where('name', 'address')->first();
        $phone = DB::table('configs')->select('name', 'value')->where('name', 'phone')->first();
        $linkedin = DB::table('configs')->select('name', 'value')->where('name', 'linkedin')->first();
        $facebook = DB::table('configs')->select('name', 'value')->where('name', 'facebook')->first();
        $twitter = DB::table('configs')->select('name', 'value')->where('name', 'twitter')->first();
        $instagram = DB::table('configs')->select('name', 'value')->where('name', 'instagram')->first();
        $aboutppp_title = DB::table('configs')->select('name', 'value')->where('name', 'aboutppp_title')->first();
        $address_link = DB::table('configs')->select('name', 'value')->where('name', 'address_link')->first();

        return view('back.footer', compact('aboutppp','homepage','mail','address','phone','linkedin','facebook','twitter','instagram','aboutppp_title','address_link'));
    }

    public function aboutPPPEdit(AboutPPPStoreRequest $request)
    {
        $aboutppp = Config::where('name', 'aboutppp')->get()->first();
        $aboutppp->value = $request->input('aboutppp');
        $aboutppp->save();
        $aboutppp_title = Config::where('name', 'aboutppp_title')->get()->first();
        $aboutppp_title->value = $request->input('aboutppp_title');
        $aboutppp_title->save();

        return redirect('/footer')->with('status', __("footer.about-ppp-success"));
    }

    public function contactInfoSave(ContactInfoStoreRequest $request)
    {
        // Update elements
        $homepage = Config::where('name', 'homepage')->get()->first();
        $homepage->value = $request->input('homepage');
        $homepage->save();

        $mail = Config::where('name', 'mail')->get()->first();
        $mail->value = $request->input('mail');
        $mail->save();

        $address = Config::where('name', 'address')->get()->first();
        $address->value = $request->input('address');
        $address->save();

        $phone = Config::where('name', 'phone')->get()->first();
        $phone->value = $request->input('phone');
        $phone->save();

        $address_link = Config::where('name', 'address_link')->get()->first();
        $address_link->value = $request->input('address_link');
        $address_link->save();

        return redirect('/footer')->with('status', __("footer.contact-success"));
    }

    public function socialSave(ContactInfoStoreRequest $request)
    {
        // Update elements
        $linkedin = Config::where('name', 'linkedin')->get()->first();
        $linkedin->value = $request->input('linkedin');
        $linkedin->save();

        $facebook = Config::where('name', 'facebook')->get()->first();
        $facebook->value = $request->input('facebook');
        $facebook->save();

        $twitter = Config::where('name', 'twitter')->get()->first();
        $twitter->value = $request->input('twitter');
        $twitter->save();

        $instagram = Config::where('name', 'instagram')->get()->first();
        $instagram->value = $request->input('instagram');
        $instagram->save();

        return redirect('/footer')->with('status', __("footer.social-success"));
    }

    public function graphIndex()
    {

        $graphs=Graph::all();
        $pos_groups=GraphPos::distinct()->select('pos_group')->get();

        foreach($pos_groups as $p){
            $p->positions=array();
            $p->positions= GraphPos::where('pos_group', $p->pos_group)->get();

            foreach($p->positions as $g){
                $g->graph=$g->graph()->first();
                $info=$this->getGraphDataBySection($g->graph->section);
                $g->graph->labels=$info['labels'];
                $g->graph->data=$info['data'];


            }


        }

        foreach($graphs as $graph){
           $info=$this->getGraphDataBySection($graph->section);

            $graph->labels=$info['labels'];
            $graph->data=$info['data'];


        }


        $pos= GraphPos::all();
        $primaryColor=new Theme();
        $primaryColor=$primaryColor->getActive()->getPrimaryColor();

        return view('back.graphs', compact('graphs', 'pos', 'primaryColor', 'pos_groups' ));
    }

    private function getGraphDataBySection($section){
        $labels=array();
        $data=array();

        switch($section){
            case 'sectors':
                $sectors=Sector::all();
                foreach ($sectors as $sector){

                    array_push($labels,__('catalogs/sectors.'.$sector->code_lang));
                    array_push($data, $sector->projectsInformationCount());

                }

                break;
            case 'stages':
                $stages=Stage::all();
                $labels=array();
                $data=array();


                foreach ($stages as $stage){
                    array_push($labels, $stage->name);
                    array_push($data, $stage->ProjectInformations()->count());

                }

                break;
        }
        $result['labels']=json_encode($labels);
        $result['data']=json_encode($data);

        return $result;
    }


    public function graphUpdate(Request $request){

        $error=false;
        if(count($request->input('pos')) !== count(array_unique($request->input('pos')))){
            $error=__("graphs.error_different");
        }elseif (count($request->input('pos'))!==Graph::all()->count()){
            $error=__("graphs.empty_positions");

        }else{
            foreach ($request->input('pos') as $id => $value) {
                $pos = GraphPos::find($id);
                $pos->graph_id = $value;
                $pos->save();

            }
        }

        if(!$error) {

            return redirect(route('graphs'))->with('status', __("messages.success_save"));
        }else{
            return redirect(route('graphs'))->withErrors(array($error));
        }





    }

}
