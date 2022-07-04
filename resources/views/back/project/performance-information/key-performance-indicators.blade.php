@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/jquery-spinner/bootstrap-spinner.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/project/performance_information.css') }}" rel="stylesheet">

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#key_performance_information' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.performance_information_title'),"visible" => $project->performance_information_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project.section.performance_information.key_performance_indicators")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $project->performanceInformation->key_performance_active])
    @endcomponent


  <div class="row content-row">

    @if (!Auth::user()->isViewOnly())

    {{-- Timeless variables card --}}
      <div class="col-md-12">
        <div class="card">
          <div class="header card-header-static">
              <h2><i class="material-icons">add_box</i> <span>{{__("project/performance-information/key_performance_indicators.add_new_indicator")}}</span></h2>
          </div>
          <div class="body">
            <form method="post" action={{route("project.performance-information.key-performance-indicators.store")}} id="frmKeyPerformance">
              {{ csrf_field() }}
              <input type="hidden" name="project_id" value="{{$project->id}}">
              <div class="row"> {{-- Row --}}
                {{-- Group --}}
                <div class="col-md-2">
                    <label for="kpi_type" class="m-t-7">{{trans('project/performance-information/key_performance_indicators.kpi')}}</label>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-line">
                          <select class="form-control show-tick selectpicker" id="kpi_type" name="kpi_type">
                              <option value="">-- {{trans('general.choose-option')}} --</option>
                              @foreach($types as $type)
                                  <option value="{{$type->id}}">{{$type->name}} ({{$type->unit}})</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                </div> {{-- End group --}}
                    <div class="col-md-3">
                      <button id="btnOpenKPIModalType" class="btn btn-primary">{{trans('project/performance-information/key_performance_indicators.add_new_kpi_type')}}</button>
                    </div>
              </div>  {{-- Row end --}}
             <div class="row"> {{-- Row --}}
               {{-- Group --}}
               <div class="col-md-2">
                   <label for="year" class="m-t-7">{{trans('project/performance-information/key_performance_indicators.year')}}</label>
               </div>
               <div class="col-md-2">
                 <div class="input-group spinner" data-trigger="spinner">
                     <div class="form-line">
                         <input type="text" class="form-control text-center" value="@if(old('year')) {{old('year')}} @else {{$year}}@endif" data-min="1000" data-max="3000" name="year">
                     </div>
                     <span class="input-group-addon">
                         <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                         <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                     </span>
                 </div>
               </div>  {{-- Row end --}}
              </div>
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-2">
                      <label for="target" class="m-t-7">{{trans('project/performance-information/key_performance_indicators.target')}}</label>
                  </div>
                  <div class="col-md-10">
                      <div class="form-group">
                          <div class="form-line">
                            <input type="text" class="form-control" id="target" name="target" value="{{old('target')}}">
                          </div>
                      </div>
                  </div> {{-- End group --}}
                </div>  {{-- Row end --}}
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-2">
                      <label for="achievement" class="m-t-7">{{trans('project/performance-information/key_performance_indicators.achievement')}}</label>
                  </div>
                  <div class="col-md-10">
                      <div class="form-group">
                          <div class="form-line">
                            <input type="text" class="form-control" id="achievement" name="achievement" value="{{old('achievement')}}">
                          </div>
                      </div>
                  </div> {{-- End group --}}
                </div>  {{-- Row end --}}
                  @component('back.components.project-buttons', [
                      'section_fields' => [ 'kpi_type', 'year', 'target', 'achievement' ],
                      'position'=>0,
                      'section'=>'kpi',
                      'project'=>$project->id,
                      'hasCoordinators'=>$hasCoordinators
                  ])
                  @endcomponent
            </form>
            </div>
          </div>
        </div>
      @endif

      @if (count($arrays) === 0)
        @component('back.components.no-results')
        @endcomponent
      @endif

        @foreach($arrays as $table)
          <div class="col-md-12 m-t-25">
          <div class="m-b-10 title-table">
              @component('back.components.draft-chip',['draft'=>$draft])
              @endcomponent
              {{__('project/performance-information/key_performance_indicators.existing_key_performance')}}
              <div class="material-icons info-material-icons editabletooltip" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.table_editable') }}">info_outline</div></div>
            <div class="table responsive">
              <table class="table table-modal">
                <thead>
                  <tr>
                    <th class="w-150px">{{trans('project/performance-information/annual_demand_levels.year')}}</th>
                    @foreach($table["years"] as $years)
                      <th class="years" colspan="4" data-year="{{$years["year"]}}">{{$years["year"]}}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  {{-- {{dd($table)}} --}}
                  <tr>
                    <th></th>
                    @for($i = 0; $i < count($table["years"]); $i++)
                      <th class="ta" colspan="2">{{trans('project/performance-information/key_performance_indicators.target')}}</th>
                      <th class="ta" colspan="2">{{trans('project/performance-information/key_performance_indicators.achievement')}}</th>
                    @endfor
                  </tr>
                  @foreach($table["kpis"] as $keyY => $kpi)
                    <tr data-type="{{$kpi["type_id"]}}">
                      <th class="no-cursor">
                        <div class="edit head-col">{{$kpi["type"]["name"]}} ({{$kpi["type"]["unit"]}})</div>
                        <div class="edit edit-btn">
                          <button type="submit" class="pull-right btn btn-default delete-field" data-id="">
                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                          </button>
                        </div>
                      </th>
                      @foreach($table["records"][$kpi["type"]["id"]] as $keyR => $record)
                        @if($record)
                          <td colspan="2" class="record target" data-id="{{$record["id"]}}" data-name="target">{{$record["target"]}}</td>
                          <td colspan="2" class="record achievement" data-id="{{$record["id"]}}" data-name="achievement">{{$record["achievement"]}}</td>
                        @else
                          <td colspan="2" class="record target" data-type="{{$kpi["type"]["id"]}}" data-name="target" data-year="{{$table["years"][$keyR]["year"]}}"></td>
                          <td colspan="2" class="record achievement" data-type="{{$kpi["type"]["id"]}}" data-name="achievement" data-year="{{$table["years"][$keyR]["year"]}}"></td>
                        @endif
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>
                </table>
            </div>
          </div>
        @endforeach

        @if(count($arrays) > 0)
          <div class="col-md-12">
              @component('back.components.project-buttons-kpi', [
                  'position'=>1,
                  'section'=>'kpi',
                  'project'=>$project->id
              ])
              @endcomponent
          </div>
        @endif
    </div>

        <div class="modal fade in" tabindex="-1" role="dialog" id="modalKPIType">
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

                <form method="post" id="frmKpiType" action="{{route("project.performance-information.key-performance-indicators.storeType")}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class="row"> {{-- Row --}}
                      {{-- Group --}}
                      <div class="col-md-1">
                          <label for="name">{{trans('general.name')}}</label>
                      </div>
                      <div class="col-md-11">
                        <div class="form-group">
                          <div class="form-line">
                            <input id="name" type="text" class="form-control" name="name" {{old('name')}}>
                          </div>
                        </div>
                      </div> {{-- End group --}}
                    </div> {{-- End row --}}
                    <div class="row"> {{-- Row --}}
                      {{-- Group --}}
                      <div class="col-md-1">
                          <label for="unit">{{trans('general.unit')}}</label>
                      </div>
                      <div class="col-md-11">
                        <div class="form-group">
                          <div class="form-line">
                            <input id="unit" type="text" class="form-control" name="unit" {{old('unit')}}>
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

    @if (Auth::user()->canDelete())
        <form id="frmDelete" method="post" action="{{route("project.performance-information.key-performance-indicators.Delete")}}">
          {{ csrf_field() }}
          <input type="hidden" name="type_id" value="">
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

    @component('back.components.enable-subsection-js', ["section" => "kpi","project_id" => $project->performanceInformation->id])
    @endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('back/plugins/jquery-spinner/jquery.spinner.js') }}"></script>
    <script src="{{ asset('back/plugins/editable-table/mindmup-editabletable.js') }}"></script>



    <script>

    @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
        $('table').editableTableWidget();
    @endif


    var project_id = {{$project->id}};
    $('[data-toggle="tooltip"]').tooltip({'container':'body'});


    var keyPerformanceIndicators = {
      newRecords: new Array(),
      existingRecords: new Array(),
      project_id: project_id,
        submit_type: "",

    };
    /*
      On every change td method, add to the array the value to save or update.
     */

    /*
     * Function
     * Update the data array for the key performance indicators
     */
    function updateData(array, obj){
      var objFound_bool = false;
      for (var i = 0; i < array.length; i++) {
        if(obj.id === array[i].id){
          objFound_bool = true;
          $.extend(array[i], obj);
          break;
        }
      }
      if(!objFound_bool){
        array.push(obj)
      }
      return array;
    }

    $('table td').on('validate', function(evt, value) {
      var td = $(this);
      var name = td.data('name');

      /*if(name == 'target' && value == ""){
        return false;
      }*/
      return true;

    });

    $('table td').on('change', function(evt, value) {
      var td = $(this);
      var name = td.data('name');

      // New records

      // Update records
      if(td.data('id') && !td.data('type')){
        var object = {
          id: td.data('id')
        }
        if(name == 'achievement'){
          object.achievement = value;
          object.target = td.prev('.target').html()
        }
        else if(name == 'target'){
          object.target = value;
          object.achievement = td.next('.achievement').html()
        }

        keyPerformanceIndicators.existingRecords = updateData(keyPerformanceIndicators.existingRecords, object);
        console.log(keyPerformanceIndicators.existingRecords)
      }
      else if(td.data('type') && !td.data('id')){
        var idO = td.data('type').toString() + td.data('year').toString();

        var object = {
          id: idO,
          type: td.data('type'),
          year: td.data('year')
        }
        if(name == 'achievement'){
          object.achievement = value
          object.target = td.prev('.target').html()
        }
        else if(name == 'target'){
          object.target = value;
          object.achievement = td.next('.achievement').html()
        }

        keyPerformanceIndicators.newRecords = updateData(keyPerformanceIndicators.newRecords, object);


      }
    });


    @if (Auth::user()->canDelete())
        /*
         * Delete group cell record
         */

        $('.delete-field').click(function(ev){

          var row = $(this).parent().parent().parent();
          var table = row.parent().parent();
          $('[name="years[]"]').remove();
          $.each(table.find('.years'), function(index, object){
            if($(object).data('year')){
              $("#frmDelete").append('<input type="hidden" name="years[]" value="' +$(object).data('year')+ '">')
            }
          });
          swal({
              title: '{{ trans('messages.confirm') }}',
              text: "{{trans('project/performance-information/key_performance_indicators.delete_confirm')}}",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{ trans('messages.yes_delete') }}",
              cancelButtonText: "{{ trans('general.no') }}",
              closeOnConfirm: true
          },
          function(){
            $("[name='type_id']").val(row.data('type'));
            $("#frmDelete").submit();
          });
        });
    @else
        $('button.delete-field').remove();
    @endif

    /*Save or update method*/

    $(".type").click(function(event){

        event.preventDefault();
        keyPerformanceIndicators.position = 1;
        keyPerformanceIndicators.section = 'kpi';
        keyPerformanceIndicators.reason = $('.rfm-kpi-reason-section textarea').val();

        if(keyPerformanceIndicators.existingRecords.length > 0 || keyPerformanceIndicators.newRecords.length > 0){
          $.ajax({
            @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
                url: '{{route("project.performance-information.key-performance-indicators.updateStore")}}',
            @else
                url: '{{route('request-modification/store')}}',
            @endif
            type: 'POST',
            data: keyPerformanceIndicators,
            success: function(data){
              if(data.status){
                  if (data.rfm) {
                      swal({
                          title: "{{trans('messages.success')}}",
                          text: "{{trans('task.request_modification_sent')}}",
                          type: "success",
                          html: true
                      }, function(){
                          window.location = '';
                      });

                  } else {
                      swal({
                          title: "{{trans('messages.success')}}",
                          text: "{{trans('project/performance-information/key_performance_indicators.success')}}",
                          type: "success",
                          html: true
                      }, function(){
                      });
                  }

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
        }
        // else{
        //     swal({
        //         title: "{{trans('messages.success')}}",
        //         text: "{{trans('project.key_performance_indicators_none')}}",
        //         type: "warning",
        //         html: true
        //     });
        // }

    });

    /*
     * Form validation
     */
     var frmKpiType = $("#frmKpiType").validate({
       ignore: ":hidden:not(.selectpicker)",
       /* Onkeyup
        * For not sending an ajax request to validate the email each time till the typing is done.
        */
       /*onkeyup: false,*/
       rules: {
         'name' :{
          required: true
         },
         'unit' :{
          required: true
         },
       },
       submitHandler: function (form) {
           form.submit();
       }
     }); //Validation end


     var frmKeyPerformance = $("#frmKeyPerformance").validate({
       ignore: ":hidden:not(.selectpicker)",
       /* Onkeyup
        * For not sending an ajax request to validate the email each time till the typing is done.
        */
       /*onkeyup: false,*/
       rules: {
         'kpi_type' :{
          required: true
         },
         'target' :{
          required: true
         },
         'achievement' :{
          required: false
         },
         'year' :{
          required: true
         },
       },
       submitHandler: function (form) {
           form.submit();
       }
     }); //Validation end

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


    $("#btnOpenKPIModalType").click(function(ev){
      ev.preventDefault();

      $("#modalKPIType").modal('toggle');
    });

    @if (count($errors) > 0 && (old('name')))
      $("#modalKPIType").modal('toggle');
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
    @elseif (session('status') == true)
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
