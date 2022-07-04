<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectDetails\SectionEditRequest;
use App\Models\Section;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

/**
 * Class SectionsToDisclose
 * @package App\Http\Controllers\Backend
 */
class SectionsToDiscloseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public $user;

    /**
     * SectionsToDisclose constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin');

        $this->user = $user;

    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        $sections = Section::all('id', 'name', 'section_code', 'active');

        return view('back.sectionstodisclose',compact('sections'));
    }

    /**
     * @param SectionEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SectionEditRequest $request){

        $response = false;
        try {

            DB::beginTransaction();

            foreach($request->get('sections') as $section){
                if($section["id"] != 1){
                    $pSection = Section::find($section["id"]);
                    $pSection->active = $section["active"];
                    $pSection->save();
                }

            }

            // Commit the changes
            DB::commit();

            $response = true;

        } catch (\Exception $e) {
            $response = false;
            dd($e->getMessage());
            Log::error(
                PHP_EOL.
                "|- Action: SectionsToDisclose@update".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );

            // Ouuuupsss... something wrong here!
            DB::rollback();

        }

        // Load the view again
        return Response::json($response);

    }

    /**
     * @return \Illuminate\Support\Collection
     *
     */
    private function getSectionsStatus (){

        $sections = Section::all('id', 'name', 'section_code', 'active');

        return $sections;

    }

    /**
     * @param $section
     * @return string
     */
    private function sectionTranslation($section){

        switch ($section){

            case "p": $out = 'Project Name'; break;
            case "i": $out = 'Project Information'; break;
            case "cm": $out = 'Project milestones'; break;
            case "par": $out = 'Parties'; break;
            case "d": $out = 'Documents'; break;
            case "a": $out = 'Announcements'; break;
            case "pri": $out = 'Procurement'; break;
            case "ri": $out = 'Risks'; break;
            case "e": $out = 'Evaluation'; break;
            case "fi": $out = 'Financial'; break;
            case "gs": $out = 'Government Support'; break;
            case "t": $out = 'Tariffs'; break;
            case "ct": $out = 'Terminal Provisions'; break;
            case "r": $out = 'Renegotiation'; break;
            case "cs": $out = 'Contract Summary'; break;
            default: $out = 'Undefined';

        }

        return $out;

    }

}
