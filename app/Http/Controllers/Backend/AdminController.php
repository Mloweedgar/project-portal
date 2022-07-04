<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Project\Project;
use App\Models\Role;
use App\Models\Section;
use App\Models\Sector;
use App\User;
use Illuminate\Http\Request;
use App\MyLibs\ProjectGenericConstants;

class AdminController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
    }

     /**
     * Returns the homepage-management view.
     *
     * @return \Illuminate\Http\Response
     */
    public function homepageManagement()
    {
        return view('back.homepage-management');
    }

     /**
     * Returns projects
     * The method is used to search the projects by name
     * @return JSON
     */
    public function likeProjects(Request $request)
    {
        $projects = Project::like('name', $request->get('q'))->get();
        return ["projects" => $projects];
    }

    /**
     * Returns a list of users by input name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeUsers(Request $request)
    {
        $users = User::where('name', 'like', '%'.$request->get('q').'%')->get();
        return $users;
    }

    /**
     * Returns a list of users by input name except views only.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeUsersExceptViewOnly(Request $request)
    {

        $users = \App\User::whereHas('role', function($q) {
           $q->where('roles.name', '!=', 'role_viewer');
        })->where('name', 'like', '%'.$request->get('q').'%')->get();

        return $users;
    }


    /**
     * Returns a list of users by input name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeUsersRole(Request $request)
    {
        $users = User::where('name', 'like', '%'.$request->get('q').'%')->get();
        return $users;
    }


    /**
     * Returns a list of users by input name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectSectionsList(Request $request)
    {
        $project_id = $request->get('pid');

        $project = Project::findOrFail($project_id);

        $sectionsList = ProjectGenericConstants::getProjectSectionsList($project);

        $sectionCodes = array_column($sectionsList, 'section_code');

        $availableSections = array_column(\App\Models\Section::select('section_code')
            ->whereIn('section_code', $sectionCodes)
            ->where('active', 1)
            ->get()->toArray(), 'section_code');

        $projectAvailableSections = $project->visibleSections();

        $sectionsListAvailable = [];

        foreach ($sectionsList as $sectionList) {
            if (in_array($sectionList['section_code'], $availableSections)
            && in_array($sectionList['section_code'], $projectAvailableSections)) {
                $sectionsListAvailable[] = $sectionList;
            }
        }

        return $sectionsListAvailable;

        // $sectionsDB = $project->getAvailableSections();
        //
        // $groups = ['pi', 'pd'];
        //
        // $sections = [];
        // $i = 0;
        //
        // foreach ($sectionsDB as $sectionDB) {
        //     $sections[$i] = [];
        //     $sections[$i]['section_code'] = $sectionDB->section_code;
        //     $sections[$i]['name'] = $sectionDB->name;
        //     $sections[$i]['parent'] = $sectionDB->parent;
        //
        //     if (in_array($sectionDB->section_code, $groups)) {
        //         $sections[$i]['group'] = true;
        //     } else {
        //         $sections[$i]['group'] = false;
        //     }
        //
        //     $i++;
        // }
        //
        // return $sections;
    }


    /**
     * Returns a list of users by input name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectSectionsPositionsList(Request $request)
    {
        $project_id = $request->get('pid');
        $section_id = $request->get('sid'); // section_code

        $project = Project::findOrFail($project_id);
        $section = Section::where('section_code', $section_id)->first();

        $positionsDB = $project->getSectionPositions($section);

        $positions = [];
        $positions[0] = [];
        $positions[0]['id'] = 0;
        $positions[0]['name'] = __("project/project-information.all_section");

        if ($positionsDB) {
            $i = 1;

            foreach ($positionsDB as $positionDB) {
                $positions[$i] = [];

                $positions[$i]['id'] = $positionDB['id'];

                if (isset($positionDB['title'])) {
                    $positions[$i]['name'] = $positionDB['title'];
                } else {
                    $positions[$i]['name'] = $positionDB['name'];
                }

                $i++;
            }
        }

        return $positions;
    }
}
