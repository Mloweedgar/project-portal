@if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())
    <span class="switch switch-left">
        <label>
            {{__('project.draft')}}
            <input class="active-button individual-visibility" name="private" type="checkbox"
                      {{ $status ? "checked" : "" }} data-project="{{$project}}" data-position="{{$position}}" data-route="{{$route}}">
            <span class="lever switch-col-blue"></span>
            {{__('project.published')}}
        </label>
    </span>
@endif