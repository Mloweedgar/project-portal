<?php

namespace App;

use App\Models\Config;
use App\Models\Entity;
use App\Models\Newsletter;
use App\Models\Permissions;
use App\Models\Prefix;
use App\Models\Project\Project;
use App\Models\Role;
use App\Models\Section;
use App\Models\Task;
use App\MyLibs\ProjectGenericConstants;
use App\Notifications\MyResetPassword;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use LogsActivity;


    protected static $logAttributes = [
        'name', 'email','telephone','inactive'
    ];


    protected $fillable = [
        'name', 'email', 'telephone','inactive'
    ];

    protected static $recordEvents = ['created','updated'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * Permission Field @IMPORTANT
     * The field is used to define what type of permission the user has
     * 0 Not assigned
     * 1 Sectors
     * 2 Projects
     * 3 Both (this works for administrator)
     */


    /**
     * The password attribute after insert is hashed.
     *
     * @var array
     */
    public function setPasswordAttribute($password){

        $this->attributes['password'] = bcrypt($password);

    }


    public function hasOldPassword(){

        // Get the max age for a password in days
        $maxAge = (int)Config::where('name','password_expiry_days')->first()->value;

        $dateToCompare = $this->password_updated_at ?? $this->created_at;

        $password_expiry_at = Carbon::parse($dateToCompare)->addDays($maxAge);

        return $password_expiry_at->lessThan(Carbon::now());

    }


    /**
     * The relationships.
     *
     * @var
     */
    public function role(){
        return $this->belongsTo(Models\Role::class);
    }


    /**
     * Function for checking if the user has an specific role
     * @param   $role role name
     * @return  boolean
     */
    public function hasRole($role){

        if (is_array($role)) {
            return  (in_array($this->role()->first()->name, $role));
        }

        return $this->role()->first()->name == $role ? true : false;
    }

    public function isAdmin(){
        return $this->hasRole('role_admin');
    }

    public function isDataEntry()
    {
        return $this->hasRole([
            'role_data_entry_generic', 'role_data_entry_project_coordinator'
        ]);
    }

    public function isGenericDataEntry()
    {
        return $this->hasRole('role_data_entry_generic');
    }

    public function isProjectCoordinator()
    {
        return $this->hasRole('role_data_entry_project_coordinator');
    }

    public function isViewOnly()
    {
        return $this->hasRole('role_viewer');
    }

    public function isIT(){
        return $this->hasRole('role_it');
    }

    public function isAuditor(){
        return $this->hasRole('role_auditor');
    }

    public function permissions(){
        return $this->belongsToMany(Permissions::class, 'permission_user', 'permission_id', 'user_id');
    }

    public function prefix(){
        return $this->belongsTo(Prefix::class);
    }

    public function entity(){
        return $this->belongsTo(Entity::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'user_id');
    }

    public function creator(){
        return $this->hasMany(Task::class, 'creator_id');
    }

    public function newsletter(){
        return $this->belongsTo(Newsletter::class);
    }

    public function sections(){
        return $this->belongsToMany('App\Models\Section', 'permission_user_section', 'user_id', 'section_id');
    }

    public function projectsPermissions(){
        return $this->belongsToMany('App\Models\Project\Project', 'permission_user_project', 'user_id', 'project_id');
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }
    public function projectCoordinatorDataEntries(){
        return $this->belongsToMany('App\User', 'coordinator_assigned_data_entries', 'project_coordinator', 'de_generic_id');
    }
    public function data_entries(){
        return $this->belongsToMany('App\User', 'coordinator_assigned_data_entries', 'de_generic_id', 'project_coordinator');
    }


    /**
     * Checks if the user can access to a specific project section.
     *
     * @param $project_id
     * @param $section_id
     * @return bool
     */
    public function hasPermission(Project $project, $section_id)
    {
        $section = Section::where('section_code', $section_id)->first();

        if (!$section || $section->active == '0') {
            return false;
        }

        $projectOrSectorValid = false;

        if ($this->isAdmin()) {

            return true;

        } elseif($project->user_id == $this->id) {

            $projectOrSectorValid = true;

        }elseif($this->hasProject($project->id)) {

            $projectOrSectorValid = true;

        } else {
            return false;
        }

        $userSections = $this->sections()->where('section_code', $section_id)->count() > 0 ? true : false;

        return ($userSections && $projectOrSectorValid);
    }

    /**
     * Function for checking if the user has an specific section
     * @param
     * @return boolean
     */
    private function hasSector($sector_id){
        return $this->sectors->where('id', $sector_id)->count() > 0 ? true : false;

    }

    /**
     * Function for checking if the user has an specific section
     * @param
     * @return boolean
     */
    private function hasProject($project_id){
        return $this->projectsPermissions()->where('project_id', $project_id)->count() > 0 ? true : false;
    }

    public function canAccessProjectInformation(Project $project)
    {

        $section = Section::where('section_code', 'i')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isProjectInformationActive() && $this->hasPermission($project, 'i'))));
    }

    public function canAccessContractMilestones(Project $project)
    {
        $section = Section::where('section_code', 'cm')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isContractMilestonesActive() && $this->hasPermission($project, 'cm'))));
    }

    public function canAccessParties(Project $project)
    {
        $section = Section::where('section_code', 'par')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPartiesActive() && $this->hasPermission($project, 'par'))));
    }

    public function canAccessProjectDetails(Project $project)
    {
        $section = Section::where('section_code', 'pd')->first()->active == 1 ? true : false;

        return ($section && ($this->isAdmin()
            || ($project->isProjectDetailsActive() && $this->hasPermission($project, 'pd'))));

    }

    public function canAccessPDDocuments(Project $project)
    {
        $section = Section::where('section_code', 'd')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDDocumentsActive() && $this->hasPermission($project, 'd'))));
    }

    public function canAccessPDEnvironment(Project $project)
    {
        $section = Section::where('section_code', 'env')->first()->active == 1 ? true : false;

        return ($section && ($this->isAdmin()
                || ($project->isPDEnvironmentActive() && $this->hasPermission($project, 'env'))));
    }

    public function canAccessPDAnnouncements(Project $project)
    {
        $section = Section::where('section_code', 'a')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDAnnouncementsActive() && $this->hasPermission($project, 'a'))));
    }

    public function canAccessPDProcurementInformation(Project $project)
    {
        $section = Section::where('section_code', 'pri')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDProcurementActive() && $this->hasPermission($project, 'pri'))));
    }

    public function canAccessPDRisks(Project $project)
    {
        $section = Section::where('section_code', 'ri')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDRisksActive() && $this->hasPermission($project, 'ri'))));
    }

    public function canAccessPDEvaluationPPP(Project $project)
    {
        $section = Section::where('section_code', 'e')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDEvaluationPPPActive() && $this->hasPermission($project, 'e'))));
    }

    public function canAccessPDFinancialSupport(Project $project)
    {
        $section = Section::where('section_code', 'fi')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDFinancialActive() && $this->hasPermission($project, 'fi'))));
    }

    public function canAccessPDGovernmentSupport(Project $project)
    {
        $section = Section::where('section_code', 'gs')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDGovernmentSupportActive() && $this->hasPermission($project, 'gs'))));
    }

    public function canAccessPDTariffs(Project $project)
    {
        $section = Section::where('section_code', 't')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDTariffsActive() && $this->hasPermission($project, 't'))));
    }

    public function canAccessPDContractTermination(Project $project)
    {
        $section = Section::where('section_code', 'ct')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDContractTerminationActive() && $this->hasPermission($project, 'ct'))));
    }


    public function canAccessPDRenegotiations(Project $project)
    {
        $section = Section::where('section_code', 'r')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDRenegotiationsActive() && $this->hasPermission($project, 'r'))));
    }

    public function canAccessPDAward(Project $project)
    {
        $section = Section::where('section_code', 'aw')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
                || ($project->isPDAwardActive() && $this->hasPermission($project, 'aw'))));
    }

    public function canAccessPDContractSummary(Project $project)
    {
        $section = Section::where('section_code', 'cs')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPDContractSummaryActive() && $this->hasPermission($project, 'cs'))));
    }

    public function canAccessPerformanceInformation(Project $project)
    {
        $section = Section::where('section_code', 'pi')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPerformanceInformationActive() && $this->hasPermission($project, 'pi'))));
    }

    public function canAccessPIAnnualDemandLevels(Project $project)
    {
        $section = Section::where('section_code', 'dl')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPIAnnualDemandLevelsActive() && $this->hasPermission($project, 'dl'))));
    }

    public function canAccessPIIncomeStatementsMetrics(Project $project)
    {
        $section = Section::where('section_code', 'ism')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPIIncomeStatementsActive() && $this->hasPermission($project, 'ism'))));
    }

    public function canAccessPIOtherFinancialMetrics(Project $project)
    {
        $section = Section::where('section_code', 'of')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPIOtherFinancialMetricsActive() && $this->hasPermission($project, 'of'))));
    }

    public function canAccessPIKeyPerformanceIndicators(Project $project)
    {
        $section = Section::where('section_code', 'kpi')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPIKeyPerformanceActive() && $this->hasPermission($project, 'kpi'))));
    }

    public function canAccessPIPerformanceFailures(Project $project)
    {
        $section = Section::where('section_code', 'pf')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPIPerformanceFailuresActive() && $this->hasPermission($project, 'pf'))));
    }

    public function canAccessPIPerformanceAssessments(Project $project)
    {
        $section = Section::where('section_code', 'pa')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isPIPerformanceAssessmentActive() && $this->hasPermission($project, 'pa'))));
    }

    public function canAccessGallery(Project $project)
    {
        $section = Section::where('section_code', 'g')->first()->active == 1 ? true : false;
        return ($section && ($this->isAdmin()
            || ($project->isGalleryActive() && $this->hasPermission($project, 'g'))));
    }

    public function canAccessTasks()
    {
        return ($this->isAdmin() || $this->isDataEntry());
    }

    public function canAccessEntities()
    {
        return ($this->isAdmin() || $this->hasRole([
                'role_data_entry_generic',
                'role_data_entry_project_coordinator',
                'role_viewer'
        ]));
    }

    public function canCreate($project = null, $section=null)
    {
        return ($this->isAdmin() || $this->isProjectCoordinator()? true : false);
    }

    public function canDraft()
    {
        return ($this->hasRole([
            'role_data_entry_generic',
        ]));
    }

    public function canPublish($project, $section, $position)
    {
        //return ($this->isAdmin());
        return ($this->isAdmin() || $this->isProjectCoordinator() ? true : false);
    }

    public function canDelete()
    {
        // return $this->isAdmin();
        return ($this->isAdmin() || $this->isProjectCoordinator() ? true : false);
    }

    public function canRequestModification()
    {
        return ($this->hasRole([
            'role_data_entry_generic',
        ]));
    }

    public function getFirstProjectUrl(Project $project)
    {
        $firstMainUrls = [
            'i' => route('project.project-information', array('id' => $project->id)),
            'cm' => route('project.contract-milestones', array('id' => $project->id)),
            'par' => route('project.parties', array('id' => $project->id)),
            'pri' => route('project.procurement', array('id' => $project->id)),

            /*
            'pd' => route('project-details-documents', array('id' => $project->id)),
            'd' => route('project-details-documents', array('id' => $project->id)),
            'a' => route('project-details-announcements', array('id' => $project->id)),
            'ri' => route('project-details-risks', array('id' => $project->id)),
            'e' => route('project-details-evaluation-ppp', array('id' => $project->id)),
            'fi' => route('project-details-financial', array('id' => $project->id)),
            'gs' => route('project-details-government-support', array('id' => $project->id)),
            't' => route('project-details-tariffs', array('id' => $project->id)),
            'ct' => route('project-details-contract-termination', array('id' => $project->id)),
            'r' => route('project-details-renegotiations', array('id' => $project->id)),
            'env' => route('project-details-environment', array('id' => $project->id)),

            'pi' => route('project.performance-information.annual-demand-levels', array('id' => $project->id)),
            'dl' => route('project.performance-information.annual-demand-levels', array('id' => $project->id)),
            'ism' => route('project.performance-information.income-statements-metrics', array('id' => $project->id)),
            'of' => route('project.performance-information.other-financial-metrics', array('id' => $project->id)),
            'kpi' => route('project.performance-information.key-performance-indicators', array('id' => $project->id)),
            'pf' => route('project.performance-information.performance-failures', array('id' => $project->id)),
            'pa' => route('project.performance-information.performance-assessments', array('id' => $project->id)),
            */
        ];

        $projectDetailsUrls = ProjectGenericConstants::getProjectDetailsOrder($project);

        $projectPerformanceUrls = ProjectGenericConstants::getProjectPerformanceOrder($project);

        $lastMainUrls = [

            'g' => route('project.gallery', array('id' => $project->id))

        ];

        $urls = array_merge($firstMainUrls, $projectDetailsUrls, $projectPerformanceUrls, $lastMainUrls);

        foreach ($urls as $section_id => $url) {
            if ($this->hasPermission($project, $section_id)) {
                return $urls[$section_id];
            }
        }

        return false;
    }

    public function getProjecDetailstSectionUrl(Project $project)
    {

        $urls = ProjectGenericConstants::getProjectDetailsOrder($project);

        $visibleSections = $project->visibleSections();
        foreach ($urls as $section_id => $url) {
            if(($this->isAdmin() || in_array($section_id, $visibleSections)) && $this->hasPermission($project, $section_id)) {
                return $urls[$section_id];
            }
        }

        return false;
    }

    public function getProjectPerformanceSectiontUrl(Project $project)
    {
        $urls = ProjectGenericConstants::getProjectPerformanceOrder($project);

        $visibleSections = $project->visibleSections();
        foreach ($urls as $section_id => $url) {
            if (($this->isAdmin() || in_array($section_id, $visibleSections)) && $this->hasPermission($project, $section_id)) {
                return $urls[$section_id];
            }
        }

        return false;
    }

    /**
     * Reset Password
     */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

}
