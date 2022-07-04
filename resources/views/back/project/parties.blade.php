@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">

        @component('components.project-menu', ["project" => $project,"project_name"=> $project->name,"updated_at" => $project->updated_at])
        @endcomponent

            @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
                <div class="section-information">
                <a href="{{ route('documentation').'#parties' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
            </div>
            @endif

        @component('back.components.enable-section', ["section" => trans('project.section.parties'),"visible" => $project->parties_active])
        @endcomponent

        @if (!Auth::user()->isViewOnly())
            <div class="row content-row">
                <div class="col-md-12">

                    <div class="card card-shadow m-b-0">
                        <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                            <h2><i class="material-icons">add_box</i> <span>{{__("project/party.add_party")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                        </div>
                        <div id="card-body" class="body @if (count($errors) > 0 || (isset($flag))) is-visible @else not-visible @endif">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty($flag))
                                <div class="alert alert-danger">
                                    Message: {{$flag["message"]}}
                                </div>
                            @endif

                            <form action="parties/update" method="POST" class="party-form">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="{{__('project/party.party') }}">{{ __('project/party.name') }}</label>
                                    <select name="party"  class="form-control party-select col-md-8 m-l-20">
                                        @if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())
                                            <option value="new-party">{{__('project/party.new_party')}}...</option>
                                        @endif
                                        @foreach($entities as $entity)
                                            <option value="{{$entity->id}}">{{ $entity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <button type="submit" class="btn btn-large btn-primary waves-effect btn-draft">{{__("project/party.add_party")}}</button> --}}
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'party' ],
                                    'position'=>0,
                                    'section'=>'par',
                                    'project'=>$project->id,
                                    'hasCoordinators'=>$hasCoordinators
                                ])
                                @endcomponent
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        @if(count($project->projectInformation->sponsor) > 0)
            <h2 class="content-title-project">
                {{__('general.sponsor-agency')}}
            </h2>
            <div class="row content-row toggleable-wrapper">
                @if($project->projectInformation->sponsor)

                    <div class="col-md-12">
                        <div class="card dynamic-card toggleable-container">
                            <div class="header card-header-static toggleable-card">
                                <h2><span>{{ $project->projectInformation->sponsor->name }}</span></h2>
                            </div>
                            <div class="body not-visible" data-status="0">

                                <div class="flex">

                                    <div class="item-1-5 vertical-align">

                                        <img src="{{route('uploader.par', array('position' => $project->projectInformation->sponsor))}}" class="img-responsive card-entity-logo"/>

                                    </div>

                                    <div class="item-4-5 vertical-align">
                                        <b>{{__("entity.description")}}</b>
                                        <p>{{ $project->projectInformation->sponsor->description }}</p>
                                        <div class="social-media-icons">
                                            @if ($project->projectInformation->sponsor->email)
                                                <a href="mailto:{{ $project->projectInformation->sponsor->email }}" class="btn mail-icon btn-circle waves-effect waves-circle waves-float">
                                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if ($project->projectInformation->sponsor->facebook)
                                                <a href="{{ $project->projectInformation->sponsor->facebook }}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float">
                                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            @if ($project->projectInformation->sponsor->twitter)
                                                <a href="{{ $project->projectInformation->sponsor->twitter }}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float">
                                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                                </a>

                                            @endif
                                            @if ($project->projectInformation->sponsor->instagram)
                                                <a href="{{ $project->projectInformation->sponsor->instagram }}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float">
                                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        @endif

        

            @if(count($parties) > 0)

                <h2 class="content-title-project">{{__('project/party.parties')}}</h2>

                <div class="row content-row toggleable-wrapper">
                    @foreach($parties as $party)

                        <div class="col-md-12">
                            <div class="card dynamic-card toggleable-container">
                                <div class="header card-header-static toggleable-card">
                                    <h2><span>{{ $party->name }}</span> <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-project="{{$project->id}}" data-party="{{$party->id}}"></i>
                                    </h2>
                                </div>
                                <div class="body not-visible" data-status="0">

                                    <div class="flex">

                                        <div class="item-1-5 vertical-align">
                                            <img src="{{route('uploader.par', array('position' => $party->id))}}" class="img-responsive card-entity-logo"/>
                                        </div>

                                        <div class="item-4-5 vertical-align">
                                            <p class="bold-me">{{__("entity.description")}}</p>
                                            <p>{{ $party->description }}</p>
                                            <div class="social-media-icons">
                                                @if ($party->email)
                                                    <a href="mailto:{{ $party->email }}" class="btn mail-icon btn-circle waves-effect waves-circle waves-float">
                                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                    </a>
                                                @endif

                                            @if ($party->url)
                                                    <a href="{{ $party->url }}" class="btn home-icon btn-circle waves-effect waves-circle waves-float">
                                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                                @if ($party->facebook)
                                                    <a href="{{ $party->facebook }}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float">
                                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                                @if ($party->twitter)
                                                    <a href="{{ $party->twitter }}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float">
                                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                                    </a>

                                                @endif
                                                @if ($party->instagram)
                                                    <a href="{{ $party->instagram }}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float">
                                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif
        

        @if (count($parties) == 0 && count($project->projectInformation->sponsor)==0)
            @component('back.components.no-results')
            @endcomponent
        @endif

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>

    @component('back.components.enable-section-js', ["section" => "par","project_id" => $project->id])
    @endcomponent


    <script>

        @if (!Auth::user()->isAdmin() &&  !Auth::user()->isProjectCoordinator())
$('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
        @endif

$(".card-entity-logo").error(function () {
            $(this).parent().remove();
        });

        $(document).ready(function(){

            $('.party-select').change(function(){
                if($(this).val()=="new-party"){

                    swal({
                            title: "{{__('project/party.new_party')}}",
                            text: "{{__('project/party.redirect_entities')}}",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#1f91f3 ",
                            confirmButtonText: "{{__('project/party.go_entities')}}",
                            closeOnConfirm: false
                        },
                        function(){
                            window.location.href='/entities';
                        });

                }
            });

        });

        @if (Auth::user()->canDelete())

            $('.del-btn').click(function(){
            var project = $(this).data('project');
            var party = $(this).data('party');
            var card = $(this).parent().parent().parent().parent();
            console.log(project,party);

            swal({
                    title: 'Are you sure?',
                    type: "warning",
                    text: "{{__('project/party.delete_confirm')}}",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No, cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(){
                    $.ajax({
                        url: '{{ route("project.parties.delete") }}',
                        type: 'DELETE',
                        data: { project_id: project, entity_id: party },
                        dataType: "json",
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            card.remove();

                            console.log(data);
                        },
                        error: function(errors){
                            console.log(errors);
                        },
                        complete: function() {
                            location.reload();
                        }
                    });
                });
        });
        @else
            $('i.delete-group').remove();
        @endif

        /**
         * Card Behaviour
         */
        $('.toggleable-card').each(function(){

            $(this).click(function (e) {

                if(!$(e.target).is('.delete-group')){

                    // Get status of the box
                    var headerElement = $(this);
                    var bodyElement = $(this).siblings('.body');
                    var status = headerElement.data("status");

                    if(!status){

                        // Card closed, we proceed to open
                        bodyElement.removeClass("not-visible").addClass("is-visible");

                        // Update the status of the card
                        headerElement.data("status", 1);

                        // Update the keyboard_arrow of the box if any
                        if(headerElement.find("#keyboard_arrow").length > 0){

                            $('#keyboard_arrow').html("keyboard_arrow_up");

                        }

                    } else {

                        // Card open, we proceed to close
                        bodyElement.removeClass("is-visible").addClass("not-visible");

                        // Update the status of the card
                        headerElement.data("status", 0);

                        // Update the keyboard_arrow of the box if any
                        if(headerElement.find("#keyboard_arrow").length > 0){

                            $('#keyboard_arrow').html("keyboard_arrow_down");

                        }

                    }

                }

            });

        });
    </script>

@endsection
