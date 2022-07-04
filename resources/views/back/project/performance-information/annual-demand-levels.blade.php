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
        <h1 class="content-title-project-subsection">{{trans("project.section.performance_information.annual_demand_levels")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $project->performanceInformation->annual_demmand_active])
    @endcomponent

        <div class="row content-row">
            {{-- End annual demand type --}}
            @if(Auth::user()->canCreate())
                <div class="col-md-12">
                  <div class="card">
                    <div class="header card-header-static">
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/performance-information/annual_demand_levels.add_annual_demmand")}}</span></h2>
                    </div>

                    <div class="body">
                      <form id="frmAnnualDemand" method="post" action="{{route("project.performance-information.annual-demand-levels.store")}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="project_id" value="{{$project->id}}">

                        <div class="row"> {{-- Row --}}
                         {{-- Group --}}
                         <div class="col-md-1">
                             <label for="type_id" >{{trans('project/performance-information/annual_demand_levels.type-demand')}}</label>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <div class="form-line">
                                   <select class="form-control show-tick selectpicker" name="type_id" title="-- {{trans('general.choose-option')}} --">
                                       @foreach($types as $type)
                                           <option value="{{$type->id}}" {{ (old("type_id") == $type->id ? "selected":"") }}> {{$type->type}} <p style="text-transform: uppercase;">({{$type->unit}})</p></option>
                                       @endforeach
                                   </select>
                                 </div>
                             </div>
                         </div> {{-- End group --}}
                         <div class="col-md-3">
                           <button id="btnOpenNewTypeModal" class="btn btn-primary">{{__("project/performance-information/annual_demand_levels.add_new_type")}}</button>
                         </div>
                       </div>  {{-- Row end --}}
                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-1">
                              <label for="year" class="m-t-7" >{{trans('project/performance-information/annual_demand_levels.year')}}</label>
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
                              <label for="value" >{{trans('project/performance-information/annual_demand_levels.annual-demand')}}</label>

                          </div>
                          <div class="col-md-11">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input id="value" type="text" class="form-control" name="value" {{old('value')}}>
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
                    {{$table["type"]}} ({{$table["unit"]}}) <div class="material-icons info-material-icons editabletooltip" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.table_editable') }}">info_outline</div></div>
                @foreach($table["records"] as $record)
                    <div class="table-responsive" id="prmSectors">
                        <table class="table table-modal" style="width:100%">
                          <thead>
                            <tr>
                              <th class="no-cursor" style="width: 200px;">{{trans('general.year')}}</th>
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
                              <th class="no-cursor" style="width: 200px;">
                                {{trans('project/performance-information/annual_demand_levels.annual-demand')}}</th>
                              @foreach($record as $cell)
                                <td class="record" data-id="{{$cell["id"]}}">{{$cell["value"]}} {{-- <i class="material-icons" style="color:#d2d5da; vertical-align: middle">mode edit</i> --}}</td>
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
                    @component('back.components.project-buttons',['position'=>0,'section'=>'dl','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                    @endcomponent
                </div>
            @endif
          </div> {{-- Content row --}}


      </div> {{-- Content row --}}
    <div class="modal fade in" tabindex="-1" role="dialog" id="modalType">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            @if (count($errors) > 0 && (old('type') || old('unit')))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" id="frmTypes" action="{{route("project.performance-information.annual-demand-levels.storeType")}}")>
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-2">
                      <label for="type">{{trans('project/performance-information/annual_demand_levels.type-demand')}}</label>
                  </div>
                  <div class="col-md-10">
                      <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="type" class="form-control" name="type" value ="{{old('type')}}">
                          </div>
                      </div>
                  </div> {{-- End group --}}
                </div> {{-- End row --}}
                <div class="row"> {{-- Row --}}
                  {{-- Group --}}
                  <div class="col-md-2">
                      <label for="unit">{{trans('project/performance-information/annual_demand_levels.unit')}}</label>
                  </div>
                  <div class="col-md-10">
                      <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="unit" class="form-control" name="unit" value="{{old('unit')}}">
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
        <form id="frmDelete" method="post" action="{{route("project.performance-information.annual-demand-levels.delete")}}">
          {{ csrf_field() }}
          <input type="hidden" name="annual_demmand_id" value="">
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

    @component('back.components.enable-subsection-js', ["section" => "dl","project_id" => $project->performanceInformation->id])
    @endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
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

    /*
     * Modal type
     */
    $("#frmTypes").validate({
          ignore: ":hidden:not(.selectpicker)",
          /* Onkeyup
           * For not sending an ajax request to validate the email each time till the typing is done.
           */
          /*onkeyup: false,*/
          rules: {
            'type': {
                required: true
            },
            'unit' :{
              required: true
            },
          },
          submitHandler: function (form) {
              console.log("Submitted!");
              form.submit();
          }
        }); //Validation end

    $("#btnOpenNewTypeModal").click(function(ev){

      ev.preventDefault();
      $("#modalType").modal('toggle');

    });

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

    /*
     * Validatior
     */
    $("select").on('change', function(){
            /*var optionVal = $(this + " option:selected")*/
        /*validator.element($(this));*/
    });
    var annualDemands = {
      demmands: [],
      project_id: project_id,
        submit_type: "",


    }
    $(".type").click(function(event){
        event.preventDefault();

        $('.page-loader-wrapper').show();
        $.each($(".record"), function(index, object){
          annualDemands.demmands.push({
            id: $(object).data('id'),
            value: $(object).html()
          })

        });
        annualDemands.submit_type = $(this).parent().parent().find('input[name="submit-type"]').val();


        $.ajax({
          url: '{{route("project.performance-information.annual-demand-levels.update")}}',
          type: 'POST',
          data: annualDemands,
          success: function(data){
            if(data.status){
              swal({
                  title: "{{trans('messages.success')}}",
                  text: "{{trans('project/performance-information/annual_demand_levels.success')}}",
                  type: "success",
                  html: true
              }, function(){
                  location.reload();
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

    /*
     * Validatior
     */
    $("select").on('change', function(){
            /*var optionVal = $(this + " option:selected")*/
        validatorAnual.element($(this));
    });
    var validatorAnual = $("#frmAnnualDemand").validate({
        ignore: ":hidden:not(.selectpicker)",
        /* Onkeyup
         * For not sending an ajax request to validate the email each time till the typing is done.
         */
        /*onkeyup: false,*/
        rules: {
          'type_id': {
              required: true
          },
          'year' :{
            required: true
          },
          'value' :{
            required: true,
            number: true
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
              text: "{{trans('project/performance-information/annual_demand_levels.delete_confirm')}}",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{ trans('messages.yes_delete') }}",
              cancelButtonText: "{{ trans('general.no') }}",
              closeOnConfirm: true
          },
          function(){
            $("[name='annual_demmand_id']").val(id);
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
    @if (count($errors) > 0 && (old('type') || old('unit')))
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
