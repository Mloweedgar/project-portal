<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProjectStoreRequest;
use App\Http\Requests\Project\ActiveRequest;
use App\Models\Config;
use App\Models\Entity;
use App\Models\Location;
use App\Models\Project\ContractMilestones\ContractMilestone;
use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain;
use App\Models\Project\PerformanceInformation\PI_AnnualDemandLevelMain;
use App\Models\Project\PerformanceInformation\PI_IncomeStatementMain;
use App\Models\Project\PerformanceInformation\PI_PerformanceAssessment;
use App\Models\Project\PerformanceInformation\PerformanceInformation;
use App\Models\Project\Project;
use App\Models\Project\ProjectDetails\PD_ContractSummary;
use App\Models\Project\ProjectDetails\PD_Environment;
use App\Models\Project\ProjectDetails\PD_Financial;
use App\Models\Project\ProjectDetails\PD_GovernmentSupport;
use App\Models\Project\ProjectDetails\PD_Procurement;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectInformation;
use App\Models\Sector;
use App\Models\Stage;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AddProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $project;

    public function __construct(Project $project)
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        // $this->middleware('role:role_admin');

        $this->project = $project;

    }

    /**
     * Returns the view page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function addProjects()
    {
        $sectors = Sector::all("sectors.id","sectors.name");
        $regions = Location::where("type","region")->get();
        $stages = Stage::all("stages.id","stages.name");
        $currency = Config::where('name','currency')->first()->value;
        $sponsors = Entity::all("entities.id","entities.name");

        $types = [];
        
        return view('back.project.add',compact('sectors','regions','stages','currency','sponsors', 'types'));
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request)
    {
        $projects = Project::with([
            'projectInformation.sponsor',
            'projectInformation.sectors',
            'projectInformation.regions',
            'projectInformation.stage',
            'users' => function($q) {
                $q->where('user_id', Auth::user()->id);
            }
        ])
        ->select('projects.*');

        $regions = $request->get('regions_array');
        $sectors = $request->get('sectors_array');
        $stages = $request->get('stages_array');
        $sponsor = $request->get('sponsor');
        $project_name = $request->get('name');

        if ($project_name) {
            $projects->where('projects.name', 'like', '%' . $project_name . '%');
        }
        if ($regions) {
            $projects->whereHas('projectInformation.regions', function($q) use($regions){
                $q->whereIn('location_project_information.location_id', $regions);
            });
        }
        if ($sectors) {
            $projects->whereHas('projectInformation.sectors', function($q) use($sectors){
                $q->whereIn('sector_project_information.sector_id', $sectors);
            });
        }
        if ($stages) {
            $projects->whereHas('projectInformation.stage', function($q) use($stages){
                $q->whereIn('stages.id', $stages);
            });
        }

        if (!Auth::user()->isAdmin()) {
            $projects
                ->join('permission_user_project','projects.id','=','permission_user_project.project_id')
                ->join('users', 'permission_user_project.user_id', '=', 'users.id')
                ->where('users.id', Auth::user()->id);
        }

        // if (request()->has('projectInformation.ocid')) {
        //     $projects->orderBy('projectInformation.ocid', 'desc');
        // }

        $datatables = app('datatables')->of($projects)
            ->addColumn('sectors', function (Project $project) {
                if(isset($project->projectInformation)){
                    return $project->projectInformation->sectors->map(function($sector) {
                        return str_limit($sector->name);
                    })->implode(', ');
                }
            })->addColumn('regions', function (Project $project) {
                if(isset($project->projectInformation)){
                    return $project->projectInformation->regions->map(function($region) {
                        return str_limit($region->name);
                    })->implode(', ');
                }
            })->addColumn('stage', function (Project $project) {
                if(isset($project->projectInformation)){
                    return $project->projectInformation->stage->name;
                }
            })->addColumn('sponsor', function (Project $project) {
                if(isset($project->projectInformation)){
                    return $project->projectInformation->sponsor->name;
                }
            })->addColumn('project_value_usd', function (Project $project) {
                if(isset($project->projectInformation)){
                    if ($project->projectInformation->project_value_usd){
                        return $project->projectInformation->project_value_usd;
                    }
                }
            })->addColumn('project_value_second', function (Project $project) {
                if(isset($project->projectInformation)){
                    return $project->projectInformation->project_value_second;
                }
            })->addColumn('project_url', function ($project) {
                return Auth::user()->getFirstProjectUrl($project);
            })
            ->editColumn('updated_at', function ($project) {
                return $project->updated_at->format('Y/m/d');
            })
            ->filterColumn('updated_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
            })
            ->filterColumn('sponsor', function ($query, $keyword) {

                $query->where("entity_project.id like ?", ["%$keyword%"]);
            })
            ->filterColumn('project_value_second', function ($query, $keyword) {
                $query->whereRaw("project_information.project_value_usd like ?", ["%$keyword%"]);
            });

        $datatables->orderColumn('projectInformation.ocid', 'projects.id $1');

        return $datatables->make(true);

    }

    /**
     * Deletes a project in AJAX request
     * @param Request $request
     * @return mixed
     */
    public function deleteProject(Request $request)
    {

        //TODO: Before deleting the project, we must delete ALL the rows in other tables related to this one. This has to be done because of the restrict settings in the DB relationships.


        $projectDetail = ProjectDetail::where("project_id",$request->input('id'))->first();

        if (isset($projectDetail)){

            $projectDetail->delete();

        }

        $performanceInformation = PerformanceInformation::where("project_id",$request->input('id'))->first();

        if (isset($performanceInformation)){

            $performanceInformation->delete();

        }

        Project::destroy($request->input('id'));

        $response = array(
            'status' => 'success',
            'msg' => 'Project successfully deleted');

        return Response::json($response);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(AddProjectStoreRequest $request)
    {
        $flag = ["status" => true];

        DB::beginTransaction();
        try {
            // Create and populate the data
            $project = new Project();
            $project->name = $request->input('project_name');
            
            $project->user_id = Auth::user()->id;
            // Save the data to the database
            $project->save();

            $projectInformation = new ProjectInformation();

            // Get the ocid
            $ocid = Config::where('name','ocid')->first();

            $projectInformation->ocid = $ocid->value.'-'.$project->id;
            $projectInformation->stage_id = $request->get('stage');
            $projectInformation->project_value_usd = str_replace(',', '', $request->get('project_value_usd'));
            if ($request->get('project_value_second') == '') {
                $projectInformation->project_value_second = null;
            } else {
                $projectInformation->project_value_second = str_replace(',', '', $request->get('project_value_second'));
            }
            $projectInformation->sponsor_id = $request->get('sponsor');
            
            $projectInformation->project_id = $project->id;
            $projectInformation->save();

            $projectInformation->regions()->sync($request->get('regions'));
            $projectInformation->sectors()->sync($request->get('sectors'));

            $project->userPermissions()->attach(Auth::user()->id);

            //Save essential related models
            $pd_data = [];

            $pd = $project->projectDetails()->save(new ProjectDetail($pd_data));
            $pd->environment()->save(new PD_Environment());

            $pf_data = [];
            
            $pf = $project->performanceInformation()->save(new PerformanceInformation($pf_data));

            $kpm = new PI_KeyPerformanceIndicatorMain();
            $kpm->performance_information_id = $pf->id;
            $kpm->save();
            // Commit the changes
            DB::commit();

            return redirect()->route('project.project-information', ["id" => $project->id])->with(["project" => "success", "new" => true]);

        } catch (\Exception $e) {
            dd($e->getMessage());
            $flag["error"] = $e->getMessage();
            $flag["status"] = false;

            // Ouuuupsss... something wrong here!
            DB::rollback();
        }

        // Load the view again
        return back()->with($flag);
    }


    public function active(ActiveRequest $request)
    {
        $flag = ["status" => true, "message" => ""];
        $project = Project::find($request->input('id'));

        try {
            if ($project->active == 1) {
                $project->active = 0;
            } else {
                $project->active = 1;
            }
            $project->save();

        } catch (\Exception $e) {
            Log::error(
                PHP_EOL.
                "|- Action: AddProjectController@active[".$request->get('id')."]".PHP_EOL.
                "|- User ID: ".Auth::id().PHP_EOL.
                "|- Line number: ".$e->getLine().PHP_EOL.
                "|- Message: ".$e->getMessage().PHP_EOL.
                "|- File: ".$e->getFile()
            );
            $flag["status"] = false;
            $flag["error"] = __('errors.internal_error');
        }

        return $flag;
    }

    public function exportToExcel($id)
    {
        if (!Auth::user()->isAdmin()) {
            \Illuminate\Support\Facades\Redirect::to('dashboard')->send();
        }
        // $spreadsheet->getProperties()
        //     ->setCreator("Maarten Balliauw")
        //     ->setLastModifiedBy("Maarten Balliauw")
        //     ->setTitle("Office 2007 XLSX Test Document")
        //     ->setSubject("Office 2007 XLSX Test Document")
        //     ->setDescription(
        //         "Test document for Office 2007 XLSX, generated using PHP classes."
        //     )
        //     ->setKeywords("office 2007 openxml php")
        //     ->setCategory("Test result file");

        $project = Project::find($id);
        $projectInformation = $project->projectInformation;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getRowDimension('1')->setRowHeight(30);


        $sheet->setCellValue('A1',  $project->name);
        $sheet->getStyle('A1')->getFont()->setSize(20);


        $nextA = 1;


        // Project basic information
        $label_regions = '';
        $label_regions = trans('excel.regions');

        $sponsor = trans('excel.contracting_authority');

        $value_second = '';
        
        $mainInfoData = [
            [trans('excel.sectors'), implode(', ', array_column($projectInformation->sectors->toArray(), 'name'))],
            [$label_regions, implode(', ', array_column($projectInformation->regions->toArray(), 'name'))],
            [trans('excel.phase'), $projectInformation->stage->name],
            [$sponsor.':', $projectInformation->sponsor->name],
            [trans('excel.value'), $projectInformation->project_value_usd],
            [$value_second, $projectInformation->project_value_second ? $projectInformation->project_value_second : trans('excel.not_specified')],
            [trans('excel.ocid'), $projectInformation->ocid],
        ];

        $sheet->fromArray(
            $mainInfoData,
            NULL,
            'A'.($nextA+1)
        );

        $nextA += count($mainInfoData) + 1;

        $basicInformationData = [];
        $basicInformationFields = $projectInformation->getInformation();
        foreach ($basicInformationFields as $value) {
            $basicInformationData[] = [ $value['name'].":", $value['value'] ];
        }

        $sheet->fromArray(
            $basicInformationData,
            NULL,
            'A'.($nextA+1)
        );

        $nextA += count($basicInformationFields) + 3;

        // Project Milestones
        $sheet->setCellValue('A'.$nextA,  trans('excel.project_milestones'));
        $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

        $projectMilestonesData = [
            [trans('excel.name'), trans('excel.type'), trans('excel.date'), trans('excel.description')]
        ];


        $contract_milestones = ContractMilestone::normalizeToSimpleArray($project->contractMilestones()->with('type')->get());



        $sheet->fromArray(
            array_merge($projectMilestonesData, $contract_milestones),
            NULL,
            'A'.($nextA+1)
        );

        $nextA += count($contract_milestones) + 4;


        // Procurement Documents
        $sheet->setCellValue('A'.$nextA,  trans('excel.procurement_documents'));
        $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

        $procurementDocumentsData = [
            [trans('excel.name'), trans('excel.description')]
        ];
        $procurement_documents = $project->procurements()->get([trans('excel.name'), trans('excel.description')])->toArray();

        $sheet->fromArray(
            array_merge($procurementDocumentsData, $procurement_documents),
            NULL,
            'A'.($nextA+1)
        );

        $nextA += count($procurement_documents) + 4;


        // Parties section
        $sheet->setCellValue('A'.$nextA, trans('excel.parties'));
        $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);
        $nextA += 1;

        $parties = array_chunk(array_column($project->parties()->get(['name'])->toArray(), 'name'), 1);

        $sheet->fromArray(
            $parties,
            NULL,
            'A'.($nextA+1)
        );

        $nextA += count($parties) + 3;

        if ($project->isTypePrivate()) {
            // Risks
            $sheet->setCellValue('A'.$nextA,  trans('excel.risks'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $risksData = [
                [trans('excel.name'), trans('excel.description'), trans('excel.allocation'), trans('excel.mitigation')]
            ];
            $risks = \App\Models\Project\ProjectDetails\PD_Risk::normalizeToSimpleArray($project->projectDetails->risks()->with('allocation')->get());

            $sheet->fromArray(
                array_merge($risksData,$risks),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($risks) + 4;


            // Government Support
            $governmentSupportTitle = trans('excel.government_support');

            
            $sheet->setCellValue('A'.$nextA,  trans('excel.government_support'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $governmentSupportData = [
                [trans('excel.name'), trans('excel.description')]
            ];
            $government_support = $project->projectDetails->governmentSupports()->get([trans('excel.name'), trans('excel.description')])->toArray();

            $sheet->fromArray(
                array_merge($governmentSupportData,$government_support),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($government_support) + 4;
        }

        if ($project->isTypePublic() || $project->isTypePrivate()) {
            // Tariffs
            $sheet->setCellValue('A'.$nextA,  trans('excel.tariffs'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $tariffsData = [
                [trans('excel.name'), trans('excel.description')]
            ];
            $tariffs = $project->projectDetails->tariffs()->get([trans('excel.name'), trans('excel.description')])->toArray();

            $sheet->fromArray(
                array_merge($tariffsData,$tariffs),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($tariffs) + 4;


            // Termination provisions
            $sheet->setCellValue('A'.$nextA,  trans('excel.termination_provisions'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $terminationProvisionsData = [
                [trans('excel.party'), trans('excel.name'), trans('excel.description'), trans('excel.termination_payment')]
            ];
            $termination_provisions = \App\Models\Project\ProjectDetails\PD_ContractTermination::normalizeToSimpleArray($project->projectDetails->contractTerminations()->get());

            $sheet->fromArray(
                array_merge($terminationProvisionsData,$termination_provisions),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($termination_provisions) + 4;
        }

        // Renegotiations
        $sheet->setCellValue('A'.$nextA,  trans('excel.renegotiations'));
        $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

        $renegotiationsData = [
            [trans('excel.name'), trans('excel.description')]
        ];
        $renegotiations = $project->projectDetails->renegotiations()->get([trans('excel.name'), trans('excel.description')])->toArray();

        $sheet->fromArray(
            array_merge($renegotiationsData,$renegotiations),
            NULL,
            'A'.($nextA+1)
        );

        $nextA += count($renegotiations) + 4;

        //====================================================================================================================
        // KPI
        if ($project->isTypePublic() || $project->isTypePrivate()) {
            $pi_key_performance_main_id = $project->performanceInformation->keyPerformanceIndicators;

            if(!$pi_key_performance_main_id){
                $obje = new \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain();
                $project->performanceInformation->keyPerformanceIndicators()->save($obje);
                $pi_key_performance_main_id = $obje->id;

            }else{
                $pi_key_performance_main_id = $pi_key_performance_main_id->id;
            }

            $years = \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator::where('pi_key_performance_main_id', $pi_key_performance_main_id)->select('year')->groupBy('year')->orderBy('year')->get();
            $project_inf_id = $project->performanceInformation->id;

            $types = \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorKpiType::all();

            $arrays = \App\Http\Controllers\Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController::getTable($pi_key_performance_main_id, false);
            $year = Carbon::now()->year;

            $project->load('performanceInformation');

            $draft = \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain::where('id',$pi_key_performance_main_id)->first()->draft;

            $kpi_headers = [];
            $kpi_targets_achievements = [];
            $kpi_targets_achievements[] = null;
            $kpi_values = [];

            foreach ($arrays as $table):
                $kpi_headers[] = 'Year';
                foreach($table["years"] as $years):
                    $kpi_headers[] = $years["year"];
                    $kpi_headers[] = $years["year"];
                endforeach;

                for($i = 0; $i < count($table["years"]); $i++):
                    $kpi_targets_achievements[] = trans('project/performance-information/key_performance_indicators.target');
                    $kpi_targets_achievements[] = trans('project/performance-information/key_performance_indicators.achievement');
                endfor;

                foreach($table["kpis"] as $keyY => $kpi):
                    $kpi_values[$keyY][] = $kpi["type"]["name"] . '('.$kpi["type"]["unit"].')';

                    foreach($table["records"][$kpi["type"]["id"]] as $keyR => $record):
                        if($record):
                            $kpi_values[$keyY][] = $record["target"];
                            $kpi_values[$keyY][] = $record["achievement"];
                        else:
                            $kpi_values[$keyY][] = null;
                            $kpi_values[$keyY][] = null;
                        endif;
                    endforeach;
                endforeach;
            endforeach;

            $sheet->setCellValue('A'.$nextA,  trans('excel.key_performance_indicators'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $alphabet = [
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
                'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
                'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
                'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
                'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
                'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
            ];

            for ($i = 0; $i < (count($kpi_headers)*2)-1; $i++):
                if ($i === 0) continue;

                if ($i % 2 !== 0) {
                    $sheet->mergeCellsByColumnAndRow($i, $nextA+1, $i+1, $nextA+1);
                    $style = array(
                        'alignment' => array(
                            'horizontal' =>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        )
                    );
                    $sheet->getStyle($alphabet[$i].($nextA+1).':'.$alphabet[$i+1].($nextA+1))->applyFromArray($style);
                }
            endfor;

            $sheet->fromArray(
                array_merge([$kpi_headers, $kpi_targets_achievements], $kpi_values),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($kpi_values) + 5;

            //====================================================================================================================

            // Performance Information - Performance Failures
            $sheet->setCellValue('A'.$nextA,  trans('excel.performance_failures'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $performanceFailuresData = [
                [
                    trans('excel.title'),
                    trans('excel.category_failure'),
                    trans('excel.number_events'),
                    trans('excel.penalty_abatement_contract'),
                    trans('excel.penalty_abatement_imposed'),
                    trans('excel.penalty_abatement_effected')
                ]
            ];

            $performance_failures = \App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure::normalizeToSimpleArray($project->performanceInformation->performanceFailures()->with('category')->get());

            $sheet->fromArray(
                array_merge($performanceFailuresData,$performance_failures),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($performance_failures) + 4;


            // Performance Information - Performance Assesments
            $sheet->setCellValue('A'.$nextA,  trans('excel.performance_assesments'));
            $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

            $performanceAssesmentsData = [
                [
                    trans('excel.name'),
                    trans('excel.description')
                ]
            ];

            $performance_assesments = $project->performanceInformation->performanceAssessments()->get([trans('excel.name'), trans('excel.description')])->toArray();

            $sheet->fromArray(
                array_merge($performanceAssesmentsData,$performance_assesments),
                NULL,
                'A'.($nextA+1)
            );

            $nextA += count($performance_assesments) + 4;
        }


        // Announcements
        $sheet->setCellValue('A'.$nextA,  trans('excel.announcements'));
        $sheet->getStyle('A'.$nextA)->getFont()->setBold(true);

        $announcementsData = [
            [
                trans('excel.name'),
                trans('excel.description')
            ]
        ];

        $announcements = $project->projectDetails->announcements()->get([trans('excel.name'), trans('excel.description')])->toArray();

        $sheet->fromArray(
            array_merge($announcementsData,$announcements),
            NULL,
            'A'.($nextA+1)
        );

        $excel = storage_path('app'.DIRECTORY_SEPARATOR.'export'.DIRECTORY_SEPARATOR.$project->id.'.xlsx');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($excel);
        $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return Response::download($excel, str_slug($project->name).'.xlsx', $headers)->deleteFileAfterSend(true);

        // $sheet->getStyle('B:B7')->getAlignment()->setWrapText(true)->setShrinkToFit(true);

        // $sheet->getColumnDimension('B')->setAutoSize(true);


        // $sheet->getStyle('A1')->applyFromArray([
        //     'font' => [
        //         'bold' => true,
        //     ],
        //     'borders' => [
        //         'top' => [
        //             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //         ],
        //     ],
        // ]);

    }
}
