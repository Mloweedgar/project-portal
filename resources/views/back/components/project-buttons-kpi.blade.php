<div class="project-buttons">
    @if (Auth::user()->isAdmin())
    <!-- Publish -->
        <input type="hidden" class="hidden" name="position" value="{{$position}}" />
        <input type="hidden" class="hidden" name="project" value="{{$project}}" />
        <input type="hidden" class="hidden" name="section" value="{{$section}}" />

        @if($position == 0 && ($section == 'ri' || $section == 'r' || $section == 'cm' || $section == 'kpi'))
            <button type="submit" class="btn btn-large btn-primary waves-effect">{{__("general.publish")}}</button>
        @elseif($position == 0)
            <a id="upload-button" class="btn btn-large btn-primary waves-effect">{{__("general.publish")}}</a>
        @else
            <button type="button" class="publish-button type btn btn-large btn-primary waves-effect" data-type="publish">{{__("general.publish")}}</button>
        @endif

    @else

        <!-- Request for modification -->
        @if (!Auth::user()->isViewOnly())
            @if (!\App\Models\Task::exists($project, $section, $position))
                <!-- Request for modification -->

                <input type="hidden" class="hidden" name="project" value="{{$project}}" />

                <button type="button" class="rfm-kpi-submit-btn type btn btn-large btn-success waves-effect hidden">{{__("task.request_modification_submit")}}</button>
                <button type="button" class="rfm-kpi-close-btn btn btn-large btn-primary waves-effect float-right hidden">{{__("task.request_modification_close")}}</button>

                <button type="button" class="rfm-kpi-open-btn btn btn-large btn-primary waves-effect">{{__("task.request_modification_open")}}</button>
            @else
                <span class="btn btn-large btn-warning">{{__("task.request_modification_exists")}}</span>
            @endif
        @endif

    @endif
</div>
