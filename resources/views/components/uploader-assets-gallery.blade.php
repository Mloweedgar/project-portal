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

        if(positionAddress === -1){

            loadFineUploaderDynamic(object, projectAddress, sectionAddress, positionAddress, uniqueToken);

        } else {

            loadFineUploaderEdition(object, projectAddress, sectionAddress, positionAddress, uniqueToken);

        }


    });

    /**
     * Uploader for non-positioned elements
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

        var uploader = new qq.FineUploader({
            debug: false,
            element: element,
            autoUpload: false,
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
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
                sizeLimit: 4194304
            },
            callbacks: {
                onAllComplete: function(succeeded, failed) {
                    if (failed.length > 0) {

                        console.log("Error: Some files were not uploaded. Please, try again.");

                    } else if (succeeded.length > 0 ) {

                        // Submit the form
                        $("#dynamic-form-validation").submit();

                    }
                },
                onSubmit :function(img){
                    $('#upload-button').show();

                }
            }
        });

        qq(document.getElementById("upload-button")).attach('click', function() {

            if(formValidator.valid()){

                //Check if there is some files to upload
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
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
                sizeLimit: 4194304
            },
            retry: {
                enableAuto: true
            }

        });

    }

</script>
