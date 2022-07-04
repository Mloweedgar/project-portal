@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">

    <style type="text/css">
    .qq-upload-list-selector {
        margin-top:10px;
    }

    #fine-uploader-import-errors {
        margin-top:20px;
        padding:5px;
        font-size:1.2em;
        border:1px dashed #A63F3F;
        background-color:#FFF0F0;
        color:#6F2E2E;
    }

    #fine-uploader-import-success {
        margin-top:20px;
        padding:5px;
        font-size:1em;
        border:1px dashed #69BA5B;
        background-color:#F6FDF5;
        color:#2A4026;
    }
    #fine-uploader-import-success p {
        margin:0px;
        padding:3px;
    }
    </style>

@endsection

@section('content')
    <h1 class="content-title">{{__("add-project.import_project")}}</h1>

    <div class="row content-row">
        <p><a href="{{ route('import-project-download') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-down" aria-hidden="true"></i> {{ trans('import-project.download_template') }}</a></p>
        <div id="fine-uploader-manual-trigger"></div>
        <p style="margin-top:10px;margin-bottom:10px;">Please, make sure you use the template above available for download before importing a project. The template includes a hidden column (Column A) that is necessary for the correct importing of the file.</p>
        <div id="fine-uploader-import-errors" class="hidden"></div>
        <div id="fine-uploader-import-success" class="hidden"></div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/fineuploader-core/all.fine-uploader.js') }}"></script>

    <script type="text/template" id="qq-template-manual-trigger">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop project's Excel file here please">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="buttons">
                <div class="qq-upload-button-selector btn btn-primary">
                    <div>Select Excel to import</div>
                </div>
                <button type="button" id="trigger-upload" class="btn btn-primary">
                   Import
                </button>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
{{--                     <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text"> --}}
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                    {{-- <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span> --}}
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <script>
    var token = $('meta[name="csrf-token"]').attr('content');
    var manualUploader = new qq.FineUploader({
        element: document.getElementById('fine-uploader-manual-trigger'),
        template: 'qq-template-manual-trigger',
        request: {
            endpoint: '{{ route('import-project') }}',
            customHeaders: {
                'X-CSRF-TOKEN': token
            },
        },
        validation: {
            allowedExtensions: ["xlsx"]
        },
        messages: {
            typeError: "This file is not an Excel (.xlsx)"
        },
        multiple: false,
        thumbnails: {
            placeholders: {
                waitingPath: '{{ asset('back/plugins/fineuploader-core/placeholders/waiting-generic.png') }}',
                notAvailablePath: '{{ asset('back/img/tick.png') }}'
            }
        },
        autoUpload: false,
        callbacks: {
            onSubmit: function(id, name) {
                $('#fine-uploader-import-success').html('').addClass('hidden');
                $('#fine-uploader-import-errors').html('').addClass('hidden');
            },
            onCancel: function(id, name) {
                $('#fine-uploader-import-success').html('').addClass('hidden');
                $('#fine-uploader-import-errors').html('').addClass('hidden');
            },
            onComplete: function(id, name, responseJSON, xhrOrXdr) {
                if (responseJSON.success) {
                    $('#fine-uploader-import-success').removeClass('hidden');
                    var data = responseJSON.events;
                    $.each(data, function( index, value ) {
                        $('#fine-uploader-import-success').append('<p><i class="fa fa-check" aria-hidden="true"></i> ' + value + '.</p>');
                    });
                    $('#fine-uploader-manual-trigger').reset();
                }
            },
            onManualRetry: function(id, name) {
                $('#fine-uploader-import-success').html('').addClass('hidden');
                $('#fine-uploader-import-errors').html('').addClass('hidden');
            },
            onError: function(id, name, errorReason, xhrOrXdr) {
                $('#fine-uploader-import-errors').removeClass('hidden');
                $('#fine-uploader-import-errors').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + errorReason + '.');
            }
        }
    });

    qq(document.getElementById("trigger-upload")).attach("click", function() {
        manualUploader.uploadStoredFiles();
    });
    </script>
@endsection
