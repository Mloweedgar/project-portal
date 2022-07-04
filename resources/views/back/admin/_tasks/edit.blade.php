<!-- Modal Edit Task ====================================================================================================================== -->
<div class="modal fade " id="modalEditTask" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">{{ trans('task.edit_task') }}</h4>
        </div>
        <div class="modal-body" style="overflow: visible;">
            <form id="frmEditTask">
                <div class="form-group form-float">
                    <b>{{ trans("task.task_name") }}</b>
                    <div class="form-line">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>

                <div class="form-group form-float">
                    <b>{{ trans("task.project_name") }}</b>
                    <div class="form-line">
                        <select class="form-control show-tick selectpicker" name="project" data-live-search="true" title="{{ trans("task.search_project") }}"></select>
                    </div>
                </div>

                <div class="form-group form-float">
                  <b>{{ trans("task.assigned_to") }}</b>
                  <div class="form-line">
                      <select class="form-control show-tick selectpicker" name="assigned_to" data-live-search="true" title="{{ trans("task.search_user") }}"></select>
                  </div>
                </div>

                <div class="form-group form-float">
                  <b>{{ trans("task.deadline") }}</b>
                    <div class="form-line">
                        <input type="text" class="form-control datepicker" name="deadline">
                    </div>
                </div>
                <div class="form-group form-float">
                  <b>{{ trans('task.reason') }}</b>
                  <div class="form-line">
                      <textarea class="form-control" rows="4" name="description"></textarea>
                  </div>
                </div>
                <input type="hidden" value="" name="id">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect text-uppercase" id="btnEditTask">{{ trans('task.save_changes') }}</button>
            <button type="button" class="btn btn-link waves-effect text-uppercase" data-dismiss="modal">{{ trans('task.close') }}</button>
        </div>
    </div>
</div>
<!--  Modal Edit Task ====================================================================================================================== -->
