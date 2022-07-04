@if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())
	<div class="btn-group">
	    <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	        <span class="small-text">{{trans('project.options')}}</span> <span class="caret"></span>
	    </button>
	    <ul class="dropdown-menu">
	        <li><a href="{{route('project-export-excel', ['id' => $project->id])}}" class=" waves-effect waves-block"><i class="fa fa-file-excel-o" aria-hidden="true"></i> {{trans('project.export_excel')}}</a></li>
	    </ul>
	</div>
@endif