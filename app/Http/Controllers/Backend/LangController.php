<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Lang;
use App\Models\LangField;
use App\Models\LangFile;
use App\Models\LangValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LangController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:role_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $languages = Lang::all()->where('available', 1);
        $sections = DB::table('lang_files')->select('id', 'name')->get();
        $newlangs = Lang::all()->where('available', 0);
        return view('back.langs.lang', compact('languages', 'sections', 'newlangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, ['id' => 'required | integer']);

        $flag = array('status' => true, 'message' => "");

        DB::beginTransaction();

        try {

            $id = $request->input('id');
            $lang = Lang::find($id);
            $lang->available = 1;
            $lang->save();
            $defaultLang = Lang::where('default',1)->first();
            $files = LangFile::all();


            foreach ($files as $file) {

                $fields = $file->fields()->where('parent_id', 0)->where('lang_id', $defaultLang->id)->get();

                foreach ($fields as $field) {
                    $langField = new LangField();
                    $langField->file_id = $file->id;
                    $langField->lang_id = $lang->id;
                    $langField->name = $field->name;
                    $langField->value = null;
                    $langField->attribute = $field->attribute;

                    $langField->parent_id=0;


                    $langField->save();


                    if(count($field->childrens()->get()) >0){
                        $this->saveChildrens($file, $lang, $field->id, $langField->id);
                    }
                }

            }

            DB::commit();
        } catch (\Exception $e) {
            $flag['status'] = false;
            $flag['message'] = __('langs.save_error');
            DB::rollback();

            Log::info(
                PHP_EOL .
                "|- Action: LangController@create" . PHP_EOL .
                "|- User ID: " . Auth::id() . PHP_EOL .
                "|- Line number: " . $e->getLine() . PHP_EOL .
                "|- Message: " . $e->getMessage() . PHP_EOL .
                "|- File: " . $e->getFile()
            );


        }

        return $flag;

    }

    /**
     * Recursive function to save the childrens of a /App/Models/LangField
     *
     * @params \App\Models\LangFile, \App\Models\Lang, parent field in default language, new parent field
     * @return \Illuminate\Http\Response
     */

    private function saveChildrens($file, $lang, $oldParentId, $newParentId){
        $fields = $file->fields()->where('parent_id',$oldParentId)->get();

        foreach ($fields as $field) {
            $langField = new LangField();
            $langField->file_id = $file->id;
            $langField->lang_id = $lang->id;
            $langField->name = $field->name;
            $langField->value = null;
            $langField->attribute = $field->attribute;

            $langField->parent_id=$newParentId;


            $langField->save();


            if(count($field->childrens()->get()) >0){
                $this->saveChildrens($file, $lang, $field->id, $langField->id);
            }

        }

        return true;
    }


    /**
     * Active a language for the website.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function active(Request $request){
        $this->validate($request, ['lang' => 'integer | required']);

        $lang=Lang::where('active', 1)->get();

        foreach($lang as $l){
            $l->active=0;
            $l->save();
        }

        $id=$request->input('lang');
        $lang=Lang::find($id);
        $lang->active=1;
        $lang->save();
        $langDefault=Config::where('name','lang_default')->first();
        $langDefault->value = $lang->iso;
        $langDefault->save();
        $config=Config::where('name','lang_updated')->first();
        $config->value=Carbon::now()->format('Y-m-d H:i:s');
        $config->save();


        return redirect('langs/')->with('status', '__(messages.success_saved)');
    }


    private function createFile($lang, $file_id)
    {

        $file = LangFile::find($file_id);
        $parentFields = LangField::getParentFields()->where('file_id', $file->id)->where('lang_id', $lang->id)->get();

        $path = '../resources/lang/' . $lang->iso . '/' . $file->path;


        $errors = array();

        if (!file_exists($path)) {
            mkdir($path);
        }
        $tmpFile = $path . $file->name . '.tmp';
        $myfile = fopen($tmpFile, "w");


        $content = "<?php" . PHP_EOL . " return [" . PHP_EOL;

        foreach ($parentFields as $parentField) {


            if ($parentField->hasChildrens()) {

                $content .= '"' . $parentField->name . '"' . ' => [ ' . PHP_EOL;

                $content .= $this->getChildrenArrayString($parentField->childrens()->get());

                $content .= '], ' . PHP_EOL;

            } else {

                $content .= '"' . $parentField->name . '" => ';

                if (is_null($parentField->value)) {
                    $content .= "null," . PHP_EOL;
                } else {
                    $content .= '"' . htmlspecialchars($parentField->value) . '",' . PHP_EOL;
                }
            }

        }

        $content .= "];";


        if (!fwrite($myfile, $content)) {
            $errors['msg'] = "Error saving translation in " . $tmpFile;
        }
        fclose($myfile);


        if (count($errors) > 0) {
            $result = $errors;
        } else {


            $filetodelete = $path . $file->name . '.php';
            if (file_exists($filetodelete)) {
                unlink($filetodelete);
            }
            rename($path . $file->name . '.tmp', $path . $file->name . '.php');


            $result = true;
        }
        return $result;

    }


    private function getChildrenArrayString($childrens)
    {

        $content = "";

        foreach ($childrens as $child) {


            if ($child->hasChildrens()) {

                $content .= '"' . $child->name . '" => [' . PHP_EOL;

                $content .= $this->getChildrenArrayString($child->childrens()->get());

                $content .= '], ' . PHP_EOL;

            } else {


                $content .= '"' . $child->name . '" => ';

                if (is_null($child->value)) {
                    $content .= " null," . PHP_EOL;
                } else {
                    $content .= '"' . htmlspecialchars($child)->value . '",' . PHP_EOL;
                }
            }

        }

        return $content;

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lang $lang
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {


        $lang_id = $request->input('lang_id');
        $section_id = $request->input('section_id');

        $lang = Lang::find($lang_id);
        $file = LangFile::find($section_id);
        $langFields = LangField::where('file_id', $section_id)->where('lang_id', $lang_id)->where('parent_id',0)->with('childrens')->get();

        return view('back.langs.edit', compact('langFields', 'lang', 'file'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Lang $lang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $flag = array('status' => true, 'message'=> '');

        $this->validate($request, ['lang' => 'integer']);

        $lang = Lang::find($request->input('lang'));
        $section = $request->input('section');
        $inputs = $request->except(['_token', 'lang', 'section']);

        DB::beginTransaction();

        try {
            foreach ($inputs as $id => $value) {
                //TODO save for el edit
                $langvalue = LangField::find($id);

                $langvalue->value = null;

                $error=false;
                if($langvalue->attribute){
                    $attributes=explode(',',$langvalue->attribute);

                    foreach($attributes as $attr){
                        if ($value!="" || $value!==null && stristr($value, $attr)===false ) {
                            $error=true;
                        }
                    }
                }
                if(!$error){
                    $langvalue->value = $value;
                    $langvalue->save();
                }else{
                    $flag['status']=false;
                    $flag['message']="";
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            Log::info(
                PHP_EOL .
                "|- Action: LangController@update" . PHP_EOL .
                "|- User ID: " . Auth::id() . PHP_EOL .
                "|- Line number: " . $e->getLine() . PHP_EOL .
                "|- Message: " . $e->getMessage() . PHP_EOL .
                "|- File: " . $e->getFile()
            );

        }



        //will return the errors if fails
        $filesaved = $this->createFile($lang, $section);

        if ($filesaved === true) {

            return redirect('langs/')->with('status', '__(messages.success_saved)');
        } else {
            return back()->withErrors($flag);
        }
    }


    /**
     * Read languages files names
     *
     * @param  \App\Lang $lang
     * @return Array_FileNames
     */

    private function readFilePaths(Lang $lang, $pathLangs)
    {
        $path=$pathLangs . $lang->iso;
        $files = $this->getDirs($path);


        return $files;
    }

    public function getDirs($path){
        $dirs = array_filter(glob($path . '/*'), 'is_dir');
        $result=glob($path . '/*.php');

        foreach($dirs as $dir){

            if(count(array_filter(glob($dir . '/*'), 'is_dir')) > 0){

               $result= array_merge($result, $this->getDirs( $dir ));


            }else{
                $result= array_merge($result, glob($dir .'/*.php'));
            }
        }

        return $result;
    }



    /**
     * Read languages files
     *
     * @param  \App\Lang $lang
     * @return Array_Lang
     */

    private function readFileFields(Lang $lang, $pathLangs)
    {
        $filePaths = $this->readFilePaths($lang, $pathLangs);

        foreach ($filePaths as $fs) {

            $content = include($fs);
            $file= pathinfo($fs);
            $filename = $file['filename'];


            $files[$filename] = $content;

        }

        return $files;
    }


    /**
     * Add files names to de table lang_files
     *
     * @param Lang $lang
     */
    public function loadFiles(Lang $lang, $pathLangs='../resources/lang/')
    {

        $fields = $this->readFileFields($lang, $pathLangs);

        foreach ($fields as $file => $field) {
            $fileId = LangFile::where('name', $file)->first()->id;
            $this->loadFields($fileId, $field, $lang->id);
        }
    }


    private function loadFields($fileId, $fields, $langId, $parentId = 0)
    {

            foreach ($fields as $name => $value) {

                $langField = new LangField();
                $langField->file_id = $fileId;
                $langField->name = $name;

                $langField->attribute = null;
                $langField->lang_id = $langId;


                $langField->parent_id = $parentId;

                if (is_array($value)) {
                    $langField->save();

                    $this->loadFields($fileId, $value, $langId, $langField->id);
                } else {
                    if(count($this->getLocaleVars($value))){
                        $langField->attribute = implode( ', ', $this->getLocaleVars($value));
                    }
                    $langField->value = $value;


                    $langField->save();
                }

        }

    }


    private function getLocaleVars($value){

        $matches=null;
        if(preg_match('/\:[a-z]*/', $value)>0){
            preg_match('/\:[a-z]*/', $value, $matches);
        } else {
            $matches = [];
        }

        return $matches;
    }

}
