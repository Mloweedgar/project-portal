<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntityStoreRequest;
use App\Models\Entity;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class EntityController extends Controller{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_data_entry_project_coordinator');
    }

    public function index(){
        // Check specific permissions
        if (Auth::user()->canAccessEntities() == false) {
            return redirect('dashboard');
        }

        $entities=Entity::all();

        foreach($entities as $entity){
            $entity->image = Media::where('project', '0')->where('section', 'par')->where('position', $entity->id)->first();
        }

        return view('back.entities.index',compact('entities'));
    }

    public function store(EntityStoreRequest $request){

        DB::beginTransaction();
        try {

          $entity=new Entity();
          $entity->name=$request->name;
          $entity->name_representative = $request->name_representative;
          $entity->address = $request->address;
          $entity->tel = $request->tel;
          $entity->fax = $request->fax;
          $entity->email = $request->email;
          $entity->description=$request->description;
          $entity->facebook=$request->facebook;
          $entity->twitter=$request->twitter;
          $entity->instagram=$request->instagram;
          $entity->url=$request->website;
          $entity->requested_modification=0;
          $entity->published=0;
          $entity->draft=1;
          $entity->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            return redirect('/entities/')->withErrors('msg',__("messages.error_save"));
        }
        return redirect('/entities/')->with('status',__("messages.success_save"));

    }

    public function update(EntityStoreRequest $request){

        DB::beginTransaction();
        try {

            $entity = Entity::find($request->id);
            $entity->name = $request->name;

            $entity->name_representative = $request->name_representative;
            $entity->address = $request->address;
            $entity->tel = $request->tel;
            $entity->fax = $request->fax;
            $entity->email = $request->email;

            $entity->description = $request->description;
            $entity->facebook = $request->facebook;
            $entity->twitter = $request->twitter;
            $entity->instagram = $request->instagram;
            $entity->url = $request->website;

            $type = $request->get('submit-type');

            if($type == 'publish'){
                $entity->published = 1;
                $entity->draft = 0;
            }else if($type == 'save_draft'){
                $entity->draft = 1;
                $entity->published = 0;

            }else if($type == 'request_modification'){
                $entity->request_modification = 1;
            }
            $entity->save();
            DB::commit();

        }catch(\Exception $e){

            DB::rollback();
            return redirect('/entities/')->withErrors('msg',__("messages.error_save"));
        }
        return redirect('/entities/')->with('status',__("messages.success_save"));
    }

    public function publish(Request $request){
      DB::beginTransaction();
      try{
        $entity=Entity::find($request->id);
        $entity->publish=1;
        $entity->draft=0;
        DB::commit();
      }catch(\Exception $e){
        DB::rollback();

        return redirect('/entities/')->withErrors('msg',__("messages.error_publish"));
      }

      return redirect('/entities/')->with('status',__("messages.success_save"));
    }

    public function delete(Request $request){

        $flag= ["status" => true, "message" => ""];
        $id=$request->input('id');
        $entity=Entity::find($id);

        if(!$entity->hasProjects()){
          DB::beginTransaction();
          try {

              $media = Media::where('section', 'par')->where('position', $id)->first();

              if ($media) {

                  try {
                      $media_path = "../storage/app/" . $media->path;
                      unlink($media_path);
                      rmdir('../storage/app/vault/0/par/'.$id);
                      $media->delete();

                  } catch (\Exception $fatal) {

                      Log::info(
                          PHP_EOL .
                          "|- Action: WebsiteManagementController@removeMedia" . PHP_EOL .
                          "|- User ID: " . Auth::id() . PHP_EOL .
                          "|- Section: " . $media->section . PHP_EOL .
                          "|- Line number: " . $fatal->getLine() . PHP_EOL .
                          "|- Message: " . $fatal->getMessage() . PHP_EOL .
                          "|- File: " . $fatal->getFile()
                      );

                  }
              }
              $entity->delete();
              DB::commit();

          }catch(\Exception $e){
              DB::rollback();
              $flag["status"]=false;
              $flag["message"]=__("entity.error_delete");

          }
        }else{
            $flag["status"]=false;
            $flag["message"]=__("entity.error_delete_has_projects");
        }
      return $flag;
    }
}
