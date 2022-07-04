@if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())
<div class="enable-subsection">
    <div class="switch inline-block">
        <label>{{__('project.non-visible')}}<input type="checkbox" id="subsection-visibility" {{$visible == 1 ? 'checked':''}}><span class="lever"></span>{{__('project.visible')}}</label>
    </div>
</div>
@endif
