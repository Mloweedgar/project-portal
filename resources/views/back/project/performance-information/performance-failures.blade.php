@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <style>
      .back-gray{
        background-color: #e5e5e5;
      }
      .table-modal {
        border-right: 1px solid #eee;
      }
    </style>

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#performance_failures' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.performance_information_title'),"visible" => $project->performance_information_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project.section.performance_information.performance_failures")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $project->performanceInformation->performance_failures_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "pf","project" => $project->id])
    @endcomponent --}}

  @if (!Auth::user()->isViewOnly())
      <div class="row content-row">
        {{-- Category failure type --}}
        <div class="col-md-12">

            <div class="card">
                <div class="card-header header" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                    <h2><i class="material-icons">add_box</i> <span>{{__("project/performance-information/performance_failures.add_group")}}</span> <i class="keyboard_arrow material-icons">keyboard_arrow_down</i></h2>
                </div>
                <div class="card-body body @if (count($errors) > 0 && !old('category_name') || (isset($flag))) is-visible @else not-visible @endif">
                    @if (count($errors) > 0 && !old('category_name'))
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
                    <form method="post" action="{{route("project.performance-information.performance-failures.store")}}" @if (count($errors) == 0 ) hidden @endif class="formsPerformance">
                        {{ csrf_field() }}
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                              <label for="title">{{trans('project/performance-information/performance_failures.title')}}</label>
                          </div>
                          <div class="col-md-10">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" id="title" class="form-control" name="title" value ="{{old('title')}}">
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}

                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                              <label for="category_failure">{{trans('project/performance-information/performance_failures.category')}}</label>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <div class="form-line">
                                    <select class="form-control show-tick selectpicker" name="category_failure">
                                        <option value="">-- {{trans('general.choose-option')}} --</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ (old("category_failure") == $category->id ? "selected":"") }}> {{$category->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                          @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
                              <div class="col-md-3">
                                <button id="btnOpenNewTypeModal" class="btn btn-primary">{{trans('project/performance-information/performance_failures.add_new_category')}}</button>
                              </div>
                          @endif
                        </div> {{-- End row --}}

                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                              <label for="number_events">{{trans('project/performance-information/performance_failures.number_events')}}</label>
                          </div>
                          <div class="col-md-10">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" id="number_events" class="form-control" name="number_events" value="{{old('number_events')}}">
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}


                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                              <label for="penalty_abatement_contract">{{trans('project/performance-information/performance_failures.penalty_abatement_contract')}}</label>
                          </div>
                          <div class="col-md-10">
                              <div class="form-group">
                                  <div class="form-line">
                                    <textarea rows="5" id="penalty_abatement_contract" name="penalty_abatement_contract" class="textarea form-control no-resize" placeholder="{{trans('project/performance-information/performance_failures.penalty_abatement_contract_placeholder')}}">{{old('penalty-abatement-contract')}}</textarea>
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}

                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                              <label for="penalty_abatement_imposed">{{trans('project/performance-information/performance_failures.penalty_abatement_imposed')}}</label>
                          </div>
                          <div class="col-md-10">
                              <div class="form-group">
                                  <div class="form-line">
                                    <textarea rows="5" id="penalty_abatement_imposed" name="penalty_abatement_imposed" class="textarea form-control no-resize" placeholder="{{trans('project/performance-information/performance_failures.penalty_abatement_contract_placeholder')}}">{{old('penalty_abatement_imposed')}}</textarea>
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}

                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                              <label for="penalty_abatement_imposed_yes_no">{{trans('project/performance-information/performance_failures.penalty_abatement_yes_no')}}</label>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <div class="form-line">
                                    <select class="form-control show-tick selectpicker" id="penalty_abatement_imposed_yes_no" name="penalty_abatement_imposed_yes_no">
                                        <option value="">-- {{trans('general.choose-option')}} --</option>
                                        <option value="1" @if(old('penalty_abatement_imposed_yes_no') == 1) selected @endif>Yes</option>
                                        <option value="0" @if(old('penalty_abatement_imposed_yes_no') == 0) selected @endif>No</option>
                                    </select>
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}

                        @component('back.components.project-buttons', [
                            'section_fields' => [ 'title', 'category_failure', 'number_events', 'penalty_abatement_contract', 'penalty_abatement_imposed', 'penalty_abatement_imposed_yes_no'],
                            'position'=>0,
                            'section'=>'pf',
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

    @if(count($performance_failures) > 0)
        <ul id="sortable">
            @foreach($performance_failures as $performance_failure)
                <li class="ui-state-default" data-order="{{$performance_failure->position}}">
                    <div class="row content-row toggleable-wrapper">
          <div class="col-md-12">
              <div class="card dynamic-card toggleable-container">
                <div class="card-header-static header toggleable-card">
                      <h2>
                          @component('back.components.draft-chip',['draft'=>$performance_failure->draft])
                          @endcomponent
                          <span>{{$performance_failure->title}}</span>
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'position' => $performance_failure->id,
                                'status' => $performance_failure->published,
                                'route' => route('project.performance-information.performance-failures.visibility')
                            ])@endcomponent
                          <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$performance_failure->id}}"></i></h2>
                  </div>
                  <div class="body not-visible" data-status="0">

                      <form method="post" action="{{route("project.performance-information.performance-failures.update")}}" class="formsPerformance">
                          {{ csrf_field() }}
                          <input type="hidden" name="performance_failure_id" value="{{$performance_failure->id}}">
                          <div class="row"> {{-- Row --}}
                            {{-- Group --}}
                            <div class="col-md-2">
                                <label for="title">{{trans('project/performance-information/performance_failures.title')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="form-line">
                                      <input type="text" id="title" class="form-control" name="title" value ="{{$performance_failure->title}}">
                                    </div>
                                </div>
                            </div> {{-- End group --}}
                          </div> {{-- End row --}}

                          <div class="row"> {{-- Row --}}
                            {{-- Group --}}
                            <div class="col-md-2">
                                <label for="category_failure">{{trans('project/performance-information/performance_failures.category')}}</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-line">

                                      <select class="form-control show-tick selectpicker" name="category_failure">
                                          <option value="">-- {{trans('general.choose-option')}} --</option>
                                          @foreach($categories as $category)
                                              <option value="{{$category->id}}" {{ ($performance_failure->category_failure_id == $category->id ? "selected":"") }}> {{$category->name}}</option>
                                          @endforeach
                                      </select>

                                    </div>
                                </div>
                            </div> {{-- End group --}}
                          </div> {{-- End row --}}

                          <div class="row"> {{-- Row --}}
                            {{-- Group --}}
                            <div class="col-md-2">
                                <label for="number_events">{{trans('project/performance-information/performance_failures.number_events')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="form-line">
                                      <input type="text" id="number_events" class="form-control" name="number_events" value="{{$performance_failure->number_events}}">
                                    </div>
                                </div>
                            </div> {{-- End group --}}
                          </div> {{-- End row --}}

                          <div class="row"> {{-- Row --}}
                            {{-- Group --}}
                            <div class="col-md-2">
                                <label for="penalty_abatement_contract">{{trans('project/performance-information/performance_failures.penalty_abatement_contract')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="form-line">
                                      <textarea rows="5" id="penalty_abatement_contract" name="penalty_abatement_contract" class="textarea form-control no-resize" placeholder="{{trans('project/performance-information/performance_failures.penalty_abatement_contract_placeholder')}}">{{$performance_failure->penalty_contract}}</textarea>
                                    </div>
                                </div>
                            </div> {{-- End group --}}
                          </div> {{-- End row --}}

                          <div class="row"> {{-- Row --}}
                            {{-- Group --}}
                            <div class="col-md-2">
                                <label for="penalty_abatement_imposed">{{trans('project/performance-information/performance_failures.penalty_abatement_imposed')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="form-line">
                                      <textarea rows="5" id="penalty_abatement_imposed" name="penalty_abatement_imposed" class="textarea form-control no-resize" placeholder="{{trans('project/performance-information/performance_failures.penalty_abatement_contract_placeholder')}}">{{$performance_failure->penalty_imposed}}</textarea>
                                    </div>
                                </div>
                            </div> {{-- End group --}}
                          </div> {{-- End row --}}

                          <div class="row"> {{-- Row --}}
                            {{-- Group --}}
                            <div class="col-md-2">
                                <label for="penalty_abatement_imposed_yes_no">{{trans('project/performance-information/performance_failures.penalty_abatement_yes_no')}}</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-line">
                                      <select class="form-control show-tick selectpicker" id="penalty_abatement_imposed_yes_no" name="penalty_abatement_imposed_yes_no">
                                          <option value="">-- {{trans('general.choose-option')}} --</option>
                                          <option value="1" @if($performance_failure->penalty_paid == 1) selected @endif>Yes</option>
                                          <option value="0" @if($performance_failure->penalty_paid == 0) selected @endif>No</option>
                                      </select>
                                    </div>
                                </div>
                            </div> {{-- End group --}}
                          </div> {{-- End row --}}

                          <input type="hidden" name="submit-type">

                          @component('back.components.project-buttons', [
                              'section_fields' => [ 'title', 'category_failure', 'number_events', 'penalty_abatement_contract', 'penalty_abatement_imposed', 'penalty_abatement_imposed_yes_no'],
                              'position'=>$performance_failure->id,
                              'section'=>'pf',
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

      <div class="row content-row">
        @foreach($tables as $table)
        <div class="col-md-12 m-t-25">
        <div class="m-b-10" style="font-size: 16px; text-transform: capitalize"></div>
          <div class="table-responsive" id="prmSectors">
              <table class="table table-modal" style="width:100%">
                <thead>
                  <tr class="back-gray">
                    <th style="width: 20%"></th>
                    @foreach($table as $record)
                      <th style="width:{{80/count($table)}}%">{{$record["title"]}}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="back-gray">{{trans('project/performance-information/performance_failures.category')}}</td>
                    @foreach($table as $record)
                      <td>{{$record["category"]["name"]}}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="back-gray">{{trans('project/performance-information/performance_failures.number_events')}}</td>
                    @foreach($table as $record)
                      <td>{{$record["number_events"]}}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="back-gray">{{trans('project/performance-information/performance_failures.penalty_abatement_contract')}}</td>
                    @foreach($table as $record)
                      <td>{{$record["penalty_contract"]}}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="back-gray">{{trans('project/performance-information/performance_failures.penalty_abatement_imposed')}}</td>
                    @foreach($table as $record)
                      <td>{{$record["penalty_imposed"]}}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="back-gray">{{trans('project/performance-information/performance_failures.penalty_abatement_yes_no_table')}}</td>
                    @foreach($table as $record)
                      <td>
                        @if($record["penalty_paid"] == 1)
                          {{trans('project/performance-information/performance_failures.yes')}}
                        @else
                          {{trans('project/performance-information/performance_failures.no')}}
                        @endif
                      </td>
                    @endforeach
                  </tr>
                   {{-- <tr>
                    <th>{{trans('project/performance-information/annual_demand_levels.annual-demand')}}</th>
                    @foreach($table["records"] as $record)

                      <td class="record" data-id="{{$record["id"]}}">{{$record["value"]}}</td>
                    @endforeach
                  </tr> --}}
                </tbody>

              </table>
            </div>
        </div>

        @endforeach
      </div>
    @else
        @component('back.components.no-results')
        @endcomponent
    @endif

    <div class="modal fade in" tabindex="-1" role="dialog" id="modalCategory">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <div class="modal-body">
            @if (count($errors) > 0 && old('category_name'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{route("project.performance-information.performance-failures.storeCategory")}}" id="frmCategory">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-3">
                      <label for="category_name">{{trans('project/performance-information/performance_failures.category')}}</label>
                  </div>
                  <div class="col-md-9">
                      <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="category_name" class="form-control" name="category_name" value ="{{old('category_name')}}">
                          </div>
                      </div>
                  </div> {{-- End group --}}
                </div> {{-- End row --}}
                <button class="btn btn-large btn-primary waves-effect" type="submit">{{trans('general.save')}}</button>
            </form>

          </div>{{-- Body --}}
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect">{{trans('user.save')}}</button>
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('user.back')}}</button>
          </div> --}}
        </div>
      </div>
    </div>


@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

        @component('back.components.enable-section-js', ["section" => "pi","project_id" => $project->id])
        @endcomponent

        @component('back.components.enable-subsection-js', ["section" => "pf","project_id" => $project->performanceInformation->id])
        @endcomponent

        @component('back.components.individual-visibility-js', [
        ])@endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/fineuploader-core/all.fine-uploader.js') }}"></script>

        <script src="{{ asset('back/plugins/jquery-ui-1.12.1/jquery-ui.js') }}"></script>

        <script>
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
                    url: '{{ route('project.performance-information.performance-failures.order') }}',
                    type: 'POST',
                    data: { order: order, project_id: {{$project->performanceInformation->id}} },
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

        $('select').selectpicker('refresh');


        $("#frmCategory").validate({
          ignore: ":hidden:not(.selectpicker)",
          /* Onkeyup
           * For not sending an ajax request to validate the email each time till the typing is done.
           */
          /*onkeyup: false,*/
          rules: {
            category_name:{
              required: true
            }
          },
          submitHandler: function (form) {
              form.submit();
          }
        }); //Validation end

        $("#btnOpenNewTypeModal").click(function(ev){
          ev.preventDefault();
          $("#modalCategory").modal('toggle');

        });


        @if (Auth::user()->canDelete())
            /*
             * DELETE METHOD
            */

           $('.delete-group').click(function(ev){
             ev.preventDefault();


             var id = $(this).data('id');

             var card = $(this).closest('.card');

             swal({
                 title: '{{ trans('messages.confirm') }}',
                 text: "{{trans('project/performance-information/performance_failures.delete_confirm')}}",
                 type: "warning",
                 showCancelButton: true,
                 confirmButtonColor: "#DD6B55",
                 confirmButtonText: "{{ trans('messages.yes_delete') }}",
                 cancelButtonText: "{{ trans('general.no') }}",
                 closeOnConfirm: true
             },
             function(){
                 $.ajax({
                     url: '{{ route('project.performance-information.performance-failures.delete') }}',
                     type: 'DELETE',
                     data: { id: id },
                     dataType: "json",
                     beforeSend: function() {
                         $('.page-loader-wrapper').show();
                     },
                     success: function(data){
                         if (data.status) {
                             location.reload();

                         } else {
                             swal({
                                 title: "{{trans('messages.error')}}",
                                 text: info,
                                 type: "error",
                                 html: true
                             }, function(){

                             });
                         }
                     },
                     error: function(errors){
                         $('.page-loader-wrapper').fadeOut();
                         var info = laravelErrors(data)
                         swal({
                             title: "{{trans('messages.error')}}",
                             text: info,
                             type: "error",
                             html: true
                         }, function(){
                         });
                     },
                     complete: function() {

                     }
                 });
             });
           });

       @else
           $('i.delete-group').remove();
       @endif



        $(".formsPerformance").each(function(){
            var form = $(this);
            var validator = form.validate({
              ignore: ":hidden:not(.selectpicker)",
              /* Onkeyup
               * For not sending an ajax request to validate the email each time till the typing is done.
               */
              /*onkeyup: false,*/
              rules: {
                title:{
                  required: true
                },
                category_failure:{
                  required: true
                },
                number_events:{
                  required: true,
                  digits: true
                },
                penalty_abatement_contract:{
                  required: true
                },
                penalty_abatement_imposed:{
                  required: false
                },
                penalty_abatement_imposed_yes_no:{
                  required: false
                },
              },
              submitHandler: function (form) {
                  form.submit();
              }
            }); //Validation end
            $("[name='category_failure']").on('change', function(){

                validator.element($(this));
            });
        });


        @if (count($errors) > 0 && (old('category_name')))
          $("#modalCategory").modal('toggle');
        @endif
        /**
         * Card Behaviour
         */
        $('.card-header').click(function () {

          // Get status of the box

          var headerElement = $(this);

          var bodyElement = $(this).parent().find('.card-body');


          var status = headerElement.data("status");

          if(!status){

              // Card closed, we proceed to open
              bodyElement.removeClass("not-visible").addClass("is-visible");

              // Update the status of the card
              headerElement.data("status", 1);

              bodyElement.find('form').show();

              // Update the keyboard_arrow of the box
              console.log(headerElement.find('.keyboard_arrow'))
              headerElement.find('.keyboard_arrow').html("keyboard_arrow_up");

          } else {

              // Card open, we proceed to close
              bodyElement.removeClass("is-visible").addClass("not-visible");

              // Update the status of the card
              headerElement.data("status", 0);

              bodyElement.find('form').hide();

              // Update the keyboard_arrow of the box
              headerElement.find('.keyboard_arrow').html("keyboard_arrow_down");

          }

        });


        @if(session('deleted') == true)
          swal({
              title: "{{trans('messages.success')}}",
              text: "{{ trans('project/performance-information/performance_failures.deleted') }}",
              type: "success",
              html: true
          }, function(){
          });
        @endif
    </script>

    @if (session('status') == true)
        <script>
            swal({
                title: "{{trans('messages.success')}}",
                text: "{{trans('project/performance-information/performance_failures.success')}}",
                type: "success",
                html: true
            }, function(){

            });
        </script>
    @endif


@endsection
