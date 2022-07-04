
    <div id="basic-info" class="hidden-xs hidden-sm hidden-md" style="background: url(/img/accra-port.jpg);">
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
                        <h2>{{trans('general.region')}}</h2>
                        @if($project->projectInformation && $project->projectInformation)
                            <p>@foreach($project->projectInformation->regions as $region) {{$region->name}} @if(!$loop->last), @endif @endforeach</p>
                        @endif
                    </div>
                </div>
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('project/project-information.project_value')}}</h2>
                        <p>{{$project->projectInformation->project_value_usd}} US$ (million)
                            @if($project->projectInformation->project_value_second != "" || $project->projectInformation->project_value_second != null)
                                - {{$project->projectInformation->project_value_second}} GH₵ (million)
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.stage')}}</h2>
                        <p>{{$project->projectInformation->stage->name}}</p>
                    </div>
                </div>
                <div class="basic-info-box col-md-4">
                    <div class="inner">
                        <h2>{{trans('general.sponsor-agency')}}</h2>
                        <p>{{$project->sponsor->first()->name}}</p>
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

    <div id="project-m" class="visible-md-block visible-sm-block visible-xs-block">
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
                {{$project->projectInformation->project_value_usd}} {{trans('project/project-information.usd')}}
                @if($project->projectInformation->project_value_second != "" || $project->projectInformation->project_value_second != null)
                    - {{$project->projectInformation->project_value_second}} {{trans('project/project-information.ghs')}}
                @endif
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.stage')}}</h2>
                <p>{{$project->projectInformation->stage->name}}</p>
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.sponsor-agency')}}</h2>
                <p>{{$project->sponsor->first()->name}}</p>
            </div>
            <div class="col-md-4 col-xs-6">
                <h2>{{trans('general.last_update')}}</h2>
                <p>{{$project->updated_at->format('d-m-Y H:i:s')}}</p>
            </div>
        </div>
    </div>

    <div class="container content-project">

        <div id="download-page">
            <!--<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect print"><a href="#" target="_blank"><i class="material-icons">local_printshop</i>{{trans('general.download_page_pdf')}}</a></button>-->
            @if (count($projectDocuments)>0)
            <a href="{{route('project.all-files',['id'=>$project->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect print" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_page_documents')}}</a>
            @endif
        </div>

        <div class="project-menu">
            <ul>
                @if ($project->project_information_active)
                    <li><a href="#project-info" class="soft-scroll">{{trans("project.section.project_basic_information")}}</a></li>
                @endif
                @if ($project->contract_milestones_active)
                    <li><a href="#contract-milestones" class="soft-scroll">{{trans("project.section.contract_milestones")}}</a></li>
                @endif
                @if ($project->parties_active)
                    <li><a href="#parties" class="soft-scroll">{{trans("project.section.parties")}}</a></li>
                @endif
                @if ($project->project_details_active)
                    <li><a href="#project-details" class="soft-scroll">{{trans("project.section.project_details_title")}}</a></li>
                @endif
                @if ($project->performance_information_active)
                    <li><a href="#performance-information" class="soft-scroll">{{trans("project.section.performance_information_title")}}</a></li>
                @endif
                <li><a href="#requests-documents" class="soft-scroll">Request documents</a></li>
                @if ($project->gallery_active && count($projectGallery)>0)
                    <li><a href="#gallery" class="soft-scroll">{{trans("project.section.gallery")}}</a></li>
                @endif
            </ul>
        </div>

        <div class="row">
            @if ($project->project_information_active)

                <div class="col-lg-8 col-md-8">
                    <div id="project-info" class="project-info"> <!-- project-info -->
                        <h2>{{trans("project.section.project_basic_information")}}</h2>
                        @if ($project->projectInformation)
                            <ul>
                                @if($project->projectInformation->description)
                                <li>
                                    <h3>{{trans('project/project-information.description')}}</h3>
                                        <p>{{$project->projectInformation->description}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==10)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                </li>
                                @endif
                                @if($project->projectInformation->project_description)
                                <li>
                                    <h3>{{trans('project/project-information.project-description')}}</h3>
                                        <p>{{$project->projectInformation->project_description}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==1)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                </li>
                                @endif
                                @if($project->projectInformation->project_need)
                                <li>
                                    <h3>{{trans('project/project-information.project-need')}}</h3>
                                        <p>{{$project->projectInformation->project_need}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==2)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                </li>
                                @endif
                                @if($project->projectInformation->description_services)
                                <li>
                                    <h3>{{trans('project/project-information.description-services')}}</h3>
                                        <p>{{$project->projectInformation->description_services}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==3)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                </li>
                                @endif
                                @if($project->projectInformation->reasons_ppp)
                                    <li>
                                        <h3>{{trans('project/project-information.reasons-ppp')}}</h3>
                                        <p>{{$project->projectInformation->reasons_ppp}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==4)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($project->projectInformation->technical_description)
                                    <li>
                                        <h3>{{trans('project/project-information.technical-description')}}</h3>
                                        <p>{{$project->projectInformation->technical_description}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==5)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($project->projectInformation->estimated_demand)
                                    <li>
                                        <h3>{{trans('project/project-information.estimated-demand')}}</h3>
                                        <p>{{$project->projectInformation->estimated_demand}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==6)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($project->projectInformation->stakeholder_consultation)
                                    <li>
                                        <h3>{{trans('project/project-information.stakeholder-consultation')}}</h3>
                                        <p>{{$project->projectInformation->stakeholder_consultation}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==7)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($project->projectInformation->others_models_analyzed)
                                    <li>
                                        <h3>{{trans('project/project-information.other-models')}}</h3>
                                        <p>{{$project->projectInformation->others_models_analyzed}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==8)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($project->projectInformation->project_additionality)
                                    <li>
                                        <h3>{{trans('project/project-information.project-additionality')}}</h3>
                                        <p>{{$project->projectInformation->project_additionality}}</p>
                                        @foreach($projectDocuments as $projectDocument)
                                            @if ($projectDocument->section=="i" && $projectDocument->position==9)
                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                            </ul>
                        @else
                            <p>{{trans('messages.empty_record')}}</p>
                        @endif
                    </div> <!-- /project-info -->
                </div>
            @endif

            <div class="col-lg-4 col-md-4"><!-- right-sidebar -->

                @if ($project->contract_milestones_active)

                    <div id="contract-milestones" class="milestones">
                        <h2>{{trans("project.section.contract_milestones")}}</h2>
                        @if(count($project->contractMilestones) == 0)
                            <p>{{trans('messages.empty_record')}}</p>
                        @endif
                        <div class="timeline-centered">
                            @foreach($project->contractMilestones as $contractMilestone)
                                <article class="timeline-entry">
                                    <div class="timeline-entry-inner">
                                        <div class="timeline-icon">
                                            <p class="year">{{$contractMilestone->date->format('Y')}}</p>
                                        </div>
                                        <div class="timeline-label">
                                            <div class="timeline-title">
                                                <h3>{{$contractMilestone->name}}</h3>
                                                <p>{{$contractMilestone->date->format('j F')}}</p>
                                            </div>
                                            <div class="timeline-separate"></div>
                                            <p>{{$contractMilestone->description}}</p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div> <!-- milestones -->

                @endif

                <div class="newsletter"> <!-- newsletter -->
                    <h2>Get our updates</h2>
                    <p>Subscribe to our newsletter to receive the latest information in your inbox.</p>
                    <div class="subscribeState hidden"></div>
                    <form id="frmSubscribe">
                        <div class="mdl-textfield mdl-js-textfield" id="newsletter_name_div">
                            <input class="mdl-textfield__input" name="name" type="text" id="newsletter-subscribe-name">
                            <label class="mdl-textfield__label" for="field1">Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input" name="email" type="text" id="newsletter-subscribe-mail">
                            <label class="mdl-textfield__label" for="field2">E-mail</label>
                        </div>
                        <div id="newsletter_subscribe_div">
                            <button id="newsletter-subscribe-button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Subscribe</button>
                        </div>
                    </form>
                    <div class="subscribeLoader align-center"></div>
                </div> <!-- /newsletter -->
            </div> <!-- /right-sidebar -->
        </div>



    </div><!-- /container -->
    @if ($project->parties_active)

        @if (count($project->parties) > 0)
            <div id="parties" class="parties">
                <h2 class="container">{{trans('project.section.parties')}}</h2>
                <div class="carousel-parties">
                    <ul>
                        @foreach($project->parties as $party)
                            <li class="logo" data-id="{{ $party->id }}"><a href="#"><img src="{{ route('uploader.par', array('position' => $party->id)) }}" alt="logo"></a></li>
                        @endforeach
                    </ul>
                    @foreach($project->parties as $party)
                        <div class="party party-{{$party->id}}">
                            <div class="logo-party"><a href="#"><img src="{{ route('uploader.par', array('position' => $party->id)) }}" alt="Logo"></a></div>
                            <div class="party-information">
                                <p>{{ $party->description }}</p>
                                <ul>
                                    <li>
                                        <a href="{{ $party->url }}" class="icon-button" target="_blank">
                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $party->facebook }}" class="icon-button" target="_blank">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $party->twitter }}" class="icon-button" target="_blank">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $party->instagram }}" class="icon-button" target="_blank">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="close-party"><i class="material-icons">highlight_off</i></div>
                            </div>
                        </div><!-- party -->
                    @endforeach
                </div>
            </div><!-- /parties -->
        @else
            <div class="container content-project">
                <div>
                    <h2>{{trans('project.section.parties')}}</h2>
                    <p>{{trans('messages.empty_record')}}</p>
                </div>
            </div>
        @endif
    @endif

    <div class="container content-project"> <!-- content-project -->

        @if ($project->project_details_active && ($project->projectDetails->contract_termination_active || $project->projectDetails->renegotiations_active ||
        $project->projectDetails->evaluation_ppp_active || $project->projectDetails->risks_active || $project->projectDetails->financial_active || $project->projectDetails->tariffs_active ||
        $project->projectDetails->documents_active || $project->projectDetails->announcements_active || $project->projectDetails->procurement_active || $project->projectDetails->government_support_active
        ))

            <div id="project-details" class="project-details"><!-- project-details -->
                <h2>{{__("project.section.project_details_title")}}</h2>
                @if ($project->projectDetails->documents_active || $project->projectDetails->announcements_active || $project->projectDetails->procurement_active || $project->projectDetails->government_support_active)
                    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table1 -->
                        <div class="mdl-tabs__tab-bar">
                            @if ($project->projectDetails->announcements_active)
                                <a href="#announcements-panel" class="mdl-tabs__tab is-active col-lg-3 col-md-3">{{__("project.section.project_details.announcements")}}</a>
                            @endif
                            @if ($project->projectDetails->documents_active)
                                <a href="#project-documents-panel" class="mdl-tabs__tab @if (!$project->projectDetails->announcements_active) is-active @endif  col-lg-3 col-md-3">{{__("project.section.project_details.documents")}}</a>
                            @endif
                            @if ($project->projectDetails->procurement_active)
                                <a href="#procurement-information-panel" class="mdl-tabs__tab @if (!$project->projectDetails->announcements_active && !$project->projectDetails->documents_active) is-active @endif col-lg-3 col-md-3">{{__("project.section.project_details.procurement")}}</a>
                            @endif
                            @if ($project->projectDetails->government_support_active)
                                <a href="#government-support-panel" class="mdl-tabs__tab @if (!$project->projectDetails->announcements_active && !$project->projectDetails->documents_active && !$project->projectDetails->procurement_active) is-active @endif col-lg-3 col-md-3">{{__("project.section.project_details.government-support")}}</a>
                            @endif
                        </div>
                        @if ($project->projectDetails->announcements_active)
                            <div class="mdl-tabs__panel is-active" id="announcements-panel">
                                <ul>
                                    @if(count($project->projectDetails->announcements) > 0)
                                        @foreach($project->projectDetails->announcements as $announcement)
                                            <li>
                                                <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel">
                                                        <div class="panel-heading" role="tab" id="headingAnnOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAnn{{$announcement->id}}" aria-expanded="true" aria-controls="collapseAnn{{$announcement->id}}">{{$announcement->name}}</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseAnn{{$announcement->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingAnnOne">
                                                            <div class="panel-body">
                                                                <p>{{$announcement->description}}</p>
                                                                @foreach($projectDocuments as $projectDocument)
                                                                    @if ($projectDocument->section=="a" && $projectDocument->position==$announcement->id)
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                </div><!-- end of #accordion -->
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{trans('messages.empty_record')}}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                        @if ($project->projectDetails->documents_active)
                            <div class="mdl-tabs__panel @if (!$project->projectDetails->announcements_active) is-active @endif" id="project-documents-panel">
                                <ul>
                                    @if(count($project->projectDetails->documents) > 0)
                                        @foreach($project->projectDetails->documents as $document)
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
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                </div><!-- end of #accordion -->
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{trans('messages.empty_record')}}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                        @if ($project->projectDetails->procurement_active)
                            <div class="mdl-tabs__panel @if (!$project->projectDetails->announcements_active && !$project->projectDetails->documents_active) is-active @endif" id="procurement-information-panel">
                                <ul>
                                    @if(count($project->projectDetails->procurements) > 0)
                                        @foreach($project->projectDetails->procurements as $procurement)
                                            <li>
                                                <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel">
                                                        <div class="panel-heading" role="tab" id="headingPIOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePI{{$procurement->id}}" aria-expanded="true" aria-controls="collapsePI{{$procurement->id}}">{{$procurement->name}}</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapsePI{{$procurement->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingPIOne">
                                                            <div class="panel-body">
                                                                <p>{{$procurement->description}}</p>
                                                                @foreach($projectDocuments as $projectDocument)
                                                                    @if ($projectDocument->section=="pri" && $projectDocument->position==$procurement->id)
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                </div><!-- end of #accordion -->
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{trans('messages.empty_record')}}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                        @if ($project->projectDetails->government_support_active)
                            <div class="mdl-tabs__panel @if (!$project->projectDetails->announcements_active && !$project->projectDetails->documents_active && !$project->projectDetails->procurement_active) is-active @endif" id="government-support-panel">
                                @if(count($project->projectDetails->governmentSupports) > 0)
                                    <div class="table-responsive">
                                        <table class="table-type1">
                                            @foreach($project->projectDetails->governmentSupports as $governmentSupport)
                                                <tr>
                                                    <td>{{$governmentSupport->name}}</td>
                                                    <td>
                                                        <p>{{$governmentSupport->description}}</p>
                                                        @foreach($projectDocuments as $projectDocument)
                                                            @if ($projectDocument->section=="gs" && $projectDocument->position==$governmentSupport->id)
                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    {{trans('messages.empty_record')}}
                                @endif
                            </div><!-- /#government-support-panel -->
                        @endif
                    </div><!-- /table1 -->
                @endif

                @if ($project->projectDetails->evaluation_ppp_active || $project->projectDetails->risks_active || $project->projectDetails->financial_active || $project->projectDetails->tariffs_active)
                    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table2 -->
                        <div class="mdl-tabs__tab-bar">
                            @if ($project->projectDetails->evaluation_ppp_active)
                                <a href="#evaluation-of-PPP-panel" class="mdl-tabs__tab is-active col-lg-3 col-md-3">{{__("project.section.project_details.evaluation-ppp")}}</a>
                            @endif
                            @if ($project->projectDetails->risks_active)
                                <a href="#risks-panel" class="mdl-tabs__tab @if (!$project->projectDetails->evaluation_ppp_active) is-active @endif col-lg-3 col-md-3">{{__("project.section.project_details.risks")}}</a>
                            @endif
                            @if ($project->projectDetails->financial_active)
                                <a href="#financial-information-panel" class="mdl-tabs__tab @if (!$project->projectDetails->evaluation_ppp_active && !$project->projectDetails->risks_active) is-active @endif col-lg-3 col-md-3">{{__("project.section.project_details.financial")}}</a>
                            @endif
                            @if ($project->projectDetails->tariffs_active)
                                <a href="#tariffs-panel" class="mdl-tabs__tab @if (!$project->projectDetails->evaluation_ppp_active && !$project->projectDetails->risks_active && !$project->projectDetails->financial_active) is-active @endif col-lg-3 col-md-3">{{__("project.section.project_details.tariffs")}}</a>
                            @endif
                        </div>
                        @if ($project->projectDetails->evaluation_ppp_active)

                            <div class="mdl-tabs__panel is-active" id="evaluation-of-PPP-panel"><!--evaluation of PPP -->
                                <ul>

                                    @if(count($project->projectDetails->evaluationsPPP) > 0)
                                        @foreach($project->projectDetails->evaluationsPPP as $evaluation)
                                            <li>
                                                <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel">
                                                        <div class="panel-heading" role="tab" id="headingevOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseev{{$evaluation->id}}" aria-expanded="true" aria-controls="collapseev{{$evaluation->id}}">{{$evaluation->name}}</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseev{{$evaluation->id}}" class="panel-collapse collapse @if($loop->first) in @endif" role="tabpanel" aria-labelledby="headingevOne">
                                                            <div class="panel-body">
                                                                <div>{{$evaluation->description}}</div>
                                                                @foreach($projectDocuments as $projectDocument)
                                                                    @if ($projectDocument->section=="e" && $projectDocument->position==$evaluation->id)
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                </div><!-- end of #accordion -->
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{trans('messages.empty_record')}}</li>
                                    @endif
                                </ul>
                            </div> <!-- evaluation of PPP -->
                        @endif
                        @if ($project->projectDetails->risks_active)

                            <div class="mdl-tabs__panel @if (!$project->projectDetails->evaluation_ppp_active) is-active @endif" id="risks-panel">
                                @if(count($project->projectDetails->risks) > 0)
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
                                            @foreach($project->projectDetails->risks as $risk)
                                                <tr>
                                                    <td>{{$risk->name}}</td>
                                                    <td>{{$risk->description}}</td>
                                                    <td>{{$risk->allocation->name}}</td>
                                                    <td>{{$risk->mitigation}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @foreach($projectDocuments as $projectDocument)
                                        @if ($projectDocument->section=="ri" && $projectDocument->position==1)
                                            <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                        @endif
                                    @endforeach
                                @else
                                    {{trans('messages.empty_record')}}
                                @endif

                            </div><!-- /#risks-panel -->
                        @endif

                        @if ($project->projectDetails->financial_active)

                            <div class="mdl-tabs__panel @if (!$project->projectDetails->evaluation_ppp_active && !$project->projectDetails->risks_active) is-active @endif" id="financial-information-panel">
                                <ul>
                                    @if(count($project->projectDetails->financials) > 0)
                                        @foreach($project->projectDetails->financials as $financial)
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
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                </div><!-- end of #accordion -->
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{trans('messages.empty_record')}}</li>
                                    @endif
                                </ul>
                            </div><!-- /#financial-information-panel -->
                        @endif

                        @if ($project->projectDetails->tariffs_active)

                            <div class="mdl-tabs__panel @if (!$project->projectDetails->evaluation_ppp_active && !$project->projectDetails->risks_active && !$project->projectDetails->financial_active) is-active @endif" id="tariffs-panel">
                                <ul>
                                    @if(count($project->projectDetails->tariffs) > 0)
                                        @foreach($project->projectDetails->tariffs as $tariff)
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
                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><!-- end of panel -->
                                                </div><!-- end of #accordion -->
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{trans('messages.empty_record')}}</li>
                                    @endif
                                </ul>
                            </div><!-- /#tariffs-panel -->
                        @endif
                    </div><!-- /table2-->
                @endif

                @if ($project->projectDetails->contract_termination_active || $project->projectDetails->renegotiations_active)
                    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table3 -->
                        <div class="mdl-tabs__tab-bar">
                            @if ($project->projectDetails->contract_termination_active)
                                <a href="#contract-termination-panel" class="mdl-tabs__tab is-active col-lg-3 col-md-3">Terminal Provisions</a>
                            @endif
                            @if ($project->projectDetails->renegotiations_active)
                                <a href="#renegotiations-panel" class="mdl-tabs__tab @if (!$project->projectDetails->contract_termination_active) is-active @endif col-lg-3 col-md-3">Renegotiations</a>
                            @endif
                        </div>
                        @if ($project->projectDetails->contract_termination_active)

                            <div class="mdl-tabs__panel is-active" id="contract-termination-panel"><!-- Terminal Provisions -->
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
                                                        @if($project->projectDetails->contractTerminations && count($project->projectDetails->contractTerminations->where('party_type', 'operator')) > 0)
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
                                                                        <tr>
                                                                            <td>{{$contract->name}}</td>
                                                                            <td>{{$contract->description}}</td>
                                                                            <td>{{$contract->termination_payment}}</td>
                                                                            <td nowrap>
                                                                                @foreach($projectDocuments as $projectDocument)
                                                                                    @if ($projectDocument->section=="ct" && $projectDocument->position==$contract->id)
                                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                        </tr>
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
                                                        @if($project->projectDetails->contractTerminations && count($project->projectDetails->contractTerminations->where('party_type', 'authority')) > 0)
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
                                                                        <tr>
                                                                            <td>{{$contract->name}}</td>
                                                                            <td>{{$contract->description}}</td>
                                                                            <td>{{$contract->termination_payment}}</td>
                                                                            <td nowrap>
                                                                                @foreach($projectDocuments as $projectDocument)
                                                                                    @if ($projectDocument->section=="ct" && $projectDocument->position==$contract->id)
                                                                                        <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                        </tr>
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
                        @if ($project->projectDetails->renegotiations_active)

                            <div class="mdl-tabs__panel @if (!$project->projectDetails->contract_termination_active) is-active @endif" id="renegotiations-panel">
                                @if(count($project->projectDetails->renegotiations) > 0)
                                    <table class="table-type1">
                                        @foreach($project->projectDetails->renegotiations as $renegotiation)
                                            <tr>
                                                <td>{{$renegotiation->name}}</td>
                                                <td>
                                                    <p>{{$renegotiation->description}}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    @foreach($projectDocuments as $projectDocument)
                                        @if ($projectDocument->section=="r" && $projectDocument->position==1)
                                            <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                        @endif
                                    @endforeach
                                @else
                                    <p>{{trans('messages.empty_record')}}</p>
                                @endif

                            </div><!-- /#renegotiations-panel -->
                        @endif
                    </div><!-- /table3-->
                @endif
            </div><!-- /project-details -->

        @endif

        @if ($project->performance_information_active && ($project->performanceInformation->annual_demmand_active || $project->performanceInformation->income_statements_active || $project->performanceInformation->timeless_financial_active || $project->performanceInformation->annual_financial_active || $project->performanceInformation->key_performance_active || $project->performanceInformation->performance_failures_active || $project->performanceInformation->performance_assessment_active))

            <div id="performance-information" class="performance-information"><!-- performance-information -->
                <h2>Performance information</h2>
                <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table1 -->
                    <div class="mdl-tabs__tab-bar">
                        @if ($project->performanceInformation->annual_demmand_active)
                        <a href="#annual-demand-panel" class="mdl-tabs__tab is-active col-lg-4 col-md-4">Annual demand levels</a>
                        @endif
                            @if ($project->performanceInformation->income_statements_active)

                            <a href="#statements-metrics-panel" class="mdl-tabs__tab @if (!$project->performanceInformation->annual_demmand_active) is-active @endif col-lg-4 col-md-4">Income statements metrics</a>
                            @endif
                            @if ($project->performanceInformation->timeless_financial_active || $project->performanceInformation->annual_financial_active)

                            <a href="#other-financial-panel" class="mdl-tabs__tab @if (!$project->performanceInformation->annual_demmand_active && !$project->performanceInformation->income_statements_active) is-active @endif col-lg-4 col-md-4">Other financial metrics</a>
                                @endif
                    </div>
                    @if ($project->performanceInformation->annual_demmand_active)

                    <div class="mdl-tabs__panel is-active" id="annual-demand-panel">
                        @if(count($tables["annual_demmands"]) > 0)
                            <div class="private-information"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button">Private information</button></div>
                            @foreach($tables["annual_demmands"] as $table)
                                <p @if(! $loop->first) class="m-t-20" @endif>{{$table["type"]}} ({{$table["unit"]}})</p>
                                @foreach($table["records"] as $record)
                                    <table class="table-type1 @if(! $loop->first) m-t-10 @endif">
                                        <tr>
                                            <td>{{trans('general.year')}}</td>
                                            @foreach($record as $cell)
                                                <td>{{$cell["year"]}}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>Annual demand</td>
                                            @foreach($record as $cell)
                                                <td>{{$cell["value"]}} </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                @endforeach
                            @endforeach
                        @else
                            <p>{{trans('messages.empty_record')}}</p>
                        @endif
                    </div><!-- /#annual-demand-panels -->
                    @endif
                    @if ($project->performanceInformation->income_statements_active)

                    <div class="mdl-tabs__panel @if (!$project->performanceInformation->annual_demmand_active) is-active @endif" id="statements-metrics-panel">
                        @if(count($tables["income_metrics"]) > 0)
                            @foreach($tables["income_metrics"] as $table)
                                <p @if(! $loop->first) class="m-t-20" @endif>{{$table["type"]}} ({{$table["currency"]}})</p>
                                @foreach($table["records"] as $record)
                                    <table class="table-type1 @if(! $loop->first) m-t-10 @endif">
                                        <tr>
                                            <td>{{trans('general.year')}}</td>
                                            @foreach($record as $cell)
                                                <td>{{$cell["year"]}}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>Income metric</td>
                                            @foreach($record as $cell)
                                                <td>{{$cell["value"]}} </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                @endforeach
                            @endforeach
                        @else
                            <p>{{trans('messages.empty_record')}}</p>
                        @endif
                    </div><!-- /#statementes-metrics-panel -->
                    @endif

                    @if ($project->performanceInformation->timeless_financial_active || $project->performanceInformation->annual_financial_active)

                    <div class="mdl-tabs__panel @if (!$project->performanceInformation->annual_demmand_active && !$project->performanceInformation->income_statements_active) is-active @endif" id="other-financial-panel">
                        <ul>
                            @if ($project->performanceInformation->timeless_financial_active)
                            <li>
                                <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel">
                                        <div class="panel-heading" role="tab" id="headingofOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseofOne" aria-expanded="true" aria-controls="collapseofOne">{{trans('project/performance-information/other_financial_metrics.timeless_title')}}</a>
                                            </h4>
                                        </div>
                                        <div id="collapseofOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingofOne">
                                            <div class="panel-body">
                                                @if($project->performanceInformation->otherFinancialMetricTimelessMain && count($project->performanceInformation->otherFinancialMetricTimelessMain->metricsTimeless) > 0)
                                                    @foreach(array_chunk($project->performanceInformation->otherFinancialMetricTimelessMain->metricsTimeless->toArray(), 5) as $metrics)
                                                        <table class="table-type2">
                                                            <thead>
                                                            <tr>
                                                                @foreach($metrics as $metric)
                                                                    <th>{{$metric["type"]["name"]}}</th>
                                                                @endforeach

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                @foreach($metrics as $metric)
                                                                    <td class="text-center">{{$metric["value"]}}</td>
                                                                @endforeach
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    @endforeach
                                                @else
                                                    <p>{{trans('messages.empty_record')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- end of panel -->
                                </div><!-- end of #accordion -->
                            </li>
                            @endif
                                @if ($project->performanceInformation->annual_financial_active)
                                <li>
                                <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel">
                                        <div class="panel-heading @if (!$project->performanceInformation->timeless_financial_active) active @endif" role="tab" id="headingofTwo">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseofTwo" aria-expanded="false" aria-controls="collapseofTwo">{{trans('project/performance-information/other_financial_metrics.annual_title')}}</a>
                                            </h4>
                                        </div>
                                        <div id="collapseofTwo" class="panel-collapse collapse @if (!$project->performanceInformation->timeless_financial_active) in @endif " role="tabpanel" aria-labelledby="headingofTwo">
                                            <div class="panel-body">
                                                @if(count($tables["other_financial_metrics_annual"]) > 0)
                                                    @foreach($tables["other_financial_metrics_annual"] as $table)
                                                        <p @if(! $loop->first) class="m-t-20" @endif>{{$table["type"]}} ({{$table["unit"]}})</p>
                                                        @foreach($table["records"] as $record)
                                                            <table class="table-type1 @if(! $loop->first) m-t-10 @endif">
                                                                <tr>
                                                                    <td>{{trans('general.year')}}</td>
                                                                    @foreach($record as $cell)
                                                                        <td>{{$cell["year"]}}</td>
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Income metric</td>
                                                                    @foreach($record as $cell)
                                                                        <td >{{$cell["value"]}} </td>
                                                                    @endforeach
                                                                </tr>
                                                            </table>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    <p>{{trans('messages.empty_record')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- end of panel -->
                                </div><!-- end of #accordion -->
                            </li>
                                    @endif
                        </ul>
                    </div><!-- /#other-financial-panel -->
                        @endif
                </div><!-- /table1 -->

                @if ($project->performanceInformation->key_performance_active || $project->performanceInformation->performance_failures_active || $project->performanceInformation->performance_assessment_active)
                <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect"><!-- table2 -->
                    <div class="mdl-tabs__tab-bar">
                        @if ($project->performanceInformation->key_performance_active)
                            <a href="#KPI-panel" class="mdl-tabs__tab is-active col-lg-4 col-md-4">{{trans("project.section.performance_information.key_performance_indicators")}}</a>
                        @endif
                            @if ($project->performanceInformation->performance_failures_active)
                        <a href="#failures-panel" class="mdl-tabs__tab @if (!$project->performanceInformation->key_performance_active) is-active @endif col-lg-4 col-md-4">{{trans("project.section.performance_information.performance_failures")}}</a>
                            @endif
                            @if ($project->performanceInformation->performance_assessment_active)
                            <a href="#assessments-panel" class="mdl-tabs__tab @if (!$project->performanceInformation->key_performance_active && !$project->performanceInformation->performance_failures_active) is-active @endif col-lg-4 col-md-4">{{trans("project.section.performance_information.performance-assessments")}}</a>
                                @endif
                    </div>
                    @if ($project->performanceInformation->key_performance_active)
                    <div class="mdl-tabs__panel is-active" id="KPI-panel"><!--KPI -->
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
                    @if ($project->performanceInformation->performance_failures_active)

                    <div class="mdl-tabs__panel @if (!$project->performanceInformation->key_performance_active) is-active @endif" id="failures-panel">
                        @if(count($project->performanceInformation->performanceFailures) > 0)

                            @foreach(array_chunk($project->performanceInformation->performanceFailures->toArray(), 2) as $performanceFailures)

                                <table class="table-type3 @if(! $loop->first) m-t-10 @endif">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        @foreach($performanceFailures as $performanceFailure)
                                            <th>{{$performanceFailure["title"]}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{trans('project/performance-information/performance_failures.category')}}</td>
                                        @foreach($performanceFailures as $performanceFailure)
                                            <td>{{$performanceFailure["category"]["name"]}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>{{trans('project/performance-information/performance_failures.number_events')}}</td>
                                        @foreach($performanceFailures as $performanceFailure)
                                            <td>{{$performanceFailure["number_events"]}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>{{trans('project/performance-information/performance_failures.penalty_abatement_contract')}}</td>
                                        @foreach($performanceFailures as $performanceFailure)
                                            <td>{{$performanceFailure["penalty_contract"]}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>{{trans('project/performance-information/performance_failures.penalty_abatement_imposed')}}</td>
                                        @foreach($performanceFailures as $performanceFailure)
                                            <td>{{$performanceFailure["penalty_imposed"]}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>{{trans('project/performance-information/performance_failures.penalty_abatement_yes_no_table')}}</td>
                                        @foreach($performanceFailures as $performanceFailure)
                                            <td>
                                                @if($performanceFailure["penalty_paid"] == 1)
                                                    {{trans('project/performance-information/performance_failures.yes')}}
                                                @else
                                                    {{trans('project/performance-information/performance_failures.no')}}
                                                @endif
                                            </td>
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
                    @if ($project->performanceInformation->performance_assessment_active)
                        <div class="mdl-tabs__panel @if (!$project->performanceInformation->key_performance_active && !$project->performanceInformation->performance_failures_active) is-active @endif" id="assessments-panel">
                        <ul>
                            @if(count($project->performanceInformation->perfromanceAssessments) > 0)
                                @foreach($project->performanceInformation->perfromanceAssessments as $perfromanceAssessment)
                                    <li>
                                        <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingassOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseass{{$perfromanceAssessment->id}}" aria-expanded="true" aria-controls="collapseass{{$perfromanceAssessment->id}}">{{$perfromanceAssessment->name}}</a>
                                                    </h4>
                                                </div>
                                                <div id="collapseass{{$perfromanceAssessment->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingassOne">
                                                    <div class="panel-body">
                                                        <p>{{$perfromanceAssessment->description}}</p>
                                                        @foreach($projectDocuments as $projectDocument)
                                                            @if ($projectDocument->section=="pa" && $projectDocument->position==$perfromanceAssessment->id)
                                                                <a href="{{route('application.media',["id"=>$projectDocument->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div><!-- end of panel -->
                                        </div><!-- end of #accordion -->
                                    </li>
                                @endforeach
                            @else
                                <li>{{trans('messages.empty_record')}}</li>
                            @endif
                        </ul>
                    </div><!-- /#assessments-panel -->
                        @endif
                </div><!-- /table2-->
                    @endif

            </div><!-- /performance-information -->


        @endif

    </div> <!-- /main-content -->

    @if ($project->gallery_active)

        <div id="gallery">

            <div class="project-gallery">

            @foreach($projectDocuments as $projectDocument)

                @if ($projectDocument->section=="g")

                    <div class="item"><img src="{{route('application.media',['id'=>$projectDocument->id])}}" class="img-responsive"/></div>

                    @endif

                @endforeach

            </div>

        </div><!--/carousel-gallery-->

    @endif
