<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Core\Translator\TranslatorFactory;
use App\Models\Config;
use App\Models\Entity;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_Award;
use App\Models\Project\ProjectInformation;
use App\Transformers\ContractMilestoneApiTransformer;
use App\Transformers\ContractMilestoneApiTransformerV2;
use App\Transformers\KeyPerformanceIndicatorsApiTransformer;
use App\Transformers\KeyPerformanceIndicatorsApiTransformerV2;
use App\Transformers\PartiesApiTransformer;
use App\Transformers\PartiesApiTransformerV2;
use App\Transformers\PerformanceAssessmentsApiTransformer;
use App\Transformers\ProjectInformationApiTransformer;
use App\Transformers\ProjectInformationApiTransformerV2;
use App\Transformers\RedactedPPPAgreementApiTransformer;
use App\Transformers\RenegotiationsApiTransformer;
use App\Transformers\RiskApiTransformerV2;
use Illuminate\Http\Request;

class ApiControllerV2 extends Controller
{
    const API_VERSION = "v2";

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

    /**
     * Prompt out all the data of the database through the API
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulk(){

        $projects = Project::all();

        $out = array();

        // The big loop
        foreach($projects as $project){
            // Create a request object on the fly to fulfill with the project method arguments
            $request = new Request();
            $request->replace(['ocid' => $project->projectInformation->ocid]);
            // Add the result to an array of projects
            array_push($out, $this->project($request, true));
        }

        // Return the array of objects
        return responder()->success($out)->respond();

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

    public function project(Request $request, $raw_output = false)
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

        /**
         * ===============================================================
         * COMMON PROJECT DATA
         * ===============================================================
         */
        $release = [
            'ocid' => "$projectInformation->ocid",
            'id' => "$project->id",
            'date' => $project->updated_at->format('c'),
            'initiationType' => 'ppp',
            'tag' => [ $tag ],
            'planning' => array(
                'project' => array(
                    'title' => $project->name
                )
            )
        ];

        /**
         * INITIALIZATIONS
         */
        $this->initiateTender($release, $ocid);
        $this->initiateContract($release, $ocid, $project);

        /**
         * Attach: Sector
         */
        $this->attachReleaseSector($release, $projectInformation);
        /**
         * Attach: Locations
         */
        $this->attachReleaseLocations($release, $projectInformation->regions()->get()->pluck('name')->toArray());
        /**
         * Attach: Sponsor
         */
        $this->attachSponsoringAgency($release, $projectInformation->sponsor);
        /**
         * Attach: Project Value
         */
        $this->attachProjectValue($release, $projectInformation);
        /**
         * Attach: Project Information
         */
        $this->attachProjectInformation($release, $projectInformation);
        /**
         * Attach: Project milestones
         */
        $this->attachProjectMilestones($release, $project);
        /**
         * Attach: Procurement Documents
         */
        $this->attachProjectProcurementDocuments($release, $project);
        /**
         * Attach: Project Parties
         */
        $this->attachProjectParties($release, $project);
        /**
         * Attach: Redacted PPP Agreement
         */
        $this->attachRedactedPPPAgreement($release, $project);
        /**
         * Attach: Award Contract Data
         */
        $this->attachAward($release, $project);
        /**
         * Attach: Financing Award Data
         */
        $this->attachAwardFinancing($release, $project);
        /**
         * Attach: Project Financial Structure
         * TODO: Allocate this data "Equity-debt ratio ; Share capital ; Shareholders" in other sections of the OCDS
         * Status: Deactivated until solving all the conflicts with the new Award Financing data
         */
        //$this->attachProjectFinancialStructure($release, $project);
        /**
         * Attach: Project Risks
         */
        $this->attachProjectRisks($release, $project);
        $this->attachProjectRisksDocuments($release, $project);
        /**
         * Attach: Project Tariffs
         */
        $this->attachProjectTariffs($release, $project);
        /**
         * Attach: Key Performance Indicators
         */
        $this->attachKeyPerformanceIndicators($release, $project);
        /**
         * Attach: Project Performance Failures
         */
        $this->attachProjectPerformanceFailures($release, $project);
        /**
         * Attach: Performance Assessments Documents
         */
        $this->attachPerformanceAssessments($release, $project);

        /**
         * BUILD THE RELEASES
         */
        $record['releases'][] = $release;

        /**
         * ===============================================================
         * FINAL JSON RESPONSE
         * ===============================================================
         */
        $data = [];
        $data['version'] = '1.1';
        $data['license'] = "http://opendatacommons.org/licenses/pddl/1.0/";
        $data['extensions'] = [ env('PPP_OCDS_EXTENSION_URL') ];
        $data['publishedDate'] = $projectInformation->updated_at !== null ? $projectInformation->updated_at->format('c') : \Carbon\Carbon::now()->format('c');
        $data['publisher'] = [
            'scheme' => env("OCDS_SCHEME"),
            'name' => env("OCDS_NAME"),
            'uri' => env("OCDS_URI"),
            'uid' => env("OCDS_UID")
        ];
        $data['uri'] = $request->url();

        // RECORDS
        $data['records'][] = $record;

        // delete procurement related data on NSIA as this stage does not exist
        if (isNigeriaSovereign()) {
            if ($tag == 'implementation') {
                unset($data['records'][0]['releases'][0]['procurement']);
            }
        }

        /*
         * This is an addition to the V2 Api,
         * we can control now the type of output in case
         * the function is used for internal purposes or just
         * to output all the project data in JSON format.
         */
        if($raw_output){
            return $data;
        } else {
            return response()->json($data);
        }

    }

    /**
     * REQUIREMENTS INITIALIZATIONS
     */

    /**
     * Initiate Tender
     * @param array $release
     * @param $ocid
     */
    public function initiateTender(array &$release, $ocid){

        $release['tender']['id'] = $ocid;

    }

    /**
     * Initiate base contract
     * @param array $release
     * @param $ocid
     * @param Project|null $project
     */
    public function initiateContract(array &$release, $ocid, Project $project){

        // Check if the project has an award attached
        $award =  $project->projectDetails->award()->first();
        if($award){
            $award_id = $award->award_code;
        } else {
            $award_id = uniqid();
        }

        $release['contracts'][0] = array(
            "id" => $ocid,
            "awardID" => $award_id
        );
    }

    /**
     * ATTACHMENTS
     */

    /**
     * Attach: planning/project/locations
     * @param array $release
     * @param array $locations
     */
    public function attachReleaseLocations(array &$release, array $locations){

        foreach($locations as $location){
            $release['planning']['project']['locations'][] = $this->enhanceLocationWithGeodata($location);
        }

    }

    /**
     * Attach: planning/project/sector
     * @param array $release
     * @param ProjectInformation $pi
     */
    public function attachReleaseSector(array &$release, ProjectInformation $pi){

        // First we check if the sector COFOG is available or not
        if($pi->cofog_sector_id){

            // If the sector is available, we put the COFOG sector with their predefined structure
            $release['planning']['project']['sector'] = $pi->getCOFOGSector($pi->cofog_sector_id);

        } else {

            // If is not available, we put the basic sector of the Transparency framework
            $release['planning']['project']['sector'] = array(
                'description' => $pi->sectors()->get()->pluck('name')->first()
            );

        }

    }

    /**
     * Attach: parties && tender/procuringEntity
     * @param array $release
     * @param Entity $sponsor
     */
    public function attachSponsoringAgency(array &$release, Entity $sponsor){

        // First we add a new party to the release
        $party['id'] = (string) $sponsor->id;
        $party['name'] = $sponsor->name;
        $party['roles'][] = "procuringEntity"; // This is mandatory or the validation will fail
        $party['identifier'] = array(
            "scheme" => null,
            "id" => (string) $sponsor->id,
            "legalName" => $sponsor->name,
            "uri" => null
        );
        $party['address'] = array(
            "streetAddress" => $sponsor->address,
            "locality" => null,
            "region" => null,
            "postalCode" => null,
            "countryName" => null
        );
        $party['contactPoint'] = array(
            "name" => $sponsor->name_representative,
            "email" => $sponsor->email,
            "telephone" => $sponsor->tel,
            "faxNumber" => $sponsor->fax,
            "url" => $sponsor->url
        );
        $release['parties'][] = $party;

        // Then we include the sponsoring agency
        $release['tender']['procuringEntity']['id'] = (string) $sponsor->id;
        $release['tender']['procuringEntity']['name'] = $sponsor->name;

    }

    /**
     * Attach: planning/project/totalValue
     * @param array $release
     * @param ProjectInformation $pi
     */
    public function attachProjectValue(array &$release, ProjectInformation $pi){

        // Second project value currency
        $secondProjectValueCurrency = Config::where('name', 'currency')->first()->value;

        // Total project value
        $release['planning']['budget']['amount']['amount'] = (int)($pi->project_value_usd*1000000);
        $release['planning']['budget']['amount']['currency'] = 'USD';

        $release['planning']['project']['totalValue']['amount'] = (int)($pi->project_value_usd*1000000);
        $release['planning']['project']['totalValue']['currency'] = 'USD';

        // Total project value, local currency
        $budget['id'] = random_int(1, 99999);
        $budget['amount']['amount'] = (int)($pi->project_value_second*1000000);
        $budget['amount']['currency'] = $secondProjectValueCurrency == 'KSh' ? 'KES' : $secondProjectValueCurrency;

        // Budget breakdown has been removed for the version V2 of the Api
        //$release['planning']['budget']['budgetBreakdown'][] = $budget;

    }

    /**
     * Attach: ProjectInformation All Platforms
     * @param array $release
     * @param ProjectInformation $projectInformation
     * @return void
     */
    public function attachProjectInformation(array &$release, ProjectInformation $projectInformation)
    {
        $release = array_merge_recursive($release, (new ProjectInformationApiTransformerV2)->transform($projectInformation));
    }

    /**
     * Attach: Project Milestones
     * @param array $release
     * @param Project $project
     */
    public function attachProjectMilestones(array &$release, Project $project){

        if($project->isContractMilestonesActive()){

            $projectContractMilestones = $project->contractMilestones()->with('type')->get();

            // Milestones Containers
            $planning_milestones = array();
            $procurement_milestones = array();
            $implementation_milestones = array();
            $contract_milestones = array();

            foreach($projectContractMilestones as $contractMilestone){

                if($this->isInStage($contractMilestone->name, "Planning")) {

                    array_push($planning_milestones, (new ContractMilestoneApiTransformer)->transform($contractMilestone));

                }
                if($this->isInStage($contractMilestone->name, "Procurement")){

                    array_push($procurement_milestones, (new ContractMilestoneApiTransformer)->transform($contractMilestone));

                }
                if($this->isInStage($contractMilestone->name, "Implementation")){

                    array_push($implementation_milestones, (new ContractMilestoneApiTransformer)->transform($contractMilestone));

                }
                if($this->isInStage($contractMilestone->name, "Contract")){

                    array_push($contract_milestones, (new ContractMilestoneApiTransformer)->transform($contractMilestone));

                }

            }

            // Init milestones
            $release['planning']['milestones'] = $planning_milestones;
            $release['tender']['milestones'] = $procurement_milestones;
            // IS ALWAYS ZERO BECAUSE OF GHANA, KENYA and NIGERIA FRAMEWORK
            $release['contracts'][0]['implementation']['milestones'] = $implementation_milestones;
            // The financial close and commercial close milestones goes in the raw contracts category
            $release['contracts'][0]['milestones'] = $contract_milestones;

        }

    }

    /**
     * Attach: Procurement Documents
     * @param array $release
     * @param Project $project
     */
    public function attachProjectProcurementDocuments(array &$release, Project $project)
    {
        if($project->isPDProcurementActive()){
            $pd_documents = $project->procurements()->get();
            $pack = self::stripEmptyItems(transform($pd_documents, new \App\Transformers\ProcurementDocumentApiTransformerV2));
            $documents = array();
            foreach($pack as $items){
                foreach($items as $item){
                    array_push($documents, $item);
                }
            }
            $tender_documents['tender']['documents'] = $documents;
            $release = array_merge_recursive($release, $tender_documents);
        }
    }

    /**
     * Attach: Project Parties
     * @param array $release
     * @param Project $project
     * @return void
     */
    public function attachProjectParties(array &$release, Project $project)
    {
        /**
         * TODO: There is an issue with the project importing via excel features that does not validates
         * TODO: duplicated ENTITIES inserts, the validation should be reworked for the next big update
         */
        $parties = $project->parties()->distinct()->get(); // Added "distinct()" here to avoid duplicate entries that will cause OCDS validation error
        $parties_builder['parties'] = transform($parties, (new PartiesApiTransformerV2));
        $release = array_merge_recursive($release, $parties_builder);
    }

    /**
     * Attach: Redacted PPP Agreement (UNIQUE) ZERO
     * @param array $release
     * @param Project $project
     */
    public function attachRedactedPPPAgreement(array &$release, Project $project)
    {
        if($project->isPDDocumentsActive()){
            // We retrieve only the first "contract" block due to the incompatibility of the platforms frameworks and the OCDS PPP profile
            $redactedPPPAgreement = $project->projectDetails->documents()->first();
            if($redactedPPPAgreement){
                $release['contracts'][0]['items'][0]['id'] = $redactedPPPAgreement->id;
                $release['contracts'][0]['items'][0]['description'] = $redactedPPPAgreement->description;
                $release['contracts'][0]['title'] = $redactedPPPAgreement->name;
                $release['contracts'][0]['dateSigned'] = (new \DateTime($redactedPPPAgreement->updated_at))->format('c');
                $release['contracts'][0]['documents'] = UploaderController::documentsApiLoader(
                    $redactedPPPAgreement->projectDetail->project,
                    ["section" => "d", "position" => $redactedPPPAgreement->id]
                );
            }
        }
    }

    /**
     * Attach: Award Contract Data (New section at V2 - 21/01/2019)
     * @param array $release
     * @param Project $project
     */
    public function attachAward(array &$release, Project $project)
    {
        if($project->isPDAwardActive()){
            // Retrieve all the award data
            $award = $project->projectDetails->award()->first();
            if($award){
                // Get financing party data
                $preferred_bidder = Entity::find($award->preferred_bidder_id);

                $release['awards'][0]['id'] = $award->award_code;
                $release['awards'][0]['title'] = $award->name;
                $release['awards'][0]['description'] = $award->description;
                $release['awards'][0]['status'] = ($award->status) ? $award->status->code : null;
                $release['awards'][0]['date'] =  ($award->award_date) ? (new \DateTime($award->award_date))->format('c') : null;
                $release['awards'][0]['value']['amount'] = $award->total_amount;
                $release['awards'][0]['value']['currency'] = ($award->total_amount) ? 'USD' : null;
                $release['awards'][0]['contractPeriod']['startDate'] = ($award->contract_signature_date) ? (new \DateTime($award->contract_signature_date))->format('c') : null;
                $release['awards'][0]['contractPeriod']['endDate'] = ($award->contract_signature_date_end) ? (new \DateTime($award->contract_signature_date_end))->format('c') : null;
                if($preferred_bidder){
                    $release['awards'][0]['preferredBidders'][0]['id'] = $preferred_bidder->id;
                    $release['awards'][0]['preferredBidders'][0]['name'] = $preferred_bidder->name;
                }
            }
        }
    }

    /**
     * Attach: Financing Award Data
     * @param array $release
     * @param Project $project
     */
    public function attachAwardFinancing(array &$release, Project $project)
    {
        /**
         * THIS SECTION IS ONLY FEATURING FINANCING INFORMATION
         * IT DOESN'T HAVE VISIBILITY OPTION AS OF V2 RELEASE
         * TODO: ADD VISIBILITY OPTIONS
         */
        $financing = $project->projectDetails->financing()->with('category')->get();
        if($financing){
            $finance_elements = array();
            foreach($financing as $f){

                // Get financing party data
                $financing_party = Entity::find($f->financing_party_id);

                array_push($finance_elements, array(
                    "id" => (string) $f->id,
                    "title" => $f->name,
                    "description" => $f->description,
                    "financingParty" => array(
                        "name" => $financing_party->name,
                        "id" => $financing_party->id
                    ),
                    "financeCategory" => $f->category->code,
                    "value" => array(
                        "amount" => $f->amount,
                        "currency" => 'USD'
                    ),
                    "period" => array(
                        "startDate" => ($f->start_date) ? (new \DateTime($f->start_date))->format('c') : null,
                        "endDate" => ($f->end_date) ? (new \DateTime($f->end_date))->format('c') : null
                    )
                ));
            }
            $release["contracts"][0]['finance'] = $finance_elements;
        }
    }

    /**
     * Attach: Project Financial Structure
     * @param array $release
     * @param Project $project
     */
    public function attachProjectFinancialStructure(array &$release, Project $project)
    {
        if($project->isPDFinancialActive()){
            $financialStructures = $project->projectDetails->financials()->get();
            if($financialStructures){
                foreach($financialStructures as $financialStructure){
                    $finance_data = array(
                        "id" => (string) $financialStructure->id,
                        "title" => $financialStructure->name,
                        "description" => $financialStructure->description
                    );
                    $finance_data["period"]["startDate"] = (new \DateTime($financialStructure->updated_at))->format('c');
                    $finance_data["period"]["endDate"] = (new \DateTime($financialStructure->updated_at))->format('c');
                    $documents = UploaderController::documentsApiLoader(
                        $financialStructure->projectDetail->project,
                        ["section" => "fi", "position" => $financialStructure->id]
                    );
                    if(count($documents)){
                        $release['contracts'][0]['documents'] = array_merge_recursive($release['contracts'][0]['documents'], $documents);
                    }
                    $release['contracts'][0]['finance'][] = $finance_data;
                }
            }
        }
    }

    /**
     * Attach: Project Risks
     * @param array $release
     * @param Project $project
     */
    public function attachProjectRisks(array &$release, Project $project)
    {
        if($project->isPDRisksActive()){
            $risks = $project->projectDetails->risks()->with('allocation')->get();
            $release['contracts'][0]['riskAllocation'] = transform($risks, (new RiskApiTransformerV2()));
        }
    }

    /**
     * Attach: Project Risks Documents
     * @param array $release
     * @param Project $project
     */
    public function attachProjectRisksDocuments(array &$release, Project $project)
    {
        if($project->isPDRisksActive()){

            $risk_documents = UploaderController::documentsApiLoader(
                $project,
                ["section" => "ri"]
            );
            if(count($risk_documents)){
                $release['contracts'][0]['documents'] = array_merge_recursive($release['contracts'][0]['documents'], $risk_documents);
            }

        }
    }

    /**
     * Attach: Project Tariffs
     * @param array $release
     * @param Project $project
     * @return void
     */
    public function attachProjectTariffs(array &$release, Project $project)
    {
        if($project->isPDTariffsActive()){
            $tariffs = $project->projectDetails->tariffs()->get();
            if($tariffs){
                foreach($tariffs as $tariff){
                    $tariff_data = array(
                        "id" => (string) $tariff->id,
                        "title" => $tariff->name,
                        "notes" => $tariff->description
                    );
                    if($tariff->paidBy){
                        $tariff_data["paidBy"] = $tariff->paidBy;
                    }
                    if($tariff->value){
                        $tariff_data["value"] = array(
                            "amount" => (float) $tariff->value,
                            "currency" => 'USD'
                        );
                    }
                    if($tariff->startDate){
                        $tariff_data["period"]["startDate"] = ($tariff->startDate) ? (new \DateTime($tariff->startDate))->format('c') : null;
                        $tariff_data["period"]["endDate"] = ($tariff->endDate) ? (new \DateTime($tariff->endDate))->format('c') : null;
                    }
                    $documents = UploaderController::documentsApiLoader(
                        $tariff->projectDetail->project,
                        ["section" => "t", "position" => $tariff->id]
                    );
                    if(count($documents)){
                        $release['contracts'][0]['documents'] = array_merge_recursive($release['contracts'][0]['documents'], $documents);
                    }
                    $release['contracts'][0]['implementation']['tariffs'][] = $tariff_data;
                }
            }
        }
    }

    /**
     * Attach: Key Performance Indicators
     * @param array $release
     * @param Project $project
     * @return void
     */
    public function attachKeyPerformanceIndicators(array &$release, Project $project)
    {
        if($project->isPIKeyPerformanceActive()){
            $kpis = $project->performanceInformation->keyPerformanceIndicators->indicators()->get();
            $release['contracts'][0]['implementation']['metrics'] = self::stripEmptyItems(transform($kpis, (new KeyPerformanceIndicatorsApiTransformerV2())));
        }
    }

    /**
     * Attach: Performance Failures
     * @param array $release
     * @param Project $project
     * @return void
     */
    public function attachProjectPerformanceFailures(array &$release, Project $project)
    {
        if($project->isPIPerformanceFailuresActive()){
            $performanceFailures = $project->performanceInformation->performanceFailures()->get();
            $release['contracts'][0]['implementation']['performanceFailures'] = self::stripEmptyItems(transform($performanceFailures, new \App\Transformers\PerformanceFailuresApiTransformerV2));
        }
    }

    /**
     * Attach: Performance Assessments Documents
     * @param array $release
     * @param Project $project
     */
    public function attachPerformanceAssessments(array &$release, Project $project)
    {
        if($project->isPIPerformanceAssessmentActive()){

            $assessments = $project->performanceInformation->performanceAssessments()->get();
            if($assessments){
                foreach($assessments as $assessment){
                    $documents = UploaderController::documentsApiLoader(
                        $assessment->performance_information->project,
                        array("section" => "pa", "position" => $assessment->id)
                    );
                    if(count($documents)){
                        $release['contracts'][0]['documents'] = array_merge_recursive($release['contracts'][0]['documents'], $documents);
                    }
                }
            }

        }
    }

    /**
     * Helper: Check if the milestone is in the tagged project stage
     * @param $milestoneTitle
     * @param $stage
     * @return bool
     */
    public function isInStage($milestoneTitle, $stage){

        switch ($milestoneTitle){

            case "Project proposal received":
            case "Project proposal screened":
            case "Project proposal enters list of published projects pipeline":
            case "Transaction Advisors appointed":
            case "Project feasibility study approved":
            case "OBC compliance certificate issued":
            case "FEC approval for OBC":
            case "FBC compliance certificate issued":
            case "Enters national priority list":
            case "Feasibility study starts":
            case "FEC approval for FBC": $is_in_stage = ($stage == "Planning") ? true : false; break;
            case "Commercial close":
            case "Financial close": $is_in_stage = ($stage == "Contract") ? true : false; break;
            case "Beginning of construction or development":
            case "Completion of construction or development":
            case "Commissioning of project":
            case "Expiry of contract":
            case "Construction started":
            case "Construction completed": $is_in_stage = ($stage == "Implementation") ? true : false; break;
            case "EOI":
            case "RFQ":
            case "RFP":
            case "Selection of preferred bidder":
            case "Award": $is_in_stage = ($stage == "Procurement") ? true : false; break;

            default: $is_in_stage = false;

        }

        return $is_in_stage;

    }

    /**
     * Helper: Strip Empty Items
     * @param array $pack
     * @return array
     */
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
     * Helper: enhance location with geodata if available
     * The geodata API proposal by the OCDS is having investment difficulties and their servers
     * are most of the time under heavy load, including an incoming change in their
     * API from Open Source to pay per use. We have extracted the data needed manually to avoid
     * any disruption of our API response.
     * @param $location_name
     * @return array
     */
    public function enhanceLocationWithGeodata($location_name){

        switch ($location_name){

            // Nigeria
            case 'Federal Capital Territory': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2352776')), 'uri' => 'http://www.geonames.org/2352776/federal-capital-territory.html'); break;
            case 'Abia': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2565340')), 'uri' => 'http://www.geonames.org/2565340/abia-state.html'); break;
            case 'Adamawa': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2565342')), 'uri' => 'http://www.geonames.org/2565342/adamawa-state.html'); break;
            case 'Akwa Ibom': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2350813')), 'uri' => 'http://www.geonames.org/2350813/akwa-ibom-state.html'); break;
            case 'Anambra': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2349961')), 'uri' => 'http://www.geonames.org/2349961/anambra-state.html'); break;
            case 'Bauchi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2347468')), 'uri' => 'http://www.geonames.org/2347468/bauchi-state.html'); break;
            case 'Bayelsa': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2595344')), 'uri' => 'http://www.geonames.org/2595344/bayelsa-state.html'); break;
            case 'Benue': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2347266')), 'uri' => 'http://www.geonames.org/2347266/benue-state.html'); break;
            case 'Borno': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2346794')), 'uri' => 'http://www.geonames.org/2346794/borno-state.html'); break;
            case 'Cross River': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2345891')), 'uri' => 'http://www.geonames.org/2345891/cross-river-state.html'); break;
            case 'Delta	region': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2565341')), 'uri' => 'http://www.geonames.org/2565341/delta-state.html'); break;
            case 'Ebonyi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2595345')), 'uri' => 'http://www.geonames.org/2595345/ebonyi-state.html'); break;
            case 'Edo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2565343')), 'uri' => 'http://www.geonames.org/2565343/edo.html'); break;
            case 'Ekiti': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2595346')), 'uri' => 'http://www.geonames.org/2595346/ekiti-state.html'); break;
            case 'Enugu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2565344')), 'uri' => 'http://www.geonames.org/2565344/enugu-state.html'); break;
            case 'Gombe': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2595347')), 'uri' => 'http://www.geonames.org/2595347/gombe-state.html'); break;
            case 'Imo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2337542')), 'uri' => 'http://www.geonames.org/2337542/imo-state.html'); break;
            case 'Jigawa': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2565345')), 'uri' => 'http://www.geonames.org/2565345/jigawa-state.html'); break;
            case 'Kaduna': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2335722')), 'uri' => 'http://www.geonames.org/2335722/kaduna-state.html'); break;
            case 'Kano': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2335196')), 'uri' => 'http://www.geonames.org/2335196/kano-state.html'); break;
            case 'Katsina': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2334797')), 'uri' => 'http://www.geonames.org/2334797/katsina-state.html'); break;
            case 'Kebbi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2597363')), 'uri' => 'http://www.geonames.org/2597363/kebbi-state.html'); break;
            case 'Kogi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2597364')), 'uri' => 'http://www.geonames.org/2597364/kogi-state.html'); break;
            case 'Kwara': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2332785')), 'uri' => 'http://www.geonames.org/2332785/kwara-state.html'); break;
            case 'Lagos': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2332453')), 'uri' => 'http://www.geonames.org/2332453/lagos-state.html'); break;
            case 'Nasarawa': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2595348')), 'uri' => 'http://www.geonames.org/2595348/nasarawa-state.html'); break;
            case 'Niger': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2328925')), 'uri' => 'http://www.geonames.org/2328925/niger-state.html'); break;
            case 'Ogun': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2327546')), 'uri' => 'http://www.geonames.org/2327546/ogun-state.html'); break;
            case 'Ondo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2326168')), 'uri' => 'http://www.geonames.org/2326168/ondo-state.html'); break;
            case 'Osun': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2597365')), 'uri' => 'http://www.geonames.org/2597365/osun-state.html'); break;
            case 'Oyo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2325190')), 'uri' => 'http://www.geonames.org/2325190/oyo-state.html'); break;
            case 'Plateau': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2324828')), 'uri' => 'http://www.geonames.org/2324828/plateau-state.html'); break;
            case 'Rivers': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2324433')), 'uri' => 'http://www.geonames.org/2324433/rivers-state.html'); break;
            case 'Sokoto': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2322907')), 'uri' => 'http://www.geonames.org/2322907/sokoto-state.html'); break;
            case 'Taraba': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2597366')), 'uri' => 'http://www.geonames.org/2597366/taraba-state.html'); break;
            case 'Yobe': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2597367')), 'uri' => 'http://www.geonames.org/2597367/yobe-state.html'); break;
            case 'Zamfara': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2595349')), 'uri' => 'http://www.geonames.org/2595349/zamfara-state.html'); break;

            // Ghana
            case 'Ashanti': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2304116')), 'uri' => 'http://www.geonames.org/2304116/ashanti-region.html'); break;
            case 'Brong-Ahafo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2302547')), 'uri' => 'http://www.geonames.org/2302547/brong-ahafo-region.html'); break;
            case 'Central': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2302353')), 'uri' => 'http://www.geonames.org/2302353/central-region.html'); break;
            case 'Eastern': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2301360')), 'uri' => 'http://www.geonames.org/2301360/eastern-region.html'); break;
            case 'Greater Accra': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2300569')), 'uri' => 'http://www.geonames.org/2300569/greater-accra-region.html'); break;
            case 'Northern': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2297169')), 'uri' => 'http://www.geonames.org/2297169/northern-region.html'); break;
            case 'Upper East': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2294291')), 'uri' => 'http://www.geonames.org/2294291/upper-east-region.html'); break;
            case 'Upper West': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2294286')), 'uri' => 'http://www.geonames.org/2294286/upper-west-region.html'); break;
            case 'Volta	region': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2294234')), 'uri' => 'http://www.geonames.org/2294234/volta-region.html'); break;
            case 'Western': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('2294076')), 'uri' => 'http://www.geonames.org/2294076/western-region.html'); break;

            // Kenya
            case 'Baringo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('200573')), 'uri' => 'http://www.geonames.org/200573/baringo.html'); break;
            case 'Bomet': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667666')), 'uri' => 'http://www.geonames.org/7667666/bomet.html'); break;
            case 'Bungoma': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('200066')), 'uri' => 'http://www.geonames.org/200066/bungoma.html'); break;
            case 'Busia': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('199987')), 'uri' => 'http://www.geonames.org/199987/busia.html'); break;
            case 'Elgeyo Marakwet': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667646')), 'uri' => 'http://www.geonames.org/7667646/elegeyo-marakwet.html'); break;
            case 'Embu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('198474')), 'uri' => 'http://www.geonames.org/198474/embu.html'); break;
            case 'Garissa': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('197744')), 'uri' => 'http://www.geonames.org/197744/garissa.html'); break;
            case 'Homa Bay': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667665')), 'uri' => 'http://www.geonames.org/7667665/homa-bay.html'); break;
            case 'Isiolo': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('196228')), 'uri' => 'http://www.geonames.org/196228/isiolo.html'); break;
            case 'Kajiado': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667657')), 'uri' => 'http://www.geonames.org/7667657/kajiado.html'); break;
            case 'Kakamega': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('195271')), 'uri' => 'http://www.geonames.org/195271/kakamega.html'); break;
            case 'Kericho': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('192898')), 'uri' => 'http://www.geonames.org/192898/kericho.html'); break;
            case 'Kiambu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('192709')), 'uri' => 'http://www.geonames.org/192709/kiambu.html'); break;
            case 'Kilifi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('192064')), 'uri' => 'http://www.geonames.org/192064/kilifi.html'); break;
            case 'Kirinyaga': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('191420')), 'uri' => 'http://www.geonames.org/191420/kirinyaga.html'); break;
            case 'Kisii	region': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('191298')), 'uri' => 'http://www.geonames.org/191298/kisii.html'); break;
            case 'Kisumu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('191242')), 'uri' => 'http://www.geonames.org/191242/kisumu.html'); break;
            case 'Kitui': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('191037')), 'uri' => 'http://www.geonames.org/191037/kitui.html'); break;
            case 'Kwale': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('190106')), 'uri' => 'http://www.geonames.org/190106/kwale.html'); break;
            case 'Laikipia': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('189794')), 'uri' => 'http://www.geonames.org/189794/laikipia.html'); break;
            case 'Lamu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667643')), 'uri' => 'http://www.geonames.org/7667643/lamu.html'); break;
            case 'Machakos': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667644')), 'uri' => 'http://www.geonames.org/7667644/machakos.html'); break;
            case 'Makueni': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667645')), 'uri' => 'http://www.geonames.org/7667645/makueni.html'); break;
            case 'Mandera': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('187895')), 'uri' => 'http://www.geonames.org/187895/mandera.html'); break;
            case 'Marsabit': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('187583')), 'uri' => 'http://www.geonames.org/187583/marsabit.html'); break;
            case 'Meru': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('186824')), 'uri' => 'http://www.geonames.org/186824/meru.html'); break;
            case 'Migori': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667678')), 'uri' => 'http://www.geonames.org/7667678/migori.html'); break;
            case 'Mombasa': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('186298')), 'uri' => 'http://www.geonames.org/186298/mombasa.html'); break;
            case "Murang'a": $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('185578')), 'uri' => 'http://www.geonames.org/185578/murang-a.html'); break;
            case 'Nairobi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('184742')), 'uri' => 'http://www.geonames.org/184742/nairobi.html'); break;
            case 'Nakuru': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7668902')), 'uri' => 'http://www.geonames.org/7668902/nakuru.html'); break;
            case 'Nandi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('8051212')), 'uri' => 'http://www.geonames.org/8051212/nandi.html'); break;
            case 'Narok': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7668904')), 'uri' => 'http://www.geonames.org/7668904/narok.html'); break;
            case 'Nyamira': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7806857')), 'uri' => 'http://www.geonames.org/7806857/nyamira.html'); break;
            case 'Nyandarua': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7603036')), 'uri' => 'http://www.geonames.org/7603036/nyandarua.html'); break;
            case 'Nyeri': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667661')), 'uri' => 'http://www.geonames.org/7667661/nyeri.html'); break;
            case 'Samburu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('180782')), 'uri' => 'http://www.geonames.org/180782/samburu.html'); break;
            case 'Siaya	region': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('180320')), 'uri' => 'http://www.geonames.org/180320/siaya.html'); break;
            case 'Taita Taveta': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667652')), 'uri' => 'http://www.geonames.org/7667652/taita-taveta.html'); break;
            case 'Tana River': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('179585')), 'uri' => 'http://www.geonames.org/179585/tana-river.html'); break;
            case 'Tharaka Nithi': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('179380')), 'uri' => 'http://www.geonames.org/179380/tharaka-nithi.html'); break;
            case 'Trans Nzoia': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('179068')), 'uri' => 'http://www.geonames.org/179068/trans-nzoia.html'); break;
            case 'Turkana': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('178914')), 'uri' => 'http://www.geonames.org/178914/turkana.html'); break;
            case 'Uasin Gishu': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('178837')), 'uri' => 'http://www.geonames.org/178837/uasin-gishu.html'); break;
            case 'Vihiga': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('7667638')), 'uri' => 'http://www.geonames.org/7667638/vihiga.html'); break;
            case 'Wajir': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('178440')), 'uri' => 'http://www.geonames.org/178440/wajir.html'); break;
            case 'West Pokot': $out = array('description' => $location_name, 'gazetteer' => array('scheme' => 'GEONAMES', 'identifiers' => array('178145')), 'uri' => 'http://www.geonames.org/178145/west-pokot.html'); break;

            default: $out = array('description' => $location_name);

        }

        return $out;

    }

    /**
     * Check API status.
     * The status of the API can be changed from the backend of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Api\Core\Translator\Src\TranslatorExceptions
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
