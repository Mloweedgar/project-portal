@if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
<script>
    /**
     *  Need the section, project ID and new visibility
     */

    $("#section-visibility").change(function () {

        var section = "{{$section}}";
        var project_id = "{{$project_id}}";
        var visibility = $("#section-visibility").is(":checked");

        $.ajax({
            url: '{{ route('project-change-visibility') }}',
            type: 'POST',
            data: { section: section, project_id:project_id,visibility:visibility },
            success: function(data){
                if(data.status){
                    swal({
                        title: "{{ trans('project.visibility-changed') }}",
                        type: "success",
                        html: true
                    });

                } else {
                    laravelErrors(data);
                }
            },
        });
    });
</script>
@endif
