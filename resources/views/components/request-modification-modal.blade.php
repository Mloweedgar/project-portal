<div class="modal fade request-modification-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-t-5">
            <div class="modal-header">
                <h4>{{__('general.request_modification-title')}}</h4>
                <p>{{__('general.request_modification-instructions')}}</p>
            </div>
            <div class="modal-body">

                <div class="form-group form-float">
                    <div class="form-line focused">
                        <input type="text" class="form-control" name="title" value={{ Auth::user()->email }} readonly>
                        <label class="form-label">{{__("general.user")}}</label>
                    </div>
                </div>
                <div class="form-group form-float">
                    <div class="form-line">
                        <textarea rows="4" name="request-modification-reason" class="form-control no-resize"></textarea>
                        <label class="form-label">{{__("general.reason")}}</label>
                    </div>
                </div>
                <div class="form-group form-float">
                    <div class="form-line">
                        <textarea rows="4" name="request-modification-changes" class="form-control no-resize" ></textarea>
                        <label class="form-label">{{__("general.changes")}}</label>
                    </div>
                </div>
                <div class="form-group form-float">
                    <div class="form-line focused">
                        <input type="text" class="form-control" name="url" value={!! date('d-m-Y') !!} readonly>
                        <label class="form-label">{{__("general.date")}}</label>
                    </div>
                </div>
                @if (isset($position))
                    <input type="hidden" name="position" value="{{$position}}">
                @endif
                @if (isset($project))
                    <input type="hidden" name="project" value="{{$project}}">
                @endif
                @if (isset($section))
                    <input type="hidden" name="section" value="{{$section}}">
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="request-modification-submit btn btn-primary waves-effect">{{__("general.request_modification")}}</button>
                <button type="button" class="btn waves-effect" data-dismiss="modal">{{__("general.cancel")}}</button>
            </div>
        </div>
    </div>
</div>
<script>

</script>
