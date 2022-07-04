{{-- @inject('permission', 'App\Services\PermissionsService') --}}
{{-- {{$permission->requires($project->id, 1)}} --}}
<div class="relative project-title-information">
<h1 class="content-title">@component('back.components.export_excel', ['project' => $project])@endcomponent {{__("menu.projects")}}</h1>
<h2 class="content-title-2">
    @if (Auth::user()->isAdmin())
    <span contenteditable="true" id="project-name-editable" data-id="{{$project->id}}" tabindex='1'>{{$project->name}} </span><i class="material-icons hidden color-green" id="project-name-save">check</i><i class="material-icons" id="project-name-edit">mode_edit</i>
        @else
        {{$project->name}}
    @endif
        <div class="updated_at_date">{{trans('general.last_update')}}: {{$project->updated_at->format('d-m-Y H:i:s')}} </div>

</h2>
<span class="project-save-info hidden"><i class="material-icons">info_outline</i> {{__('project.save-name-info')}}</span>
</div>


<div class="project-menu">
    <ul>
        @if (Auth::user()->canAccessProjectInformation($project))
            <li class="{{active('project/*/project-information')}}"><a href="{{route('project.project-information', array('id' => $project->id))}}">{{__("project.section.project_basic_information")}}</a></li>
        @endif
            @if (Auth::user()->canAccessContractMilestones($project))
                <li class="{{active('project/*/project-milestones')}}"><a href="{{route('project.contract-milestones', array('id' => $project->id))}}">{{__("project.section.contract_milestones")}}</a></li>
            @endif

        @if (Auth::user()->canAccessPDProcurementInformation($project))
            <li class="{{active('project/*/procurement')}}"><a href="{{route('project.procurement', array('id' => $project->id))}}">{{__("project.section.procurement")}}</a></li>
        @endif
        @if (Auth::user()->canAccessParties($project))
            <li class="{{active('project/*/parties')}}"><a href="{{route('project.parties', array('id' => $project->id))}}">{{__("project.section.parties")}}</a></li>
        @endif
        @if (Auth::user()->canAccessProjectDetails($project))
            <li class="{{active('project/*/contract-information/*')}}"><a href="{{ Auth::user()->getProjecDetailstSectionUrl($project) }}">{{__("project.section.project_details_title")}}</a></li>
        @endif
        @if (Auth::user()->canAccessPerformanceInformation($project))
            <li class="{{active('project/*/performance-information/*')}}"><a href="{{ Auth::user()->getProjectPerformanceSectiontUrl($project) }}">{{__("project.section.performance_information_title")}}</a></li>
        @endif
        @if (Auth::user()->canAccessGallery($project))
            <li class="{{active('project/*/gallery')}}"><a href="{{route('project.gallery', array('id' => $project->id))}}">{{__("project.section.gallery")}}</a></li>
        @endif
            @if (Auth::user()->canAccessPDAnnouncements($project))
                <li class="{{active('project/*/announcements')}}"><a href="{{route('project-details-announcements', array('id' => $project->id))}}">{{__("project.section.project_details.announcements")}}</a></li>
            @endif

    </ul>
</div>

@if (Request::is('project/*/performance-information/*') || Request::is('project/*/contract-information/*'))

<div class="project-submenu">
    <ul>
        @if (Request::is('project/*/contract-information/*'))
            @if (Auth::user()->canAccessPDFinancialSupport($project))
                <li class="{{active('project/*/contract-information/financial')}}"><a href="{{route('project-details-financial', array('id' => $project->id))}}">{{__("project.section.project_details.financial")}}</a></li>
            @endif

        @if (Auth::user()->canAccessPDDocuments($project))
                <li class="{{active('project/*/contract-information/documents')}}"><a href="{{route('project-details-documents', array('id' => $project->id))}}">{{__("project.section.project_details.documents")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDEnvironment($project))
                <li class="{{active('project/*/contract-information/environment')}}"><a href="{{route('project-details-environment', array('id' => $project->id))}}">{{__("project.section.project_details.environment")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDRisks($project))
                <li class="{{active('project/*/contract-information/risks')}}"><a href="{{route('project-details-risks', array('id' => $project->id))}}">{{__("project.section.project_details.risks")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDEvaluationPPP($project))
                <li class="{{active('project/*/contract-information/evaluation-ppp')}}"><a href="{{route('project-details-evaluation-ppp', array('id' => $project->id))}}">{{__("project.section.project_details.evaluation-ppp")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDGovernmentSupport($project))
                <li class="{{active('project/*/contract-information/government-support')}}"><a href="{{route('project-details-government-support', array('id' => $project->id))}}">{{__("project.section.project_details.government-support")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDTariffs($project))
                <li class="{{active('project/*/contract-information/tariffs')}}"><a href="{{route('project-details-tariffs', array('id' => $project->id))}}">{{__("project.section.project_details.tariffs")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDContractTermination($project))
                <li class="{{active('project/*/contract-information/termination-provisions')}}"><a href="{{route('project-details-contract-termination', array('id' => $project->id))}}">{{__("project.section.project_details.contract-termination")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPDRenegotiations($project))
                <li class="{{active('project/*/contract-information/renegotiations')}}"><a href="{{route('project-details-renegotiations', array('id' => $project->id))}}">{{__("project.section.project_details.renegotiations")}}</a></li>
            @endif
        @endif

        @if (Request::is('project/*/performance-information/*'))
            @if (Auth::user()->canAccessPIAnnualDemandLevels($project))
                <li class="{{active('project/*/performance-information/annual-demand-levels')}}"><a href="{{route('project.performance-information.annual-demand-levels', array('id' => $project->id))}}">{{__("project.section.performance_information.annual_demand_levels")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPIIncomeStatementsMetrics($project))
                <li class="{{active('project/*/performance-information/income-statement-metrics')}}"><a href="{{route('project.performance-information.income-statements-metrics', array('id' => $project->id))}}">{{__("project.section.performance_information.income_statements_metrics")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPIOtherFinancialMetrics($project))
                <li class="{{active('project/*/performance-information/other-financial-metrics')}}"><a href="{{route('project.performance-information.other-financial-metrics', array('id' => $project->id))}}">{{__("project.section.performance_information.other_financial_metrics")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPIKeyPerformanceIndicators($project))
                <li class="{{active('project/*/performance-information/key-performance-indicators')}}"><a href="{{route('project.performance-information.key-performance-indicators', array('id' => $project->id))}}">{{__("project.section.performance_information.key_performance_indicators")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPIPerformanceFailures($project))
                <li class="{{active('project/*/performance-information/performance-failures')}}"><a href="{{route('project.performance-information.performance-failures', array('id' => $project->id))}}">{{__("project.section.performance_information.performance_failures")}}</a></li>
            @endif
            @if (Auth::user()->canAccessPIPerformanceAssessments($project))
                <li class="{{active('project/*/performance-information/performance-assessments')}}"><a href="{{route('project.performance-information.performance-assessments' , array('id' => $project->id))}}">{{__("project.section.performance_information.performance-assessments")}}</a></li>
            @endif
        @endif
    </ul>
</div>

    @endif