@extends('layouts.front')

@section('styles')
    <style type="text/css">
        .navbar {box-shadow: 0 4px 13px #ccc;}
      </style>
@endsection

@section('content')
<div class="newsletter-content">
    <div class="newsletter-confirmation">

         <div class="section-title container-wrapper text-center">
            <h1>{{__("emails.newsletter_subscription")}}</h1>
            <span></span>
        </div>

        @if ($active && isset($newsletter))

        <div class="flex">
            <div class="icon"><i class="fa fa-check" aria-hidden="true"></i></div>

                                    
            <div class="user-information">
                <div>
                    <p>{{__("emails.dear",['name'=>$newsletter->name])}},</p>
                    <div class="newsletter-access">
                        <p>{{__("emails.newsletter_email_text")}}</p>
                        <p>{{__("emails.newsletter_continue_navigation")}}</p>
                        <a href="/" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">{{__("emails.newsletter_homepage")}}</a>
                    </div>
                    <p class="contact-email">{{__("emails.contact")}}: <a href="mailto:{{$contactMail}}">{{$contactMail}}</a></p>
                </div>
            </div>
         </div>

        @else

         <div class="flex">
            <div class="icon"><i class="fa fa-times" aria-hidden="true"></i></div>

                                    
            <div class="user-information">
                <div>
                    <div class="newsletter-access">
                        <p>{{__("emails.newsletter_email_error_text")}}</p>
                        <a href="/" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">{{__("emails.newsletter_homepage")}}</a>
                    </div>
                    <p class="contact-email">{{__("emails.contact")}}: <a href="mailto:{{$contactMail}}">{{$contactMail}}</a></p>
                </div>
            </div>
         </div>

        @endif

    </div>


</div>

    
       

@endsection
