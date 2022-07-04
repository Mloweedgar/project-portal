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
        <a href="{{ route('documentation').'#performance_assessments' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.performance_information_title'),"visible" => $project->performance_information_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project.section.performance_information.performance-assessments")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $project->performanceInformation->performance_assessment_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "pa","project" => $project->id])
    @endcomponent --}}

  @if (!Auth::user()->isViewOnly())
      <div class="row content-row">

          <div class="col-md-12">

          <div class="card">
              <div class="card-header header" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                  <h2><i class="material-icons">add_box</i> <span>{{__("project/performance-information/performance_assessments.add_group")}}</span> <i class="keyboard_arrow material-icons">keyboard_arrow_down</i></h2>
              </div>
              <div class="card-body body @if (count($errors) > 0 && !old('category_name') || (isset($flag))) is-visible @else not-visible @endif">
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
                  <form id="dynamic-form-validation" method="post" action="{{route("project.performance-information.performance-assessments.store")}}" @if (count($errors) == 0 ) hidden @endif>
                      {{ csrf_field() }}
                      <input type="hidden" name="project_id" value="{{$project->id}}">
                      <div class="row"> {{-- Row --}}
                        {{-- Group --}}
                        <div class="col-md-2">
                            <label for="title">{{trans('project/performance-information/performance_assessments.title')}}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                  <input type="text" id="title" class="form-control" name="title" value ="{{old('title')}}" required>
                                </div>
                            </div>
                        </div> {{-- End group --}}
                      </div> {{-- End row --}}

                      <div class="row"> {{-- Row --}}
                        {{-- Group --}}
                        <div class="col-md-2">
                          <label for="description">{{trans('project/performance-information/performance_assessments.description')}}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                  <textarea rows="5" id="description" name="description" class="textarea form-control no-resize" placeholder="{{trans('project/performance-information/performance_assessments.description_placeholder')}}" required>{{old('penalty-abatement-contract')}}</textarea>
                                </div>
                            </div>
                        </div> {{-- End group --}}
                      </div> {{-- End row --}}
                      @component('components.uploader', [
                            'projectAddress' => $project->id,
                            'sectionAddress' => 'pa',
                            'positionAddress' => -1
                       ])@endcomponent

                      @component('back.components.project-buttons', [
                          'section_fields' => [ 'title', 'description'],
                          'position'=>0,
                          'section'=>'pa',
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

    @if(count($performance_assessments) > 0)
        <ul id="sortable">
        @foreach($performance_assessments as $performance_assessment)
                <li class="ui-state-default" data-order="{{$performance_assessment->position}}">
                    <div class="row content-row toggleable-wrapper">
              <div class="col-md-12">
                  <div class="card dynamic-card toggleable-container">
                      <div class="header card-header-static toggleable-card">
                          <h2>
                          @component('back.components.draft-chip',['draft'=>$performance_assessment->draft])
                          @endcomponent
                          <span>{{$performance_assessment->name}}</span>
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'position' => $performance_assessment->id,
                                'status' => $performance_assessment->published,
                                'route' => route('project.performance-information.performance-assessments.visibility')
                            ])@endcomponent
                              <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$performance_assessment->id}}"></i></h2>
                  </div>
                      <div class="body not-visible" data-status="0">

                    <form method="post" action="{{route("project.performance-information.performance-assessments.update")}}" class="formsPerformanceAssesments">
                      {{ csrf_field() }}
                      <input type="hidden" name="performance_assessment_id" value="{{$performance_assessment->id}}">
                      <div class="row"> {{-- Row --}}
                        {{-- Group --}}
                        <div class="col-md-2">
                            <label for="title">{{trans('project/performance-information/performance_assessments.title')}}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                  <input type="text" id="title" class="form-control" name="title" value ="{{$performance_assessment->name}}">
                                </div>
                            </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}
                        <div class="row"> {{-- Row --}}
                          {{-- Group --}}
                          <div class="col-md-2">
                            <label for="description">{{trans('project/performance-information/performance_assessments.description')}}</label>
                          </div>
                          <div class="col-md-10">
                              <div class="form-group">
                                  <div class="form-line">
                                    <textarea rows="5" id="description" name="description" class="textarea form-control no-resize" placeholder="{{trans('project/performance-information/performance_assessments.description_placeholder')}}">{{$performance_assessment->description}}</textarea>
                                  </div>
                              </div>
                          </div> {{-- End group --}}
                        </div> {{-- End row --}}
                        @component('components.uploader', [
                            'projectAddress' => $project->id,
                            'sectionAddress' => 'pa',
                            'positionAddress' => $performance_assessment->id
                        ])@endcomponent

                        <input type="hidden" name="submit-type">
                        @component('back.components.project-buttons', [
                            'section_fields' => [ 'title', 'description'],
                            'position'=>$performance_assessment->id,
                            'section'=>'pa',
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
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    @component('back.components.enable-section-js', ["section" => "pi","project_id" => $project->id])
    @endcomponent

    @component('back.components.enable-subsection-js', ["section" => "pa","project_id" => $project->performanceInformation->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

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
                url: '{{ route('project.performance-information.performance-assessments.order') }}',
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

        @if (Auth::user()->canDelete())
            /*
             Delete group
             */

            $('.delete-group').click(function(ev){
              ev.preventDefault();


              var id = $(this).data('id');

              var card = $(this).closest('.card');

              swal({
                  title: '{{ trans('messages.confirm') }}',
                  text: "{{trans('project/performance-information/performance_assessments.delete_confirm')}}",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "{{ trans('messages.yes_delete') }}",
                  cancelButtonText: "{{ trans('general.no') }}",
                  closeOnConfirm: true
              },
              function(){
                  $.ajax({
                      url: '{{ route('project.performance-information.performance-assessments.delete') }}',
                      type: 'DELETE',
                      data: { id: id },
                      dataType: "json",
                      beforeSend: function() {
                          $('.page-loader-wrapper').show();
                      },
                      success: function(data){
                          if (data.status) {

                              swal({
                                  title: "{{trans('messages.success')}}",
                                  text: "{{ trans('project/performance-information/performance_assessments.deleted') }}",
                                  type: "success",
                                  html: true
                              }, function(){

                              });
                              card.parent().remove();
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
                          $('.page-loader-wrapper').fadeOut();
                      }
                  });
              });
            });
        @else
            $('i.delete-group').remove();
        @endif


        $(".formsPerformanceAssesments").each(function(){
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
                description:{
                  required: true
                },
              },
              submitHandler: function (form) {
                 if ($('#upload-button').length > 0) {
                      qq(document.getElementById("upload-button")).attach('click', function() {
                          // Start uploading the files only when the user click the action button
                          // This is applied when adding but not editing
                          uploader.uploadStoredFiles();
                      });
                 }

                  form.submit();
              }
            }); //Validation end
        });



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

    </script>

    <script>
    @if (session('status') == true)
          swal({
              title: "{{trans('messages.success')}}",
              text: "{{trans('project/performance-information/performance_assessments.success')}}",
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
