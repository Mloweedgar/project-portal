<div class="project-buttons">
    @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
    <!-- Publish -->
        <input type="hidden" class="hidden" name="position" value="{{$position}}" />
        <input type="hidden" class="hidden" name="project" value="{{$project}}" />
        <input type="hidden" class="hidden" name="section" value="{{$section}}" />

        @if($position == 0 && ($section == 'ri' || $section == 'cm' || $section == 'kpi' || $section == 'par' || $section == 'pf' || $section=='ga' || $section=='aw' || $section=='awf'))
            <button type="submit" class="btn btn-large btn-primary waves-effect">{{__("general.publish")}}</button>
        @elseif($position == 0 || ($section == 'ga' && $position==-1))
            <a id="upload-button" class="btn btn-large btn-primary waves-effect">{{__("general.publish")}}</a>
        @else
            <button @if (isset($required_message)) data-required-message="{{$required_message}}" @endif type="button" class="publish-button @if (isset($fileUploader_required)) check-file-uploader-required @else type @endif btn btn-large btn-primary waves-effect" data-type="publish">{{__("general.publish")}}</button>
        @endif

    @else

        @if (!Auth::user()->isViewOnly())
            @if (!\App\Models\Task::exists($project, $section, $position))

                <!-- Request for modification -->
                <input type="hidden" class="hidden" name="position" value="{{$position}}" />
                <input type="hidden" class="hidden" name="project" value="{{$project}}" />
                <input type="hidden" class="hidden" name="section" value="{{$section}}" />

                @if(isset($section_fields))
                    <input type="hidden" name="section_fields" value="{{implode(',', $section_fields)}}" />
                @endif

                @if(($section == 'kpi' || $section == 'par') || ($position == 1 && $section=='i') || $section=='cm' || $section=='ri' || $section == 'pf' || $section == 'aw' || $section=='awf')
                    <a class="rfm-submit-btn btn btn-large btn-success waves-effect hidden">{{__("task.request_modification_submit")}}</a>
                @else
                    <a class="rfm-submit-btn2 btn btn-large btn-success waves-effect hidden">{{__("task.request_modification_submit")}}</a>
                @endif

                

                    <button type="button" class="rfm-open-btn btn btn-large btn-primary waves-effect">{{__("task.request_modification_open")}}</button>
                    <button type="button" class="rfm-close-btn btn btn-large btn-primary waves-effect float-right hidden">{{__("task.request_modification_close")}}</button>

            @else
                <span class="btn btn-large btn-warning">{{__("task.request_modification_exists")}}</span>
            @endif
        @endif

    @endif
</div>
