@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
    <h1 class="content-title-project-subsection">{{__("project/project-details/environment.title")}}</h1>
    </div>
    @component('back.components.enable-subsection', ["visible" => $projectDetail->environment_active])
    @endcomponent

        <div class="row content-row ">
            <div class="col-md-12">
                <div class="card dynamic-card ">
                    <div class="header card-header-static ">
                        <h2>
                            {{__("project/project-details/environment.title")}}
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'position' => $environment->id,
                                'status' => $environment->published,
                                'route' => route('project-details-environment/visibility')
                            ])@endcomponent
                        </h2>
                    </div>
                    <div class="body " data-status="0">
                        <form method="post" class="frmEditDocument" action="{{route("project-details-environment/edit")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$environment->id}}">
                            <div class="form-group">
                                <b>{{__("project/project-details/environment.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/environment.description-placeholder")}}">{{$environment->description}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'env',
                                // 'positionAddress' => $environment->id
                                'positionAddress' => 1 // can only be one
                            ])@endcomponent

                            <input type="hidden" name="submit-type">
                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'description' ],
                                'position'=>1,
                                'section'=>'env',
                                'project'=>$project->id,
                                'hasCoordinators'=>$hasCoordinators
                            ])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')

    @component('back.components.enable-section-js', ["section" => "pd","project_id" => $project->id])
    @endcomponent

    @component('back.components.enable-subsection-js', ["section" => "env","project_id" => $projectDetail->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

    <script>
    @if (!Auth::user()->isAdmin() && !Auth::user()->isProjectCoordinator())
        $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
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
                  text: "{{trans('project/project-details/environment.success')}}",
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
