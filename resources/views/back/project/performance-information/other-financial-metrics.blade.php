@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/jquery-spinner/bootstrap-spinner.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/project/performance_information.css') }}" rel="stylesheet">


@endsection

@section('content')
    <h1 class="content-title">{{__("menu.projects")}}</h1>


    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @component('back.components.enable-section', ["section" => trans('project.section.performance_information_title'),"visible" => $project->performance_information_active])
    @endcomponent


    <h1 class="content-title-project">{{__("project.section.performance_information.other_financial_metrics")}}</h1>
    <div class="row content-row content-metrics">
      {{-- Timeless variables card --}}
      {{-- Timeless variables insert --}}
      @if(Auth::user()->canCreate())
          <div class="col-md-12 m-b-30">
            <div class="card">
              <div class="header card-header-static">
                  <div class="inline-block">
                  <h2>
                      @component('back.components.draft-chip',['draft'=>$draft_timeless])
                      @endcomponent
                      <span>{{trans('project/performance-information/other_financial_metrics.timeless_title')}}</span></h2>
                  </div>
                  @component('back.components.enable-subsection-2', ["visible" => $project->performanceInformation->timeless_financial_active])
                  @endcomponent
              </div>
              <div class="body">
                  <form method="post" id="frmTiemeless">
                 {{ csrf_field() }}
                 <input type="hidden" name="project_id" value="{{$project->id}}">
                  <div class="row">
                    <div class="col-md-1">
                        <label for="income_metric" >{{trans('project/performance-information/other_financial_metrics.timeless_variable')}}</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-line">
                              <select class="form-control show-tick" id="income_metric" name="timeless_type" multiple>
                                  @foreach($timelessVariables as $type)
                                      <option value="{{$type["id"]}}" {{ ($type["timeless"] ? "selected":"") }}> {{$type["name"]}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div> {{-- End group --}}
                    <div class="material-icons info-material-icons editabletooltip" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('project/performance-information/other_financial_metrics.info_timeless') }}">info_outline</div>
                  </div>
                  <div class="row">
                  {{-- @foreach(array_chunk($timelessVariables, 4) as $key => $row) --}}

                    @foreach($timelessVariables as $key => $variable)
                       <div class="col-md-3 timelessInputs" data-id="{{$variable["id"]}}" {{($variable["timeless"]) ? "" : "hidden"}}>
                         <label for="timeless_variable{{$loop->index}}">{{$variable["name"]}}</label>
                        <div class="form-group">
                            <div class="form-line">

                              <input type="text" id="timeless_variable{{$loop->index}}" data-id="{{$variable["id"]}}" class="form-control timeless_variables timeless_vars" name="timeless_variable[{{$loop->index}}]" value="@if($variable["timeless"]){{$variable["timeless"]["value"]}}@endif">
                            </div>
                        </div>
                      </div> {{-- End group --}}
                    @endforeach
                  {{-- @endforeach --}}
                  </div>
                    <button type="submit" id="btnSaveTimeless" class="btn btn-large btn-primary waves-effect m-b-10" data-type="save_draft">{{__("general.save")}}</button>
                    <button id="btnOpenTimelessTypeModal" class="btn btn-large btn-primary waves-effect m-b-10">{{trans('project/performance-information/other_financial_metrics.add_new_timeless_metric')}}</button>
                </form>
              </div>
            </div>
          </div>
          {{-- Timeless end variables --}}
          {{-- Annual variables insert --}}

          <div class="col-md-12 m-b-30">
            <div class="card">

              <div class="header card-header-static">
                  <div class="inline-block">
                  <h2><i class="material-icons">add_box</i> <span>{{trans('project/performance-information/other_financial_metrics.annual_title')}}</span></h2>
                  </div>
                  @component('back.components.enable-subsection', ["visible" => $project->performanceInformation->annual_financial_active])
                  @endcomponent
              </div>

              <div class="body">
                <form method="post" action="{{route("project.performance-information.other-financial-metrics.storeAnnual")}}" id="frmAnnual">
                  {{ csrf_field() }}
                  <input type="hidden" name="project_id" value="{{$project->id}}">
                  <div class="row"> {{-- Row --}}
                    {{-- Group --}}
                    <div class="col-md-1">
                        <label for="income_metric" class="m-t-7">{{trans('project/performance-information/income_statements_metrics.income_statement_metric')}}</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-line">
                              <select class="form-control show-tick" id="income_metric" name="income_metric" title="-- {{trans('general.choose-option')}} --">
                                  @foreach($annualTypes as $type)
                                      <option value="{{$type->id}}" {{ (old("type") == $type->id ? "selected":"") }}> {{$type->type_annual}} ({{$type->unit}})</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div> {{-- End group --}}
                    <div class="col-md-3">
                      <button id="btnOpenAnnualTypeModal" class="btn btn-primary">{{trans('project/performance-information/other_financial_metrics.add_new_annual_financial')}}</button>
                    </div>
                  </div>  {{-- Row end --}}

                  <div class="row"> {{-- Row --}}
                    {{-- Group --}}
                    <div class="col-md-1">
                        <label for="year" class="m-t-7">{{trans('project/performance-information/income_statements_metrics.year')}}</label>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group spinner" data-trigger="spinner">
                          <div class="form-line">
                              <input type="text" class="form-control text-center" value="@if(old('year')) {{old('year')}} @else {{$year}}@endif" data-min="1000" data-max="3000" name="year">
                          </div>
                          <span class="input-group-addon">
                              <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                              <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                          </span>
                      </div>
                    </div> {{-- End group --}}
                  </div>  {{-- Row end --}}

                  <div class="row"> {{-- Row --}}
                    {{-- Group --}}
                    <div class="col-md-1">
                      <label for="value" class="m-t-7">{{trans('project/performance-information/income_statements_metrics.value')}}</label>
                    </div>
                    <div class="col-md-11">
                        <div class="form-group">
                            <div class="form-line">
                              <input id="value" type="text" class="form-control" name="value" value="{{old('value')}}">
                            </div>
                        </div>
                    </div> {{-- End group --}}
                  </div>  {{-- Row end --}}
                  <button type="submit" class="btn btn-large btn-primary waves-effect" data-type="save_draft">{{__("general.save")}}</button>
                </form>
              </div>
            </div>
          </div>
      @endif
      {{-- End form annual variables --}}


      @foreach($tables as $table)
      <div class="col-md-12 m-t-25">
        <div class="m-b-10 title-table">
            @component('back.components.draft-chip',['draft'=>$draft_annual])
            @endcomponent
            {{$table["type"]}} ({{$table["unit"]}}) <div class="material-icons info-material-icons editabletooltip" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.table_editable') }}">info_outline</div></div>
        @foreach($table["records"] as $record)
          <div class="table-responsive" id="prmSectors">
              <table class="table table-modal">
                <thead>
                  <tr>
                    <th class="no-cursor w-200px">{{trans('general.year')}}</th>
                    @foreach($record as $cell)
                    <th class="no-cursor">
                          <div class="edit head-col">{{$cell["year"]}}</div>
                          <div class="edit edit-btn">
                            <button type="submit" class="pull-right btn btn-default delete-field" data-id="{{$cell["id"]}}">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                          </div>
                          </th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                   <tr>
                    <th class="no-cursor">{{trans('project/performance-information/annual_demand_levels.annual-demand')}}</th>
                    @foreach($record as $cell)
                      <td class="record" data-id="{{$cell["id"]}}">{{$cell["value"]}}</td>
                    @endforeach
                  </tr>
                </tbody>

              </table>
          </div>
        @endforeach

      </div>

      @endforeach
      @if(count($tables) > 0)
      <div class="col-md-12">
          <input type="hidden" name="submit-type">
          @component('back.components.project-buttons',['position'=>0,'section'=>'of','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
          @endcomponent
      </div>
      @endif
    </div> {{-- Main row --}}


    <div class="modal fade in" tabindex="-1" role="dialog" id="modalTimelessType">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            @if (count($errors) > 0 && (old('type_timeless')))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" id="frmTimelessType" action="{{route("project.performance-information.other-financial-metrics.storeTimelessType")}}">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-1">
                      <label for="type_timeless">{{trans('project/performance-information/other_financial_metrics.type')}}</label>
                  </div>
                  <div class="col-md-11">
                    <div class="form-group">
                      <div class="form-line">
                        <input id="type_timeless" type="text" class="form-control" name="type_timeless" {{old('type_timeless')}}>
                      </div>
                    </div>
                  </div> {{-- End group --}}
                </div> {{-- End row --}}
                <button type="submit" class="btn btn-large btn-primary waves-effect" data-type="save_draft">{{__("general.save")}}</button>
                <button class="btn btn-large btn-primary waves-effect" data-dismiss="modal">{{__("general.close")}}</button>
            </form>
          </div>{{-- Body --}}
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect">{{trans('user.save')}}</button>
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('user.back')}}</button>
          </div> --}}
        </div>
      </div>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="modalAnnualType">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            @if (count($errors) > 0 && (old('unit') || old('type_annual')))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" id="frmAnnualTypes" action="{{route("project.performance-information.other-financial-metrics.storeAnnualType")}}">
                {{ csrf_field() }}

                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-2">
                      <label for="type_annual">{{trans('project/performance-information/other_financial_metrics.type')}}</label>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <div class="form-line">
                        <input id="type_annual" type="text" class="form-control" name="type_annual" {{old('type_annual')}}>
                      </div>
                    </div>
                  </div> {{-- End group --}}
                </div> {{-- End row --}}
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-2">
                      <label for="unit">{{trans('project/performance-information/other_financial_metrics.unit')}}</label>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <div class="form-line">
                        <input id="unit" type="text" class="form-control" name="unit" {{old('unit')}}>
                      </div>
                    </div>
                  </div> {{-- End group --}}
                </div> {{-- End row --}}
                <button type="submit" class="btn btn-large btn-primary waves-effect" data-type="save_draft">{{__("general.save")}}</button>
                <button class="btn btn-large btn-primary waves-effect" data-dismiss="modal">{{__("general.close")}}</button>
              </form>

          </div>{{-- Body --}}
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect">{{trans('user.save')}}</button>
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('user.back')}}</button>
          </div> --}}
        </div>
      </div>
    </div>

    @if (Auth::user()->canDelete())
        <form id="frmDelete" method="post" action="{{route("project.performance-information.other-financial-metrics.deleteAnnual")}}">
          {{ csrf_field() }}
          <input type="hidden" name="other_financial_id" value="">
          <input type="hidden" name="project_id" value="{{$project->id}}">
        </form>
    @endif

    @component('components.request-modification-modal')
    @endcomponent

@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    @component('back.components.enable-section-js', ["section" => "pi","project_id" => $project->id])
    @endcomponent

    @component('back.components.enable-subsection-js', ["section" => "af","project_id" => $project->performanceInformation->id])
    @endcomponent

    @component('back.components.enable-subsection-2-js', ["section" => "tf","project_id" => $project->performanceInformation->id])
    @endcomponent


    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/jquery-spinner/jquery.spinner.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('back/plugins/editable-table/mindmup-editabletable.js') }}"></script>

    <script>

    @if (!Auth::user()->isAdmin() && !Auth::user()->isProjectCoordinator())
        $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
    @endif


    var project_id = {{$project->id}};
    $('[data-toggle="tooltip"]').tooltip({'container':'body'});



    /*
     * Timeless function multiple select
     */

    $("[name='timeless_type']").change(function(){
      var vals = $(this).val();
      $(".timelessInputs").hide();
      if(vals != null){
        if(vals.length > 0){
          $.each(vals, function(index, val){
            $('.timelessInputs[data-id=' + val + ']').show();
          });
        }
      }
      else{

      }

    })

    /*
     * Form validation
     */

    //Annual forms
    //frmAnnualTypes
    var frmAnnualTypes = $("#frmAnnualTypes").validate({
      ignore: ":hidden:not(.selectpicker)",
      /* Onkeyup
       * For not sending an ajax request to validate the email each time till the typing is done.
       */
      /*onkeyup: false,*/
      rules: {
        'type_annual': {
            required: true
        },
        'unit': {
            required: true
        },
      },
      submitHandler: function (form) {
          form.submit();
      }
    }); //Validation end

    var frmAnnual = $("#frmAnnual").validate({
      ignore: ":hidden:not(.selectpicker)",
      /* Onkeyup
       * For not sending an ajax request to validate the email each time till the typing is done.
       */
      /*onkeyup: false,*/
      rules: {
        'income_metric': {
            required: true
        },
        'year': {
            required: true
        },
        'value': {
            required: true
        },
      },
      submitHandler: function (form) {
          form.submit();
      }
    }); //Validation end

    $("[name='income_metric']").on('change', function(){

      frmAnnual.element($(this));
    });

    /*
     * Modals
     */

    $("#btnOpenAnnualTypeModal").click(function(ev){
      ev.preventDefault();

      $("#modalAnnualType").modal('toggle');

    });

    $("#btnOpenTimelessTypeModal").click(function(ev){
      ev.preventDefault();

      $("#modalTimelessType").modal('toggle');

    });


    @if (Auth::user()->canDelete())
        /*
         * Delete group cell record
         */

        $('.delete-field').click(function(ev){

          var id = $(this).data('id');

          swal({
              title: '{{ trans('messages.confirm') }}',
              text: "{{trans('project/performance-information/other_financial_metrics.delete_confirm')}}",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{ trans('messages.yes_delete') }}",
              cancelButtonText: "{{ trans('general.no') }}",
              closeOnConfirm: true
          },
          function(){
            $("[name='other_financial_id']").val(id);
            $("#frmDelete").submit();

          });
        });
    @else
        $('button.delete-field').remove();
    @endif


    //Form timeless type

    var frmTimelessType = $("#frmTimelessType").validate({
      ignore: ":hidden:not(.selectpicker)",
      /* Onkeyup
       * For not sending an ajax request to validate the email each time till the typing is done.
       */
      /*onkeyup: false,*/
      rules: {
        'type_timeless': {
            required: true
        },
      },
      submitHandler: function (form) {
          form.submit();
      }
    }); //Validation end

    //Frm timeless

    var frmTiemeless = $("#frmTiemeless").validate({

        /* Onkeyup
         * For not sending an ajax request to validate the email each time till the typing is done.
         */
        /*onkeyup: false,*/
        submitHandler: function (form, event) {



          event.preventDefault();
          var timelessVariables = {
            variables: [],
            variablesDelete:[],
            project_id: project_id,
          }
          timelessVariables.project_id = project_id;
          $(".timeless_vars").each(function(index, object){
            if($(this).is(":visible")){
              timelessVariables.variables.push({id: $(this).data('id'), value: $(this).val(), id_exists: $(this).data('id-exists')})
            }else{
              timelessVariables.variablesDelete.push($(this).data('id'));
            }
          });
          var message;

          if(timelessVariables.variables.length == 0){
            message = "{{trans('project/performance-information/other_financial_metrics.save_confirm_none_selected')}}"
          }else{
            message = "{{trans('project/performance-information/other_financial_metrics.save_confirm')}}"
          }

          swal({
              title: '{{ trans('messages.confirm') }}',
              text: message,
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{ trans('messages.yes_proceed') }}",
              cancelButtonText: "{{ trans('general.no') }}",
              closeOnConfirm: true
          },
          function(){
            $('.page-loader-wrapper').show();
            $.ajax({
              url: '{{route('project.performance-information.other-financial-metrics.storeTimeless')}}',
              type: 'POST',
              data: timelessVariables,
              success: function(data){
                if(data.status){
                  swal({
                      title: "{{trans('messages.success')}}",
                      text: "{{trans('project/performance-information/other_financial_metrics.success')}}",
                      type: "success",
                      html: true
                  }, function(){
                  });

                }
                $('.page-loader-wrapper').fadeOut();

              },
              error: function(data){
                if(!data.errors){
                  laravelErrors(data);
                }
                $('.page-loader-wrapper').fadeOut();

              }
            });
          });



        }
      }); //Validation end

    $(".timeless_variables").each(function(){
         $(this).rules("add", {
          required: true,
          digits: true
         });
      });


    /*jQuery("[name='timeless_variable']").each(function(e) {
      jQuery(this).rules('add', {
          minlength: 2,
          required: true
          })
      });
    */

   /*
    * Table editable
    */

    @if (!Auth::user()->isViewOnly())
        $('table').editableTableWidget();
    @endif

   $('table td').on('validate', function(evt, value) {

      var fl1 = isNaN(parseFloat(value))
      var fl2 = isFinite(value);
      if(!fl1 && fl2){
       /*$(this).removeClass('boxShadow');*/
       return true
      }else{
       /*$(this).addClass('boxShadow');*/
       return false;
      }
     /*return !isNaN(parseFloat(value)) && isFinite(value);*/
     /*return false;*/
   });

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

    $(".type").click(function(event){
        event.preventDefault();
        var timelessVariables = {
          variables: [],
          project_id: project_id,
            submit_type: "",

        }
        $('.page-loader-wrapper').show();
        $.each($(".record"), function(index, object){
          timelessVariables.variables.push({
            id: $(object).data('id'),
            value: $(object).html()
          });
        });
        timelessVariables.submit_type = $(this).parent().parent().find('input[name="submit-type"]').val();


        $.ajax({
          url: '{{route('project.performance-information.other-financial-metrics.updateAnnual')}}',
          type: 'POST',
          data: timelessVariables,
          success: function(data){
            if(data.status){
              swal({
                  title: "{{trans('messages.success')}}",
                  text: "{{trans('project/performance-information/other_financial_metrics.success')}}",
                  type: "success",
                  html: true
              }, function(){
              });
            }
            $('.page-loader-wrapper').fadeOut();
          },
          error: function(data){
            if(!data.errors){
              laravelErrors(data);
            }
            $('.page-loader-wrapper').fadeOut();

          }
          });
      });


    @if (count($errors) > 0 && (old('type_annual') || old('unit') ))
      $("#modalAnnualType").modal('toggle');
    @endif

    @if (count($errors) > 0 && old('type_timeless'))
      $("#modalTimelessType").modal('toggle');
    @endif



    </script>
    <script>
    @if (session('status') == true)
      swal({
          title: "{{trans('messages.success')}}",
          text: "{{session('message')}}",
          type: "success",
          html: true
      }, function(){
      });
    @elseif(session('error') == true)
      swal({
          title: "{{trans('messages.error')}}",
          text: "{{session('error')}}",
          type: "error",
          html: true
      }, function(){
      });
    @endif
    </script>
@endsection
