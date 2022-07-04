<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Theme_schema;
use App\Models\Theme_schema_field;
use Illuminate\Http\Request;


class ThemeController extends Controller
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

        $themes = Theme::all();
        return view('themes.index', ['themes' => $themes]);


    }

    public static function compile(){
        $returnCode = shell_exec('cd .. && node_modules/less/bin/lessc --clean-css resources/assets/less/app.less public/css/app.css');

        $result=false;
        if($returnCode==0){
            $result=true;
        }

        return $result;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme_schema_fields = Theme::where('custom',0)->first()->schema()->get();

        return view('themes.create', compact('theme_schema_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


           $model = Theme::where('custom',0)->first()->schema()->get();

            if($model){
                $validations['name'] = 'required';

                foreach($model as $m){

                    $validations[$m->name] = 'required';
                }

                $this->validate($request, $validations);

            }

        $theme = new Theme();
        $theme->name = $request->input('name');
        $theme->active = 0;
        $theme->custom = 1;
        $theme->save();

        if($model) {
            foreach ($model as $m) {
                $schema = new Theme_schema();
                $schema->theme_id = $theme->id;
                $schema->name = $m->name;
                $schema->css_key = $m->css_key;
                $schema->css_rule = $request->input($m->name);
                $schema->save();
            }
        }
        return redirect('/themes/')->with('status',__("messages.success_save"));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $theme)
    {
        //
    }


    /**
     * Changes the active theme
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function activeTheme($id){


        self::createCustomVarsFile($id);
        $theme=Theme::all()->where('active',1)->first();

        if(self::compile()) {
            if ($theme) {
                $theme->active = 0;
                $theme->save();
            }

            $theme = Theme::find($id);
            $theme->active = 1;
            $theme->save();


            return redirect('/themes/')->with('status', __("messages.success_save"));
        }else{
            return back()->withErrors('msg', __("messages.error_save"));
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $theme=Theme::find($id);
        return view('themes/edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function schemaUpdate(Request $request)
    {
        $theme=$request->except('_token');
        reset($theme); //get the first element of array
        $theme=key($theme); //get the key of element
        $theme = Theme_schema::find($theme)->Theme()->first(); //get the theme

        foreach($request->except('_token') as $k=>$s) {
            $schema = Theme_schema::find($k);
            $schema->css_rule = $s;
            $schema->save();
        }

        if($theme->active) {
            $this->createCustomVarsFile($theme->id);
            self::compile();
        }
        return redirect('/themes/')->with('status',__("messages.success_save"));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $theme = Theme::find($id);
        $theme->schema()->delete();
        $theme->delete();

        // set default one
        $default_theme = Theme::where('custom', 0)->first();
        $default_theme->active = 1;
        $default_theme->save();
        self::createCustomVarsFile($default_theme->id);
        self::compile();

        return redirect('/themes/')->with('status',__("messages.success_delete"));

    }


    /**
     * Create the less custom variables
     *
     * @param
     * @return
     */

    public static function createCustomVarsFile($id_theme){
        $theme = Theme::find($id_theme);
        $schemas = $theme->schema()->get();

        $schString='';

        foreach($schemas as $sch){
            $schString.=$sch->css_key;
            $schString.=' :';
            $schString.=$sch->css_rule;
            $schString.=';'.PHP_EOL;
        }

        $file='../resources/assets/less/_custom_variables.tmp';
        $myfile = fopen($file, "w");
        $errors=false;

        if(!fwrite($myfile, $schString)){
            $errors['msg']="Error saving translation in ".$file;
        }
        fclose($myfile);

        if(!$errors)
            rename('../resources/assets/less/_custom_variables.tmp', '../resources/assets/less/_custom_variables.less');
    }


}
