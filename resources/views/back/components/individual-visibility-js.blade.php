@if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())
    <script>
        /**
         *  Need the section, project ID and new visibility
         */

        $(".publish-button").each(function () {

            var checkboxElement = $(this).closest(".card").find(".individual-visibility");
            var checkboxStatus = checkboxElement.attr("checked");

            if(checkboxElement.length > 0){

                if(checkboxStatus){

                    checkboxElement.closest(".card").find(".publish-button").removeClass("btn-default").addClass("btn-primary").html("Publish");

                } else {

                    checkboxElement.closest(".card").find(".publish-button").removeClass("btn-primary").addClass("btn-default").html("Save as draft");

                }

            }

        });

        $(".individual-visibility").change(function () {

            var project = $(this).data("project");
            var position = $(this).data("position");
            var route = $(this).data("route");
            var visibility = $(this).is(":checked");

            var buttonElement = $(this).closest(".card").find(".publish-button");

            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    project: project,
                    position: position,
                    visibility: visibility
                },
                success: function(data){
                    if(data.status){

                        if(visibility){

                            buttonElement.removeClass("btn-default").addClass("btn-primary").html("Publish");

                        } else {

                            buttonElement.removeClass("btn-primary").addClass("btn-default").html("Save as draft");

                        }

                        swal({
                            title: "{{ trans('project.status_element') }}",
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