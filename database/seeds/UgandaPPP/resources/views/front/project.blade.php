@extends('layouts.front')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blueimp-gallery.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div id="basic-info" class="hidden-xs hidden-sm" style="background: url({{$projectBG}});">
        <div class="container">
            <h1>{{$project->name}}</h1>
            <div class="row">
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.sector')}}</h2>
                        @if($project->projectInformation && count($project->projectInformation) > 0)
                            <p>@foreach($project->projectInformation->sectors as $sector) {{$sector->name}} @if(!$loop->last), @endif @endforeach</p>
                        @endif
                    </div>
                </div>
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.location')}}</h2>
                        @if($project->projectInformation && $project->projectInformation)
                            <p>@foreach($project->projectInformation->regions as $region) {{$region->name}}@if(!$loop->last), @endif @endforeach</p>
                        @endif
                        @if($project->projectInformation->local_government)
                            <span><b>{{trans('project/project-information.local_government')}}:</b> {{ $project->projectInformation->local_government }}</span>
                        @endif
                    </div>
                </div>
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>
                            @if ($project->isPostprocurement())
                                {{trans('project/project-information.project_value')}}
                            @else
                                {{trans('project/project-information.project_indicative_value')}}
                            @endif
                        </h2>
                        <p>
                            @if(($project->projectInformation->project_value_second != "" || $project->projectInformation->project_value_second != null))
                                @if($project->projectInformation->project_value_usd != 0)
                                    {{$currency}} {{$project->projectInformation->project_value_second}} {{__('project.million')}} (US$ {{$project->projectInformation->project_value_usd}} million)
                                @else
                                    {{$currency}} {{$project->projectInformation->project_value_second}} {{__('project.million')}}
                                @endif
                            @else
                                @if($project->projectInformation->project_value_usd != 0)
                                    US$ {{$project->projectInformation->project_value_usd}} {{__('project.million')}}
                                @else
                                    {{trans('project/project-information.project_value_not_available')}}
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.phase')}}</h2>
                        <p>{{$project->projectInformation->stage->name}}</p>
                    </div>
                </div>
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.contracting_authority')}}</h2>
                        <p>{{$project->projectInformation->sponsor->name}}</p>
                    </div>
                </div>
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.last_update')}}</h2>
                        <p>{{$project->updated_at->format('d-m-Y H:i:s')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="project-m" class="visible-sm-block visible-xs-block">
        <div id="project-title-m"><h1>{{$project->name}}</h1></div>
        <div id="project-info-m" class="row">
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.sector')}}</h2>
                <p>@foreach($project->projectInformation->sectors as $sector) {{$sector->name}} @if(!$loop->last), @endif @endforeach</p>
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.region')}}</h2>
                <p>@foreach($project->projectInformation->regions as $region) {{$region->name}} @if(!$loop->last), @endif @endforeach</p>
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('project/project-information.project_value')}}</h2>
                @if(($project->projectInformation->project_value_second != "" || $project->projectInformation->project_value_second != null))
                    @if($project->projectInformation->project_value_usd != 0)
                        {{$currency}} {{$project->projectInformation->project_value_second}} {{__('project.million')}} (US$ {{$project->projectInformation->project_value_usd}} million)
                    @else
                        {{$currency}} {{$project->projectInformation->project_value_second}} {{__('project.million')}}
                    @endif
                @else
                    @if($project->projectInformation->project_value_usd != 0)
                        US$ {{$project->projectInformation->project_value_usd}} {{__('project.million')}}
                    @else
                        {{trans('project/project-information.project_value_not_available')}}
                    @endif
                @endif
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.phase')}}</h2>
                <p>{{$project->projectInformation->stage->name}}</p>
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.sponsor-agency')}}</h2>
                <p>{{$project->projectInformation->sponsor->name}}</p>
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.last_update')}}</h2>
                <p>{{$project->updated_at->format('d-m-Y H:i:s')}}</p>
            </div>
        </div>
    </div>

    <div class="container content-project">

        <div id="download-page">
            <button onclick="window.print();" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect print hiddenAtPrint"><a href="#" target="_blank"><i class="material-icons">print</i>{{trans('general.download_page_pdf')}}</a></button>
            @if (count($projectDocuments)>0)
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect print hiddenAtPrint" id="download-all"><i class="material-icons">file_download</i>{{trans('general.download_page_documents')}}</button>
            @endif
        </div>

        <div class="project-menu hiddenAtPrint">
            <ul>
                @if ($project->isProjectInformationActive())
                    <li><a href="#project-info" class="soft-scroll">{{trans("project.section.project_basic_information")}}</a></li>
                @endif
                @if ($project->isProcurementOrHigher() && $project->isPDProcurementActive())
                    <li><a href="#procurement-documents" class="soft-scroll">{{trans("project.procurement-documents")}}</a></li>
                @endif
                @if ($project->isPostprocurement() && $project->isPartiesActive())
                    <li><a href="#parties" class="soft-scroll">{{trans("project.section.parties")}}</a></li>
                @endif
                @if ($project->isPostprocurement() && $project->isProjectDetailsActive() && ($project->isPDGovernmentSupportActive() || $project->isPDTariffsActive() || $project->isPDContractTerminationActive() || $project->isPDDocumentsActive() || $project->isPDFinancialActive() || $project->isPDRisksActive()))
                    <li><a href="#contract-information" class="soft-scroll">{{trans("project.contract-information")}}</a></li>
                @endif
                @if ($project->isPostprocurement() && $project->isPerformanceInformationActive())
                    <li><a href="#performance-information" class="soft-scroll">{{trans("project.section.performance_information_title")}}</a></li>
                @endif
                @if ($project->isPDAnnouncementsActive())
                    <li><a href="#announcements-section" class="soft-scroll">{{trans("project.section.project_details.announcements")}}</a></li>
                @endif
                @if ($project->isGalleryActive() && count($projectGallery)>0)
                    <li><a href="#gallery" class="soft-scroll">{{trans("project.section.gallery")}}</a></li>
                @endif
            </ul>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                @if ($project->isProjectInformationActive())
                    <div id="project-info" class="project-info"> <!-- project-info -->
                        <div class="section-title-double section-title-left section-title-project">
                            <h2>{{trans("project.section.project_basic_information")}}</h2>

                            <span></span>
                        </div>

                        @if ($project->projectInformation)
                            <ul>
                                <li>
                                    <h3>{{trans('project/project-information.project-need')}}</h3>
                                    @if($project->projectInformation->project_need && $project->projectInformation->project_need_private)
                                        <p>{!! $project->projectInformation->project_need !!}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==2)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>{{trans('messages.empty_record')}}</p>
                                    @endif
                                </li>
                                <li>
                                    <h3>{{trans('project.description-asset')}}</h3>
                                    @if($project->projectInformation->description_asset && $project->projectInformation->description_asset_private)
                                        <p>{!! $project->projectInformation->description_asset !!}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==3)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>{{trans('messages.empty_record')}}</p>
                                    @endif
                                </li>
                                <li>
                                    <h3>{{trans('project/project-information.description-services')}}</h3>
                                    @if($project->projectInformation->description_services && $project->projectInformation->description_services_private)
                                        <p>{!! $project->projectInformation->description_services !!}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==4)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>{{trans('messages.empty_record')}}</p>
                                    @endif
                                </li>
                                <li>
                                    <h3>{{trans('project/project-information.reasons-ppp')}}</h3>
                                    @if($project->projectInformation->reasons_ppp && $project->projectInformation->reasons_ppp_private)
                                        <p>{!! $project->projectInformation->reasons_ppp !!}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==5)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>{{trans('messages.empty_record')}}</p>
                                    @endif
                                </li>
                                <li>
                                    <h3>{{trans('project/project-information.stakeholder-consultation')}}</h3>
                                    @if($project->projectInformation->stakeholder_consultation && $project->projectInformation->stakeholder_consultation_private)
                                        <p>{!! $project->projectInformation->stakeholder_consultation !!}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==6)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>{{trans('messages.empty_record')}}</p>
                                    @endif
                                </li>
                            </ul>
                        @else
                            <p>{{trans('messages.empty_record')}}</p>
                        @endif
                    </div> <!-- /project-info -->
                @endif

                @if ($project->isProcurementOrHigher() && $project->isPDProcurementActive())
                    <div class="section-title-double section-title-left section-title-project">
                        <h2 id="procurement-documents">{{__('project.procurement-documents')}}</h2>

                        <span></span>
                    </div>


                    <ul id="procurement-documents-list">
                        @if(count($project->procurements) > 0)
                            <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">

                                @foreach($project->procurements as $procurement)
                                    @if($procurement->published)
                                        <div class="panel">
                                            <div class="panel-heading @if ($loop->iteration==1) active @endif" role="tab" id="headingPIOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePI{{$procurement->id}}" aria-expanded="true" aria-controls="collapsePI{{$procurement->id}}">{{$procurement->name}}</a>
                                                </h4>
                                            </div>
                                            {{-- @if($loop->first) in @endif --}}
                                            <div id="collapsePI{{$procurement->id}}" class="panel-collapse collapse @if ($loop->iteration==1) in @endif" role="tabpanel" aria-labelledby="headingPIOne">
                                                <div class="panel-body">
                                                    <p>{{$procurement->description}}</p>
                                                    @foreach($projectDocuments as $projectDocument)
                                                        @if ($projectDocument->section=="pri" && $projectDocument->position==$procurement->id)
                                                            <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div><!-- end of panel -->
                                    @endif
                                @endforeach
                            </div><!-- end of #accordion -->

                        @else
                            <li>{{trans('messages.empty_record')}}</li>
                        @endif
                    </ul>
                @endif
            </div>

            @if ($project->isContractMilestonesActive())
                <div class="col-lg-4 col-md-4"><!-- right-sidebar -->
                    <div id="contract-milestones" class="milestones">
                        <div class="section-title-double section-title-left section-title-project">
                            <h2>{{trans("project.section.contract_milestones")}}</h2>

                            <span></span>
                        </div>

                        @if(count($project->contractMilestones) == 0)
                            <p>{{trans('messages.empty_record')}}</p>
                        @endif
                        <div class="timeline-centered">
                            @foreach($project->contractMilestones as $contractMilestone)
                                @if($contractMilestone->published)
                                    <article class="timeline-entry">
                                        <div class="timeline-entry-inner">
                                            <div class="timeline-icon">
                                                <p class="year">{{$contractMilestone->date->format('Y')}}</p>
                                            </div>
                                            <div class="timeline-label">
                                                <div class="timeline-title">
                                                    <p>{{$contractMilestone->date->format('j F')}}</p>
                                                    <h3>{{$contractMilestone->name}}</h3>
                                                </div>
                                                <div class="timeline-description">
                                                    <p>{{$contractMilestone->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endif
                            @endforeach
                        </div>
                    </div> <!-- milestones -->
                </div> <!-- /right-sidebar -->
            @endif
        </div>

        @if ($project->isPostprocurement() && $project->isPartiesActive())
            <div class="section-title-double section-title-left section-title-project">
                <h2 id="parties">{{trans('project.section.parties')}}</h2>
                <span></span>
            </div>

            <div id="project-parties">
                <div class="row">

                    @if (isNigeriaSovereign())

                        <div class="party-item col-sm-4">
                            @if($project->isTypePPP())
                                <h3 class="item-title">{{__('project.private_party')}}</h3>
                            @elseif($project->isTypePublic())
                                <h3 class="item-title">{{__('project.public_authority_party')}}</h3>
                            @elseif($project->isTypePrivate())
                                <h3 class="item-title">{{__('project.private_party_co_developer')}}</h3>
                            @endif
                            @if($project->projectInformation->sponsor)
                                <img id="sponsor-logo" class="img-responsive img-centered party-logo" src="{{ route('uploader.par', array('position' => $project->projectInformation->sponsor->id)) }}" alt="logo">

                                <div class="modal party-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                @if($project->isTypePPP())
                                                    <h4 class="modal-title">{{__('project.private_party')}}</h4>
                                                @elseif($project->isTypePublic())
                                                    <h4 class="modal-title">{{__('project.public_authority_party')}}</h4>
                                                @elseif($project->isTypePrivate())
                                                    <h4 class="modal-title">{{__('project.private_party_co_developer')}}</h4>
                                                @endif
                                            </div>
                                            <div class="modal-body">
                                                <ul class="sponsor-contact-list">
                                                    <li><i class="material-icons">business_center</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->name }}</span></li>
                                                    @if ($project->projectInformation->sponsor->name_representative)
                                                        <li><i class="material-icons">person</i> <span class="m-l-5">{{trans('entity.name-representative')}}: {{ $project->projectInformation->sponsor->name_representative }}</span></li>
                                                    @endif

                                                    @if ($project->projectInformation->sponsor->address)
                                                        <li><i class="material-icons">location_on</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->address }}</span></li>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->tel)
                                                        <li><i class="material-icons">phone</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->tel }}</span></li>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->fax)
                                                        <li><i class="material-icons">print</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->fax }}</span></li>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->email)
                                                        <li><i class="material-icons">email</i><span class="m-l-5"><a href="mailto:{{$project->projectInformation->sponsor->mail}}">{{ $project->projectInformation->sponsor->email }}</a></span></li>
                                                    @endif
                                                </ul>
                                                <div class="social-media-icons">
                                                    @if ($project->projectInformation->sponsor->url)
                                                        <a href="{{$project->projectInformation->sponsor->url}}" class="btn home-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->facebook)
                                                        <a href="{{$project->projectInformation->sponsor->facebook}}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->twitter)
                                                        <a href="{{$project->projectInformation->sponsor->twitter}}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                                        </a>
                                                    @endif

                                                    @if($project->projectInformation->sponsor->instagram)
                                                        <a href="{{$project->projectInformation->sponsor->instagram}}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal" data-upgraded=",MaterialButton,MaterialRipple">
                                                    {{__('general.close')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                        @if (count($project->parties)>0)
                            <div class="col-sm-8">
                                <div class="party-wrapper">

                                    @foreach($project->parties as $party)

                                        <div class="party-item">
                                            <img id="party-logo{{$party->id}}" class="party-logo img-centered" src="{{ route('uploader.par', array('position' => $party->id)) }}" alt="{{$party->name}}">
                                            <div class="modal party-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            @if($project->isTypePPP())
                                                                <h4 class="modal-title">{{__('project.private_party')}}</h4>
                                                            @elseif($project->isTypePublic())
                                                                <h4 class="modal-title">{{__('project.public_authority_party')}}</h4>
                                                            @elseif($project->isTypePrivate())
                                                                <h4 class="modal-title">{{__('project.private_party_co_developer')}}</h4>
                                                            @endif
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="sponsor-contact-list">
                                                                <li><i class="material-icons">business_center</i> <span class="m-l-5">{{ $party->name }}</span></li>
                                                                @if ($party->name_representative)
                                                                    <li><i class="material-icons">person</i> <span class="m-l-5">{{trans('entity.name-representative')}}: {{ $party->name_representative }}</span></li>
                                                                @endif

                                                                @if ($party->address)
                                                                    <li><i class="material-icons">location_on</i> <span class="m-l-5">{{ $party->address }}</span></li>
                                                                @endif
                                                                @if ($party->tel)
                                                                    <li><i class="material-icons">phone</i> <span class="m-l-5">{{ $party->tel }}</span></li>
                                                                @endif
                                                                @if ($party->fax)
                                                                    <li><i class="material-icons">print</i> <span class="m-l-5">{{ $party->fax }}</span></li>
                                                                @endif
                                                                @if ($party->email)
                                                                    <li><i class="material-icons">email</i><span class="m-l-5"><a href="mailto:{{$party->mail}}">{{ $party->email }}</a></span></li>
                                                                @endif
                                                            </ul>
                                                            <div class="social-media-icons">
                                                                @if ($party->url)
                                                                    <a href="{{$party->url}}" class="btn home-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                                @if ($party->facebook)
                                                                    <a href="{{$party->facebook}}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                                @if ($party->twitter)
                                                                    <a href="{{$party->twitter}}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif

                                                                @if($party->instagram)
                                                                    <a href="{{$party->instagram}}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal" data-upgraded=",MaterialButton,MaterialRipple">
                                                                {{__('general.close')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @else

                        <div class="party-item col-sm-4">
                            <h3 class="item-title">{{__('project.contracting-authority')}}</h3>
                            @if($project->projectInformation->sponsor)
                                <img id="sponsor-logo" class="img-responsive img-centered party-ca" src="{{ route('uploader.par', array('position' => $project->projectInformation->sponsor->id)) }}" alt="{{$project->projectInformation->sponsor->name}}">

                                <div class="modal party-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{__('project.sponsor-info')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="sponsor-contact-list">
                                                    <li><i class="material-icons">business_center</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->name }}</span></li>
                                                    @if ($project->projectInformation->sponsor->name_representative)
                                                        <li><i class="material-icons">person</i> <span class="m-l-5">{{trans('entity.name-representative')}}: {{ $project->projectInformation->sponsor->name_representative }}</span></li>
                                                    @endif

                                                    @if ($project->projectInformation->sponsor->address)
                                                        <li><i class="material-icons">location_on</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->address }}</span></li>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->tel)
                                                        <li><i class="material-icons">phone</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->tel }}</span></li>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->fax)
                                                        <li><i class="material-icons">print</i> <span class="m-l-5">{{ $project->projectInformation->sponsor->fax }}</span></li>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->email)
                                                        <li><i class="material-icons">email</i><span class="m-l-5"><a href="mailto:{{$project->projectInformation->sponsor->mail}}">{{ $project->projectInformation->sponsor->email }}</a></span></li>
                                                    @endif
                                                </ul>
                                                <div class="social-media-icons">
                                                    @if ($project->projectInformation->sponsor->url)
                                                        <a href="{{$project->projectInformation->sponsor->url}}" class="btn home-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->facebook)
                                                        <a href="{{$project->projectInformation->sponsor->facebook}}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                    @if ($project->projectInformation->sponsor->twitter)
                                                        <a href="{{$project->projectInformation->sponsor->twitter}}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                                        </a>
                                                    @endif

                                                    @if($project->projectInformation->sponsor->instagram)
                                                        <a href="{{$project->projectInformation->sponsor->instagram}}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal" data-upgraded=",MaterialButton,MaterialRipple">
                                                    {{__('general.close')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                        @if (count($project->parties)>0)
                            <div class="col-sm-8">
                                <h3 class="party-subheading">{{__('project.private-parties')}}</h3>
                                <div class="party-wrapper">

                                    @foreach($project->parties as $party)

                                        <div class="party-item">
                                            <img id="party-logo{{$party->id}}" class="party-logo img-centered" src="{{ route('uploader.par', array('position' => $party->id)) }}" alt="{{$party->name}}">
                                            <div class="modal party-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('project.party-info')}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="sponsor-contact-list">
                                                                <li><i class="material-icons">business_center</i> <span class="m-l-5">{{ $party->name }}</span></li>
                                                                @if ($party->name_representative)
                                                                    <li><i class="material-icons">person</i> <span class="m-l-5">{{trans('entity.name-representative')}}: {{ $party->name_representative }}</span></li>
                                                                @endif

                                                                @if ($party->address)
                                                                    <li><i class="material-icons">location_on</i> <span class="m-l-5">{{ $party->address }}</span></li>
                                                                @endif
                                                                @if ($party->tel)
                                                                    <li><i class="material-icons">phone</i> <span class="m-l-5">{{ $party->tel }}</span></li>
                                                                @endif
                                                                @if ($party->fax)
                                                                    <li><i class="material-icons">print</i> <span class="m-l-5">{{ $party->fax }}</span></li>
                                                                @endif
                                                                @if ($party->email)
                                                                    <li><i class="material-icons">email</i><span class="m-l-5"><a href="mailto:{{$party->mail}}">{{ $party->email }}</a></span></li>
                                                                @endif
                                                            </ul>
                                                            <div class="social-media-icons">
                                                                @if ($party->url)
                                                                    <a href="{{$party->url}}" class="btn home-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                                @if ($party->facebook)
                                                                    <a href="{{$party->facebook}}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                                @if ($party->twitter)
                                                                    <a href="{{$party->twitter}}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif

                                                                @if($party->instagram)
                                                                    <a href="{{$party->instagram}}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float" target="_blank">
                                                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal" data-upgraded=",MaterialButton,MaterialRipple">
                                                                {{__('general.close')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @endif

                </div>
            </div>
        @endif
    </div><!-- /container -->

    <div class="container content-project"> <!-- content-project -->
        @if ($project->isPostprocurement() && $project->isProjectDetailsActive())

            @if ($project->isPDGovernmentSupportActive() || $project->isPDTariffsActive() || $project->isPDContractTerminationActive() || $project->isPDDocumentsActive() || $project->isPDFinancialActive() || $project->isPDRisksActive())

                <div id="project-details" class="project-details"><!-- project-details -->
                    <div class="section-title-double section-title-left section-title-project">
                        <h2 id="contract-information">{{__("project.contract-information")}}</h2>
                        <span></span>
                    </div>

                    @if ($project->isPDDocumentsActive() || $project->isPDFinancialActive() || $project->isPDRisksActive())

                        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table1 -->
                            <div class="mdl-tabs__tab-bar hiddenAtPrint">
                                @if ($project->isPDDocumentsActive())
                                    <a href="#project-documents-panel" class="mdl-tabs__tab is-active col-lg-3 col-md-3">{{__("project.section.project_details.documents")}}</a>
                                @endif

                                @if ($project->isPDFinancialActive())
                                    <a href="#financial-information-panel" class="mdl-tabs__tab col-lg-3 col-md-3 @if (!$project->isPDDocumentsActive()) is-active @endif">{{__("project.financial-structure")}}</a>
                                @endif
                                @if ($project->isPDRisksActive())
                                    <a href="#risks-panel" class="col-md-3 mdl-tabs__tab @if (!$project->isPDDocumentsActive() && !$project->isPDFinancialActive()) is-active @endif">{{__("project.section.project_details.risks")}}</a>
                                @endif

                            </div>

                            @if ($project->isPDDocumentsActive())
                                <div class="mdl-tabs__panel is-active" id="project-documents-panel">
                                    <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.documents")}}</h3>
                                    <ul>
                                        @if(count($project->projectDetails->documents->where('published', true)) > 0)
                                            @foreach($project->projectDetails->documents as $document)
                                                @if($document->published)
                                                    <li>
                                                        <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                            <div class="panel">
                                                                <div class="panel-heading" role="tab" id="headingOne">
                                                                    <h4 class="panel-title">
                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDocument{{$document->id}}" aria-expanded="true" aria-controls="collapseDocument{{$document->id}}">{{$document->name}}</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseDocument{{$document->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingOne">
                                                                    <div class="panel-body">
                                                                        <p>{{$document->description}}</p>
                                                                        @foreach($projectDocuments as $projectDocument)
                                                                            @if ($projectDocument->section=="d" && $projectDocument->position==$document->id)
                                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div><!-- end of panel -->
                                                        </div><!-- end of #accordion -->
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <li>{{trans('messages.empty_record')}}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif

                            @if ($project->isPDFinancialActive())
                                <div class="mdl-tabs__panel @if (!$project->isPDDocumentsActive()) is-active @endif" id="financial-information-panel">
                                    <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.financial")}}</h3>
                                    <ul>
                                        @if(count($project->projectDetails->financials->where('published', true)) > 0)
                                            @foreach($project->projectDetails->financials as $financial)
                                                @if($financial->published)
                                                    <li>
                                                        <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                            <div class="panel">
                                                                <div class="panel-heading" role="tab" id="headingfiOne">
                                                                    <h4 class="panel-title">
                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefi{{$financial->id}}" aria-expanded="true" aria-controls="collapsefi{{$financial->id}}">{{$financial->name}}</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapsefi{{$financial->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingfiOne">
                                                                    <div class="panel-body">
                                                                        <p>{{$financial->description}}</p>
                                                                        @foreach($projectDocuments as $projectDocument)
                                                                            @if ($projectDocument->section=="fi" && $projectDocument->position==$financial->id)
                                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div><!-- end of panel -->
                                                        </div><!-- end of #accordion -->
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <li>{{trans('messages.empty_record')}}</li>
                                        @endif
                                    </ul>
                                </div><!-- /#financial-information-panel -->
                            @endif

                            @if ($project->isPDRisksActive())
                                <div class="mdl-tabs__panel @if (!$project->isPDDocumentsActive() && !$project->isPDFinancialActive()) is-active @endif" id="risks-panel">
                                    <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.risks")}}</h3>
                                    @if(count($project->projectDetails->risks->where('published', true)) > 0)
                                        <div class="table-responsive">
                                            <table class="table-type2">
                                                <thead>
                                                <tr>
                                                    <th>{{__("project/project-details/risks.type_risk")}}</th>
                                                    <th>{{__("project/project-details/risks.table_description")}}</th>
                                                    <th>{{__("project/project-details/risks.table_allocation")}}</th>
                                                    <th>{{__("project/project-details/risks.table_mitigation")}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(collect($project->projectDetails->risks)->sortBy('position') as $risk)
                                                    @if($risk->published)
                                                        <tr>
                                                            <td>{{$risk->name}}</td>
                                                            <td>{{$risk->description}}</td>
                                                            <td>{{$risk->allocation->name}}</td>
                                                            <td>{{$risk->mitigation}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="ri" && $projectDocument->position==1)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        {{trans('messages.empty_record')}}
                                    @endif
                                </div><!-- /#risks-panel -->
                            @endif

                        </div><!-- /table1 -->
                    @endif

                    @if ($project->isPDGovernmentSupportActive() || $project->isPDTariffsActive() || $project->isPDContractTerminationActive())

                        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table1 -->
                            <div class="mdl-tabs__tab-bar hiddenAtPrint">
                                @if ($project->isPDGovernmentSupportActive())
                                    <a href="#government-support-panel" class="col-md-3  mdl-tabs__tab is-active">{{__("project.section.project_details.government-support")}}</a>
                                @endif
                                @if ($project->isPDTariffsActive())
                                    <a href="#tariffs-panel" class="col-md-2  mdl-tabs__tab @if (!$project->isPDGovernmentSupportActive()) is-active @endif">{{__("project.section.project_details.tariffs")}}</a>
                                @endif
                                @if ($project->isPDContractTerminationActive())
                                    <a href="#contract-termination-panel" class="col-md-3  mdl-tabs__tab @if (!$project->isPDGovernmentSupportActive() && !$project->isPDTariffsActive()) is-active @endif">{{__("project.terminal-provisions")}}</a>
                                @endif
                                @if ($project->isPDRenegotiationsActive())
                                    <a href="#renegotiations-panel" class="col-md-2 mdl-tabs__tab @if (!$project->isPDGovernmentSupportActive() && !$project->isPDTariffsActive() && !$project->isPDContractTerminationActive()) is-active @endif">{{__("project.section.project_details.renegotiations")}}</a>
                                @endif
                            </div>

                            @if ($project->isPDGovernmentSupportActive())
                                <div class="mdl-tabs__panel is-active" id="government-support-panel">
                                    @if(count($project->projectDetails->governmentSupports->where('published', true)) > 0)
                                        <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.government-support")}}</h3>
                                        <div class="table-responsive">
                                            <table class="table-type1">
                                                @foreach($project->projectDetails->governmentSupports as $governmentSupport)
                                                    @if($governmentSupport->published)
                                                        <tr>
                                                            <td>{{$governmentSupport->name}}</td>
                                                            <td>
                                                                <p>{{$governmentSupport->description}}</p>
                                                                @foreach($projectDocuments as $projectDocument)
                                                                    @if ($projectDocument->section=="gs" && $projectDocument->position==$governmentSupport->id)
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    @else
                                        {{trans('messages.empty_record')}}
                                    @endif
                                </div><!-- /#government-support-panel -->
                            @endif

                            @if ($project->isPDTariffsActive())
                                <div class="mdl-tabs__panel @if (!$project->isPDGovernmentSupportActive()) is-active @endif" id="tariffs-panel">
                                    <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.tariffs")}}</h3>
                                    <ul>
                                        @if(count($project->projectDetails->tariffs->where('published', true)) > 0)
                                            @foreach($project->projectDetails->tariffs as $tariff)
                                                @if($tariff->published)
                                                    <li>
                                                        <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                            <div class="panel">
                                                                <div class="panel-heading" role="tab" id="headingtfOne">
                                                                    <h4 class="panel-title">
                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetf{{$tariff->id}}" aria-expanded="true" aria-controls="collapsetf{{$tariff->id}}">{{$tariff->name}}</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapsetf{{$tariff->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingtfOne">
                                                                    <div class="panel-body">
                                                                        <p>{{$tariff->description}}</p>
                                                                        @foreach($projectDocuments as $projectDocument)
                                                                            @if ($projectDocument->section=="t" && $projectDocument->position==$tariff->id)
                                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div><!-- end of panel -->
                                                        </div><!-- end of #accordion -->
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <li>{{trans('messages.empty_record')}}</li>
                                        @endif
                                    </ul>
                                </div><!-- /#tariffs-panel -->
                            @endif

                            @if ($project->isPDContractTerminationActive())
                                <div class="mdl-tabs__panel @if (!$project->isPDGovernmentSupportActive() && !$project->isPDTariffsActive()) is-active @endif" id="contract-termination-panel"><!-- Terminal Provisions -->
                                    <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.contract-termination")}}</h3>
                                    <ul>
                                        <li>
                                            <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel">
                                                    <div class="panel-heading" role="tab" id="headingctOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsectOne" aria-expanded="true" aria-controls="collapsectOne">Concessionaire</a>
                                                        </h4>
                                                    </div>

                                                    <div id="collapsectOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingctOne">
                                                        <div class="panel-body">
                                                            @if($project->projectDetails->contractTerminations && count($project->projectDetails->contractTerminations->where('published', true)->where('party_type', 'operator')) > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table-type2">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{trans('project/project-details/contract-termination.table_name')}}</th>
                                                                            <th>{{trans('project/project-details/contract-termination.table_description')}}</th>
                                                                            <th>{{trans('project/project-details/contract-termination.table_termination_payment')}}</th>
                                                                            <th>{{trans('general.documents')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($project->projectDetails->contractTerminations->where('party_type', 'operator') as $contract)
                                                                            @if($contract->published)
                                                                                <tr>
                                                                                    <td>{{$contract->name}}</td>
                                                                                    <td>{{$contract->description}}</td>
                                                                                    <td>{{$contract->termination_payment}}</td>
                                                                                    <td nowrap>
                                                                                        @foreach($projectDocuments as $projectDocument)
                                                                                            @if ($projectDocument->section=="ct" && $projectDocument->position==$contract->id)
                                                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <p>{{trans('messages.empty_record')}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div><!-- end of panel -->
                                            </div><!-- end of #accordion -->
                                        </li>
                                        <li>
                                            <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel">
                                                    <div class="panel-heading" role="tab" id="headingctTwo">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsectTwo" aria-expanded="false" aria-controls="collapsectTwo">Authority</a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapsectTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingctTwo">
                                                        <div class="panel-body">
                                                            @if($project->projectDetails->contractTerminations && count($project->projectDetails->contractTerminations->where('published', true)->where('party_type', 'authority')) > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table-type2">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{trans('project/project-details/contract-termination.table_name')}}</th>
                                                                            <th>{{trans('project/project-details/contract-termination.brief_description')}}</th>
                                                                            <th>{{trans('project/project-details/contract-termination.table_termination_payment')}}</th>
                                                                            <th>{{trans('general.documents')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($project->projectDetails->contractTerminations->where('party_type', 'authority') as $contract)
                                                                            @if($contract->published)
                                                                                <tr>
                                                                                    <td>{{$contract->name}}</td>
                                                                                    <td>{{$contract->description}}</td>
                                                                                    <td>{{$contract->termination_payment}}</td>
                                                                                    <td nowrap>
                                                                                        @foreach($projectDocuments as $projectDocument)
                                                                                            @if ($projectDocument->section=="ct" && $projectDocument->position==$contract->id)
                                                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <p>{{trans('messages.empty_record')}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div><!-- end of panel -->
                                            </div><!-- end of #accordion -->
                                        </li>
                                    </ul>
                                </div> <!-- Terminal Provisions -->
                            @endif

                            @if ($project->isPDRenegotiationsActive())
                                <div class="mdl-tabs__panel @if (!$project->isPDGovernmentSupportActive() && !$project->isPDTariffsActive() && !$project->isPDContractTerminationActive()) is-active @endif" id="renegotiations-panel">
                                    <h3 class="showAtPrint printSectionHeader">{{__("project.section.project_details.renegotiations")}}</h3>
                                    @if(count($project->projectDetails->renegotiations->where('published', true)) > 0)
                                        <table class="table-type1">
                                            @foreach($project->projectDetails->renegotiations as $renegotiation)
                                                @if($renegotiation->published)
                                                    <tr>
                                                        <td>{{$renegotiation->name}}</td>
                                                        <td>
                                                            <p>{{$renegotiation->description}}</p>
                                                        </td>
                                                        <td>
                                                            @foreach($projectDocuments as $projectDocument)
                                                                @if ($projectDocument->section=="r" && $projectDocument->position==$renegotiation->id)
                                                                    <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    @else
                                        <p>{{trans('messages.empty_record')}}</p>
                                    @endif
                                </div><!-- /#renegotiations-panel -->
                            @endif
                        </div><!-- /table2 -->
                    @endif
                </div><!-- /project-details -->
            @endif

        @endif

        @if ($project->isPostprocurement() && $project->isPerformanceInformationActive())
            <div id="performance-information" class="performance-information"><!-- performance-information -->
                <div class="section-title-double section-title-left section-title-project">
                    <h2>{{__("project.section.performance_information_title")}}</h2>
                    <span></span>
                </div>


                <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table2 -->
                    <div class="mdl-tabs__tab-bar hiddenAtPrint">
                        @if ($project->isPIKeyPerformanceActive())
                            <a href="#KPI-panel" class="mdl-tabs__tab is-active col-lg-4 col-md-4">{{trans("project.section.performance_information.key_performance_indicators")}}</a>
                        @endif
                        @if ($project->isPIPerformanceFailuresActive())
                            <a href="#failures-panel" class="mdl-tabs__tab col-lg-4 col-md-4">{{trans("project.section.performance_information.performance_failures")}}</a>
                        @endif
                        @if ($project->isPIPerformanceAssessmentActive())
                            <a href="#assessments-panel" class="mdl-tabs__tab col-lg-4 col-md-4">{{trans("project.section.performance_information.performance-assessments")}}</a>
                        @endif
                    </div>
                    @if ($project->isPIKeyPerformanceActive())
                        <div class="mdl-tabs__panel is-active" id="KPI-panel"><!--KPI -->
                            <h3 class="showAtPrint printSectionHeader">{{__("project.section.performance_information.key_performance_indicators")}}</h3>
                            @if(count($tables["key_performance_indicators"]) > 0)
                                @foreach($tables["key_performance_indicators"] as $table)
                                    <table class="table-type3 @if(! $loop->first) m-t-10 @endif">
                                        <thead>
                                        <tr>
                                            <th>{{trans('project/performance-information/annual_demand_levels.year')}}</th>
                                            @foreach($table["years"] as $years)
                                                <th class="years" colspan="4" data-year="{{$years["year"]}}">{{$years["year"]}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td></td>
                                            @for($i = 0; $i < count($table["years"]); $i++)
                                                <td colspan="2">{{trans('project/performance-information/key_performance_indicators.target')}}</td>
                                                <td colspan="2">{{trans('project/performance-information/key_performance_indicators.achievement')}}</td>
                                            @endfor
                                        </tr>
                                        @foreach($table["kpis"] as $keyY => $kpi)
                                            <tr>
                                                <td>{{$kpi["type"]["name"]}} ({{$kpi["type"]["unit"]}})</td>
                                                @foreach($table["records"][$kpi["type"]["id"]] as $keyR => $record)
                                                    @if($record)
                                                        <td  colspan="2">{{$record["target"]}}</td>
                                                        <td  colspan="2">{{$record["achievement"]}}</td>
                                                    @else
                                                        <td  colspan="2"></td>
                                                        <td  colspan="2"></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            @else
                                <p>{{trans('messages.empty_record')}}</p>
                            @endif
                        </div> <!-- KPI -->
                    @endif
                    @if ($project->isPerformanceInformationActive())

                        <div class="mdl-tabs__panel @if (!$project->performanceInformation->key_performance_active) is-active @endif" id="failures-panel">
                            <h3 class="showAtPrint printSectionHeader">{{__("project.section.performance_information.performance_failures")}}</h3>
                            @if(count($project->performanceInformation->performanceFailures->where('published', true)) > 0)

                                @foreach(array_chunk(collect($project->performanceInformation->performanceFailures)->sortBy('position')->toArray(), 2) as $performanceFailures)

                                    <table class="table-type3 @if(! $loop->first) m-t-10 @endif">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @foreach($performanceFailures as $performanceFailure)
                                                @if($performanceFailure["published"])
                                                    <th>{{$performanceFailure["title"]}}</th>
                                                @endif
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{trans('project/performance-information/performance_failures.category')}}</td>
                                            @foreach($performanceFailures as $performanceFailure)
                                                @if($performanceFailure["published"])
                                                    <td>{{$performanceFailure["category"]["name"]}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>{{trans('project/performance-information/performance_failures.number_events')}}</td>
                                            @foreach($performanceFailures as $performanceFailure)
                                                @if($performanceFailure["published"])
                                                    <td>{{$performanceFailure["number_events"]}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>{{trans('project/performance-information/performance_failures.penalty_abatement_contract')}}</td>
                                            @foreach($performanceFailures as $performanceFailure)
                                                @if($performanceFailure["published"])
                                                    <td>{{$performanceFailure["penalty_contract"]}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>{{trans('project/performance-information/performance_failures.penalty_abatement_imposed')}}</td>
                                            @foreach($performanceFailures as $performanceFailure)
                                                @if($performanceFailure["published"])
                                                    <td>{{$performanceFailure["penalty_imposed"]}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>{{trans('project/performance-information/performance_failures.penalty_abatement_yes_no_table')}}</td>
                                            @foreach($performanceFailures as $performanceFailure)
                                                @if($performanceFailure["published"])
                                                    <td>
                                                        @if($performanceFailure["penalty_paid"] == 1)
                                                            {{trans('project/performance-information/performance_failures.yes')}}
                                                        @else
                                                            {{trans('project/performance-information/performance_failures.no')}}
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                            @else
                                <p>{{trans('messages.empty_record')}}</p>
                            @endif
                        </div><!-- /#failures-panel -->
                    @endif
                    @if ($project->isPIPerformanceAssessmentActive())
                        <div class="mdl-tabs__panel @if (!$project->performanceInformation->key_performance_active && !$project->performanceInformation->performance_failures_active) is-active @endif" id="assessments-panel">
                            <h3 class="showAtPrint printSectionHeader">{{__("project.section.performance_information.performance-assessments")}}</h3>
                            <ul>
                                @if(count($project->performanceInformation->performanceAssessments->where('published', true)) > 0)
                                    <li>
                                        <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                            @foreach($project->performanceInformation->performanceAssessments as $performanceAssessment)
                                                @if($performanceAssessment->published)
                                                    <div class="panel">
                                                        <div class="panel-heading" role="tab" id="headingassOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseass{{$performanceAssessment->id}}" aria-expanded="true" aria-controls="collapseass{{$performanceAssessment->id}}">{{$performanceAssessment->name}}</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseass{{$performanceAssessment->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingassOne">
                                                            <div class="panel-body">
                                                                <p>{{$performanceAssessment->description}}</p>
                                                                @foreach($projectDocuments as $projectDocument)
                                                                    @if ($projectDocument->section=="pa" && $projectDocument->position==$performanceAssessment->id)
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                @endif
                                            @endforeach
                                        </div><!-- end of #accordion -->
                                    </li>
                                @else
                                    <li>{{trans('messages.empty_record')}}</li>
                                @endif
                            </ul>
                        </div><!-- /#assessments-panel -->
                    @endif
                </div><!-- /table2-->

            </div><!-- /performance-information -->
        @endif


        @if ($project->isPDAnnouncementsActive())
            <div class="section-title-double section-title-left section-title-project">
                <h2 id="announcements-section">{{__('project.section.project_details.announcements')}}</h2>
                <span></span>
            </div>

            <ul id="announcements-section-list">
                @if(count($project->projectDetails->announcements->where('published', true)) > 0)
                    <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">

                        @foreach($project->projectDetails->announcements as $announcement)
                            @if($announcement->published)
                                <div class="panel">
                                    <div class="panel-heading" role="tab" id="headingAnnouncementOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAnnouncement{{$announcement->id}}" aria-expanded="true" aria-controls="collapseAnnouncement{{$announcement->id}}">{{$announcement->name}} @if($announcement->created_at)<span class="announcement-time"><i class="fa fa-clock-o" aria-hidden="true"></i> {{$announcement->created_at->format('l jS \of F Y')}}</span>@endif</a>
                                        </h4>
                                    </div>
                                    <div id="collapseAnnouncement{{$announcement->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingAnnouncementOne">
                                        <div class="panel-body">
                                            <p>{!! $announcement->description !!}</p>
                                            @foreach($projectDocuments as $projectDocument)
                                                @if ($projectDocument->section=="a" && $projectDocument->position==$announcement->id)
                                                    <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button hiddenAtPrint" target="_blank"><i class="material-icons">file_download</i>{{$projectDocument->old_name}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div><!-- end of panel -->
                            @endif
                        @endforeach
                    </div><!-- end of #accordion -->

                @else
                    <li>{{trans('messages.empty_record')}}</li>
                @endif
            </ul>
    @endif

    </div>


    @if ($project->isGalleryActive()  && count($projectGallery)>0)

        <div id="gallery">
            <div class="section-title-double section-title-left section-title-project container">
                <h2 id="parties">{{trans('project.section.gallery')}}</h2>
                <span></span>
            </div>
            <div id="links" class="project-gallery">

                @foreach($projectDocuments as $projectDocument)

                    @if ($projectDocument->section=="g")

                        <a href="{{route('application.media',['id'=>$projectDocument->id])}}" class="item"><img src="{{route('application.media',['id'=>$projectDocument->id])}}" class="img-responsive-gallery"/></a>

                    @endif

                @endforeach

            </div>

        </div><!--/carousel-gallery-->
    @endif
    <div class="overlay"></div>

    <div class="modal fade file-modal" tabindex="-1" role="dialog" aria-labelledby="" id="file-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="material-icons">file_download</i> {{trans('general.download_document')}}</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">{{trans("frontpage.generating_files1")}}</p>
                    <p class="text-center">{{trans("frontpage.generating_files2")}}</p>
                    <div class="progress">
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/blueimp-gallery.min.js') }}"></script>
    <script type="text/javascript">

        $(".party-item img").click(function () {
            $(this).parent().find('.modal').modal('show');
        });

        /**
         * Image Gallery
         * @param event
         */
        document.getElementById('links').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };

        $(document).ready(function() {
            $('.collapse.in').prev('.panel-heading').addClass('active');
            $('#accordion, #bs-collapse')
                .on('show.bs.collapse', function(a) {
                    $(a.target).prev('.panel-heading').addClass('active');
                })
                .on('hide.bs.collapse', function(a) {
                    $(a.target).prev('.panel-heading').removeClass('active');
                });
        });
    </script>

    <script type="text/javascript">


        $(document).ready(function() {

            //Carousel
            $('#myCarousel').carousel({
                interval: 10000
            })

        });


    </script>

    <script type="text/javascript">

        // Fix for project-menu on top

        $(window).bind('scroll', function() {

            projectmenuScrollTop();

        });

        function projectmenuScrollTop() {
            var navHeight = $("#navbar-main").outerHeight();
            var basicinfoHeight = $('#basic-info').outerHeight();
            var downloadpageHeight = $('#download-page').outerHeight();
            var projectHeight = navHeight + basicinfoHeight + downloadpageHeight;
            if ($(window).scrollTop() > projectHeight) {
                $('.project-menu').addClass('fixed');
            } else {
                $('.project-menu').removeClass('fixed');
            }
        };
    </script>

    <script type="text/javascript">
        // Subscribe to newsletter
        $('#newsletter-subscribe-button').click(function (event) {
            event.preventDefault();
            event.stopPropagation();

            if($('#frmSubscribe').valid()){
                var input_name = $('#frmSubscribe input[name=name]');
                var input_email = $('#frmSubscribe input[name=email]');
                $.ajax({
                    url: '{{ route('newsletter.subscribe') }}',
                    type: 'POST',
                    data: { name: input_name.val(), email: input_email.val(), _token: "{{ csrf_token() }}" },
                    beforeSend: function() {
                        $('.subscribeLoader').html("<img alt='Loading ...' src='/img/loader.gif'>");
                    },
                    success: function(data){
                        if (data.status) {
                            var success = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>You were successfully subscribed.</div>';
                            $('.subscribeState').removeClass('hidden').addClass('display');
                            $('.subscribeState').html(success);
                            $('#frmSubscribe').remove();
                        } else {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
                            $('.subscribeState').removeClass('hidden').addClass('display');
                            $('.subscribeState').html(errors);
                        }
                    },
                    error: function(data){
                        if (data.status === 422) {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><ul>';
                            $.each(data.responseJSON, function(index, value){
                                errors += "<li>" + value + "</li>";
                            });
                            errors += '</ul></div>';
                            $('.subscribeState').removeClass('hidden').addClass('display');
                            $('.subscribeState').html(errors);
                        } else {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>There was an internal error. Please try soon again.</div>';
                            $('.subscribeState').removeClass('hidden').addClass('display');
                            $('.subscribeState').html(errors);
                        }
                    },
                    complete: function() {
                        $('.subscribeLoader').html("");
                    }
                });
            }
        });

        var validatorContact = $('#frmContact').validate({
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'message': {
                    required: true
                },
            },

        });

        $('#frmOnlineRequest').validate({
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'document': {
                    required: true,
                },
                'description': {
                    required: true
                },
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#btnOnlineRequest').click(function (event) {
            event.preventDefault();
            event.stopPropagation();

            if($('#frmOnlineRequest').valid()){
                var input_name = $('#frmOnlineRequest input[name=name]');
                var input_email = $('#frmOnlineRequest input[name=email]');
                var input_document = $('#frmOnlineRequest select[name=document]');
                var input_description = $('#frmOnlineRequest textarea[name=description]');

                $.ajax({
                    url: '{{ route('onlineRequest.send') }}',
                    type: 'POST',
                    data: { name: input_name.val(), email: input_email.val(), document: input_document.val(), description: input_description.val(), _token: "{{ csrf_token() }}" },
                    beforeSend: function() {
                        $('.onlineRequestStateLoader').html("<img alt='Loading ...' src='/img/loader.gif'>");
                    },
                    success: function(data){
                        if (data.status) {
                            var success = '<div class="alert alert-success">Your request was successfully sent.</div>';
                            $('.onlineRequestState').removeClass('hidden').addClass('display');
                            $('.onlineRequestState').html(success);
                            $('#frmOnlineRequest').remove();
                        } else {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
                            $('.onlineRequestState').removeClass('hidden').addClass('display');
                            $('.onlineRequestState').html(errors);
                        }
                    },
                    error: function(data){
                        if (data.status === 422) {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><ul>';
                            $.each(data.responseJSON, function(index, value){
                                errors += "<li>" + value + "</li>";
                            });
                            errors += '</ul></div>';
                            $('.onlineRequestState').removeClass('hidden').addClass('display');
                            $('.onlineRequestState').html(errors);
                        } else {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>There was an internal error. Please try soon again.</div>';
                            $('.onlineRequestState').removeClass('hidden').addClass('display');
                            $('.onlineRequestState').html(errors);
                        }
                    },
                    complete: function() {
                        $('.onlineRequestStateLoader').html("");
                    }
                });
            }
        });

        $("#download-all").click(function () {

            $.ajax({
                url: '{{ route('project.all-files',['id'=>$project->id]) }}',
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function() {
                    $("#file-modal").modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $(".overlay").removeClass('opacity-full').addClass('opacity-full');

                },
                success: function(data){

                    var old_content = $("#file-modal").find('.modal-body').html();

                    $("#file-modal").find('.modal-body').html("<p class='text-center'>{{__('frontpage.generating_files3')}}</p>");

                    setTimeout(function () {
                        $("#file-modal").modal('hide');
                        $("#file-modal").find('.modal-body').html(old_content);

                        $(".overlay").removeClass('opacity-full');

                        document.location.href = "/projectfile/"+data.name;

                    },3000);

                },
                error: function(data){
                    console.log("Error",data);
                }
            })
        })

    </script>

@endsection
