@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#award' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project/project-details/award.title")}}</h1>
    </div>
    @component('back.components.enable-subsection', ["visible" => $projectDetail->award_active])
    @endcomponent


    <div class="row content-row">
        <div class="col-md-12">
            @if ($errors->any())
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
            <div class="card dynamic-card">
                <div class="header card-header-static">
                    <h2>
                        <span>{{__("project/project-details/award.main-dates-title")}}</span>
                    </h2>
                </div>

                <div class="body" data-status="0">
                    <form method="post" class="frmEditDocument" id="formCoreInfo" action="{{route("project-details-award/store-core")}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <b>{{__("project/project-details/award.award-name")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="award_name" value="{{ $award->name or '' }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>{{__("project/project-details/award.total-amount")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control decimal" name="total_amount" value="{{ $award->total_amount or '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>{{__("project/project-details/award.award-status")}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="award_status_id" title="-- {{__("project/project-details/award.award-status-placeholder")}} --">
                                            @if($award)
                                                @foreach($awards_status as $award_status)
                                                    <option @if($award->award_status_id == $loop->iteration) selected @endif value="{{$award_status->id}}">{{$award_status->name}}</option>
                                                @endforeach
                                            @else
                                                @foreach($awards_status as $award_status)
                                                    <option value="{{$award_status->id}}">{{$award_status->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            {{-- Col --}}
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-details/award.award_date')}}</b>
                                    <div class="form-line">
                                        <input type="text"
                                               class="form-control datepicker"
                                               name="award_date"
                                               value="{{$award ? $award->award_date ? $award->award_date->format('d-m-Y') : null : null}}"
                                               placeholder="{{trans('project/project-details/award.no-date')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-details/award.contract_signature_date')}}</b>
                                    <div class="form-line">
                                        <input type="text"
                                               class="form-control
                                               datepicker"
                                               name="contract_signature_date"
                                               value="{{$award ? $award->contract_signature_date ? $award->contract_signature_date->format('d-m-Y') : null : null}}"
                                               placeholder="{{trans('project/project-details/award.no-date')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-details/award.contract_signature_date_end')}}</b>
                                    <div class="form-line">
                                        <input type="text"
                                               class="form-control
                                               datepicker"
                                               name="contract_signature_date_end"
                                               value="{{$award ? $award->contract_signature_date_end ? $award->contract_signature_date_end->format('d-m-Y') : null : null}}"
                                               placeholder="{{trans('project/project-details/award.no-date')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <b>{{__("project/project-details/award.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="award_description" placeholder="{{__("project/project-details/award.description-placeholder")}}">{{ $award->description or '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="submit-type">
                        @component(
                            'back.components.project-buttons', [
                                'section_fields' => ['award_date', 'contract_signature_date', 'contract_signature_date_end', 'total_amount', 'award_description', 'award_name', 'award_status_id'],
                                'position'=> $award?1:0,
                                'section'=>'aw',
                                'project'=>$project->id,
                                'hasCoordinators'=>$hasCoordinators
                            ])
                        @endcomponent
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h2 class="content-title-project">{{__("project/project-details/award.preferred-bidder-title")}}</h2>
    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow m-b-0">
                    <div id="card-header" class="header toggleable-card" @if ($errors->any() || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/award.select-preferred-bidder")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                    </div>
                    <div id="card-body" class="body @if ($errors->any() || (isset($flag))) is-visible @else not-visible @endif">

                        <form action="{{route("project-details-award/store-bidder")}}" method="POST" class="party-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <label for="preferred_bidder_id">{{__("project/project-details/award.preferred-bidder-title")}}</label>
                                <select id="preferred_bidder_id" name="preferred_bidder_id"  class="form-control party-select col-md-8 m-l-20" title="-- {{__("project/project-details/award.choose")}} --">
                                    @foreach($entities as $entity)
                                        <option value="{{$entity->id}}">{{ $entity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <button type="submit" class="btn btn-large btn-primary waves-effect btn-draft">{{__("project/party.add_party")}}</button> --}}
                            @component(
                                'back.components.project-buttons', [
                                    'section_fields' => ['preferred_bidder_id'],
                                    'position'=>1,
                                    'section'=>'aw',
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
    @if($bidder)
        <div class="row content-row">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <h2><span>{{ $bidder->name }}</span> @if( \Illuminate\Support\Facades\Auth::user()->canDelete() ) <i class="fa fa-trash-o del-btn x2 delete-bidder" aria-hidden="true" data-project="{{$project->id}}" data-id="{{$award->id}}"></i>@endif </h2>
                    </div>
                    <div class="body" data-status="0">

                        <div class="flex">

                            <div class="item-1-5 vertical-align">
                                <img src="{{route('uploader.par', array('position' => $bidder->id))}}" class="img-responsive card-entity-logo"/>
                            </div>

                            <div class="item-4-5 vertical-align">
                                <p class="bold-me">{{__("entity.description")}}</p>
                                <p>{{ $bidder->description }}</p>
                                @if (env('APP_NAME')=='NigeriaICRC')
                                    <div class="row">
                                        @if ($bidder->name_representative)
                                            <div class="col-md-4">
                                                <p class="bold-me">{{__("entity.name-representative")}}</p>
                                                <p>{{ $bidder->name_representative }}</p>
                                            </div>
                                        @endif
                                        @if ($bidder->address)
                                            <div class="col-md-4">
                                                <p class="bold-me">{{__("entity.address")}}</p>
                                                <p>{{ $bidder->address }}</p>
                                            </div>
                                        @endif
                                        @if ($bidder->tel)
                                            <div class="col-md-4">
                                                <p class="bold-me">{{__("entity.tel")}}</p>
                                                <p>{{ $bidder->tel }}</p>
                                            </div>
                                        @endif
                                        @if ($bidder->fax)
                                            <div class="col-md-4">
                                                <p class="bold-me">{{__("entity.fax")}}</p>
                                                <p>{{ $bidder->fax }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="social-media-icons">
                                    @if ($bidder->email)
                                        <a href="mailto:{{ $bidder->email }}" class="btn mail-icon btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        </a>
                                    @endif

                                    @if ($bidder->url)
                                        <a href="{{ $bidder->url }}" class="btn home-icon btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                    @if ($bidder->facebook)
                                        <a href="{{ $bidder->facebook }}" class="btn fb-icon btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                    @if ($bidder->twitter)
                                        <a href="{{ $bidder->twitter }}" class="btn twitter-icon btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>

                                    @endif
                                    @if ($bidder->instagram)
                                        <a href="{{ $bidder->instagram }}" class="btn instagram-icon btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <h2 class="content-title-project">{{__("project/project-details/award.financing-information-title")}}</h2>
    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow m-b-0">
                    <div id="card-header" class="header toggleable-card" @if ($errors->any() || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/award.add-financing-information")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                    </div>
                    <div id="card-body" class="body @if ($errors->any() || (isset($flag))) is-visible @else not-visible @endif">

                        <form action="{{route("project-details-award/store-financing")}}" method="POST" class="party-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>{{__("project/project-details/award.financing_title")}}</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="financing_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                {{-- Col --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{trans('project/project-details/award.financing-start-date')}}</b>
                                        <div class="form-line">
                                            <input type="text"
                                                   class="form-control datepicker"
                                                   name="financing_start_date"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{trans('project/project-details/award.financing-end-date')}}</b>
                                        <div class="form-line">
                                            <input type="text"
                                                   class="form-control datepicker"
                                                   name="financing_end_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{__("project/project-details/financial.category")}}</b>
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" name="financing_category_id" title="-- {{__("project/project-details/financial.category-placeholder")}} --" required>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{__("project/project-details/award.amount")}}</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control decimal" name="financing_amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>{{__("project/project-details/award.description")}}</b>
                                        <div class="form-line">
                                            <textarea class="form-control no-resize" name="financing_description" placeholder="{{__("project/project-details/award.description-placeholder")}}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="financing_party_id">{{__("project/project-details/award.financing-party-label")}}</label>
                                        <select id="financing_party_id" name="financing_party_id"  class="form-control party-select col-md-8 m-l-20" title="-- {{__("project/project-details/award.choose-financing-party")}} --" required>
                                            @foreach($entities as $entity)
                                                <option value="{{$entity->id}}">{{ $entity->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- <button type="submit" class="btn btn-large btn-primary waves-effect btn-draft">{{__("project/party.add_party")}}</button> --}}
                            @component(
                                'back.components.project-buttons', [
                                    'section_fields' => [ 'financing_name', 'financing_start_date', 'financing_end_date', 'financing_category_id', 'financing_amount', 'financing_description', 'financing_party_id' ],
                                    'position'=>0,
                                    'section'=>'awf',
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

    @if(count($award_financings) > 0)
        <ul id="sortable">

            @foreach($award_financings as $award_financing)
                <li class="ui-state-default" data-order="{{$award_financing->position}}">

                    <div class="row content-row toggleable-wrapper">
                        <div class="col-md-12">
                            <div class="card dynamic-card toggleable-container">
                                <div class="header card-header-static toggleable-card">
                                    <h2>
                                        @component('back.components.draft-chip',['draft'=>$award_financing->draft])
                                        @endcomponent
                                        <span>{{$award_financing->name}}</span>
                                        @component('back.components.individual-visibility', [
                                            'project' => $project->id,
                                            'position' => $award_financing->id,
                                            'status' => $award_financing->published,
                                            'route' => route('project-details-award/visibility')
                                        ])@endcomponent
                                        <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$award_financing->id}}"></i></h2>
                                </div>
                                <div class="body not-visible" data-status="0">
                                    <form method="post" class="frmEditDocument" action="{{route("project-details-award/edit-financing")}}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$award_financing->id}}">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <b>{{__("project/project-details/award.financing_title")}}</b>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="financing_name" value="{{$award_financing->name or ''}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            {{-- Col --}}
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <b>{{trans('project/project-details/award.financing-start-date')}}</b>
                                                    <div class="form-line">
                                                        <input type="text"
                                                               class="form-control datepicker"
                                                               name="financing_start_date"
                                                               value="{{$award_financing->start_date ? $award_financing->start_date->format('d-m-Y') : null}}"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <b>{{trans('project/project-details/award.financing-end-date')}}</b>
                                                    <div class="form-line">
                                                        <input type="text"
                                                               class="form-control datepicker"
                                                               name="financing_end_date"
                                                               value="{{$award_financing->end_date ? $award_financing->end_date->format('d-m-Y') : null}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <b>{{__("project/project-details/financial.category")}}</b>
                                                    <div class="form-line">
                                                        <select class="form-control show-tick selectpicker" name="financing_category_id" title="-- {{__("project/project-details/financial.category-placeholder")}} --">
                                                            @foreach($categories as $category)
                                                                <option @if($award_financing->financial_category_id == $loop->iteration) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <b>{{__("project/project-details/award.amount")}}</b>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control decimal" name="financing_amount" value="{{ $award_financing->amount or '' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <b>{{__("project/project-details/award.description")}}</b>
                                                    <div class="form-line">
                                                        <textarea class="form-control no-resize" name="financing_description" placeholder="{{__("project/project-details/award.description-placeholder")}}">{{ $award_financing->description or '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="financing_party_id">{{__("project/project-details/award.financing-party-label")}}</label>
                                                    <select id="financing_party_id" name="financing_party_id"  class="form-control party-select col-md-8 m-l-20" title="-- {{__("project/project-details/award.choose-financing-party")}} --">
                                                        @foreach($entities as $entity)
                                                            <option @if($award_financing->financing_party_id == $loop->iteration) selected @endif value="{{$entity->id}}">{{ $entity->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="submit-type">
                                        @component('back.components.project-buttons', [
                                            'section_fields' => [ 'financing_name', 'financing_start_date', 'financing_end_date', 'financing_category_id', 'financing_amount', 'financing_description', 'financing_party_id' ],
                                            'position'=>$award_financing->id,
                                            'section'=>'awf',
                                            'project'=>$project->id,
                                            'hasCoordinators'=>$hasCoordinators
                                        ])
                                        @endcomponent
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>

            @endforeach
        </ul>
        @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
            <button type="button" id="order-save-button" class="btn btn-large btn-primary waves-effect m-t-20 m-l-30" disabled>{{__('order.save')}}</button>
        @endif

    @else

        @component('back.components.no-results')
        @endcomponent

    @endif




@endsection

@section('scripts')

    @component('back.components.enable-section-js', ["section" => "pd","project_id" => $project->id])
    @endcomponent

    @component('back.components.enable-subsection-js', ["section" => "aw","project_id" => $projectDetail->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('back/plugins/jquery-ui-1.12.1/jquery-ui.js') }}"></script>

    <script>

        // The good old decimal validation
        $('.decimal').keypress(function(evt){
            return (/^[0-9]*\.?[0-9]*$/).test($(this).val()+evt.key);
        });

        @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())

        /**
         * Drag and drop
         */
        var order;

        $(function() {
            $( "#sortable" ).sortable({
                update: function(event, ui) {
                    order = [];
                    $('#sortable li').each( function(e) {
                        order.push( $(this).data('order'));
                    });
                    order = order.filter(function(n){ return n != undefined });
                    $("#order-save-button").prop('disabled',false);

                }
            });
        });

        $("#order-save-button").click(function () {
            $.ajax({
                url: '{{ route('project-details-award/order') }}',
                type: 'POST',
                data: { order: order, project_id: {{$projectDetail->id}} },
                beforeSend: function() {
                },
                success: function(data){
                    swal({
                            title: '{{ trans('messages.success') }}',
                            text: "{{trans('order.success')}}",
                            type: "success",
                        },function () {
                            location.reload();
                        }
                    );
                },
                error: function(data){
                },
                complete: function() {
                }
            });
        });

        @endif

        @if (!Auth::user()->isAdmin() && !Auth::user()->isProjectCoordinator())
        $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
        @endif

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            // inline: true,
            sideBySide: true
        });

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


        @if(Auth::user()->canDelete())
        $('.delete-group').click(function(){
            var id = $(this).data('id');
            var card = $(this).parent().parent().parent().parent();

            swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/award.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-award/delete-financing') }}',
                        type: 'DELETE',
                        data: { id: id },
                        dataType: "json",
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            if (data.status) {
                                swal({
                                    title: '{{trans('messages.success')}}',
                                    text: '{{ trans('project/project-details/award.deleted') }}',
                                    type: "success",
                                    html: true
                                });

                                card.remove();
                            } else {
                                laravelErrors(data);
                            }
                        },
                        error: function(errors){
                            laravelErrors(errors);
                        },
                        complete: function() {
                            $('.page-loader-wrapper').fadeOut();
                        }
                    });
                });
        });

        $('.delete-bidder').click(function(){
            var id = $(this).data('id');
            var card = $(this).parent().parent().parent().parent();

            swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/award.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-award/delete') }}',
                        type: 'DELETE',
                        data: { id: id },
                        dataType: "json",
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            if (data.status) {
                                swal({
                                    title: '{{trans('messages.success')}}',
                                    text: '{{ trans('project/project-details/award.deleted') }}',
                                    type: "success",
                                    html: true
                                });

                                card.remove();
                            } else {
                                laravelErrors(data);
                            }
                        },
                        error: function(errors){
                            laravelErrors(errors);
                        },
                        complete: function() {
                            $('.page-loader-wrapper').fadeOut();
                        }
                    });
                });
        });
        @else
        $('i.delete-group').remove();
        @endif

        $("#frmCreateDocument").validate({
            ignore: ":hidden:not(.selectpicker)",
            /* Onkeyup
             * For not sending an ajax request to validate the email each time till the typing is done.
             */
            /*onkeyup: false,*/
            rules: {
                name:{
                    required: true
                },
                description:{
                    required: true
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        }); //Validation end

        $(".frmEditDocument").each(function(){
            var form = $(this);
            var validator = form.validate({
                ignore: ":hidden:not(.selectpicker)",
                /* Onkeyup
                 * For not sending an ajax request to validate the email each time till the typing is done.
                 */
                /*onkeyup: false,*/
                rules: {
                    name:{
                        required: true
                    },
                    description:{
                        required: true
                    },
                },
                submitHandler: function (form) {
                    form.submit();
                }
            }); //Validation end
        });

        @if (session('status') == true)
        swal({
            title: "{{trans('messages.success')}}",
            text: "{{trans('project/project-details/award.success')}}",
            type: "success",
            html: true
        }, function(){
        });
        @elseif (session('error') == true)
        swal({
            title: "{{trans('messages.error')}}",
            text: "{{session('error')}}",
            type: "error",
            html: true
        }, function(){
        });
        @endif

    </script>

    @component('components.uploader-assets')
    @endcomponent
@endsection