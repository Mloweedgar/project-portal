@if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())
<div class="enable-section">
    <div class="inline-block">
        <p>{{__('project.enable-section')}} "{{$section}}"</p>
    </div>
    <div class="switch inline-block">
        <label>{{__('project.non-visible')}}<input type="checkbox" id="section-visibility" {{$visible == 1 ? 'checked':''}}><span class="lever"></span>{{__('project.visible')}}</label>
    </div>
</div>
@endif
