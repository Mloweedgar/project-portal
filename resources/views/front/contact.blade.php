@extends('layouts.front')

@section('content')
<div id="contact-map"></div>


<div class="container content-contact-page">
    <h2>{{trans('general.contact_us')}}</h2>
    <div class="row">
        <div class="col-lg-6 col-md-6 contact-page-info">
      		<p>{{trans('contact.contact_p')}}</p>
            <div class="contact-us">
                @if (isset($homepage->value))
                    <div><i class="material-icons align-middle">language</i><a href="{{$homepage->value}}" target="_blank">{{$homepage->value}}</a></div>
                @endif
                @if (isset($mail->value))
                    <div><i class="material-icons align-middle">email</i><a href="mailto:{{$mail->value}}" target="_blank">{{$mail->value}}</a></div>
                @endif
                @if (isset($phone->value))
                    <div><i class="material-icons align-middle">call</i><a href="tel:{{$phone->value}}" target="_blank">{{$phone->value}}</a></div>
                @endif
                @if (isset($address->value))
                    <div><i class="material-icons align-middle">room</i>
                        @if (isset($address_link->value))
                        <a href="{{$address_link->value}}" target="_blank">
                            @endif
                            {{$address->value}}
                            @if (isset($address_link->value))

                        </a>
                            @endif
                    </div>
                @endif
            </div>

        </div>
    	<div class="col-lg-6 col-md-6 contact-page-form">
            <div class="contactState hidden"></div>
            <form  id="frmContact">
              <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" name="name" type="text" id="contact_name">
                <label class="mdl-textfield__label" for="field1">{{trans('general.name')}}</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" name="email" type="text" id="contact_email">
                <label class="mdl-textfield__label" for="field2">{{trans('general.email')}}</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield">
                <textarea class="mdl-textfield__input" name="message" type="text" rows= "3" id="contact_message" ></textarea>
                <label class="mdl-textfield__label" for="sample5">{{trans('general.message')}}</label>
              </div>
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" id="btnSendContact">{{trans('general.send')}}</button>
            </form>
            <div class="contactLoader align-center"></div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAdWrcpDQjt3VwF-X3pqGLN5hwbIuOo-YA"></script>


    <script type="text/javascript">
            // When the window has finished loading create our google map below
            google.maps.event.addDomListener(window, 'load', init);

            function init() {
                // Basic options for a simple Google Map
                // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
                var mapOptions = {
                    // How zoomed in you want the map to start at (always required)

                    zoom: 13,
                    scrollwheel: false,

                    // The latitude and longitude to center the map (always required)
                    center: new google.maps.LatLng({{ $coord_x }}, {{ $coord_y }}), // Ghana


                    // How you would like to style the map.
                    // This is where you would paste any style found on Snazzy Maps.
                    styles: [
                        {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {"color": "#444444"}]
                        },
                        {
                            "featureType": "administrative.province",
                            "elementType": "geometry",
                            "stylers": [
                                {"visibility": "simplified"}
                            ]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [
                                {"color": "#f2f2f2"}
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "all",
                            "stylers": [
                                {"visibility": "off"}
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [
                                {"saturation": -100},
                                {"lightness": 45}
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "all",
                            "stylers": [
                                {"visibility": "simplified"}
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "labels.icon",
                            "stylers": [
                                {"visibility": "off"}
                            ]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "all",
                            "stylers": [
                                {"visibility": "off"}
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "all",
                            "stylers": [
                                {"color": "#94919b"},
                                {"visibility": "on"}
                            ]
                        }
                    ]
                };

                // Get the HTML DOM element that will contain your map
                // We are using a div with id="contact-map" seen below in the <body>
                var mapElement = document.getElementById('contact-map');

                // Create the Google Map using our element and options defined above
                var map = new google.maps.Map(mapElement, mapOptions);

                // Let's also add a marker while we're at it
                var marker = new google.maps.Marker({

                    position: new google.maps.LatLng({{ $coord_x }}, {{ $coord_y }}),
                    map: map,

                    title: '{{ $app_title }}'
                });
            }

            
            $('#frmContact').validate({
                rules: {
                    'name': {
                        required: true
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'message': {
                        required: true
                    },
                },
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                            error.insertAfter(element);
                    }
                }
            });

            // Contact
            $('#btnSendContact').click(function (event) {
                event.preventDefault();
                event.stopPropagation();

                if($('#frmContact').valid()){
                    var input_name = $('#frmContact input[name=name]').val();
                    var input_email = $('#frmContact input[name=email]').val();
                    var input_message = $('#frmContact textarea[name=message]').val();

                    $.ajax({
                        url: '{{ route('contact.send') }}',
                        type: 'POST',
                        data: { name: input_name, email: input_email, message: input_message, _token: "{{ csrf_token() }}" },
                        beforeSend: function() {
                            $('.contactLoader').html("<img alt='Loading ...' src='/img/loader.gif'>");
                        },
                        success: function(data){
                            if (data.status) {
                                var success = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your message was successfully sent.</div>';
                                $('.contactState').removeClass('hidden').addClass('display');
                                $('.contactState').html(success);
                                $('#frmContact').remove();
                            } else {
                                var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
                                $('.contactState').removeClass('hidden').addClass('display');
                                $('.contactState').html(errors);
                            }
                        },
                        error: function(data){
                            if (data.status === 422) {
                                var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><ul>';
                                $.each(data.responseJSON, function(index, value){
                                    errors += "<li>" + value + "</li>";
                                });
                                errors += '</ul></div>';
                                $('.contactState').removeClass('hidden').addClass('display');
                                $('.contactState').html(errors);
                            } else {
                                var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>There was an internal error. Please try soon again.</div>';
                                $('.contactState').removeClass('hidden').addClass('display');
                                $('.contactState').html(errors);
                            }
                        },
                        complete: function() {
                            $('.contactLoader').html("");
                        }
                    });
                }
            });
        </script>
@endsection
