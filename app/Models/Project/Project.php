<?php

namespace App\Models\Project;

use App\Models\Entity;
use App\Models\ProjectGallery;
use App\Models\Task;
use App\Models\Permissions\PEUserProjects;
use App\Models\Project\ContractMilestones\ContractMilestone;
use App\Models\Project\PerformanceInformation\PerformanceInformation;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectInformation;
use App\Models\Section;
use App\Models\Project\ProjectDetails\PD_Procurement;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{

    use LogsActivity;

    protected $fillable = ['id','name'];

    protected static $logAttributes = ['id','name'];

    protected static $recordEvents = ['created','deleted'];

    use Searchable;

    /**
     * INDEX name
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'projects';
    }

    /**
     * FULLTEXT fields for scout searching
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }

    /**
     * Scope a query to return a like query regarding to a custom field.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $field
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public  function scopeLike($query, $field, $value){

        return $query->where($field, 'LIKE', "%$value%");

    }

    /*
     Update project date
    */


    /*
     |--------------------------------------------------------------------------
     |  Relationships Block
     |--------------------------------------------------------------------------
     |
     */

    public function procurements()
    {
        return $this->hasMany(PD_Procurement::class);
    }

    public function projectGalleries(){

        $this->hasMany(ProjectGallery::class);

    }

    public function projectInformation(){

        return $this->hasOne(ProjectInformation::class);

    }
    public function performanceInformation(){

        return $this->hasOne(PerformanceInformation::class);

    }

    public function userPermissions(){
        return $this->belongsToMany('App\User', 'permission_user_project', 'project_id', 'user_id');
    }


    public function contractMilestones(){

        return $this->hasMany(ContractMilestone::class);

    }

    public function projectDetails(){

        return $this->hasOne(ProjectDetail::class);

    }

    public function entities(){

        return $this->belongsToMany(Entity::class, 'entity_project', 'project_id', 'entity_id')->withPivot('party', 'sponsor');

    }

    public function sponsor(){
        return $this->belongsToMany(Entity::class, 'entity_project', 'project_id', 'entity_id')->wherePivot('sponsor', 1);
    }


    public function parties(){
        return $this->belongsToMany(Entity::class, 'entity_project', 'project_id', 'entity_id')->wherePivot('party', 1);
    }

    public function party($entity_id){
        return $this->belongsToMany(Entity::class, 'entity_project', 'project_id', 'entity_id')->wherePivot('party',1)->wherePivot('entity_id', $entity_id)->first();
    }


    public function tasks(){

        $this->hasMany(Task::class);

    }

    public function users(){

        return $this->belongsToMany('App\User', 'permission_user_project');

    }

    /*
     |--------------------------------------------------------------------------
     |  End Relationships block
     |--------------------------------------------------------------------------
     |
     |
     */

    public function isProjectInformationActive()
    {
        // Project basic information
        $section = Section::where('section_code', 'i')->first();
        return ($section->active == '1' && $this->project_information_active == '1');
    }

    public function isContractMilestonesActive()
    {
        // Contract milestones
        $section = Section::where('section_code', 'cm')->first();
        return ($section->active == '1' && $this->contract_milestones_active == '1');
    }

    public function isPDContractSummaryActive()
    {
        // Contract summary
        $section = Section::where('section_code', 'cs')->first();
        return ($section->active == '1' &&  $this->projectDetails->contract_summary_active == 1);
    }

    public function isPartiesActive()
    {
        // Parties
        $section = Section::where('section_code', 'par')->first();
        return ($section->active == '1' && $this->parties_active == '1');
    }

    public function isProjectDetailsActive()
    {
        // Project details
        $section = Section::where('section_code', 'pd')->first();

        $visibility = false;

        if ($this->projectDetails->financial_active == 1 || $this->projectDetails->documents_active == 1
            ||$this->projectDetails->environment_active == 1 ||$this->projectDetails->risks_active == 1
            ||$this->projectDetails->government_support_active == 1 ||$this->projectDetails->tariffs_active == 1
            ||$this->projectDetails->contract_termination_active == 1 ||$this->projectDetails->renegotiations_active == 1){

            $visibility = true;
        }

        return ($section->active == '1' && $this->project_details_active == '1' && $visibility);
    }

    public function isPDDocumentsActive()
    {
        // Project details
        $section = Section::where('section_code', 'd')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->documents_active == '1');
    }

    public function isPDEnvironmentActive()
    {
        // Project details
        $section = Section::where('section_code', 'env')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->environment_active == '1');
    }

    public function isPDAnnouncementsActive()
    {
        // Project details
        $section = Section::where('section_code', 'a')->first();
        return ($section->active == '1' && $this->announcements_active == '1');
    }

    public function isPDProcurementActive()
    {
        // Project details
        $section = Section::where('section_code', 'pri')->first();
        return ($section->active == '1' && $this->procurement_active == '1');
    }

    public function isPDRisksActive()
    {
        // Project details
        $section = Section::where('section_code', 'ri')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->risks_active == '1');
    }

    public function isPDEvaluationPPPActive()
    {
        // Project details
        $section = Section::where('section_code', 'e')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->evaluation_ppp_active == '1');
    }

    public function isPDFinancialActive()
    {
        // Project details
        $section = Section::where('section_code', 'fi')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->financial_active == '1');
    }

    public function isPDGovernmentSupportActive()
    {
        // Project details
        $section = Section::where('section_code', 'gs')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->government_support_active == '1');
    }

    public function isPDTariffsActive()
    {
        // Project details
        $section = Section::where('section_code', 't')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->tariffs_active == '1');
    }

    public function isPDContractTerminationActive()
    {
        // Project details
        $section = Section::where('section_code', 'ct')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->contract_termination_active == '1');
    }

    public function isPDRenegotiationsActive()
    {
        // Project details
        $section = Section::where('section_code', 'r')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->renegotiations_active == '1');
    }

    public function isPDAwardActive()
    {
        // Project details
        $section = Section::where('section_code', 'aw')->first();
        return ($section->active == '1' && $this->projectDetails()->first()->award_active == '1');
    }

    public function isPerformanceInformationActive()
    {
        // Performance information
        $section = Section::where('section_code', 'pi')->first();
        $visibility = false;

        if ($this->performanceInformation->key_performance_active == 1 || $this->performanceInformation->performance_failures_active == 1 ||$this->performanceInformation->performance_assessment_active == 1){
            $visibility = true;
        }
        return ($section->active == '1' && $this->performance_information_active == '1' && $visibility);
    }

    public function isPIAnnualDemandLevelsActive()
    {
        // Project details
        $section = Section::where('section_code', 'dl')->first();
        return ($section->active == '1' && $this->performanceInformation()->first()->annual_demmand_active == '1');
    }

    public function isPIIncomeStatementsActive()
    {
        // Project details
        $section = Section::where('section_code', 'ism')->first();
        return ($section->active == '1' && $this->performanceInformation()->first()->income_statements_active == '1');
    }

    public function isPIOtherFinancialMetricsActive()
    {
        // Project details
        $section = Section::where('section_code', 'of')->first();
        return ($section->active == '1' && $this->performanceInformation()->first()->timeless_financial_active == '1');
    }
    public function isPIKeyPerformanceActive()
    {
        // Project details
        $section = Section::where('section_code', 'kpi')->first();
        return ($section->active == '1' && $this->performanceInformation()->first()->key_performance_active == '1');
    }

    public function isPIPerformanceFailuresActive()
    {
        // Project details
        $section = Section::where('section_code', 'pf')->first();
        return ($section->active == '1' && $this->performanceInformation()->first()->performance_failures_active == '1');
    }

    public function isPIPerformanceAssessmentActive()
    {
        // Project details
        $section = Section::where('section_code', 'pa')->first();
        return ($section->active == '1' && $this->performanceInformation()->first()->performance_assessment_active == '1');
    }

    public function isGalleryActive()
    {
        // Gallery
        $section = Section::where('section_code', 'g')->first();
        return ($section->active == '1' && $this->gallery_active == '1');
    }

    public function getAvailableSections($get = true)
    {
        // parents
        $parentSections = [
            'i' => 'project_information_active',
            'cm' => 'contract_milestones_active',
            'parties' => 'parties_active',
            'pd' => 'project_details_active',
            'pi' => 'performance_information_active',
            'g' => 'gallery_active',
            'a' => 'announcements_active',
        ];

        // $parent => [ $children ]
        $childrenSections = [
            // project_details
            'pd' => [
                'd' => 'documents_active',
                'pri' => 'procurement_active',
                'ri' => 'risks_active',
                'e' => 'evaluation_ppp_active',
                'fi' => 'financial_active',
                'gs' => 'government_support_active',
                't' => 'tariffs_active',
                'ct' => 'contract_termination_active',
                'r' => 'renegotiations_active',
            ],
            // performance_information
            'pi' => [
                'dl' => 'annual_demmand_active',
                'ism' => 'income_statements_active',
                'of' => 'annual_financial_active',
                'kpi' => 'key_performance_active',
                'pf' => 'performance_failures_active',
                'pa' => 'performance_assessment_active',
            ],
        ];

        $availableSections = [];

        foreach ($parentSections as $section_code => $field) {
            if ($this->{$field} == 1) {
                // with no children
                if (!isset($childrenSections[$section_code])) {
                    $availableSections[] = $section_code;
                } else {
                    $availableSections[] = $section_code;
                    // performance information
                    if ($section_code === 'pi') {
                        $performanceInfo = $this->performanceInformation()->first();
                        $performanceInfoSections = $childrenSections[$section_code];
                        foreach ($performanceInfoSections as $piId => $piField) {
                            if ($performanceInfo->{$piField} == 1) {
                                $availableSections[] = $piId;
                            }
                        }
                    } else {
                    // project details
                        $projectDetails = $this->projectDetails()->first();
                        $performanceInfoSections = $childrenSections[$section_code];
                        foreach ($performanceInfoSections as $pdId => $pdField) {
                            if ($projectDetails->{$pdField} == 1) {
                                $availableSections[] = $pdId;
                            }
                        }
                    }
                }
            }
        }

        $sections =  Section::whereIn('section_code', $availableSections)->where('active', 1);

        if ($get) {
            return $sections->get();
        } else {
            return $sections;
        }
    }

    public function getSectionPositions(Section $section)
    {
        switch ($section->section_code) {
            // Basic info
            case 'i':
                return $this->projectInformation()->first()->getInformation();
                break;

            case 'cm':
                return $this->contractMilestones()->get();
                break;

            case 'par':
                return $this->parties()->get();
                break;

            case 'd':
                return $this->projectDetails()->first()->documents()->get();
                break;

            case 'a':
                return $this->announcements()->get();
                break;

            case 'pri':
                return $this->procurements()->get();
                break;

            case 'ri':
                return $this->projectDetails()->first()->risks()->get();
                break;

            case 'e':
                return $this->projectDetails()->first()->evaluationsPPP()->get();
                break;

            case 'fi':
                return $this->projectDetails()->first()->financials()->get();
                break;

            case 'gs':
                return $this->projectDetails()->first()->governmentSupports()->get();
                break;

            case 't':
                return $this->projectDetails()->first()->tariffs()->get();
                break;

            case 'ct':
                return $this->projectDetails()->first()->contractTerminations()->get();
                break;

            case 'r':
                return $this->projectDetails()->first()->renegotiations()->get();
                break;

            case 'aw':
                return $this->projectDetails()->first()->award()->get();
                break;


            // can only give to all the section
            case 'dl':
            case 'ism':
            case 'of':
            case 'kpi':
            case 'g':
            case 'env':
                return null;
                break;

            case 'pf':
                return $this->performanceInformation()->first()->performanceFailures()->get();
                break;

            case 'pa':
                return $this->performanceInformation()->first()->performanceAssessments()->get();
                break;
        }
    }

    public function visibleSections(){

        $visible = [];

        if ($this->project_information_active){
            array_push($visible,'i');
        }

        if ($this->contract_milestones_active){
            array_push($visible,'cm');
        }

        if ($this->parties_active){
            array_push($visible,'par');
        }

        if ($this->project_details_active){
            array_push($visible,'pd');
        }

        if ($this->performance_information_active){
            array_push($visible,'pi');
        }

        if ($this->gallery_active){
            array_push($visible,'g');
        }

        $projectDetails = $this->projectDetails;

        if ($projectDetails->documents_active){
            array_push($visible,'d');
        }

        if ($this->announcements_active){
            array_push($visible,'a');
        }

        if ($projectDetails->award_active){
            array_push($visible,'aw');
        }

        if ($projectDetails->procurement_active){
            array_push($visible,'pri');
        }

        if ($projectDetails->risks_active){
            array_push($visible,'ri');
        }

        if ($projectDetails->evaluation_ppp_active){
            array_push($visible,'e');
        }

        if ($projectDetails->financial_active){
            array_push($visible,'fi');
        }

        if ($projectDetails->government_support_active){
            array_push($visible,'gs');
        }

        if ($projectDetails->tariffs_active){
            array_push($visible,'t');
        }

        if ($projectDetails->contract_termination_active){
            array_push($visible,'ct');
        }

        if ($projectDetails->renegotiations_active){
            array_push($visible,'r');
        }

        if ($projectDetails->documents_active){
            array_push($visible,'env');
        }

        if ($projectDetails->contract_summary_active){
            array_push($visible,'cs');
        }

        $performanceInfo = $this->performanceInformation;

        if ($performanceInfo->annual_demmand_active){
            array_push($visible,'dl');
        }

        if ($performanceInfo->income_statements_active){
            array_push($visible,'ism');
        }

        if ($performanceInfo->timeless_financial_active){
            array_push($visible,'tf');
        }

        if ($performanceInfo->annual_financial_active){
            array_push($visible,'af');
        }

        if ($performanceInfo->key_performance_active){
            array_push($visible,'kpi');
        }

        if ($performanceInfo->performance_failures_active){
            array_push($visible,'pf');
        }

        if ($performanceInfo->performance_assessment_active){
            array_push($visible,'pa');
        }


        return $visible;

    }

    public function getSectorName($sector){
        $name = "";

        switch ($sector){

            case "i":
                $name = trans('project.section.project_basic_information');
                break;
            case "cm":
                $name = trans('project.section.contract_milestones');
                break;
            case "par":
                $name = trans('project.section.parties');
                break;
            case "pd":
                $name = trans('project.section.project_details_title');
                break;
            case "pi":
                $name = trans('project.section.performance_information_title');
                break;
            case "g":
                $name = trans('project.section.gallery');
                break;
            case "d":
                $name = trans('project.section.project_details.documents');
                break;
            case "a":
                $name = trans('project.section.project_details.announcements');
                break;
            case "pri":
                $name = trans('project.section.project_details.procurement');
                break;
            case "ri":
                $name = trans('project.section.project_details.risks');
                break;
            case "e":
                $name = trans('project.section.project_details.evaluation-ppp');
                break;
            case "fi":
                $name = trans('project.section.project_details.financial');
                break;
            case "gs":
                $name = trans('project.section.project_details.government-support');
                break;
            case "t":
                $name = trans('project.section.project_details.tariffs');
                break;
            case "ct":
                $name = trans('project.section.project_details.contract-termination');
                break;
            case "r":
                $name = trans('project.section.project_details.renegotiations');
                break;
            case "dl":
                $name = trans('project.section.performance_information.annual_demand_levels');
                break;
            case "ism":
                $name = trans('project.section.performance_information.income_statements_metrics');
                break;
            case "tf":
                $name = trans('project/performance-information/other_financial_metrics.timeless_title');
                break;
            case "af":
                $name = trans('project/performance-information/other_financial_metrics.annual_title');
                break;
            case "kpi":
                $name = trans('project.section.performance_information.key_performance_indicators');
                break;
            case "pf":
                $name = trans('project.section.performance_information.performance_failures');
                break;
            case "pa":
                $name = trans('project.section.performance_information.performance-assessments');
                break;
            case "env":
                $name = trans('project.section.project_details.environment');
                break;
            case "cs":
                $name = trans('project.section.project_details.contract-summary');
                break;
            case "aw":
                $name = trans('project.section.project_details.award');
                break;

        }

        return $name;
    }


    public function isProcurementOrHigher()
    {
        return ($this->projectInformation()->first()->stage_id >= 2);
    }

    public function isPostprocurement()
    {
        return ($this->projectInformation()->first()->stage_id >= 3);
    }

    public function getType()
    {
        return $this->projectInformation()->first()->type;
    }

    public function getTypeName()
    {
       return $this->projectInformation()->first()->getTypeName();
    }

    public function isTypePublic()
    {
        return ($this->getType() === 1);
    }

    public function isTypePrivate()
    {
        return ($this->getType() === 2);
    }

    public function isTypePPP()
    {
        return ($this->getType() === 3);
    }

}
