<script src="{{ asset('back/plugins/fineuploader-core/all.fine-uploader.js') }}"></script>

<script>

    var rand = function() {
        return Math.random().toString(36).substr(2);
    };

    var token = function() {
        return rand() + rand();
    };

    var uniqueToken = token();

    /*
     * Fine Uploader initialization
     */
    $.each($('.fine-uploader'), function(index, object){

        // Get the data of the triggered uploader form
        var projectAddress = $(this).data('project');
        var sectionAddress = $(this).data('section');
        var positionAddress = $(this).data('position');

        @if (!Auth::user()->isAdmin())

            loadFineUploaderRFM(object, projectAddress, sectionAddress, positionAddress, uniqueToken);

        @else

            if(positionAddress === -1){

                loadFineUploaderDynamic(object, projectAddress, sectionAddress, positionAddress, uniqueToken);

            } else {

                loadFineUploaderEdition(object, projectAddress, sectionAddress, positionAddress, uniqueToken);

            }

        @endif


    });

    /**
     * Uploader for non-positioned elements
     * @param element
     * @param project
     * @param section
     * @param position
     * @param uniqueToken
     */
    function loadFineUploaderRFM(element, project, section, position, uniqueToken){

        // CSRF Token for Laravel
        var token = $('meta[name="csrf-token"]').attr('content');

        // Validation module init
        var formValidator = element.closest('form');

        var uploader = new qq.FineUploader({
            debug: false,
            element: element,
            autoUpload: false,
            validation: {
                sizeLimit: 524288000 // 500MB
            },
            @if (isset($notMultiple))
            multiple: false,
            @endif
            request: {
                endpoint: '/uploader',
                customHeaders: {
                    'X-CSRF-TOKEN': token
                },
                params: {
                    projectAddress: project,
                    sectionAddress: section,
                    positionAddress: position,
                    uniqueToken: uniqueToken
                }
            },
            deleteFile: {
                enabled: true,
                forceConfirm: true,
                endpoint: '/uploader/delete',
                customHeaders: {
                    'X-CSRF-TOKEN': token
                }
            },
            retry: {
                enableAuto: true
            },
            callbacks: {
                onAllComplete: function(succeeded, failed) {
                    if (failed.length > 0) {

                        console.log("Error: Some files were not uploaded. Please, try again.");

                    } else if (succeeded.length > 0 ) {

                        // Submit the form
                        var form = formValidator;
                        form.action = "/request-modification/store";
                        form.submit();
                    }
                }
            }
        });

        var uploadButton = element.closest('form').getElementsByClassName('rfm-submit-btn2');

        $(uploadButton).on('click', function () {

            var formValidator = element.closest('form');

            if($(formValidator).valid()){

                //Check if there is some files to upload
                if(uploader.getUploads().length > 0){

                    // Start uploading the files only when the user click the action button
                    // This is applied when adding but not editing
                    uploader.uploadStoredFiles();

                } else {

                    // Submit the form without uploading files
                    var form = formValidator;
                    form.action = "/request-modification/store";
                    form.submit();

                }

            } else {

                console.log("There are some fields missing, please, complete the form.");

            }

        });

    }

    /**
     * Uploader for non-positioned elements
     * 
     * @param element
     * @param project
     * @param section
     * @param position
     * @param uniqueToken
     */
    function loadFineUploaderDynamic(element, project, section, position, uniqueToken){

        // CSRF Token for Laravel
        var token = $('meta[name="csrf-token"]').attr('content');

        // Validation module init
        var formValidator = $("#dynamic-form-validation");
        formValidator.validate({
            onsubmit: false
        });

        @php
        if (!isset($required_message)) {
            if (isset($notMultiple)) {
                $required_message = 'A file is required.';
            } else {
                $required_message = 'One or more files are required.';
            }
        }
        @endphp

        var uploader = new qq.FineUploader({
            debug: false,
            element: element,
            autoUpload: false,
            validation: {
                sizeLimit: 524288000 // 500MB
            },
            @if (isset($notMultiple))
                multiple: false,
            @endif
            request: {
                endpoint: '/uploader',
                customHeaders: {
                    'X-CSRF-TOKEN': token
                },
                params: {
                    projectAddress: project,
                    sectionAddress: section,
                    positionAddress: position,
                    uniqueToken: uniqueToken
                }
            },
            deleteFile: {
                enabled: true,
                forceConfirm: true,
                endpoint: '/uploader/delete',
                customHeaders: {
                    'X-CSRF-TOKEN': token
                }
            },
            retry: {
                enableAuto: true
            },
            callbacks: {
                @if (isset($required))
                    onSubmitted: function(id, name) {
                        var btnId = this._defaultButtonId;
                        var fineUploaderDiv = $('input[qq-button-id="'+btnId+'"]').closest('.fine-uploader');
                        fineUploaderDiv.find('.qq-uploader-selector').removeClass('error');
                        fineUploaderDiv.find('.fine-uploader-error').remove();
                    },
                    onStatusChange: function(id, old, newStatus) {
                        if (newStatus == 'canceled' && this._netUploadedOrQueued == 0) {
                            var btnId = this._defaultButtonId;
                            var fineUploaderDiv = $('input[qq-button-id="'+btnId+'"]').closest('.fine-uploader');
                            fineUploaderDiv.find('.qq-uploader-selector').addClass('error');
                            fineUploaderDiv.append('<p class="fine-uploader-error">{{ $required_message }}</p>');
                        }
                    },
                @endif
                onAllComplete: function(succeeded, failed) {
                    if (failed.length > 0) {

                        console.log("Error: Some files were not uploaded. Please, try again.");

                    } else if (succeeded.length > 0 ) {

                        // Submit the form
                        $("#dynamic-form-validation").submit();

                    }
                }
            }
        });

        qq(document.getElementById("upload-button")).attach('click', function() {

            @if (isset($required))
                var fine_uploader = $(this).closest('.row').find('.fine-uploader');

                if (uploader._netUploadedOrQueued == 0 && fine_uploader.find('.fine-uploader-error').length == 0) {
                    fine_uploader.find('.qq-uploader-selector').addClass('error');
                    fine_uploader.append('<p class="fine-uploader-error">{{ $required_message }}</p>');
                }
            @endif


            if(formValidator.valid() @if (isset($required)) && uploader._netUploadedOrQueued > 0 @endif) {

                if(uploader.getUploads().length > 0){

                    // Start uploading the files only when the user click the action button
                    // This is applied when adding but not editing
                    uploader.uploadStoredFiles();

                } else {


                    // Submit the form without uploading files
                    $("#dynamic-form-validation").submit();

                }

            } else {

                console.log("There are some fields missing, please, complete the form.");

            }

        });

    }

    /**
     * Uploader for positioned elements
     * @param element
     * @param project
     * @param section
     * @param position
     * @param uniqueToken
     */
    function loadFineUploaderEdition(element, project, section, position, uniqueToken){

        var token = $('meta[name="csrf-token"]').attr('content');

        var uploader = new qq.FineUploader({
            debug: false,
            element: element,
            autoUpload: true,
            validation: {
                sizeLimit: 524288000 // 500MB
            },
            @if (isset($notMultiple))
                multiple: false,
            @endif
            session: {
                endpoint: '/uploader/init',
                params: {
                    projectAddress: project,
                    sectionAddress: section,
                    positionAddress: position,
                    uniqueToken: uniqueToken
                }
            },
            request: {
                endpoint: '/uploader',
                customHeaders: {
                    'X-CSRF-TOKEN': token
                },
                params: {
                    projectAddress: project,
                    sectionAddress: section,
                    positionAddress: position,
                    uniqueToken: uniqueToken
                }
            },
            deleteFile: {
                enabled: true,
                forceConfirm: true,
                endpoint: '/uploader/delete',
                customHeaders: {
                    'X-CSRF-TOKEN': token
                }
            },
            retry: {
                enableAuto: true
            }@if (isset($required)),
            callbacks: {
                onSubmitted: function(id, name) {
                    var btnId = this._defaultButtonId;
                    var fineUploaderDiv = $('input[qq-button-id="'+btnId+'"]').closest('.fine-uploader');
                    fineUploaderDiv.find('.qq-uploader-selector').removeClass('error');
                    fineUploaderDiv.find('.fine-uploader-error').remove();
                },
                onDeleteComplete: function(id, xhr, isError) {
                    if (isError == false && this._netUploadedOrQueued == 0) {
                        var btnId = this._defaultButtonId;
                        var fineUploaderDiv = $('input[qq-button-id="'+btnId+'"]').closest('.fine-uploader');
                        fineUploaderDiv.find('.qq-uploader-selector').addClass('error');
                        fineUploaderDiv.append('<p class="fine-uploader-error">{{ $required_message }}</p>');
                    }
                }
            }
            @endif

        });

    }

</script>