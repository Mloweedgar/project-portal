<?php

namespace App\Http\Controllers\Backend;

use App\Models\Config;
use App\Models\Project\Currency;
use App\Models\Project\ProjectDetails\PD_GovernmentSupport;
use App\Models\Project\ProjectDetails\ProjectDetail;
use App\Models\Project\ProjectInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_auditor');
    }

    public function index(){

        $data['log']= DB::table('activity_log')->leftJoin('users','users.id','activity_log.causer_id')
            ->orderBy('activity_log.updated_at', 'desc')
            ->take(100)
            ->get(['users.email','activity_log.*']);

        return view('back.log',$data);

    }

    public function table(Request $request)
    {

        $lines = $request->get('lines');
        $user = $request->get('users');

        $log= DB::table('activity_log')->leftJoin('users','users.id','activity_log.causer_id');

        if ($user){
            $log = $log->where('causer_id',$user);
        }

        $log = $log->orderBy('activity_log.created_at', 'desc');


        if ($lines==100 || $lines==null){
            $log = $log->take(100);
        }


        $log = $log->get(['users.email','activity_log.*']);

        $datatables = app('datatables')->of($log)
            ->addColumn('description', function ($log) {

                switch ($log->description){
                    case "updated":
                        return "Updated";
                        break;
                    case "deleted":
                        return "Deleted";
                        break;
                    case "created":
                        return "Created";
                        break;

                }

            })
            ->addColumn('properties', function ($log) {
                    return $this->renderProperties($log,null);
            })
            ->addColumn('created_at', function ($log) {

                return Carbon::parse($log->created_at)->format('d-m-Y H:i:s');;

            })
            ->addColumn('subject_type', function ($log) {

                return $this->getSection($log);

            })

        ;


        return $datatables->make(true);


    }

    private function getSection($model){

        $arr = ['','App\Models\Banner','App\Models\Config','App\Models\Entity','App\Models\GlobalAnnouncements','App\Models\GraphPos','App\Models\Media','App\Models\NavMenuLink',
            'App\Models\Newsletter','App\Models\Role','App\Models\Section','App\Models\Slider','App\Models\Task','App\Models\Theme','App\Models\Theme_schema',
            'App\User','App\Models\User\DeletedUser','App\Models\Project\Project','App\Models\Project\ContractMilestones\ContractMilestone','App\Models\Project\ProjectDetails\PD_Announcement',
            'App\Models\Project\ProjectDetails\PD_ContractSummary','App\Models\Project\ProjectDetails\PD_ContractTermination','App\Models\Project\ProjectDetails\PD_Procurement',
            'App\Models\Project\ProjectDetails\PD_Financial','App\Models\Project\ProjectDetails\PD_GovernmentSupport','App\Models\Project\ProjectDetails\PD_Renegotiations',
            'App\Models\Project\ProjectDetails\PD_Risk','App\Models\Project\ProjectDetails\PD_Tariffs','App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorKpiType',
            'App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator','App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailuresCategory','App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure',
            'App\Models\Project\PerformanceInformation\PI_PerformanceAssessment','App\Models\Project\ProjectInformation','App\Models\Project\ProjectDetails\PD_Document','App\Models\Project\ProjectDetails\PD_Environment',
            'App\Models\Project\Entity','App\Models\Project\ProjectDetails\PD_Award'];

        
            $trans = ['','Banner','Configuration Values',"Entities","Global Announcements","Graphics","Media","Menu Links","Newsletter Users","Roles","Sections to disclose","Sliders","Request for Modification","Theme",
                "Theme configuration","Users","Deleted Users","Projects","Project Milestones","Project Announcements","Contract Summary","Termination Provisions","Procurement Documents","Financial Structure",
                "Government Support","Renegotiations","Risks","Tariffs","KPI Type","Key Performance Indicator","Performance Failure Category","Performance Failure","Performance Assessment","Project Information","Redacted PPP Agreement","Environment and Social Impact Assessment Report","Project Parties","Award & Financing"];

        return $this->humanReadableArrays($model->subject_type,$arr,$trans);

    }

    private function renderProperties($elm,$type){

        switch ($elm->description){
            case "updated":
                return $this->getDifferences($elm,$type);
                break;
            case "deleted":
                return "Deleted the element with ID ".$elm->subject_id;
                break;
            case "created":
                $text = "Created new element\n";
                $element = json_decode($elm->properties)->attributes;

                if ($elm->subject_type=='App\Models\Media'){

                    $text = "File new name: ".$element->name.".".$element->extension;

                } else {

                    if (isset($element->name)){
                        $text .= "Name: ".$element->name."\n";
                    }

                    if (isset($element->title)){
                        $text .= "Title: ".$element->title."\n";
                    }

                }

                return $text;
                break;

        }


        return "";
    }

    private function getDifferences($elm,$type){
        $a1 = json_decode($elm->properties)->attributes;
        $a2 = json_decode($elm->properties)->old;

        $text = "";

        // Name

        if (isset($a1->name)){
            $text .= "Name: ".$a1->name."\n";
        }

        // Role alias

        if (isset($a1->alias)){
            if ($a1->alias != $a2->alias){
                $text .= "Alias: ".$a1->alias."\n";
            }
        }

        // Description

        if (isset($a1->description)){
            if ($a1->description !== $a2->description){
                $string = (strlen(strip_tags($a1->description)) > 100) ? substr(strip_tags($a1->description),0,100).'...' : strip_tags($a1->description);
                $text .= "Description: ".$string."\n";
            }
        }

        // URL

        if (isset($a1->url)){
            if ($a1->url !== $a2->url){
                $text .= "URL: ".$a1->url."\n";
            }
        }

        // Active

        if (isset($a1->active)){

            if ($a1->active != $a2->active){
                if ($a1->active){
                    $text .= "Active: Yes\n";
                }else{
                    $text .= "Active: No\n";
                }
            }
        }

        // Inactive

        if (isset($a1->inactive)){

            if ($a1->inactive != $a2->inactive){
                if ($a1->inactive){
                    $text .= "Active: No\n";
                }else{
                    $text .= "Active: Yes\n";
                }
            }
        }

        // Name of the representative

        if (isset($a1->name_representative)){
            if ($a1->name_representative != $a2->name_representative){
                $text .= "Name of the representative: ".$a1->name_representative."\n";
            }
        }

        // Address

        if (isset($a1->address)){
            if ($a1->address != $a2->address){
                $text .= "Address: ".$a1->address."\n";
            }
        }

        // Telephone

        if (isset($a1->tel)){
            if ($a1->tel != $a2->tel){
                $text .= "Telephone: ".$a1->tel."\n";
            }
        }

        if (isset($a1->telephone)){
            if ($a1->telephone != $a2->telephone){
                $text .= "Telephone: ".$a1->telephone."\n";
            }
        }

        // Fax

        if (isset($a1->fax)){
            if ($a1->fax != $a2->fax){
                $text .= "Fax: ".$a1->fax."\n";
            }
        }

        // Email

        if (isset($a1->email)){
            if ($a1->email != $a2->email){
                $text .= "Email: ".$a1->email."\n";
            }
        }

        // Facebook

        if (isset($a1->facebook)){
            if ($a1->facebook != $a2->facebook){
                $text .= "Facebook: ".$a1->facebook."\n";
            }
        }

        // Twitter

        if (isset($a1->twitter)){
            if ($a1->twitter != $a2->twitter){
                $text .= "Twitter: ".$a1->twitter."\n";
            }
        }

        // Instagram

        if (isset($a1->instagram)){
            if ($a1->instagram != $a2->instagram){
                $text .= "Instagram: ".$a1->instagram."\n";
            }
        }

        // Link

        if (isset($a1->link)){
            if ($a1->link != $a2->link){
                $text .= "Link: ".$a1->link."\n";
            }
        }

        // White

        if (isset($a1->white)){
            if ($a1->white != $a2->white){
                if ($a1->white){
                    $text .= "Color: White\n";
                }else{
                    $text .= "Color: Black\n";
                }
            }
        }

        // CSS Rule

        if (isset($a1->css_rule)){
            if ($a1->css_rule != $a2->css_rule){

                // Get the rule name

                $rules = ["","primary_color","secondary_color","body_font_size","title_font_family","title_font_size","title_letter_spacing","subtitle_font_size","subtitle_letter_spacing","body_font_family","body_letter_spacing","body_line_height","body_spacing_paragraphs"];
                $trans = ["","Primary Color","Secondary Color","Body Font Size","Title Font Family","Title Font Size","Title Letter Spacing","Subtitle Font Size","Subtitle Letter Spacing","Body Font Family","Body Letter Spacing","Body Line Height","Body Spacing Paragraphs"];

                $human = $this->humanReadableArrays($a1->name,$rules,$trans);

                $text .= "Theme ID: ".$a1->theme_id."\n";
                $text .= $human.": ".$a1->css_rule."\n";
            }
        }

        // Date

        if (isset($a1->date)){
            if ($a1->date != $a2->date){
                $format = 'd-m-Y H:i:s';
                if ($elm->subject_type=='App\Models\Project\ContractMilestones\ContractMilestone'){
                    $format = 'd-m-Y';
                }
                $date = Carbon::parse($a1->date)->format($format);
                $text .= "Date: ".$date."\n";
            }
        }

        // Position

        if (isset($a1->position)){
            if ($a1->position != $a2->position){
                $text .= "Previous position: ".$a2->position."\n";
                $text .= "New position: ".$a1->position."\n";
            }
        }

        // Milestone type

        if (isset($a1->milestone_type_id)){
            if ($a1->milestone_type_id != $a2->milestone_type_id){
                $text .= "Milestone type ID: ".$a1->milestone_type_id."\n";
            }
        }

        // Risk Allocation ID

        if (isset($a1->risk_allocation_id)){
            if ($a1->risk_allocation_id != $a2->risk_allocation_id){
                $text .= "Risk Allocation ID: ".$a1->risk_allocation_id."\n";
            }
        }

        // Party type

        if (isset($a1->party_type)){
            if ($a1->party_type != $a2->party_type){
                $text .= "Party Type: ".ucfirst($a1->party_type)."\n";
            }
        }

        // Termination Payments

        if (isset($a1->termination_payment)){
            if ($a1->termination_payment != $a2->termination_payment){
                $text .= "Termination Payments: ".$a1->termination_payment."\n";
            }
        }


        if ($elm->subject_type=='App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator'){
            $text .= "Year: ".$a1->year."\n";
            $text .= "Type ID: ".$a1->type_id."\n";
        }

        // Target

        if (isset($a1->target)){
            if ($a1->target != $a2->target){
                $text .= "Target: ".$a1->target."\n";
            }
        }

        // Achievements

        if (isset($a1->achievement)){
            if ($a1->achievement != $a2->achievement){
                $text .= "Achievement: ".$a1->achievement."\n";
            }
        }

        // Category Failure ID

        if (isset($a1->category_failure_id)){
            if ($a1->category_failure_id != $a2->category_failure_id){
                $text .= "Category Failure ID: ".$a1->category_failure_id."\n";
            }
        }

        // Title

        if (isset($a1->title)){
            $text .= "Title: ".$a1->title."\n";
        }

        // Number of events

        if (isset($a1->number_events)){
            if ($a1->number_events != $a2->number_events){
                $text .= "Number of events: ".$a1->number_events."\n";
            }
        }

        // Penalty Contract

        if (isset($a1->penalty_contract)){
            if ($a1->penalty_contract !== $a2->penalty_contract){
                $string = (strlen(strip_tags($a1->penalty_contract)) > 100) ? substr(strip_tags($a1->penalty_contract),0,100).'...' : strip_tags($a1->penalty_contract);
                $text .= "Penalty in the contract: ".$string."\n";
            }
        }

        // Penalty imposed

        if (isset($a1->penalty_imposed)){
            if ($a1->penalty_imposed !== $a2->penalty_imposed){
                $string = (strlen(strip_tags($a1->penalty_imposed)) > 100) ? substr(strip_tags($a1->penalty_imposed),0,100).'...' : strip_tags($a1->penalty_imposed);
                $text .= "Penalty imposed: ".$string."\n";
            }
        }

        // Penalty paid

        if (isset($a1->penalty_paid)){

            if ($a1->penalty_paid != $a2->penalty_paid){
                if ($a1->penalty_paid){
                    $text .= "Penalty paid: Yes\n";
                }else{
                    $text .= "Penalty paid: No\n";
                }
            }
        }

        // Config

        if ($elm->subject_type=='App\Models\Config'){

            $rules = ["","api","aboutppp","homepage","mail","address","phone","linkedin","facebook","twitter","instagram","aboutppp_title","lang_default","lang_updated","address_link","currency","institution","institution_short","ocid"];
            $trans = ["","API activated","About PPP","Institution Website","Institution email","Institution Address","Institution Telephone","Linkedin","Facebook","Twitter","Instagram","About PPP Title","Default Language","Language updated","Institution address link","Currency","Institution","Institution short name","OCID"];

            $human = $this->humanReadableArrays($a1->name,$rules,$trans);

            $text .= $human.": ".$a1->value."\n";

        }

        /**
         *  PROJECT BASIC INFORMATION
         *  Separated by platforms (the repeated ones are on the previous elements instead of duplicated)
         */

        /* --- Ghana --- */

        // Sponsor ID

        if (isset($a1->sponsor_id)){
            if ($a1->sponsor_id != $a2->sponsor_id){
                $text .= "Sponsor ID: ".$a1->sponsor_id."\n";
            }
        }

        // OCID

        if (isset($a1->ocid)){
            if ($a1->ocid != $a2->ocid){
                $text .= "OCID: ".$a1->ocid."\n";
            }
        }

        // Stage ID

        if (isset($a1->stage_id)){
            if ($a1->stage_id != $a2->stage_id){
                $text .= "Stage ID: ".$a1->stage_id."\n";
            }
        }

        // Project Value (USD)

        if (isset($a1->project_value_usd)){
            if ($a1->project_value_usd != $a2->project_value_usd){
                $text .= "Project Value (USD): ".$a1->project_value_usd."\n";
            }
        }

        // Project Value (second)

        if (isset($a1->project_value_second)){
            if ($a1->project_value_second != $a2->project_value_second){
                // Get the currency
                $currency = Config::where('name','currency')->get()->first()->value;
                $text .= "Project Value (".$currency."): ".$a1->project_value_second."\n";
            }
        }

        // Project Need

        if (isset($a1->project_need)){
            if ($a1->project_need != $a2->project_need){
                $string = (strlen(strip_tags($a1->project_need)) > 100) ? substr(strip_tags($a1->project_need),0,100).'...' : strip_tags($a1->project_need);
                $text .= "Project Need: ".$string."\n";
            }
        }

        // Description of services

        if (isset($a1->description_services)){
            if ($a1->description_services != $a2->description_services){
                $string = (strlen(strip_tags($a1->description_services)) > 100) ? substr(strip_tags($a1->description_services),0,100).'...' : strip_tags($a1->description_services);
                if ($type==2){
                    $text .= "Description of Project Company: ".$string."\n";
                }else{
                    $text .= "Description of services: ".$string."\n";
                }

            }
        }

        // Rationale for selection of PPP mode

        if (isset($a1->reasons_ppp)){
            if ($a1->reasons_ppp != $a2->reasons_ppp){
                $string = (strlen(strip_tags($a1->reasons_ppp)) > 100) ? substr(strip_tags($a1->reasons_ppp),0,100).'...' : strip_tags($a1->reasons_ppp);
                $text .= "Rationale for selection of PPP mode: ".$string."\n";
            }
        }

        // Stakeholder consultations

        if (isset($a1->stakeholder_consultation)){
            if ($a1->stakeholder_consultation != $a2->stakeholder_consultation){
                $string = (strlen(strip_tags($a1->stakeholder_consultation)) > 100) ? substr(strip_tags($a1->stakeholder_consultation),0,100).'...' : strip_tags($a1->stakeholder_consultation);
                $text .= "Stakeholder consultations: ".$string."\n";
            }
        }

        // Description of asset

        if (isset($a1->description_asset)){
            if ($a1->description_asset != $a2->description_asset){
                $string = (strlen(strip_tags($a1->description_asset)) > 100) ? substr(strip_tags($a1->description_asset),0,100).'...' : strip_tags($a1->description_asset);
                if ($type==1 || $type==2){
                    $text .= "Market Drivers: ".$string."\n";
                }else{
                    $text .= "Description of asset: ".$string."\n";
                }
            }
        }

        /* --- Kenya --- */

        // Rationale for selecting the project for development as a PPP

        if (isset($a1->rationale_ppp)){
            if ($a1->rationale_ppp != $a2->rationale_ppp){
                $string = (strlen(strip_tags($a1->rationale_ppp)) > 100) ? substr(strip_tags($a1->rationale_ppp),0,100).'...' : strip_tags($a1->rationale_ppp);
                $text .= "Rationale for selecting the project for development as a PPP: ".$string."\n";
            }
        }

        // Name and deliverables of Transaction Advisor

        if (isset($a1->name_transaction_advisor)){
            if ($a1->name_transaction_advisor != $a2->name_transaction_advisor){
                $string = (strlen(strip_tags($a1->name_transaction_advisor)) > 100) ? substr(strip_tags($a1->name_transaction_advisor),0,100).'...' : strip_tags($a1->name_transaction_advisor);
                $text .= "Name and deliverables of Transaction Advisor: ".$string."\n";
            }
        }

        // Unsolicited project - Rationale

        if (isset($a1->unsolicited_project)){
            if ($a1->unsolicited_project != $a2->unsolicited_project){
                $string = (strlen(strip_tags($a1->unsolicited_project)) > 100) ? substr(strip_tags($a1->unsolicited_project),0,100).'...' : strip_tags($a1->unsolicited_project);
                $text .= "Unsolicited project - Rationale: ".$string."\n";
            }
        }

        // Project Summary document

        if (isset($a1->project_summary)){
            if ($a1->project_summary != $a2->project_summary){
                $string = (strlen(strip_tags($a1->project_summary)) > 100) ? substr(strip_tags($a1->project_summary),0,100).'...' : strip_tags($a1->project_summary);
                $text .= "Project Summary document: ".$string."\n";
            }
        }

        // Project Summary document

        if (isset($a1->project_summary_document)){
            if ($a1->project_summary_document != $a2->project_summary_document){
                $string = (strlen(strip_tags($a1->project_summary_document)) > 100) ? substr(strip_tags($a1->project_summary_document),0,100).'...' : strip_tags($a1->project_summary_document);
                $text .= "Project Summary document: ".$string."\n";
            }
        }


        /**
         *  CONTRACT INFORMATION
         */

        // Mitigation

        if (isset($a1->mitigation)){
            if ($a1->mitigation != $a2->mitigation){
                $string = (strlen(strip_tags($a1->mitigation)) > 100) ? substr(strip_tags($a1->mitigation),0,100).'...' : strip_tags($a1->mitigation);
                $text .= "Mitigation: ".$string."\n";
            }
        }


        switch ($elm->subject_type){
            case 'App\Models\GraphPos':
                return "Graphics";
                break;
            case 'App\Models\Task':
                return "Request for Modification";
                break;
        }

        return $text;

    }

    private function humanReadableArrays($elm,$arr,$arrTrans){


        if ($pos = array_search($elm,$arr)){

            return $arrTrans[$pos];

        } else {

            return $elm;

        }

    }

}
