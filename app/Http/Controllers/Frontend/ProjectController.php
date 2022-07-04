<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Backend\Project\PerformanceInformation\AnualDemandLevelsController;
use App\Http\Controllers\Backend\Project\PerformanceInformation\IncomeStatementsMetricsController;
use App\Http\Controllers\Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController;
use App\Http\Controllers\Backend\Project\PerformanceInformation\OtherFinancialMetricsController;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Entity;
use App\Models\Media;
use App\Models\Project\Project;
use App\Models\Project\ProjectInformation;
use Barryvdh\DomPDF\Facade as PDF;
use function foo\func;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * Middleware define
         * It's used to define that all the methods in this controller the user must be authenticated
         */
        /*$this->middleware('auth');*/
    }

    /**
     * Returns the homepage-management view.
     *
     * @return \Illuminate\Http\Response
     */
    public function project($id)
    {

        // Find the project by id
        $project = Project::where(['id' => $id, 'active' => 1])->first();

        // If the project doesn't exists redirect to the main page
        if(!$project){
            return redirect('/');
        }

        $project->load(['projectInformation.sponsor' ,'parties','projectInformation.stage', 'performanceInformation',  'sponsor', 'projectInformation.regions', 'projectInformation.sectors',
            'contractMilestones' => function($query){
                $query->orderBy('contract_milestones.date', 'asc');
        },
            'procurements' => function($query){
                $query->orderBy('pd_procurement.position', 'asc');
            }
        ]);

        /*
         * Load Project details relationships
         */
        $project->load(['projectDetails.announcements',
            'projectDetails.evaluationsPPP', 'projectDetails.risks.allocation',
            'projectDetails.environment',
            'projectDetails.documents' => function($query){
                $query->orderBy('pd_document.position','asc');
            },
            'projectDetails.financials' =>function($query){
                $query->orderBy('pd_financial.position','asc');
            },
            'projectDetails.governmentSupports' =>function($query){
                $query->orderBy('pd_government_support.position','asc');
            },
            'projectDetails.tariffs' =>function($query){
                $query->orderBy('pd_tariffs.position','asc');
            },
            'projectDetails.contractTerminations' =>function($query){
                $query->orderBy('pd_contract_termination.position','asc');
            },
            'projectDetails.renegotiations' =>function($query){
                $query->orderBy('pd_renegotiations.position','asc');
            },

            ]);


        /*
         * Load Performance Information relationships
         */

        $project->load(['performanceInformation.annual_demand', 'performanceInformation.incomeStatementMain',
            'performanceInformation.otherFinancialMetricAnnualMain', 'performanceInformation.otherFinancialMetricTimelessMain.metricsTimeless.type',
            'performanceInformation.performanceFailures.category',
            'performanceInformation.performanceAssessments' =>function($query){
                $query->orderBy('pi_performance_assessment.position','asc');
            },
            ]);

        /*
         * Generate the tables
         */
        $tables = ["annual_demmands" => [], "income_metrics" => [], "other_financial_metrics_annual" => [], "key_performance_indicators" => []];

        if ($project->performanceInformation){

            if($project->performanceInformation->annual_demand){
                $tables["annual_demmands"] = AnualDemandLevelsController::getTable($project->performanceInformation->annual_demand->id);
            }
            if($project->performanceInformation->incomeStatementMain){
                $tables["income_metrics"] = IncomeStatementsMetricsController::getTable($project->performanceInformation->incomeStatementMain->id);
            }
            if($project->performanceInformation->otherFinancialMetricAnnualMain){
                $tables["other_financial_metrics_annual"] = OtherFinancialMetricsController::getAnnualTable($project->performanceInformation->otherFinancialMetricAnnualMain->id);
            }
            if($project->performanceInformation->keyPerformanceIndicators){
                $tables["key_performance_indicators"] = KeyPerformanceIndicatorsController::getTable($project->performanceInformation->keyPerformanceIndicators->id, 4);
            }

        }

        $requestDocumentsList = \App\Models\Project\ProjectDetails\PD_Document::getRequestDocumentsList();

        $sections = Section::all();

        $projectDocuments = Media::where("project",$id)->get();

        $projectGallery = Media::where("project",$id)->where("section","g")->get();

        if (count($projectGallery)>0){

            $projectBG = route('uploader.g',['id_image'=>$projectGallery->first()->id]);

        } else {

            if (isset($project->projectInformation->sectors->first()->code_lang)){

                $projectBG = "/img/samples/project/".$project->projectInformation->sectors->first()->code_lang.".jpg";

            } else {

                $projectBG = "/img/samples/project/sector_energy.jpg";

            }

        }

        $projectInternalUrl = route('project.project-information', ['id' => $project->id]);

        $currency = Config::where('name','currency')->first()->value;

         // dump($project->projectDetails->documents->reject(function($document) { return $document->published === 0; }));exit;

        return view('front.project', compact('project', 'tables', 'requestDocumentsList','currency', 'sections','projectDocuments','projectGallery', 'projectInternalUrl','projectBG', 'currency'));
    }

}
