<?php

namespace App\Models;

use App\Http\Controllers\Backend\Project\ProjectInformationController;
use App\Models\Project\ProjectDetails\PD_Award;
use App\User;
use App\Models\Project\Project;
use App\Models\Project\ContractMilestones\MilestonesType;
use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kenya\ProjectsTableSeeder;

use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{

    use LogsActivity;

    protected $fillable = ['user_id','project_id','section','position','status','reason_declined','name','reason','data_json'];

    protected static $logAttributes = ['user_id','project_id','section','position','status','reason_declined','name','reason','data_json'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function roles(){
        return $this->belongsTo(Role::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function section()
    {
        return Section::where('section_code', $this->section);
    }

    public function getSectionName()
    {
        return $this->section()->first()->name;
    }

    public function isCreateRequest()
    {
        return ($this->position == 0);
    }

    public function isUpdateRequest()
    {
        return ($this->position != 0);
    }

    public static function exists($project, $section, $position){

        $out = DB::table("tasks")->where(['project_id' => $project, 'section' => $section, 'position' => $position, 'status' => null])->count();
        $out += DB::table("tasks")->where(['project_id' => $project, 'section' => $section, 'position' => $position, 'status' => 2])->count();

        return $out;

    }

    public function getHumanReadableData()
    {
        $data = json_decode($this->data_json);

        $readable = [];

        $common = ['title', 'name', 'description', 'date', 'deadline'];
        foreach ($common as $c) {
            if (isset($data->{$c})) {
                $readable[$c] = [
                    'label' => trans('task.'.$c),
                    'value' => $data->{$c}
                ];
            }
        }

        switch ($this->section) {
            // Basic info
            case 'i':

                if ($this->position == 1){

                    // Sectors
                    $sectors = Sector::whereIn('id',$data->sectors)->get()->toArray();
                    $sectors_names = array_column($sectors, 'name');

                    // Regions
                    $regions = Location::whereIn('id', $data->regions)->get()->toArray();
                    $regions_names = array_column($regions, 'name');

                    // Stage
                    $stage = Stage::where('id', $data->stage)->first();

                    // Sponsor
                    $sponsor = Entity::where('id', $data->sponsor)->first();

                    // Cofog
                    $cofog = DB::table('sectors_cofog')->where('id', $data->cofog)->first();

                    $readable['sectors'] = [
                        'label' => trans('general.sector'),
                        'value' => implode(', ', $sectors_names)
                    ];
                    $readable['regions'] = [
                        'label' => trans('general.region'),
                        'value' => implode(', ', $regions_names)
                    ];
                    $readable['stage'] = [
                        'label' => trans('general.phase'),
                        'value' => $stage->name
                    ];
                    $readable['sponsor'] = [
                        'label' => trans('general.sponsor-agency'),
                        'value' => $sponsor->name
                    ];
                    $readable['project_value_usd'] = [
                        'label' => trans('project/project-information.project_value_usd'),
                        'value' => $data->project_value_usd
                    ];
                    $readable['project_value_second'] = [
                        'label' => trans('project/project-information.project_value_second'),
                        'value' => $data->project_value_second
                    ];
                    if($cofog)
                    {
                        $readable['cofog'] = [
                            'label' => trans('general.cofog'),
                            'value' => $cofog->name
                        ];
                    }
                    // $readable['ocid'] = [
                    //     'label' => trans('project/project-information.ocid'),
                    //     'value' => $data->ocid
                    // ];

                } else if ($this->position == 2){

                    $readable['description'] = [
                        'label' => trans('project/project-information.project-need'),
                        'value' => $data->description
                    ];

                } else if ($this->position == 3){

                    $readable['description'] = [
                        'label' => trans('project/project-information.description-asset'),
                        'value' => $data->description
                    ];

                } else if ($this->position == 4){

                    $readable['description'] = [
                        'label' => trans('project/project-information.description-services'),
                        'value' => $data->description
                    ];

                } else if ($this->position == 5){

                    $readable['description'] = [
                        'label' => trans('project/project-information.reasons-ppp'),
                        'value' => $data->description
                    ];

                } else if ($this->position == 6){

                    $readable['description'] = [
                        'label' => trans('project/project-information.stakeholder-consultation'),
                        'value' => $data->description
                    ];

                }

                /*if ($this->position == 7){
                    $readable['description'] = [
                        'label' => trans('project/project-information.project_summary_document'),
                        'value' => $data->description
                    ];
                }*/
                break;


            // name, milestone_type, date, description
            case 'cm':
                $data->milestone_type = \App\Models\Project\ContractMilestones\MilestonesType::find($data->milestone_type)->name;
                $readable['milestone_type'] = [
                    'label' => trans('project/contract-milestones.milestone-type'),
                    'value' => $data->milestone_type
                ];
                break;

            case 'd':
                break;

            case 'a':
                break;

            case 'pri':
                break;

            case 'par':
                $data->party = \App\Models\Entity::find($data->party)->name;
                $readable['party'] = [
                    'label' => trans('project/party.party'),
                    'value' => $data->party
                ];
                break;

            case 'ri':
                $data->risk_allocation_id = \App\Models\Project\ProjectDetails\PD_RiskAllocation::find($data->risk_allocation_id)->name;
                $readable['risk_allocation_id'] = [
                    'label' => trans('project/project-details/risks.allocation'),
                    'value' => $data->risk_allocation_id
                ];
                $readable['mitigation'] = [
                    'label' => trans('project/project-details/risks.mitigation'),
                    'value' => $data->mitigation
                ];
                break;

            case 'e':
                return $this->projectDetails()->first()->evaluationsPPP()->get();
                break;

            case 'fi':
                break;

            case 'gs':
                break;

            case 't':
                break;

            case 'ct':
                if ($data->party_type == 'operator') {
                    $data->party_type = trans('project/project-details/contract-termination.party_operator');
                } else {
                    $data->party_type = trans('project/project-details/contract-termination.party_authority');
                }
                $readable['party_type'] = [
                    'label' => trans('project/project-details/contract-termination.party'),
                    'value' => $data->party_type
                ];
                $readable['termination_payment'] = [
                    'label' => trans('project/project-details/contract-termination.termination_payment'),
                    'value' => $data->termination_payment
                ];
                break;

            case "kpi":
                if ($this->position == 0) {
                    $data->kpi_type = \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorKpiType::find($data->kpi_type)->name;
                    $readable['kpi_type'] = [
                        'label' => trans('project/performance-information/key_performance_indicators.kpi'),
                        'value' => $data->kpi_type
                    ];
                    $readable['year'] = [
                        'label' => trans('project/performance-information/key_performance_indicators.year'),
                        'value' => $data->year
                    ];
                    $readable['target'] = [
                        'label' => trans('project/performance-information/key_performance_indicators.target'),
                        'value' => $data->target
                    ];
                    $readable['achievement'] = [
                        'label' => trans('project/performance-information/key_performance_indicators.achievement'),
                        'value' => $data->achievement
                    ];
                } else {
                    $existingRecords = [];
                    if (isset($data->existingRecords)) {
                        $kpiIds = array_map(function($e) {
                            return is_object($e) ? $e->id: $e['id'];
                        }, $data->existingRecords);

                        $existingRecords = \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator::select([
                            'pi_key_performance_indicators.id',
                            'pi_key_performance_indicators.year',
                            'pi_key_performance_indicators_kpi_types.name AS type_name'
                        ])
                        ->whereIn('pi_key_performance_indicators.id', $kpiIds)
                        ->join('pi_key_performance_indicators_kpi_types', 'pi_key_performance_indicators.type_id', '=', 'pi_key_performance_indicators_kpi_types.id')
                        ->get()
                        ->toArray();

                        foreach ($data->existingRecords as $existingRecord) {
                            $id = array_search($existingRecord->id, array_column($existingRecords, 'id'));
                            $existingRecords[$id]['achievement'] = $existingRecord->achievement;
                            $existingRecords[$id]['target'] = $existingRecord->target;
                        }
                    }

                    $newRecords = [];
                    if (isset($data->newRecords)) {
                        foreach ($data->newRecords as $newRecord) {
                            $newRecords[] = [
                                'year' => $newRecord->year,
                                'type_name' => \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorKpiType::find($newRecord->type)->name,
                                'achievement' => $newRecord->achievement,
                                'target' => $newRecord->target
                            ];
                        }
                    }

                    $records = array_merge($existingRecords, $newRecords);
                    foreach($records as $index => $record) {
                        $readable['year'.$index] = [
                            'label' => ($index+1).'. Year',
                            'value' => $record['year'],
                        ];
                        $readable['type'.$index] = [
                            'label' => ($index+1).'. Type',
                            'value' => $record['type_name'],
                        ];
                        $readable['achievement'.$index] = [
                            'label' => ($index+1).'. Achievement',
                            'value' => $record['achievement']
                        ];
                        $readable['target'.$index] = [
                            'label' => ($index+1).'. Target',
                            'value' => $record['target']
                        ];
                    }
                }
                break;

            // can only give to all the section
            case 'dl':
            case 'ism':
            case 'of':
            case 'g':
            case 'env':
            case 'cs':
            case 'r':
            case 'aw':
            case 'awf':
                break;

            case 'pf':
                // 'title', 'category_failure', 'number_events', 'penalty_abatement_contract', 'penalty_abatement_imposed', 'penalty_abatement_imposed_yes_no'
                $readable['title'] = [
                    'label' => trans('project/performance-information/performance_failures.title'),
                    'value' => $data->title
                ];

                $data->category_failure = \App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailuresCategory::find($data->category_failure)->name;
                $readable['category_failure'] = [
                    'label' => trans('project/performance-information/performance_failures.category'),
                    'value' => $data->category_failure
                ];
                $readable['number_events'] = [
                    'label' => trans('project/performance-information/performance_failures.number_events'),
                    'value' => $data->number_events
                ];
                $readable['penalty_abatement_contract'] = [
                    'label' => trans('project/performance-information/performance_failures.penalty_abatement_contract'),
                    'value' => $data->penalty_abatement_contract
                ];
                $readable['penalty_abatement_imposed'] = [
                    'label' => trans('project/performance-information/performance_failures.penalty_abatement_imposed'),
                    'value' => $data->penalty_abatement_imposed
                ];

                $readable['penalty_abatement_imposed_yes_no'] = [
                    'label' => trans('project/performance-information/performance_failures.penalty_abatement_yes_no'),
                    'value' => $data->penalty_abatement_imposed_yes_no == 1 ? trans('project/performance-information/performance_failures.yes') : trans('project/performance-information/performance_failures.no')
                ];
                break;

            case 'pa':
                break;

        }

        return $readable;
    }

    public function accept()
    {
        if ($this->status == 1) {
            throw new \LogicException('This Request for modification was already accepted');
        }

        $data = json_decode($this->data_json, true);

        $provision = [
            'is_create' => $this->position == 0 ? true : false,
            'table' => '',
        ];

        // attach
        $data['id'] = $this->position;
        $data['project_id'] = $this->project_id;

        switch ($this->section) {
            // Basic info
            case 'i':
                $provision['table'] = 'project_information';

                // Top info.
                if (isset($data['sectors'])) {
                    $requested_sectors = $data['sectors'];
                    $requested_regions = $data['regions'];
                    unset($data['sectors']);
                    unset($data['regions']);
                    $sync_sectors = self::sync('sector_project_information', 'project_information_id', $data['project_id'], 'sector_id', $requested_sectors);
                    $sync_regions = self::sync('location_project_information', 'project_information_id', $data['project_id'], 'location_id', $requested_regions);

                    $this->array_change_key($data, 'sponsor', 'sponsor_id');
                    $this->array_change_key($data, 'stage', 'stage_id');

                    // remove commas
                    $data['project_value_usd'] = str_replace(',', '', $data['project_value_usd']);

                    if ($data['project_value_second'] == '') {
                        $data['project_value_second'] = null;
                    } else {
                        $data['project_value_second'] = str_replace(',', '', $data['project_value_second']);
                    }

                    // COFOG
                    $this->array_change_key($data, 'cofog', 'cofog_sector_id');
                    $this->array_change_key($data, 'ppp_delivery_model', 'ppp_delivery_model_id');

                } else {
                    $data[$data['position_table']] = $data['description'];

                    unset($data['position_table']);
                    unset($data['description']);
                }
                $data['id'] = $data['project_id'];
                unset($data['project_id']);

                break;

            // name, milestone_type, date, description
            case 'cm':
                $provision['table'] = 'contract_milestones';
                $data['date'] = date('Y-m-d', strtotime($data['date']));
                $this->array_change_key($data, 'milestone_type', 'milestone_type_id');
                break;

            case 'pri':
                $provision['table'] = 'pd_procurement';
                break;

            case "par":
                $provision['table'] = 'entity_project';
                $this->array_change_key($data, 'party', 'entity_id');
                $data['sponsor'] = 0;
                $data['party'] = 1;
                break;

            case 'cs':
                $provision['table'] = 'pd_contract_summary';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'd':
                $provision['table'] = 'pd_document';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'fi':
                $provision['table'] = 'pd_financial';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'env':
                $provision['table'] = 'pd_environment';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'ri':
                $provision['table'] = 'pd_risks';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'gs':
                $provision['table'] = 'pd_government_support';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 't':
                $provision['table'] = 'pd_tariffs';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'ct':
                $provision['table'] = 'pd_contract_termination';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'r':
                $provision['table'] = 'pd_renegotiations';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case 'aw':
                $provision['table'] = 'pd_award';

                if($provision['is_create']){
                    $data['award_code'] = uniqid($prefix = null, $more_entropy = true);
                } else {
                    $data['id'] = PD_Award::where('project_details_id', $data['project_id'])->first()->id;
                }

                $this->array_change_key($data, 'project_id', 'project_details_id');

                if( !isset($data['preferred_bidder_id']) ){
                    $this->array_change_key($data, 'award_name', 'name');
                    $this->array_change_key($data, 'award_description', 'description');
                }

                if(isset($data['award_date']))                  $data['award_date'] = Carbon::createFromFormat('d-m-Y', $data['award_date']);
                if(isset($data['contract_signature_date'] ))    $data['contract_signature_date'] = Carbon::createFromFormat('d-m-Y', $data['contract_signature_date']);
                if(isset($data['contract_signature_date_end'] ))$data['contract_signature_date_end'] = Carbon::createFromFormat('d-m-Y', $data['contract_signature_date_end']);

                break;

            case 'awf':
                $provision['table'] = 'pd_award_financing';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                $this->array_change_key($data, 'financing_name', 'name');
                $this->array_change_key($data, 'financing_start_date', 'start_date');
                $this->array_change_key($data, 'financing_end_date', 'end_date');
                $this->array_change_key($data, 'financing_amount', 'amount');
                $this->array_change_key($data, 'financing_description', 'description');
                $this->array_change_key($data, 'financing_category_id', 'financial_category_id');

                if(isset($data['start_date'])){
                    $data['start_date'] = Carbon::createFromFormat('d-m-Y', $data['start_date']);
                }
                if(isset($data['end_date'] )){
                    $data['end_date'] = Carbon::createFromFormat('d-m-Y', $data['end_date']);
                }

                break;

            case 'pf':
                $provision['table'] = 'pi_performance_failures';
                $this->array_change_key($data, 'project_id', 'performance_information_id');
                $this->array_change_key($data, 'category_failure', 'category_failure_id');
                $this->array_change_key($data, 'penalty_abatement_contract', 'penalty_contract');
                $this->array_change_key($data, 'penalty_abatement_imposed', 'penalty_imposed');
                $this->array_change_key($data, 'penalty_abatement_imposed_yes_no', 'penalty_paid');
                break;

            case 'pa':
                $provision['table'] = 'pi_performance_assessment';
                $this->array_change_key($data, 'project_id', 'performance_information_id');
                $this->array_change_key($data, 'title', 'name');
                break;

            case 'a':
                $provision['table'] = 'pd_announcements';
                $this->array_change_key($data, 'project_id', 'project_details_id');
                break;

            case "kpi":
                if($data['id'] == 0) {
                    $provision['table'] = 'pi_key_performance_indicators';
                    $this->array_change_key($data, 'kpi_type', 'type_id');
                    $data['pi_key_performance_main_id'] = $data['project_id'];
                    unset($data['id']);
                    unset($data['project_id']);
                } else {
                    $this->status = 1;
                    $this->save();
                    return $this->updateKpi($data);
                }
                break;

            // can only give to all the section
            case 'dl':
            case 'ism':
            case 'of':
            case 'g':
            case 'e':
                break;
        }

        $query = DB::table($provision['table']);
        if ($provision['is_create']) {
            $query->insert($data);
            $insert_id = DB::getPdo()->lastInsertId();

            if (!($this->section == 'ri' || $this->section == 'cm' || $this->section == 'kpi' || $this->section == 'par')) {
                $mediaToUpload = \App\Models\Mystery::where([
                    'project' => $this->project_id,
                    'section' => $this->section,
                    'position' => 0,
                ])->get()->toArray();

                $idsMistery = array_column($mediaToUpload, 'id');
                DB::table('mysteries')->whereIn('id', $idsMistery)->delete();

                foreach ($mediaToUpload as $key=>$mtu) {
                    unset($mediaToUpload[$key]['id']);
                    $mediaToUpload[$key]['path'] = str_replace('mysterybox/', 'vault/', $mediaToUpload[$key]['path']);
                    $mediaToUpload[$key]['path'] = str_replace('/'.$this->project_id.'/'.$this->section.'/0/', '/'.$this->project_id.'/'.$this->section.'/'.$insert_id.'/', $mediaToUpload[$key]['path']);
                    $mediaToUpload[$key]['position'] = $insert_id;
                }
                $newMedia = \App\Models\Media::insert($mediaToUpload);

                $path = storage_path('app/mysterybox/'.$this->project_id.'/'.$this->section.'/'.$this->position);
                $path2 = storage_path('app/vault/'.$this->project_id.'/'.$this->section.'/'.$insert_id);
                \Illuminate\Support\Facades\File::copyDirectory($path, $path2);
                \Illuminate\Support\Facades\File::deleteDirectory($path);
            }

        } else {
            $query->where('id', $data['id'])->update($data);

            if (!($this->section == 'ri' || $this->section == 'cm' || $this->section == 'kpi' || $this->section == 'par')) {
                // Move files
                $path = storage_path('app/mysterybox/'.$this->project_id.'/'.$this->section.'/'.$this->position);
                $path2 = storage_path('app/vault/'.$this->project_id.'/'.$this->section.'/'.$this->position);
                \Illuminate\Support\Facades\File::copyDirectory($path, $path2);
                \Illuminate\Support\Facades\File::deleteDirectory($path);

                $mediaToUpload = \App\Models\Mystery::where([
                    'project' => $this->project_id,
                    'section' => $this->section,
                    'position' => $this->position,
                ])->get()->toArray();

                $idsMistery = array_column($mediaToUpload, 'id');
                DB::table('mysteries')->whereIn('id', $idsMistery)->delete();

                foreach ($mediaToUpload as $key=>$mtu) {
                    unset($mediaToUpload[$key]['id']);
                    $mediaToUpload[$key]['path'] = str_replace('mysterybox/', 'vault/', $mediaToUpload[$key]['path']);
                }

                $newMedia = \App\Models\Media::insert($mediaToUpload);

                // Delete files
                $mediaToDelete = \App\Models\Media::where([
                    'project' => $this->project_id,
                    'section' => $this->section,
                    'position' => $this->position,
                    'to_delete' => 1
                ])->get();

                foreach ($mediaToDelete as $mtd) {
                    \Illuminate\Support\Facades\Storage::delete($mtd->path);
                    $mtd->delete();
                }
            }
        }

        $this->status = 1;
        $this->save();

        $project = Project::find($this->project_id);
        $project->touch();

        return $provision;
    }

    public function isAccepted()
    {
        return ($this->status == 1);
    }

    public function isDeclined()
    {
        return ($this->status == 0);
    }

    public function isUnknown()
    {
        return ($this->status == null);
    }

    private function updateKpi($data)
    {

        $project = Project::findOrFail($this->project_id);
        $project->touch();

        $pi_key_performance_main_id = $project->performanceInformation->keyPerformanceIndicators->id;

        // Create
        if(isset($data['newRecords'])){
            foreach ($data['newRecords'] as $key => $value) {
                $kpi =  new \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator;
                $kpi->type_id = $value["type"];
                $kpi->achievement = $value["achievement"];
                $kpi->pi_key_performance_main_id = $pi_key_performance_main_id;
                $kpi->year = $value["year"];
                $kpi->target = $value["target"];
                $kpi->save();
            }
        }

        // Update
        if(isset($data['existingRecords'])){
            foreach ($data['existingRecords'] as $key => $value) {
                $kpi = \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator::find($value['id']);
                if($value["achievement"] == "" && $value["target"] == ""){
                    $kpi->delete();
                }else{
                    $kpi->achievement = $value["achievement"];
                    $kpi->target = $value["target"];
                    $kpi->save();
                }
            }
        }

        $project->performanceInformation->keyPerformanceIndicators->save();
        return $project->save();
    }

    /**
     * ===================================================================
     * Helpers
     * ===================================================================
     */
    public static function array_change_key(&$array, $current, $new)
    {
        $array[$new] = $array[$current];
        unset($array[$current]);
    }

    public static function sync($table, $unique_column, $unique_value, $relation_key, $new_data)
    {
        $current_data = DB::table($table)
            ->select($relation_key)
            // ->whereIn('sector_id', $data['sectors'])
            ->where($unique_column, $unique_value)
            ->get()->toArray();

        // array_column applied to object PHP 5.4 :(
        $current_data = array_map(function($e) use($relation_key) {
            return is_object($e) ? $e->{$relation_key} : $e[$relation_key];
        }, $current_data);

        $data_to_delete = [];
        foreach ($current_data as $cd) {
            if (!in_array($cd, $new_data)) {
                $data_to_delete[] = (int)$cd;
            }
        }

        $data_to_add = [];
        foreach ($new_data as $nd) {
            if (!in_array($nd, $current_data)) {
                $data_to_add[] = [
                    $unique_column => $unique_value,
                    $relation_key => (int)$nd
                ];
            }
        }

        $delete_query = DB::table($table)
            ->whereIn($relation_key, $data_to_delete)
            ->where($unique_column, $unique_value)
            ->delete();

        $add_query = DB::table($table)
            ->where($unique_column, $unique_value)
            ->insert($data_to_add);
    }
}
