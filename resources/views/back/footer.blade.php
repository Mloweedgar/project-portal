@extends('layouts.back')

@section('styles')

@endsection

@section('content')
    <h1 class="content-title">{{__("footer.title")}}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#footer' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    <div class="container-fluid">

        <div class="row content-row">
            <form action="{{route('about-ppp/edit')}}" method="POST">
                {{ csrf_field() }}

                <div class="card">
                    <div class="header">
                        <h2><i class="material-icons card-icon">people</i> {{__("aboutppp.title")}}</h2>

                    </div>
                    <div class="body">
                        <div class="form-group">

                            <div class="form-line">
                                <label for="aboutppp_title">{{__('footer.about-ppp-title')}}</label>
                                <input type="text" id="aboutppp_title" name="aboutppp_title" class="form-control" value="{{isset($aboutppp_title) ? $aboutppp_title->value : "" }}">
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="form-line">
                                <label for="aboutppp_content">{{__('footer.about-ppp-content')}}</label>
                                <textarea rows="5" class="form-control no-resize" id="aboutppp_content" name="aboutppp" >{{isset($aboutppp) ? $aboutppp->value : "" }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-large btn-primary waves-effect" type="submit">{{__('general.save')}}</button>

                    </div>
                </div>

            </form>
        </div>

        <div class="row content-row">
            <form action="{{route('footer.contact')}}" id="frmContact" method="POST">
                {{ csrf_field() }}

                <div class="card">
                    <div class="header">
                        <h2><i class="material-icons card-icon">perm_contact_calendar</i> {{__("footer.contact")}}</h2>

                    </div>
                    <div class="body">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="homepage">{{__('footer.website')}}</label>
                                <input type="url" id="homepage" name="homepage" class="form-control" value="{{isset($homepage) ? $homepage->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="mail">{{__('footer.mail')}}</label>
                                <input type="email" id="mail" name="mail" class="form-control" value="{{isset($mail) ? $mail->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="phone">{{__('footer.phone')}}</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{isset($phone) ? $phone->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="address">{{__('footer.address')}}</label>
                                <input type="text" id="address" name="address" class="form-control" value="{{isset($address) ? $address->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="address_link">{{__('footer.address_link')}}</label>
                                <input type="url" id="address_link" name="address_link" class="form-control" value="{{isset($address_link) ? $address_link->value : "" }}">
                            </div>
                        </div>
                        <button class="btn btn-large btn-primary waves-effect" type="button" id="footer-contact-save">{{__('general.save')}}</button>

                    </div>
                </div>

            </form>
        </div>

        <div class="row content-row">
            <form action="{{route('footer.social')}}" method="POST">
                {{ csrf_field() }}

                <div class="card">
                    <div class="header">
                        <h2><i class="material-icons card-icon">share</i> {{__("footer.social")}}</h2>

                    </div>
                    <div class="body">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="linkedin">Linkedin</label>
                                <input type="url" id="linkedin" name="linkedin" class="form-control" value="{{isset($linkedin) ? $linkedin->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="facebook">Facebook</label>
                                <input type="url" id="facebook" name="facebook" class="form-control" value="{{isset($facebook) ? $facebook->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="twitter">Twitter</label>
                                <input type="url" id="twitter" name="twitter" class="form-control" value="{{isset($twitter) ? $twitter->value : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="instagram">Instagram</label>
                                <input type="url" id="instagram" name="instagram" class="form-control" value="{{isset($instagram) ? $instagram->value : "" }}">
                            </div>
                        </div>
                        <button class="btn btn-large btn-primary waves-effect" type="submit">{{__('general.save')}}</button>

                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection

@section('scripts')

    <script>

        @if(Session::has('status'))

        swal({
            title: "Success!",
            text: "{{ session('status') }}",
            type: "success",
            html: true
        });
        @endif

        var validators = [];

        $('#frmContact').each(function(){
            var form = $(this)
            var validator = $(form).validate({
                ignore: ":hidden:not(.selectpicker)",
                /* Onkeyup
                 * For not sending an ajax request to validate the email each time till the typing is done.
                 */
                /*onkeyup: false,*/
                rules: {
                    'homepage': {
                        required: false,
                    },
                    'mail':{
                        required: false,
                    },
                    'phone':{
                        required: false
                    },
                    'address':{
                        required: false
                    },
                    'address_link':{
                        required: false,
                    },
                    /* 'entity': {
                     required: true
                     },
                     'role': {
                     required: true
                     }*/
                },
            }); //Validation end
            validators.push(validator);
        });

        $("#footer-contact-save").click(function () {
            $(this).closest("form").submit();
        });

    </script>

@endsection
