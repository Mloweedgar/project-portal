<?php

/**
 * SEARCHABLE INDEXES AND WEIGHTS
 * ==============================
 *
 * --------------------------------------------------------
 * | Table                            | Code  | Weight    |
 * --------------------------------------------------------
 * | projects                         | p     | 10        |
 * --------------------------------------------------------
 * | project_information              | i     | 9         |
 * --------------------------------------------------------
 * | contract_milestones              | cm    | 8         |
 * --------------------------------------------------------
 * | entities (parties)               | par   | 1         |
 * --------------------------------------------------------
 * | pd_documents                     | d     | 4         |
 * --------------------------------------------------------
 * | pd_announcements                 | a     | 6         |
 * --------------------------------------------------------
 * | pd_procurement                   | pri   | 8         |
 * --------------------------------------------------------
 * | pd_risks                         | ri    | 4         |
 * --------------------------------------------------------
 * | pd_evaluation                    | e     | 4         |
 * --------------------------------------------------------
 * | pd_financial                     | fi    | 4         |
 * --------------------------------------------------------
 * | pd_government_support            | gs    | 4         |
 * --------------------------------------------------------
 * | pd_tariffs                       | t     | 4         |
 * --------------------------------------------------------
 * | pd_contract_termination          | ct    | 4         |
 * --------------------------------------------------------
 * | pd_renegotiations                | r     | 4         |
 * --------------------------------------------------------
 */

namespace App\Http\Controllers;
use App\Models\Entity;
use App\Models\Project\ContractMilestones\ContractMilestone;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Announcement;
use App\Models\Project\ProjectDetails\PD_ContractTermination;
use App\Models\Project\ProjectDetails\PD_Document;
use App\Models\Project\ProjectDetails\PD_EvaluationPPP;
use App\Models\Project\ProjectDetails\PD_Financial;
use App\Models\Project\ProjectDetails\PD_GovernmentSupport;
use App\Models\Project\ProjectDetails\PD_Procurement;
use App\Models\Project\ProjectDetails\PD_Renegotiations;
use App\Models\Project\ProjectDetails\PD_Risk;
use App\Models\Project\ProjectDetails\PD_Tariffs;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectInformation;
use App\MyLibs\StableSort;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Searchable sections
 */
define('SECTIONS', array("p", "i", "cm", "par", "d", "a", "pri", "ri", "e", "fi", "gs", "t", "ct", "r"));

/**
 * Class SearchableController
 * @package App\Http\Controllers
 */
class SearchableController extends Controller
{

    /**
     * Priorities array with weights for every section to search.
     *
     * @var array
     */
    private $priorities = array();

    /**
     * SearchableController constructor.
     */
    public function __construct()
    {

        /*
         * Priorities initialization
         */
        $this->priorities = array (
            "p" => 10,
            "i" => 9,
            "cm" => 8,
            "par" => 1,
            "d" => 4,
            "a" => 6,
            "pri" => 8,
            "ri" => 4,
            "e" => 4,
            "fi" => 4,
            "gs" => 4,
            "t" => 4,
            "ct" => 4,
            "r" => 4
        );

    }

    /**
     * Load configuration in case we need to make
     * "on the fly" configuration updates.
     *
     * @param $priorities
     * @return $this
     */
    public function loadConfiguration($priorities){

        /*
         * Priorities configuration, allows partial priorities
         */
        if (isset($priorities)){

            foreach ($priorities as $key => $value){

                $this->priorities[$key] = $value;

            }

        }

        return $this;

    }

    /**
     * @param $string
     * @param array $sections
     * @param null $limit
     * @param null $args
     * @return string
     */
    public function search($string, $args = null, array $sections = array(), $limit = null){

        $results = array();
        $projectsOrder = array();
        $out = array();

        if(!empty($sections)){

            /*
             * Loop defined sections
             */
            foreach($sections as $section){

                $projectIDs = $this->retrieveProjectID($section,$this->sectionLoader($section)::search($string)->get());
                $results[] = array(
                    "section" => $section,
                    "weight" => $this->priorities[$section],
                    "projects" => $projectIDs
                );

            }

        } else {

            /*
             * Loop all sections
             */
            foreach(SECTIONS as $section){

                $projectIDs = $this->retrieveProjectID($section,$this->sectionLoader($section)::search($string)->get());
                $results[] = array(
                    "section" => $section,
                    "weight" => $this->priorities[$section],
                    "projects" => $projectIDs
                );

            }

        }

        /**
         * Create the array of projects with their weight
         */
        if(!empty($results)){

            foreach ($results as $result){

                foreach($result["projects"] as $project){

                    if(isset($projectsOrder[$project])){

                        $projectsOrder[$project] = array(
                            "weight" => $projectsOrder[$project]["weight"] + $result["weight"],
                            "sections" => $projectsOrder[$project]["sections"] . "-" . $result["section"],
                            "project" => $project
                        );

                    } else {

                        $projectsOrder[$project] = array(
                            "weight" => $result["weight"],
                            "sections" => $result["section"],
                            "project" => $project
                        );

                    }

                }

            }

        }

        /**
         * Order results based on weight
         */
        $searchProjectSchema = $this->orderResults($projectsOrder, $limit);

        /**
         * Get basic information
         */
        return $this->getBasicProjectInfo($searchProjectSchema, $args);


    }

    /**
     * @param $projects
     * @param $args
     * @return string
     */
    private function getBasicProjectInfo($projects, $args){

        $projectsArray = array();

        // Extract all project ids
        foreach($projects as $project){

            $projectsArray[] = $project["project"];

        }

        // Get all project information
        $projectsData = Project::select('id', 'name', 'updated_at')->whereIn('id', $projectsArray)->where('active',1)->get();

        $deleteList = [];

        // Join the projects again
        foreach($projects as $key=>&$project){

            $found = false;

            foreach($projectsData as $projectData){

                if($project["project"] == $projectData["id"]){

                    $project["name"] = $projectData["name"];
                    $project["updated_at"] = $projectData["updated_at"];

                    $found = true;

                }

            }

            if (!$found){
                array_push($deleteList,$key);
            }

        }

        foreach ($deleteList as $delete){
            unset($projects[$delete]);
        }

        $elementsHTML = '';

        // OUTPUT BUILDER
        if(!empty($projects)){

            $elementsHTML = '<h2>Projects</h2>';

            foreach($projects as $project){

                $sectionsHTML = '';

                // Build Sections of the project
                $sections = $this->explodeSections($project["sections"]);

                foreach($sections as $section){

                    $translationSection = $this->sectionTranslation($section);

                    $sectionsHTML = $sectionsHTML . '<span class="label label-search">'.$translationSection.'</span>';

                }

                if($args){

                    // Build element for backend
                    $elementsHTML = $elementsHTML . '<a href="/project/'.$project["project"].'/project-information" class="dummy-media-object"><h3>'.$project["name"].'</h3><div class="dummy-element-container"><div class="dymmy-subelement"><h4>Matches in:</h4>'.$sectionsHTML.'</div><div class="dummy-subelement"><h4>Last update:</h4><span>'.$project["updated_at"]->toFormattedDateString().'</span></div></div></a>';

                } else {

                    // Build element for frontpage
                    $elementsHTML = $elementsHTML . '<a href="/project/'.$project["project"].'/'.str_slug($project["name"]).'" class="dummy-media-object"><h3>'.$project["name"].'</h3><div class="dummy-element-container"><div class="dymmy-subelement"><h4>Matches in:</h4>'.$sectionsHTML.'</div><div class="dummy-subelement"><h4>Last update:</h4><span>'.$project["updated_at"]->toFormattedDateString().'</span></div></div></a>';

                }


            }

        }

        return $elementsHTML;


    }

    /**
     * @param $sections
     * @return array
     */
    private function explodeSections($sections){

        return array_unique(explode('-', $sections));

    }

    /**
     * Function to order the array from more weight to less
     *
     * @param $a
     * @param $b
     * @return int
     */
    private function cmp($a, $b) {

        if ($a == $b) {
            return 0;
        }

        return ($a > $b) ? -1 : 1;

    }

    /**
     * Ordering function with a callback to order the results
     * Also slice the result if needed
     * (see $this->cmp($a, $b))
     *
     * @param $data
     * @param null $limit
     * @return array|bool
     */
    private function orderResults($data, $limit = null){

        $out = array();

        uasort($data, array($this, 'cmp'));
        $out = array_slice($data, 0, $limit);

        return $out;

    }

    /**
     * Retrieve the project id of a collection of data of all the sections
     * This function has to match columns at database side.
     *
     * @param $section
     * @param $datas
     * @return array|mixed
     */
    private function retrieveProjectID($section, $datas){

/*
        Log::debug($section);
        Log::debug($datas);
*/


        $result = array();

        switch ($section){

            case "p":
                foreach($datas as $data){ $result[] = $data["id"]; }
                break;
            case "i":
            case "pri":
            case "cm":
                foreach($datas as $data){ $result[] = $data["project_id"]; }
                break;
            case "par":
                foreach($datas as $data){ $result = $this->getProjectEntities($data["id"]); }
                break;
            case "d":
            case "a":
            case "ri":
            case "e":
            case "fi":
            case "gs":
            case "t":
            case "ct":
            case "r":
                foreach($datas as $data){

                    $result = $this->getProjectDetailsSubsection($data["project_details_id"]);
                }
                break;

            default: foreach($datas as $data){ $result[] = $data["id"]; }

        }

        return $result;

    }

    /**
     * @param $entityID
     * @return mixed
     */
    private function getProjectEntities($entityID){

        return Entity::find($entityID)->projects()->pluck('project_id');

    }

    /**
     * @param $project_details_id
     * @return mixed
     */
    private function getProjectDetailsSubsection($project_details_id){

        return ProjectDetail::find($project_details_id)->pluck('project_id');

    }

    /**
     * @param $section
     * @return Entity|ContractMilestone|Project|PD_Announcement|PD_Document|PD_Procurement|ProjectInformation
     */
    private function sectionLoader($section){

        switch ($section){

            case "p": $model = new Project(); break;
            case "i": $model = new ProjectInformation(); break;
            case "cm": $model = new ContractMilestone(); break;
            case "par": $model = new Entity(); break;
            case "d": $model = new PD_Document(); break;
            case "a": $model = new PD_Announcement(); break;
            case "pri": $model = new PD_Procurement(); break;
            case "ri": $model = new PD_Risk(); break;
            case "e": $model = new PD_EvaluationPPP(); break;
            case "fi": $model = new PD_Financial(); break;
            case "gs": $model = new PD_GovernmentSupport(); break;
            case "t": $model = new PD_Tariffs(); break;
            case "ct": $model = new PD_ContractTermination(); break;
            case "r": $model = new PD_Renegotiations(); break;

            default: $model = new Project();

        }

        return $model;

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

            default: $out = 'Undefined';

        }

        return $out;

    }

}