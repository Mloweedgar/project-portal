@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/jquery-spinner/bootstrap-spinner.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/project/performance_information.css') }}" rel="stylesheet">




@endsection

@section('content')
    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @component('back.components.enable-section', ["section" => trans('project.section.performance_information_title'),"visible" => $project->performance_information_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project.section.performance_information.income_statements_metrics")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $project->performanceInformation->income_statements_active])
    @endcomponent


    <div class="row content-row">
        @if(Auth::user()->canCreate())
            <div class="col-md-12">
              <div class="card">
                <div class="header card-header-static">
                    <h2><i class="material-icons">add_box</i> <span>{{trans('project/performance-information/income_statements_metrics.add_new_income_metric')}}</span></h2>
                </div>
                <div class="body">
                  <form method="post" action="{{route("project.performance-information.income-statements-metrics.store")}}" id="frmIncome">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class="row"> {{-- Row --}}
                      {{-- Group --}}
                      <div class="col-md-1">
                          <label for="income_metric" >{{trans('project/performance-information/income_statements_metrics.income_statement_metric')}}</label>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <div class="form-line">
                                <select class="form-control show-tick" id="income_metric" name="income_metric" title="-- {{trans('general.choose-option')}} --">
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}" {{ (old("type") == $type->id ? "selected":"") }}> {{$type->name}} {{$type->currency->symbol}}</option>
                                    @endforeach
                                </select>
                              </div>
                          </div>
                      </div> {{-- End group --}}
                      <div class="col-md-3">
                        <button id="btnOpenNewTypeModal" class="btn btn-primary">{{trans('project/performance-information/income_statements_metrics.add_new_income_metric_type')}}</button>
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

            @foreach($tables as $table)
            <div class="col-md-12 m-t-25">
            <div class="m-b-10 title-table">
                @component('back.components.draft-chip',['draft'=>$draft])
                @endcomponent
                {{$table["type"]}} ({{$table["currency"]}}) <div class="material-icons info-material-icons editabletooltip" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.table_editable') }}">info_outline</div></div>
            @foreach($table["records"] as $record)
                <div class="table-responsive" id="prmSectors">
                    <table class="table table-modal">
                      <thead>
                        <tr>
                          <th class="no-cursor w-200px">{{trans('project/performance-information/income_statements_metrics.year')}}</th>
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
                          <th class="no-cursor">{{trans('project/performance-information/income_statements_metrics.income_statement_metric')}}</th>
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
                @component('back.components.project-buttons',['position'=>0,'section'=>'ism','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                @endcomponent
            </div>
            @endif
        </div>


      <div class="modal fade in" tabindex="-1" role="dialog" id="modalType">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <form method="post" id="frmTypes" action="{{route("project.performance-information.income-statements-metrics.storeType")}}">
                  {{ csrf_field() }}
                  <input type="hidden" name="project_id" value="{{$project->id}}">
                  <div class="row"> {{-- Row --}}
                    {{-- Group --}}
                    <div class="col-md-2">
                        <label for="name">{{trans('project/performance-information/income_statements_metrics.income-statement-metric-name')}}</label>
                    </div>
                    <div class="col-md-10">
                      <div class="form-group">
                        <div class="form-line">
                          <input id="name" type="text" class="form-control" name="name" {{old('name')}}>
                        </div>
                      </div>
                    </div> {{-- End group --}}
                  </div> {{-- End row --}}

                  <div class="row"> {{-- Row --}}
                    {{-- Group --}}
                    <div class="col-md-2">
                        <label for="currency_id">{{trans('project/performance-information/income_statements_metrics.currency')}}</label>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="form-line">
                              <select class="form-control show-tick" id="currency" name="currency_id">
                                  @foreach($currencies as $currency)
                                      <option value="{{$currency->id}}" {{ (old("currency") == $currency->id ? "selected":"") }}> {{$currency->name}} ({{$currency->symbol}})</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div> {{-- End group --}}
                  </div> {{-- End row --}}
                  <input type="hidden" name="submit-type">
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

    </div>

    @if (Auth::user()->canDelete())
        <form id="frmDelete" method="post" action="{{route("project.performance-information.income-statements-metrics.delete")}}">
          {{ csrf_field() }}
          <input type="hidden" name="income_statemet_id" value="">
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

    @component('back.components.enable-subsection-js', ["section" => "ism","project_id" => $project->performanceInformation->id])
    @endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/fineuploader-core/all.fine-uploader.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('back/plugins/jquery-spinner/jquery.spinner.js') }}"></script>
    <script src="{{ asset('back/plugins/editable-table/mindmup-editabletable.js') }}"></script>



    <script>

    @if (!Auth::user()->isAdmin() && !Auth::user()->isProjectCoordinator())
        $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
    @endif

    $('select').selectpicker('refresh');
    $('[data-toggle="tooltip"]').tooltip({'container':'body'});
    /*
     * Global variabbles
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

    var project_id = {{$project->id}};

    $("[name='currency_id']").on('change', function(){

      validatorType.element($(this));
    });
    $("[name='income_metric']").on('change', function(){


      validatorFrmIncome.element($(this));
    });

    $("#btnOpenNewTypeModal").click(function(ev){
      ev.preventDefault();
      /*alert();*/

      $("#modalType").modal('toggle');

    });

    var incomeMetric = {
      incomes: [],
      project_id: project_id,
      submit_type: "",
    };
    $(".type").click(function(event){
        event.preventDefault();

        $('.page-loader-wrapper').show();
        $.each($(".record"), function(index, object){
          incomeMetric.incomes.push({
            id: $(object).data('id'),
            value: $(object).html()
          })

        });
        incomeMetric.submit_type = $(this).parent().parent().find('input[name="submit-type"]').val();

        $.ajax({
          url: '{{route("project.performance-information.income-statements-metrics.update")}}',
          type: 'POST',
          data: incomeMetric,
          success: function(data){
            if(data.status){
              swal({
                  title: "{{trans('messages.success')}}",
                  text: "{{trans('project/performance-information/income_statements_metrics.success')}}",
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

    var validatorType = $("#frmTypes").validate({
        ignore: ":hidden:not(.selectpicker)",
        /* Onkeyup
         * For not sending an ajax request to validate the email each time till the typing is done.
         */
        /*onkeyup: false,*/
        rules: {
          'currency_id': {
              required: true
          },
          'name' :{
            required: true
          },
        },
        submitHandler: function (form) {
            console.log("Submitted!");
            form.submit();
        }
      }); //Validation end

    var validatorFrmIncome = $("#frmIncome").validate({
        ignore: ":hidden:not(.selectpicker)",
        /* Onkeyup
         * For not sending an ajax request to validate the email each time till the typing is done.
         */
        /*onkeyup: false,*/
        rules: {
          'income_metric': {
              required: true
          },
          'year' :{
            required: true
          },
          'value' :{
            required: true,
            number: true,

          },
        },
        submitHandler: function (form) {
            console.log("Submitted!");
            form.submit();
        }
      }); //Validation end


    @if (Auth::user()->canDelete())
        /*
         * Delete group cell record
         */
        $('.delete-field').click(function(ev){

          var id = $(this).data('id');

          swal({
              title: '{{ trans('messages.confirm') }}',
              text: "{{trans('project/performance-information/income_statements_metrics.delete_confirm')}}",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{ trans('messages.yes_delete') }}",
              cancelButtonText: "{{ trans('general.no') }}",
              closeOnConfirm: true
          },
          function(){
            $("[name='income_statemet_id']").val(id);
            $("#frmDelete").submit();
          });
        });
    @else
        $('button.delete-field').remove();
    @endif

    /**
     * Card Behaviour
     */
    $('#card-header').click(function () {

        // Get status of the box
        var headerElement = $('#card-header');
        var bodyElement = $('#card-body');

        var status = headerElement.data("status");

        if(!status){

            // Card closed, we proceed to open
            bodyElement.removeClass("not-visible").addClass("is-visible");

            // Update the status of the card
            headerElement.data("status", 1);

            bodyElement.find('form').show();

            // Update the keyboard_arrow of the box
            $('#keyboard_arrow').html("keyboard_arrow_up");

        } else {

            // Card open, we proceed to close
            bodyElement.removeClass("is-visible").addClass("not-visible");

            // Update the status of the card
            headerElement.data("status", 0);

            bodyElement.find('form').hide();

            // Update the keyboard_arrow of the box
            $('#keyboard_arrow').html("keyboard_arrow_down");

        }

    });

     @if (count($errors) > 0 && (old('name') || old('currency')))
      $("#modalType").modal('toggle');
    @endif

    </script>

  <script>
  @if (session('error') == true)
       swal({
           title: "{{trans('messages.error')}}",
           text: "{{session('error')}}",
           type: "error",
           html: true
       }, function(){
       });
     @elseif(session('status') == true)
         swal({
             title: "{{trans('messages.success')}}",
             text: "{{session('message')}}",
             type: "success",
             html: true
         }, function(){
         });
       @endif
     </script>
@endsection
