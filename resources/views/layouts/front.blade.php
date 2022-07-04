<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Project Portal</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <style type="text/css">@import url('https://fonts.googleapis.com/css?family=Roboto+Slab');</style>

    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107123710-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments)};
        gtag('js', new Date());

        gtag('config', 'UA-107123710-1');
    </script>

    @yield('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<!-- content -->

<div id="upgrade-overlay" class="hiddenAtPrint">
    <div class="browser-info">
        <div class="browser-title"><h2>{{__('frontpage.browser-outdated')}}</h2></div>
        <div class="browser-subtitle"><h3>{{__('frontpage.experience')}}</h3></div>
    </div>

    <div class="browser-center">
        <img id="browser-img" src="{{asset('img/browsers/explorer.png')}}" class="img-responsive"/>
        <div id="browser-name">Internet Explorer</div>
        <div class="download">
            <a href="" id="upgrade-link" target="_blank">{{__('frontpage.download')}}</a>
        </div>
    </div>
    <div id="upgrade-message"></div>

</div>

<section>
    <div class="container-fluid no-padding">
        @yield('content')
    </div>
</section>
<!-- footer -->




<script src="{{ asset('back/js/libs.js') }}"></script>
<script>
var $buoop = {vs:{i:10,f:-4,o:-4,s:8,c:-4},api:4};
function $buo_f(){
 var e = document.createElement("script");
 e.src = "//browser-update.org/update.min.js";
 document.body.appendChild(e);
};
try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
catch(e){window.attachEvent("onload", $buo_f)}
</script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
<script src="/front/plugins/responsive-toolkit/bootstrap-toolkit.min.js"></script>
<script type="text/javascript">
    /** Our updates modal ***/
    $(".ourupdates").click(function () {
        $('.ourupdates-modal').modal('show');
    });

    $('#frmSubscribe').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Subscribe to newsletter
    $('#newsletter-subscribe-button').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        if($('#frmSubscribe').valid()){
            var input_name = $('#frmSubscribe input[name=name]');
            var input_email = $('#frmSubscribe input[name=email]');
            $.ajax({
                url: '{{ route('newsletter.subscribe') }}',
                type: 'POST',
                data: { name: input_name.val(), email: input_email.val(), _token: "{{ csrf_token() }}", page: "home" },
                beforeSend: function() {
                    $('.subscribeLoader').html("<img alt='Loading ...' src='/img/loader.gif'>");
                },
                success: function(data){
                    if (data.status) {
                        var success = '<div class="alert alert-success">{{__('newsletter.confirmation-email')}}</div>';
                        $('.subscribeState').removeClass('hidden').addClass('display');
                        $('.subscribeState').html(success);
                        $('#frmSubscribe').remove();
                    } else {
                        var errors = '<div class="alert alert-danger">'+data.message+'</div>';
                        $('.subscribeState').removeClass('hidden').addClass('display');
                        $('.subscribeState').html(errors);
                    }
                },
                error: function(data){
                    if (data.status === 422) {
                        var errors = '<div class="alert alert-danger"><ul>';
                        $.each(data.responseJSON, function(index, value){
                            errors += "<li>" + value + "</li>";
                        });
                        errors += '</ul></div>';
                        $('.subscribeState').removeClass('hidden').addClass('display');
                        $('.subscribeState').html(errors);
                    } else {
                        var errors = '<div class="alert alert-danger">There was an internal error. Please try soon again.</div>';
                        $('.subscribeState').removeClass('hidden').addClass('display');
                        $('.subscribeState').html(errors);
                    }
                },
                complete: function() {
                    $('.subscribeLoader').html("");
                }
            });
        }
    });

    var validatorContact = $('#frmContact').validate({
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
        }
    });


    /*
     * General jQuery validation setup
     * This setup is used for adding the validation messages from the langs files.
     */
    jQuery.extend(jQuery.validator.messages, {
        required: "{{trans('jquery-validation.required')}}",
        remote: "{{trans('jquery-validation.remote')}}",
        email: "{{trans('jquery-validation.email')}}",
        url: "{{trans('jquery-validation.url')}}",
        date: "{{trans('jquery-validation.date')}}",
        dateISO: "{{trans('jquery-validation.dateISO')}}",
        number: "{{trans('jquery-validation.number')}}",
        digits: "{{trans('jquery-validation.digits')}}",
        creditcard: "{{trans('jquery-validation.creditcard')}}",
        equalTo: "{{trans('jquery-validation.equalTo')}}",
        accept: "{{trans('jquery-validation.accept')}}",
        maxlength: jQuery.validator.format("{{trans('jquery-validation.maxlength')}}"),
        minlength: jQuery.validator.format("{{trans('jquery-validation.minlength')}}"),
        rangelength: jQuery.validator.format("{{trans('jquery-validation.rangelength')}}"),
        range: jQuery.validator.format("{{trans('jquery-validation.range')}}"),
        max: jQuery.validator.format("{{trans('jquery-validation.max')}}"),
        min: jQuery.validator.format("{{trans('jquery-validation.min')}}")
    });


    (function($) {
        $.fn.menumaker = function(options) {
            var navbar = $(this), settings = $.extend({
                format: "dropdown",
                sticky: false
            }, options);
            return this.each(function() {
                $(this).find(".button").on('click', function(){
                    $(this).toggleClass('menu-opened');
                    var mainmenu = $(this).next('ul');
                    if (mainmenu.hasClass('open')) {
                        mainmenu.slideToggle().removeClass('open');
                    }
                    else {
                        mainmenu.slideToggle().addClass('open');
                        if (settings.format === "dropdown") {
                            mainmenu.find('ul').show();
                        }
                    }
                });
                navbar.find('li ul').parent().addClass('has-sub');
                multiTg = function() {
                    navbar.find(".has-sub").prepend('<span class="submenu-button"></span>');
                    navbar.find('.submenu-button').on('click', function() {
                        $(this).toggleClass('submenu-opened');
                        if ($(this).siblings('ul').hasClass('open')) {
                            $(this).siblings('ul').removeClass('open').slideToggle();
                        }
                        else {
                            $(this).siblings('ul').addClass('open').slideToggle();
                        }
                    });
                };
                if (settings.format === 'multitoggle') multiTg();
                else navbar.addClass('dropdown');
                if (settings.sticky === true) navbar.css('position', 'fixed');
                resizeFix = function() {
                    var mediasize = 700;
                    if ($( window ).width() > mediasize) {
                        navbar.find('ul').show();
                    }
                    if ($(window).width() <= mediasize) {
                        navbar.find('ul').hide().removeClass('open');
                    }
                };
                resizeFix();
                return $(window).on('resize', resizeFix);
            });
        };
    })(jQuery);

</script>
<script type="text/javascript">
    (function($, viewport){
        $(document).ready(function() {
            if(viewport.is('>=md')) {
                window.sr = ScrollReveal();
                sr.reveal('#projects-table, #graphs, .updates, .announcements', {
                    origin: 'left',
                    duration: 400,
                    delay: 0,
                });
                sr.reveal('.contact, #graphics_stage, .announcements', {
                    origin: 'right',
                    duration: 400,
                    delay: 0,
                });
            }
        });
    })(jQuery, ResponsiveBootstrapToolkit);
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $('.button-up').click(function(){
            $('body, html').animate({
                scrollTop: '0px'
            }, 600);
        });

        $(window).scroll(function(){
            if( $(this).scrollTop() > 0 ){
                $('.button-up').slideDown(300);
            } else {
                $('.button-up').slideUp(300);
            }
        });

        $(".submenu").hover(function () {

            var parentLink = $(this).data("submenu");
            var parentElement = $("#" + parentLink);
            parentElement.toggleClass("triangle-bottom");

        });

    });

    $('a.soft-scroll[href*="#"]')
    // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function(event) {
            // On-page links
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                &&
                location.hostname == this.hostname
            ) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000, function() {
                        // Callback after animation
                        // Must change focus!
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        };
                    });
                }
            }
        });

    // Fix for footer on bottom

    $(document).ready(function(){
        footerResize();
    });

    $(window).resize(function() {

        footerResize();

    });

    function footerResize() {
        var footerHeight = $('.front-footer').outerHeight();
        var docHeight = $(window).height();
        var navHeight = $("#navbar-main").outerHeight();
        if (docHeight > (navHeight + footerHeight)){
            $('section').css({'minHeight': docHeight - footerHeight - navHeight + 'px'});
        }
    }

    $(function(){
        $(".dropdown-menu > li > a.trigger").on("click",function(e){
            console.log("Clicked");
            var current=$(this).next();
            var grandparent=$(this).parent().parent();
            if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
                $(this).toggleClass('right-caret left-caret');
            grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
            grandparent.find(".sub-menu:visible").not(current).hide();
            current.toggle();
            e.stopPropagation();
        });
        $(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
            console.log("Closed");
            var root=$(this).closest('.dropdown');
            root.find('.left-caret').toggleClass('right-caret left-caret');
            root.find('.sub-menu:visible').hide();
        });
    });

</script>

@component('components.desktop-navigation-assets')
@endcomponent

@yield('scripts')
</body>

</html>
