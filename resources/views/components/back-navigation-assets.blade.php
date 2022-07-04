<script>
    ( function( window ) {

        'use strict';

        // class helper functions from bonzo https://github.com/ded/bonzo

        function classReg( className ) {
            return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
        }

        // classList support for class management
        // altho to be fair, the api sucks because it won't accept multiple classes at once
        var hasClass, addClass, removeClass;

        if ( 'classList' in document.documentElement ) {
            hasClass = function( elem, c ) {
                return elem.classList.contains( c );
            };
            addClass = function( elem, c ) {
                elem.classList.add( c );
            };
            removeClass = function( elem, c ) {
                elem.classList.remove( c );
            };
        }
        else {
            hasClass = function( elem, c ) {
                return classReg( c ).test( elem.className );
            };
            addClass = function( elem, c ) {
                if ( !hasClass( elem, c ) ) {
                    elem.className = elem.className + ' ' + c;
                }
            };
            removeClass = function( elem, c ) {
                elem.className = elem.className.replace( classReg( c ), ' ' );
            };
        }

        function toggleClass( elem, c ) {
            var fn = hasClass( elem, c ) ? removeClass : addClass;
            fn( elem, c );
        }

        var classie = {
            // full names
            hasClass: hasClass,
            addClass: addClass,
            removeClass: removeClass,
            toggleClass: toggleClass,
            // short names
            has: hasClass,
            add: addClass,
            remove: removeClass,
            toggle: toggleClass
        };

        // transport
        if ( typeof define === 'function' && define.amd ) {
            // AMD
            define( classie );
        } else {
            // browser global
            window.classie = classie;
        }

    })( window );

    (function() {

        var containerWrapper = $('#search-dropper-container');

        var morphSearch = document.getElementById( 'morphsearch' ),
            input = morphSearch.querySelector( 'input.morphsearch-input' ),
            ctrlClose = morphSearch.querySelector( 'span.morphsearch-close' ),
            isOpen = isAnimating = false,
            // show/hide search area
            toggleSearch = function(evt) {
                // return if open and the input gets focused
                if( evt.type.toLowerCase() === 'focus' && isOpen ) return false;

                var offsets = morphsearch.getBoundingClientRect();
                if( isOpen ) {
                    classie.remove( morphSearch, 'open' );

                    // trick to hide input text once the search overlay closes
                    // todo: hardcoded times, should be done after transition ends
                    if( input.value !== '' ) {
                        setTimeout(function() {
                            classie.add( morphSearch, 'hideInput' );
                            setTimeout(function() {
                                classie.remove( morphSearch, 'hideInput' );
                                input.value = '';
                            }, 300 );
                        }, 500);
                    }

                    input.blur();
                }
                else {
                    classie.add( morphSearch, 'open' );
                }
                isOpen = !isOpen;
            };

        // events
        input.addEventListener( 'focus', toggleSearch );
        ctrlClose.addEventListener( 'click', toggleSearch );
        // esc key closes search overlay
        // keyboard navigation events
        document.addEventListener( 'keydown', function( ev ) {
            var keyCode = ev.keyCode || ev.which;
            if( keyCode === 27 && isOpen ) {
                toggleSearch(ev);
            }
        } );

        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 second for example

        //on keyup, start the countdown
        $(input).on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $(input).on('keydown', function () {
            clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping () {

            if(input.value.length >= 3) {

                $.ajax({
                    url: '/search/' + input.value + '/' + 1,
                    type: 'GET',
                    beforeSend: function (){

                        // APPEND DATA
                        containerWrapper.html('<svg width="80px" height="80px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-spin"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><g transform="translate(50 50)"><g transform="rotate(0) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.87s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.87s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(45) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.75s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.75s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(90) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.62s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.62s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(135) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.5s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.5s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(180) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.37s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.37s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(225) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.25s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.25s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(270) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0.12s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0.12s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g><g transform="rotate(315) translate(34 0)"><circle cx="0" cy="0" r=5 fill="#000"><animate attributeName="opacity" from="1" to="0.1" begin="-0s" dur="1s" repeatCount="indefinite"></animate><animateTransform attributeName="transform" type="scale" from="1.3" to="1" begin="-0s" dur="1s" repeatCount="indefinite"></animateTransform></circle></g></g></svg>');

                    },
                    success: function (data) {

                        if (data.length > 0) {

                            // WIPE DATA
                            containerWrapper.empty();

                            // APPEND
                            containerWrapper.append(data);

                        } else {

                            // WIPE DATA
                            containerWrapper.empty();

                            // APPEND
                            containerWrapper.html('<div class="no-results-container"> <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 200 200"><style>.st0{fill:#BABABA}.st1{clip-path:url(#XMLID_116_)}.st2{fill:#FFF}.st3{fill:#E6E7E8}.st4{fill:#CCC}.st5{fill:#C1C1C1}.st6{fill:#929292}.st7{fill:#0E303F}.st8{fill:#DBDBDB}</style><circle id="XMLID_432_" class="st0" cx="100" cy="100" r="100"/> <g id="XMLID_526_"> <defs> <circle id="XMLID_527_" cx="100" cy="100" r="100"/> </defs> <clipPath id="XMLID_116_"> <use xlink:href="#XMLID_527_" overflow="visible"/> </clipPath> <g id="XMLID_528_" class="st1"> <g id="mouse_computer_2_"> <g id="XMLID_876_"> <path id="XMLID_877_" class="st2" d="M112.2 120.4h48.4c1.4 0 2.6 1.2 2.6 2.6v20.3h1.1v-15.1-5.2c0-2.1-1.7-3.8-3.8-3.8h-48.4"/> </g> <g id="XMLID_856_"> <path id="XMLID_875_" class="st2" d="M165.1 136.4c2.9 0 5.2 2.3 5.2 5.2v12.5c0 2.9-2.3 5.2-5.2 5.2h-1.4v-22.9h1.4z"/> <path id="XMLID_862_" class="st3" d="M162.3 136.4h1.4v22.9h-1.4c-2.9 0-5.2-2.3-5.2-5.2v-12.5c0-2.9 2.3-5.2 5.2-5.2z"/> </g> <g id="XMLID_847_"> <path id="XMLID_855_" class="st4" d="M165.4 141.9v1.1c0 1-.8 1.7-1.7 1.7v-4.6c1 .1 1.7.8 1.7 1.8z"/> <path id="XMLID_848_" class="st5" d="M163.7 140.2v4.6c-1 0-1.7-.8-1.7-1.7V142c0-1.1.7-1.8 1.7-1.8z"/> </g> </g> <g id="screen_2_"> <g id="XMLID_735_"> <path id="XMLID_844_" class="st6" d="M88.7 104.4c-1.1 4.6-2.2 9.2-3.4 13.8h31.5c-1.1-4.6-2.2-9.2-3.4-13.8H88.7z"/> <path id="XMLID_843_" class="st2" d="M118.7 118H83.3c-.9 0-1.6.9-1.6 1.9v.7h38.6v-.7c0-1.1-.7-1.9-1.6-1.9z"/> <path id="XMLID_842_" class="st2" d="M47.9 99.1v7.6c0 1.5 1.2 2.6 2.6 2.6h101c1.5 0 2.6-1.2 2.6-2.6v-7.6H47.9z"/> <path id="XMLID_841_" class="st7" d="M154.2 99.1V34.8c0-1.5-1.2-2.6-2.6-2.6h-101c-1.5 0-2.6 1.2-2.6 2.6v64.3h106.2z"/> <path id="XMLID_840_" class="st2" d="M52.2 36.3h97.6v58.4H52.2z"/> <g id="XMLID_736_"> <path id="XMLID_839_" class="st3" d="M52.2 36.3h15.2v58.4H52.2z"/> <g id="XMLID_836_"> <path id="XMLID_838_" class="st3" d="M136.9 38.8h9.4v3.6h-9.4z"/> <path id="XMLID_837_" class="st3" d="M125.6 38.8h9.4v3.6h-9.4z"/> </g> <g id="XMLID_810_"> <path id="XMLID_835_" class="st6" d="M121.7 78l-15.2-27c-.7-1.2-2.5-1.2-3.2 0L88 78c-.7 1.2.2 2.7 1.6 2.7h30.5c1.4.1 2.3-1.4 1.6-2.7z"/> <path id="XMLID_834_" class="st8" d="M90.5 78.2l14.3-25.4 14.4 25.4z"/> <g id="XMLID_831_"> <g id="XMLID_915_"> <path id="XMLID_918_" class="st6" d="M106.7 64.3c0 3.5-.8 8.8-1.9 8.8-1 0-1.9-5.3-1.9-8.8s.8-3.8 1.9-3.8c1 0 1.9.3 1.9 3.8z"/> <circle id="XMLID_917_" class="st6" cx="104.8" cy="74.9" r="1"/> </g> </g> </g> </g> </g> </g> <g id="keyboard_3_"> <path id="XMLID_734_" class="st2" d="M151 130.9c0-.7-.6-1.2-1.3-1.2H52.3c-.7 0-1.3.5-1.3 1.2v35.8c0 .7.6 1.2 1.3 1.2h97.4c.7 0 1.3-.5 1.3-1.2v-35.8z"/> <g id="XMLID_602_"> <path id="XMLID_733_" class="st4" d="M59 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_732_" class="st4" d="M68.9 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_731_" class="st4" d="M70.5 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_730_" class="st4" d="M67.3 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3H67c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_729_" class="st4" d="M59 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_728_" class="st4" d="M65.6 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_727_" class="st4" d="M72.2 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_726_" class="st4" d="M128.6 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_725_" class="st4" d="M135.3 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-2.5c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v2.5z"/> <path id="XMLID_724_" class="st4" d="M148.5 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-2.5c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v2.5z"/> <path id="XMLID_723_" class="st4" d="M80.5 165.3c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_722_" class="st4" d="M122 165.3c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_721_" class="st4" d="M113.7 165.3c0 .2-.1.3-.3.3H82c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h31.3c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_720_" class="st4" d="M73.9 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_719_" class="st4" d="M80.5 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_718_" class="st4" d="M87.1 157.8c0 .2-.1.3-.3.3H82c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_717_" class="st4" d="M93.8 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_716_" class="st4" d="M100.4 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_715_" class="st4" d="M107 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_714_" class="st4" d="M113.7 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_713_" class="st4" d="M120.3 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_712_" class="st4" d="M126.9 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_711_" class="st4" d="M133.5 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_710_" class="st4" d="M148.5 157.8c0 .2-.1.3-.3.3H135c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h13.1c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_709_" class="st4" d="M77.1 151.2c0 .2-.1.3-.3.3H72c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_708_" class="st4" d="M83.8 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_707_" class="st4" d="M90.4 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_706_" class="st4" d="M97 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_705_" class="st4" d="M103.6 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_704_" class="st4" d="M110.3 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_703_" class="st4" d="M116.9 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_702_" class="st4" d="M123.5 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_701_" class="st4" d="M130.1 151.2c0 .2-.1.3-.3.3H125c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_700_" class="st4" d="M136.8 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_699_" class="st4" d="M143.4 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_698_" class="st4" d="M75.6 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_697_" class="st4" d="M82.2 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_696_" class="st4" d="M88.8 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_695_" class="st4" d="M95.4 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_694_" class="st4" d="M102.1 144.6c0 .2-.1.3-.3.3H97c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_693_" class="st4" d="M108.7 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_692_" class="st4" d="M115.3 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_691_" class="st4" d="M122 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_690_" class="st4" d="M128.6 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_689_" class="st4" d="M135.2 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_688_" class="st4" d="M141.8 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_687_" class="st4" d="M62.3 144.6c0 .2-.1.3-.3.3h-8.2c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3H62c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_686_" class="st4" d="M148.5 137.9c0 .2-.1.3-.3.3H140c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_685_" class="st4" d="M63.9 151.2c0 .2-.1.3-.3.3h-9.7c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h9.7c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_684_" class="st4" d="M60.6 157.8c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_683_" class="st4" d="M65.6 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_682_" class="st4" d="M72.2 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_681_" class="st4" d="M78.8 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_680_" class="st4" d="M85.5 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_679_" class="st4" d="M92.1 137.9c0 .2-.1.3-.3.3H87c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_678_" class="st4" d="M98.7 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_677_" class="st4" d="M105.3 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_676_" class="st4" d="M112 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_675_" class="st4" d="M118.6 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_674_" class="st4" d="M125.2 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_673_" class="st4" d="M131.9 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_672_" class="st4" d="M138.5 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <g id="XMLID_611_"> <path id="XMLID_614_" class="st4" d="M136.4 162.6v2.6c0 .1 0 .2.1.2.1.1.1.1.2.1h4.8c.1 0 .2 0 .2-.1.1-.1.1-.1.1-.2v-2.6h-5.4z"/> <path id="XMLID_613_" class="st4" d="M141.9 162.3v-2.6c0-.1 0-.2-.1-.2-.1-.1-.1-.1-.2-.1h-4.8c-.1 0-.2 0-.2.1-.1.1-.1.1-.1.2v2.6h5.4z"/> </g> <path id="XMLID_610_" class="st4" d="M143.3 139.4c-.1 0-.2 0-.2.1-.1.1-.1.1-.1.2v4.8c0 .1 0 .2.1.2.1.1.1.1.2.1h1.3v6.3c0 .1 0 .2.1.2.1.1.1.1.2.1h3.2c.1 0 .2 0 .2-.1.1-.1.1-.1.1-.2v-11.4c0-.1 0-.2-.1-.2-.1-.1-.1-.1-.2-.1h-4.8z"/> </g> </g> </g> </g> </svg> <div class="no-results-header">We could not find any results.</div><div class="no-results-subheader">Please, try with another word or more generic phrase.</div></div>');

                        }

                    },
                    error: function (errors) {

                        // WIPE DATA
                        containerWrapper.empty();

                        // APPEND
                        containerWrapper.html('<div class="no-results-container"> <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 200 200"><style>.st0{fill:#BABABA}.st1{clip-path:url(#XMLID_90_)}.st2{fill:#FFF}.st3{fill:#E6E7E8}.st4{fill:#CCC}.st5{fill:#C1C1C1}.st6{fill:#929292}.st7{fill:#0E303F}.st8{fill:#DBDBDB}</style><circle id="XMLID_873_" class="st0" cx="100" cy="100" r="100"/> <g id="XMLID_599_"> <defs> <circle id="XMLID_600_" cx="100" cy="100" r="100"/> </defs> <clipPath id="XMLID_90_"> <use xlink:href="#XMLID_600_" overflow="visible"/> </clipPath> <g id="XMLID_601_" class="st1"> <g id="mouse_computer_1_"> <g id="XMLID_865_"> <path id="XMLID_866_" class="st2" d="M112.2 120.4h48.4c1.4 0 2.6 1.2 2.6 2.6v20.3h1.1v-15.1-5.2c0-2.1-1.7-3.8-3.8-3.8h-48.4"/> </g> <g id="XMLID_860_"> <path id="XMLID_864_" class="st2" d="M165.1 136.4c2.9 0 5.2 2.3 5.2 5.2v12.5c0 2.9-2.3 5.2-5.2 5.2h-1.4v-22.9h1.4z"/> <path id="XMLID_861_" class="st3" d="M162.3 136.4h1.4v22.9h-1.4c-2.9 0-5.2-2.3-5.2-5.2v-12.5c0-2.9 2.3-5.2 5.2-5.2z"/> </g> <g id="XMLID_857_"> <path id="XMLID_859_" class="st4" d="M165.4 141.9v1.1c0 1-.8 1.7-1.7 1.7v-4.6c1 .1 1.7.8 1.7 1.8z"/> <path id="XMLID_858_" class="st5" d="M163.7 140.2v4.6c-1 0-1.7-.8-1.7-1.7V142c0-1.1.7-1.8 1.7-1.8z"/> </g> </g> <g id="screen_1_"> <g id="XMLID_805_"> <path id="XMLID_854_" class="st6" d="M88.7 104.4c-1.1 4.6-2.2 9.2-3.4 13.8h31.5c-1.1-4.6-2.2-9.2-3.4-13.8H88.7z"/> <path id="XMLID_853_" class="st2" d="M118.7 118H83.3c-.9 0-1.6.9-1.6 1.9v.7h38.6v-.7c0-1.1-.7-1.9-1.6-1.9z"/> <path id="XMLID_852_" class="st2" d="M47.9 99.1v7.6c0 1.5 1.2 2.6 2.6 2.6h101c1.5 0 2.6-1.2 2.6-2.6v-7.6H47.9z"/> <path id="XMLID_851_" class="st7" d="M154.2 99.1V34.8c0-1.5-1.2-2.6-2.6-2.6h-101c-1.5 0-2.6 1.2-2.6 2.6v64.3h106.2z"/> <path id="XMLID_850_" class="st2" d="M52.2 36.3h97.6v58.4H52.2z"/> <g id="XMLID_806_"> <path id="XMLID_849_" class="st3" d="M52.2 36.3h15.2v58.4H52.2z"/> <g id="XMLID_807_"> <path id="XMLID_809_" class="st3" d="M136.9 38.8h9.4v3.6h-9.4z"/> <path id="XMLID_808_" class="st3" d="M125.6 38.8h9.4v3.6h-9.4z"/> </g> <circle id="XMLID_891_" class="st6" cx="104.8" cy="65.5" r="15.3"/> <circle id="XMLID_892_" class="st8" cx="104.8" cy="65.5" r="12.8"/> <g id="XMLID_895_"> <g id="XMLID_1051_"> <path id="XMLID_1053_" class="st6" d="M99.3 71c-.4-.4-.4-1 0-1.4l9.6-9.6c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-9.6 9.6c-.4.4-1 .4-1.4 0z"/> <path id="XMLID_1052_" class="st6" d="M99.3 59.9c.4-.4 1-.4 1.4 0l9.6 9.6c.4.4.4 1 0 1.4-.4.4-1 .4-1.4 0l-9.6-9.6c-.4-.3-.4-1 0-1.4z"/> </g> </g> </g> </g> </g> <g id="keyboard_2_"> <path id="XMLID_804_" class="st2" d="M151 130.9c0-.7-.6-1.2-1.3-1.2H52.3c-.7 0-1.3.5-1.3 1.2v35.8c0 .7.6 1.2 1.3 1.2h97.4c.7 0 1.3-.5 1.3-1.2v-35.8z"/> <g id="XMLID_737_"> <path id="XMLID_803_" class="st4" d="M59 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_802_" class="st4" d="M68.9 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_801_" class="st4" d="M70.5 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_800_" class="st4" d="M67.3 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3H67c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_799_" class="st4" d="M59 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_798_" class="st4" d="M65.6 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_797_" class="st4" d="M72.2 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_796_" class="st4" d="M128.6 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_795_" class="st4" d="M135.3 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-2.5c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v2.5z"/> <path id="XMLID_794_" class="st4" d="M148.5 165.3c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-2.5c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v2.5z"/> <path id="XMLID_793_" class="st4" d="M80.5 165.3c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_792_" class="st4" d="M122 165.3c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_791_" class="st4" d="M113.7 165.3c0 .2-.1.3-.3.3H82c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h31.3c.2 0 .3.1.3.3v5.6z"/> <path id="XMLID_790_" class="st4" d="M73.9 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_789_" class="st4" d="M80.5 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_788_" class="st4" d="M87.1 157.8c0 .2-.1.3-.3.3H82c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_787_" class="st4" d="M93.8 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_786_" class="st4" d="M100.4 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_785_" class="st4" d="M107 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_784_" class="st4" d="M113.7 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_783_" class="st4" d="M120.3 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_782_" class="st4" d="M126.9 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_781_" class="st4" d="M133.5 157.8c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_780_" class="st4" d="M148.5 157.8c0 .2-.1.3-.3.3H135c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h13.1c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_779_" class="st4" d="M77.1 151.2c0 .2-.1.3-.3.3H72c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_778_" class="st4" d="M83.8 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_777_" class="st4" d="M90.4 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_776_" class="st4" d="M97 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_775_" class="st4" d="M103.6 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_774_" class="st4" d="M110.3 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_773_" class="st4" d="M116.9 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_772_" class="st4" d="M123.5 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_771_" class="st4" d="M130.1 151.2c0 .2-.1.3-.3.3H125c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_770_" class="st4" d="M136.8 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_769_" class="st4" d="M143.4 151.2c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_768_" class="st4" d="M75.6 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_767_" class="st4" d="M82.2 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_766_" class="st4" d="M88.8 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_765_" class="st4" d="M95.4 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_764_" class="st4" d="M102.1 144.6c0 .2-.1.3-.3.3H97c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_763_" class="st4" d="M108.7 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_762_" class="st4" d="M115.3 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_761_" class="st4" d="M122 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_760_" class="st4" d="M128.6 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_759_" class="st4" d="M135.2 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_758_" class="st4" d="M141.8 144.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_757_" class="st4" d="M62.3 144.6c0 .2-.1.3-.3.3h-8.2c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3H62c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_756_" class="st4" d="M148.5 137.9c0 .2-.1.3-.3.3H140c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_755_" class="st4" d="M63.9 151.2c0 .2-.1.3-.3.3h-9.7c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h9.7c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_754_" class="st4" d="M60.6 157.8c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3V153c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_753_" class="st4" d="M65.6 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_752_" class="st4" d="M72.2 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_751_" class="st4" d="M78.8 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_750_" class="st4" d="M85.5 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_749_" class="st4" d="M92.1 137.9c0 .2-.1.3-.3.3H87c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_748_" class="st4" d="M98.7 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_747_" class="st4" d="M105.3 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_746_" class="st4" d="M112 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_745_" class="st4" d="M118.6 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_744_" class="st4" d="M125.2 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_743_" class="st4" d="M131.9 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <path id="XMLID_742_" class="st4" d="M138.5 137.9c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/> <g id="XMLID_739_"> <path id="XMLID_741_" class="st4" d="M136.4 162.6v2.6c0 .1 0 .2.1.2.1.1.1.1.2.1h4.8c.1 0 .2 0 .2-.1.1-.1.1-.1.1-.2v-2.6h-5.4z"/> <path id="XMLID_740_" class="st4" d="M141.9 162.3v-2.6c0-.1 0-.2-.1-.2-.1-.1-.1-.1-.2-.1h-4.8c-.1 0-.2 0-.2.1-.1.1-.1.1-.1.2v2.6h5.4z"/> </g> <path id="XMLID_738_" class="st4" d="M143.3 139.4c-.1 0-.2 0-.2.1-.1.1-.1.1-.1.2v4.8c0 .1 0 .2.1.2.1.1.1.1.2.1h1.3v6.3c0 .1 0 .2.1.2.1.1.1.1.2.1h3.2c.1 0 .2 0 .2-.1.1-.1.1-.1.1-.2v-11.4c0-.1 0-.2-.1-.2-.1-.1-.1-.1-.2-.1h-4.8z"/> </g> </g> </g> </g> </svg> <div class="no-results-header">There is a problem with the searching module.</div><div class="no-results-subheader">Please, try again later or contact us for more information.</div></div>');


                    }
                });

            }

        }

        /***** Don't allow to submit the form *****/
        morphSearch.querySelector( 'button[type="submit"]' ).addEventListener( 'click', function(ev) { ev.preventDefault(); } );
    })();

</script>