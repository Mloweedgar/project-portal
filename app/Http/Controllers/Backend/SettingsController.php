<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogoPageStoreRequest;
use App\Http\Requests\NavItemPageStoreRequest;
use App\Http\Requests\ThemePageStoreRequest;
use App\Models\Config;
use App\Models\Media;
use App\Models\NavMenuLink;
use App\Models\Project\Currency;
use App\Models\Theme;
use App\Models\Theme_schema;
use App\Models\ThemeFont;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_it');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $themes = Theme::all();
        $fonts = ThemeFont::all();
        $activeTheme = Theme::where('active', 1)->get()->first();

        $navigationItems = NavMenuLink::all();
        $api = Config::where('name', 'api')->get()->first();
        $logo = Media::where('section', 'logo')->get()->first();
        $currency = Config::where('name','currency')->get()->first();
        $allCurrencies = Currency::orderBy('iso')->distinct()->get();

        $publisher_name = Config::where('name', 'publisher_name')->get()->first();
        $publisher_scheme = Config::where('name', 'publisher_scheme')->get()->first();
        $publisher_uid = Config::where('name', 'publisher_uid')->get()->first();
        $publisher_uri = Config::where('name', 'publisher_uri')->get()->first();

        return view('back.settings.index', compact('themes', 'fonts', 'activeTheme', 'navigationItems', 'api', 'logo','currency','allCurrencies','publisher_name','publisher_scheme','publisher_uid','publisher_uri'));
    }


    public function createTheme()
    {


        $flag = ["status" => true, "message" => ""];


        DB::beginTransaction();
        try {

            $default_theme = Theme::where('custom', '0')->get()->first();

            $name = Input::get('name');
            $theme = new Theme();
            $theme->name = $name;
            $theme->active = 0;
            $theme->custom = 1;
            $theme->save();


            foreach ($default_theme->schema()->get() as $df) {
                $schema = new Theme_schema();
                $schema->theme_id = $theme->id;
                $schema->name = $df->name;
                $schema->css_key = $df->css_key;
                $schema->css_rule = $df->css_rule;
                $schema->save();
            }

            // all good
            DB::commit();

        } catch (\Exception $e) {
            // something went wrong
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }

        return response()->json(['id' => $theme->id, 'name' => $name, 'response' => $flag]);
    }

    public function getThemeSchema()
    {

        $id = Input::get('id');
        $theme = Theme::find($id);
        $themeSchema = $theme->schema()->get();

        return response()->json(['active' => $theme->active, 'custom' => $theme->custom, 'themeSchema' => $themeSchema]);

    }


    public function saveTheme(ThemePageStoreRequest $request)
    {

        $fields = $request->except('_token');


        $theme = Theme::find($fields['theme']);

        if ($theme->custom) {

            $schemas = $theme->schema()->get();

            foreach ($schemas as $schema) {
                $sch = Theme_schema::find($schema->id);
                $sch->css_rule = $fields[$schema->name];
                $sch->save();
            }

            if ($theme->active) {
                $this->createCustomVarsFile($theme->id);
                $this->compile();
            }

            return redirect('/settings/')->with('success', __("messages.success_save"));
        } else {
            return redirect('/settings/')->withErrors('msg', __("settings.save_default_theme_error"));
        }

    }

    public function deleteTheme(Request $request)
    {

        $fields = $request->except('_token');
        $theme = Theme::find($fields['theme']);

        if ($theme->custom) {

            $schemas = $theme->schema()->get();

            foreach ($schemas as $schema) {
                $sch = Theme_schema::find($schema->id);
                $sch->delete();

            }

            $theme->delete();

            // set default one
            $default_theme = Theme::where('custom', 0)->first();
            $default_theme->active = 1;
            $default_theme->save();
            $this->createCustomVarsFile($default_theme->id);
            $this->compile();

            return redirect('/settings/')->with('status', __("messages.success_delete"));
        } else {
            return redirect('/settings/')->withErrors('msg', __("settings.delete_default_theme_error"));
        }
    }

    public function activeTheme(Request $request)
    {
        $id = $request->get('theme');

        $this->createCustomVarsFile($id);
        $theme = Theme::all()->where('active', 1)->first();
        $new_theme = Theme::find($id);

        if ($new_theme){

            if ($theme) {
                $theme->active = 0;
                $theme->save();
            }

            $new_theme->active = 1;
            $new_theme->save();

            $this->compile();

        }


    }

    public function uploadLogo(LogoPageStoreRequest $request)
    {

        $path = $_FILES['file']['name'];
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $newname = 'logo';
        list($width, $height) = getimagesize($_FILES['file']['tmp_name']);


        $flag = ["status" => true, "message" => ""];
        DB::beginTransaction();

        //TODO : add section
        try {
            $media = Media::where('name', 'logo')->get()->first();
            $media->name = $newname;
            $media->old_name = $filename;
            $media->extension = $ext;
            $media->mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
            //TODO: Width && height, is done in GalleryController
            $media->width;
            $media->height;
            $media->save();
            // all good
            DB::commit();

        } catch (\Exception $e) {
            // something went wrong
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }


        return response()->json(['response' => $flag]);
    }

    public function createNavigationItem(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'link' => 'required'
        ]);

        $name = Input::get('name');
        $link = Input::get('link');

        $flag = ["status" => true, "message" => ""];
        DB::beginTransaction();

        try {
            $navItem = new NavMenuLink();
            $navItem->name = $name;
            $navItem->link = $link;
            $navItem->save();
            // all good
            DB::commit();

        } catch (\Exception $e) {
            // something went wrong
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }

        return response()->json(['id' => $navItem->id, 'name' => $name, 'link' => $link, 'response' => $flag]);
    }

    public function saveNavigationItem(NavItemPageStoreRequest $request)
    {

        $id = Input::get('id');
        $name = Input::get('name');
        $link = Input::get('link');

        $flag = ["status" => true, "message" => ""];
        DB::beginTransaction();

        try {
            $navItem = NavMenuLink::find($id);
            $navItem->name = $name;
            $navItem->link = $link;
            $navItem->save();
            // all good
            DB::commit();

        } catch (\Exception $e) {
            // something went wrong
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }

        return response()->json(['name' => $name, 'link' => $link, 'response' => $flag]);

    }

    public function deleteNavigationItem()
    {

        $id = Input::get('id');

        $flag = ["status" => true, "message" => ""];

        $navItem = NavMenuLink::find($id);


        if (!$navItem->default) {
            try {
                $navItem->delete();
                // all good

            } catch (\Exception $e) {
                // something went wrong
                $flag["status"] = false;
                $flag["error"] = $e->getMessage();

            }
        } else {
            $flag["status"] = false;
            $flag["error"] = __('settings.delete_default_nav_item');
        }


        return response()->json(['response' => $flag]);

    }

    public function setApi()
    {
        $api = Input::get('api');

        $flag = ["status" => true, "message" => ""];

        DB::beginTransaction();
        try {

            $config = Config::where('name', 'api')->get()->first();
            $config->value = $api;
            $config->save();

            // all good
            DB::commit();

        } catch (\Exception $e) {
            // something went wrong
            $flag["status"] = false;
            $flag["error"] = $e->getMessage();
            DB::rollback();

        }


        return response()->json(['response' => $flag]);
    }

    public function backupDb()
    {
        $path = 'db_backups/';
        $file = 'sql_backup_' . date("Y-m-d_H-i-s") . '.sql';
        $headers = array(
            'Content-Type: application/sql',
        );

        $path = storage_path() . '/app/db_backups/';
        exec('ls '.$path,  $output, $return_var);

        exec('mysqldump '.env('DB_DATABASE').' --result-file='.$path .$file.' --add-drop-database --disable-keys --user='.env('DB_USERNAME').' --password='.env('DB_PASSWORD'),  $output, $return_var);

        return \Illuminate\Support\Facades\Response::download(storage_path() . '/app/db_backups/' . $file, $file, $headers) ;
    }

    public function saveCurrency(Request $request)
    {

        $currency = Config::where('name','currency')->first();
        $currency->value = $request->get('currency');
        $currency->save();

        return redirect('/settings/')->with('success', __("messages.success_save"));

    }

    public function savePublisherData(Request $request)
    {

        /* Publisher Name */
        if($request->has('publisher_name')){
            $publisher_name = Config::where('name', 'publisher_name')->first();
            if($publisher_name){
                $publisher_name->value = $request->get('publisher_name');
                $publisher_name->save();
            } else {
                $publisher_name = new Config;
                $publisher_name->name = 'publisher_name';
                $publisher_name->value = $request->get('publisher_name');
                $publisher_name->save();
            }
        }

        /* Publisher Scheme */
        if($request->has('publisher_scheme')){
            $publisher_scheme = Config::where('name', 'publisher_scheme')->first();
            if($publisher_scheme){
                $publisher_scheme->value = $request->get('publisher_scheme');
                $publisher_scheme->save();
            } else {
                $publisher_name = new Config();
                $publisher_name->name = 'publisher_scheme';
                $publisher_name->value = $request->get('publisher_scheme');
                $publisher_name->save();
            }
        }

        /* Publisher Uid */
        if($request->has('publisher_uid')){
            $publisher_uid = Config::where('name', 'publisher_uid')->first();
            if($publisher_uid){
                $publisher_uid->value = $request->get('publisher_uid');
                $publisher_uid->save();
            } else {
                $publisher_name = new Config();
                $publisher_name->name = 'publisher_uid';
                $publisher_name->value = $request->get('publisher_uid');
                $publisher_name->save();
            }
        }

        /* Publisher Uri */
        if($request->has('publisher_uri')){
            $publisher_uri = Config::where('name', 'publisher_uri')->first();
            if($publisher_uri){
                $publisher_uri->value = $request->get('publisher_uri');
                $publisher_uri->save();
            } else {
                $publisher_name = new Config();
                $publisher_name->name = 'publisher_uri';
                $publisher_name->value = $request->get('publisher_uri');
                $publisher_name->save();
            }
        }

        return redirect('/settings/')->with('success', __("messages.success_save"));

    }

    private function createCustomVarsFile($id_theme)
    {
        $theme = Theme::find($id_theme);
        $schemas = $theme->schema()->get();

        $schString = '';

        foreach ($schemas as $sch) {
            $schString .= $sch->css_key;
            $schString .= ' :';
            $schString .= $sch->css_rule;
            $schString .= ';' . PHP_EOL;
        }

        $file = '../resources/assets/less/_custom_variables.tmp';
        $myfile = fopen($file, "w");
        $errors = false;

        if (!fwrite($myfile, $schString)) {
            $errors['msg'] = "Error saving translation in " . $file;
        }
        fclose($myfile);

        if (!$errors)
            rename('../resources/assets/less/_custom_variables.tmp', '../resources/assets/less/_custom_variables.less');
    }

    private function compile()
    {
        $returnCode = shell_exec('cd .. && node_modules/less/bin/lessc --clean-css resources/assets/less/app.less public/css/app.css');

        $result = false;
        if ($returnCode) {
            $result = true;
        }

        return $result;

     }
}
