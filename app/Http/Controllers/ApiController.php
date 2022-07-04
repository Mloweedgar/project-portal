<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Core\Translator\TranslatorFactory;
use App\Models\Config;
use App\Models\Project\Project;
use App\Models\Project\ProjectInformation;
use App\Transformers\KeyPerformanceIndicatorsApiTransformer;
use App\Transformers\PartiesApiTransformer;
use App\Transformers\PerformanceAssessmentsApiTransformer;
use App\Transformers\ProjectInformationApiTransformer;
use App\Transformers\RedactedPPPAgreementApiTransformer;
use App\Transformers\RenegotiationsApiTransformer;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    const API_VERSION = "v1";

    public function __construct()
    {

        /**
         * The API Middleware, controls the access to the API
         * There are currently two limitations that prevents
         * the client to access the API:
         *
         * -> API Throttle:     Prevents the client to request more information if the client
         *                      has reached the maximum amount of requests per minute as stated
         *                      in the configuration file.
         *
         * -> API Access:       Prevents the client to request information if the API is offline.
         *                      The API can be set to Online or Offline at the backend of the application.
         *
         */
        $this->middleware("api.throttle");
        $this->middleware("api.access");

    }

    public function documentation(){

        return view("api.documentation");

    }

    public function projects()
    {

        $projects = Project::all();

        $out = array();

        foreach($projects as $project){

            array_push($out, [
                'id' => $project->id,
                'ocid' => $project->projectInformation->ocid,
                'name' => $project->name,
                'url' => url("/api/project/" . $project->projectInformation->ocid),
                'publishedDate' => $project->projectInformation->updated_at !== null ? $project->projectInformation->updated_at->format('c') : \Carbon\Carbon::now()->format('c')
            ]);

        }

        return responder()->success($out)->respond();

    }

    public function project(Request $request)
    {

        // Check if the project exists and its not hidden

        $ocid = $request->ocid;
        $projectInformation = ProjectInformation::where('ocid', $ocid)->with('project')->first();

        if(!$projectInformation) {

            return responder()->error("api_project_not_found", "The specified project does not exist.")->respond(404);

        }

        if(!$projectInformation->project->active){

            return responder()->error("api_project_not_available", "The specified project is not available.")->respond();

        }

        if(isNigeriaSovereign()){

            if(!$projectInformation->isTypePPP()){

                return responder()->error("api_project_not_available", "The specified project is not available.")->respond();

            }

        }

        $project = $projectInformation->project;
        $record = [];
        $record['ocid'] = $projectInformation->ocid;

        // tag
        $tag = 'implementation';
        if ($projectInformation->stage->name == 'Development' || $projectInformation->stage->name == 'Post appraisal') {
            $tag = 'planning';
        } elseif ($projectInformation->stage->name == 'Procurement') {
            $tag = 'tender';
        }

        // budget type
        $budgetType = 'indicative';
        if ($tag == 'implementation') {
            $budgetType = 'final';
        }

        // Second project value currency
        $secondProjectValueCurrency = Config::where('name', 'currency')->first()->value;

        /**
         * ===============================================================
         * COMMON PROJECT DATA
         * ===============================================================
         */
        $record['releases'] = [
            [
                'ocid' => "$projectInformation->ocid",
                'id' => "$project->id",
                'date' => $project->updated_at->format('c'),
                'initiationType' => 'tender',
                'tag' => [ $tag ],
                'stage' => str_replace(' ', '-', strtolower($projectInformation->stage->name)),
                'sectors' => $projectInformation->sectors()->get()->pluck('name')->toArray(),
                'locations' => $projectInformation->regions()->get()->pluck('name')->toArray(),
                'sponsoringAgency' => $projectInformation->sponsor->name,
                'value' => [
                    'type' => $budgetType,
                    'baseValue' => [
                        'amount' => (int)($projectInformation->project_value_usd*1000000),
                        'currency' => 'USD'
                    ],
                    'localValue' => [
                        'amount' => (int)($projectInformation->project_value_second*1000000),
                        'currency' => $secondProjectValueCurrency == 'KSh' ? 'KES' : $secondProjectValueCurrency
                    ]
                ],
                'announcements' => self::getProjectAnnouncements($project)
            ]
        ];

        /**
         * ===============================================================
         * PLANNING PROJECT DATA
         * ===============================================================
         */
        $record['releases'][0]['development'] = [
            'basicProjectInformation' => self::getProjectInformation($projectInformation),
            'milestones' => self::getProjectMilestones($project)
        ];

        // All data until planning stage
        $planningRecord = $record;

        /**
         * ===============================================================
         * TENDER PROJECT DATA
         * ===============================================================
         */
        $record['releases'][0]['procurement'] = [
            'procurementDocuments' => self::getProjectProcurementDocuments($project)
        ];
        $record['releases'][0]['procurement'] = array_merge(
            $record['releases'][0]['development'],
            $record['releases'][0]['procurement']
        );

        // All data until tender stage
        $tenderRecord = $record;

        /**
         * ===============================================================
         * IMPLEMENTATION PROJECT DATA
         * ===============================================================
         */
        $record['releases'][0]['implementation']['privateParties'] = self::getProjectParties($project);

        if($project->isProjectDetailsActive()){

            $record['releases'][0]['implementation']['contractInformation'] = [
                'financialStructure' => self::getProjectFinancialStructure($project),
                'risks' => [
                    'items' => self::getProjectRisks($project),
                    'documents' => self::getProjectRisksDocuments($project),
                ],
                'tariffs' => self::getProjectTariffs($project),
                'terminationProvisions' => self::getProjectTerminationProvisions($project),
                'renegotiations' => self::getRenegotiations($project)
            ];

            /*if (isNigeriaICRC() || isKenya()) {
                $record['releases'][0]['implementation']['contractInformation']['redactedPPPAgreement'] = self::getRedactedPPPAgreement($project);
            } elseif (isGhana()) {
                $record['releases'][0]['implementation']['contractInformation']['contractDocuments'] = self::getRedactedPPPAgreement($project);
            }*/

            /*if (isNigeriaSovereign()) {
                $record['releases'][0]['implementation']['contractInformation']['guaranteesOrCommitmentsReceived'] = self::getProjectGovernmentSupport($project);
            } else {*/
                $record['releases'][0]['implementation']['contractInformation']['governmentSupport'] = self::getProjectGovernmentSupport($project);
            //}

            /*if (isGhana()) {
                $record['releases'][0]['implementation']['contractInformation']['environmentAndSocialImpact'] = self::getEnvironmentAndSocialImpact($project);
            }*/
        }

        if($project->isPerformanceInformationActive()){
            $record['releases'][0]['implementation']['performanceInformation'] = [
                'keyPerformanceIndicators' => self::getKeyPerformanceIndicators($project),
                'performanceFailures' => self::getProjectPerformanceFailures($project),
                'performanceAssessments' => self::getPerformanceAssessments($project)
            ];
        }

        $record['releases'][0]['implementation'] = array_merge(
            $record['releases'][0]['procurement'],
            $record['releases'][0]['implementation']
        );

        // All data until implementation stage
        $implementationRecord = $record;

        /**
         * ===============================================================
         * FINAL JSON RESPONSE
         * ===============================================================
         */
        $data = [];
        $data['extensions'] = [ env('OCDS_EXTENSION_URL') ];
        $data['uri'] = $request->url();
        $data['version'] = '1.1';
        $data['publishedDate'] = $projectInformation->updated_at !== null ? $projectInformation->updated_at->format('c') : \Carbon\Carbon::now()->format('c');
        $data['publisher'] = [
            'scheme' => env("OCDS_SCHEME"),
            'name' => env("OCDS_NAME"),
            'uri' => env("OCDS_URI"),
            'uid' => env("OCDS_UID")
        ];

        /**
         * Select the record data depending on the project stage
         */

        switch ($tag){
            case 'planning': $data['records'] = [ $planningRecord ]; break;
            case 'tender': $data['records'] = [ $tenderRecord ]; break;
            case 'implementation': $data['records'] = [ $implementationRecord ]; break;

            default: $data['records'] = [ $planningRecord ];
        }

        // delete procurement related data on NSIA as this stage does not exist
        if (isNigeriaSovereign()) {
            if ($tag == 'implementation') {
                unset($data['records'][0]['releases'][0]['procurement']);
            }
        }

        return response()->json($data);
    }

    public static function getPerformanceAssessments(Project $project)
    {
        if($project->isPIPerformanceAssessmentActive()){
            $assessments = $project->performanceInformation->performanceAssessments()->get();
            return self::stripEmptyItems(transform($assessments, (new PerformanceAssessmentsApiTransformer())));
        } else {
            return array();
        }
    }

    public static function getKeyPerformanceIndicators(Project $project)
    {
        if($project->isPIKeyPerformanceActive()){
            $kpis = $project->performanceInformation->keyPerformanceIndicators->indicators()->get();
            return self::stripEmptyItems(transform($kpis, (new KeyPerformanceIndicatorsApiTransformer())));
        } else {
            return array();
        }
    }

    public static function getRenegotiations(Project $project)
    {
        if($project->isPDRenegotiationsActive()){
            $renegotiations = $project->projectDetails->renegotiations()->get();
            return self::stripEmptyItems(transform($renegotiations, (new RenegotiationsApiTransformer())));
        } else {
            return array();
        }
    }

    public static function getRedactedPPPAgreement(Project $project)
    {
        if($project->isPDDocumentsActive()){
            $redactedPPPAgreements = $project->projectDetails->documents()->get();
            return self::stripEmptyItems(transform($redactedPPPAgreements, (new RedactedPPPAgreementApiTransformer)));
        } else {
            return array();
        }
    }

    public static function getProjectParties(Project $project)
    {
        $parties = $project->parties()->get();
        return transform($parties, (new PartiesApiTransformer));
    }

    public static function getProjectInformation(ProjectInformation $projectInformation)
    {
        return (new ProjectInformationApiTransformer)->transform($projectInformation);
    }

    public static function getProjectMilestones(Project $project)
    {
        if($project->isContractMilestonesActive()){
            $projectContractMilestones = $project->contractMilestones()->with('type')->get();
            return self::stripEmptyItems(transform($projectContractMilestones, new \App\Transformers\ContractMilestoneApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectAnnouncements(Project $project)
    {
        if($project->isPDAnnouncementsActive()){
            $announcements = $project->projectDetails->announcements()->get();
            return self::stripEmptyItems(transform($announcements, new \App\Transformers\AnnouncementApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectProcurementDocuments(Project $project)
    {
        if($project->isPDProcurementActive()){
            $announcements = $project->procurements()->get();
            return self::stripEmptyItems(transform($announcements, new \App\Transformers\ProcurementDocumentApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectFinancialStructure(Project $project)
    {
        if($project->isPDFinancialActive()){
            $financialStructure = $project->projectDetails->financials()->get();
            return self::stripEmptyItems(transform($financialStructure, new \App\Transformers\FinancialStructureApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectRisks(Project $project)
    {
        if($project->isPDRisksActive()){
            $risks = $project->projectDetails->risks()->with('allocation')->get();
            return self::stripEmptyItems(transform($risks, new \App\Transformers\RiskApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectRisksDocuments(Project $project)
    {
        if($project->isPDRisksActive()){
            return UploaderController::documentsApiLoader(
                $project,
                ["section" => "ri"]
            );
        } else {
            return array();
        }
    }

    public static function getProjectGovernmentSupport(Project $project)
    {
        if($project->isPDGovernmentSupportActive()){
            $govermentSupport = $project->projectDetails->governmentSupports()->get();
            return self::stripEmptyItems(transform($govermentSupport, new \App\Transformers\GovernmentSupportApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectTariffs(Project $project)
    {
        if($project->isPDTariffsActive()){
            $tariffs = $project->projectDetails->tariffs()->get();
            return self::stripEmptyItems(transform($tariffs, new \App\Transformers\TariffsApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectTerminationProvisions(Project $project)
    {
        if($project->isPDContractTerminationActive()){
            $terminationProvisions = $project->projectDetails->contractTerminations()->get();
            return self::stripEmptyItems(transform($terminationProvisions, new \App\Transformers\TerminationProvisionsApiTransformer));
        } else {
            return array();
        }
    }

    public static function getProjectPerformanceFailures(Project $project)
    {
        if($project->isPIPerformanceFailuresActive()){
            $performanceFailures = $project->performanceInformation->performanceFailures()->get();
            return self::stripEmptyItems(transform($performanceFailures, new \App\Transformers\PerformanceFailuresApiTransformer));
        } else {
            return array();
        }
    }

    public static function getEnvironmentAndSocialImpact(Project $project)
    {
        if($project->isPDEnvironmentActive()){
            return [
                'description' => $project->projectDetails->environment->description,
                'documents' => UploaderController::documentsApiLoader(
                    $project,
                    ["section" => "env", "position" => 1]
                )
            ];
        } else {
            return [];
        }
    }

    private static function stripEmptyItems(array $pack)
    {
        foreach ($pack as $key => $item) {
            if (is_array($item) && count($item) === 0) {
                unset($pack[$key]);
            }
        }
        return array_values($pack);
    }

    /**
     * Check API status.
     * The status of the API can be changed from the backend of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        $configModel = new Config();
        $api_status = $configModel->where("name", "api")->pluck("value")->first();

        return responder()->success([
            'api-status' => (new TranslatorFactory)->translate($configModel, "api", $api_status, 2)
        ])->respond();
    }
}
