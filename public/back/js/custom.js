
if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.AdminBSB = {};
$.AdminBSB.options = {
    colors: {
        red: '#F44336',
        pink: '#E91E63',
        purple: '#9C27B0',
        deepPurple: '#673AB7',
        indigo: '#3F51B5',
        blue: '#2196F3',
        lightBlue: '#03A9F4',
        cyan: '#00BCD4',
        teal: '#009688',
        green: '#4CAF50',
        lightGreen: '#8BC34A',
        lime: '#CDDC39',
        yellow: '#ffe821',
        amber: '#FFC107',
        orange: '#FF9800',
        deepOrange: '#FF5722',
        brown: '#795548',
        grey: '#9E9E9E',
        blueGrey: '#607D8B',
        black: '#000000',
        white: '#ffffff'
    },
    leftSideBar: {
        scrollColor: 'rgba(0,0,0,0.5)',
        scrollWidth: '4px',
        scrollAlwaysVisible: false,
        scrollBorderRadius: '0',
        scrollRailBorderRadius: '0'
    },
    dropdownMenu: {
        effectIn: 'fadeIn',
        effectOut: 'fadeOut'
    }
}

/* Left Sidebar - Function =================================================================================================
 *  You can manage the left sidebar menu options
 *
 */
$.AdminBSB.leftSideBar = {
    activate: function () {
        var _this = this;
        var $body = $('body');
        var $overlay = $('.overlay');

        //Close sidebar
        $(window).click(function (e) {
            var $target = $(e.target);
            if (e.target.nodeName.toLowerCase() === 'i') { $target = $(e.target).parent(); }

            if (!$target.hasClass('bars') && _this.isOpen() && $target.parents('#leftsidebar').length === 0) {
                if (!$target.hasClass('js-right-sidebar')) $overlay.fadeOut();
                $body.removeClass('overlay-open');
            }
        });

        $.each($('.menu-toggle.toggled'), function (i, val) {
            $(val).next().slideToggle(0);
        });

        //When page load
        $.each($('.menu .list li.active'), function (i, val) {
            var $activeAnchors = $(val).find('a:eq(0)');

            $activeAnchors.addClass('toggled');
            $activeAnchors.next().show();
        });

        //Collapse or Expand Menu
        $('.menu-toggle').on('click', function (e) {
            var $this = $(this);
            var $content = $this.next();

            if ($($this.parents('ul')[0]).hasClass('list')) {
                var $not = $(e.target).hasClass('menu-toggle') ? e.target : $(e.target).parents('.menu-toggle');

                $.each($('.menu-toggle.toggled').not($not).next(), function (i, val) {
                    if ($(val).is(':visible')) {
                        $(val).prev().toggleClass('toggled');
                        $(val).slideUp();
                    }
                });
            }

            $this.toggleClass('toggled');
            $content.slideToggle(320);
        });

        //Set menu height
        _this.setMenuHeight();
        _this.checkStatuForResize(true);
        $(window).resize(function () {
            _this.setMenuHeight();
            _this.checkStatuForResize(false);
        });

        //Set Waves
        Waves.attach('.menu .list a', ['waves-block']);
        Waves.init();
    },
    setMenuHeight: function () {
        if (typeof $.fn.slimScroll != 'undefined') {
            var configs = $.AdminBSB.options.leftSideBar;
            var height = ($(window).height() - ($('.legal').outerHeight() + $('.user-info').outerHeight() + $('.navbar').innerHeight()));

            var $el = $('.list'); // altura

            //$el.slimScroll({ destroy: true }).height("auto");
            $el.parent().find('.slimScrollBar, .slimScrollRail').remove();

            $el.slimscroll({
                height: height + "px",
                color: configs.scrollColor,
                size: configs.scrollWidth,
                alwaysVisible: configs.scrollAlwaysVisible,
                borderRadius: configs.scrollBorderRadius,
                railBorderRadius: configs.scrollRailBorderRadius
            });

        }
    },
    checkStatuForResize: function (firstTime) {
        var $body = $('body');
        var $openCloseBar = $('.navbar .navbar-header .bars');
        var width = $body.width();

        if (firstTime) {
            $body.find('.content, .sidebar').addClass('no-animate').delay(1000).queue(function () {
                $(this).removeClass('no-animate').dequeue();
            });
        }

        if (width < 1170) {
            $body.addClass('ls-closed');
            $openCloseBar.fadeIn();
        }
        else {
            $body.removeClass('ls-closed');
            $openCloseBar.fadeOut();
        }
    },
    isOpen: function () {
        return $('body').hasClass('overlay-open');
    }
};
//==========================================================================================================================

/* Right Sidebar - Function ================================================================================================
 *  You can manage the right sidebar menu options
 *
 */
$.AdminBSB.rightSideBar = {
    activate: function () {
        var _this = this;
        var $sidebar = $('#rightsidebar');
        var $overlay = $('.overlay');

        //Close sidebar
        $(window).click(function (e) {
            var $target = $(e.target);
            if (e.target.nodeName.toLowerCase() === 'i') { $target = $(e.target).parent(); }

            if (!$target.hasClass('js-right-sidebar') && _this.isOpen() && $target.parents('#rightsidebar').length === 0) {
                if (!$target.hasClass('bars')) $overlay.fadeOut();
                $sidebar.removeClass('open');
            }
        });

        $('.js-right-sidebar').on('click', function () {
            $sidebar.toggleClass('open');
            if (_this.isOpen()) { $overlay.fadeIn(); } else { $overlay.fadeOut(); }
        });
    },
    isOpen: function () {
        return $('.right-sidebar').hasClass('open');
    }
}
//==========================================================================================================================

/* Searchbar - Function ================================================================================================
 *  You can manage the search bar
 *
 */
var $searchBar = $('.search-bar');
$.AdminBSB.search = {
    activate: function () {
        var _this = this;

        //Search button click event
        $('.js-search').on('click', function () {
            _this.showSearchBar();
        });

        //Close search click event
        $searchBar.find('.close-search').on('click', function () {
            _this.hideSearchBar();
        });

        //ESC key on pressed
        $searchBar.find('input[type="text"]').on('keyup', function (e) {
            if (e.keyCode == 27) {
                _this.hideSearchBar();
            }
        });
    },
    showSearchBar: function () {
        $searchBar.addClass('open');
        $searchBar.find('input[type="text"]').focus();
    },
    hideSearchBar: function () {
        $searchBar.removeClass('open');
        $searchBar.find('input[type="text"]').val('');
    }
}
//==========================================================================================================================

/* Navbar - Function =======================================================================================================
 *  You can manage the navbar
 *
 */
$.AdminBSB.navbar = {
    activate: function () {
        var $body = $('body');
        var $overlay = $('.overlay');

        //Open left sidebar panel
        $('.bars').on('click', function () {
            $body.toggleClass('overlay-open');
            if ($body.hasClass('overlay-open')) { $overlay.fadeIn(); } else { $overlay.fadeOut(); }
        });

        //Close collapse bar on click event
        $('.nav [data-close="true"]').on('click', function () {
            var isVisible = $('.navbar-toggle').is(':visible');
            var $navbarCollapse = $('.navbar-collapse');

            if (isVisible) {
                $navbarCollapse.slideUp(function () {
                    $navbarCollapse.removeClass('in').removeAttr('style');
                });
            }
        });
    }
}
//==========================================================================================================================

/* Input - Function ========================================================================================================
 *  You can manage the inputs(also textareas) with name of class 'form-control'
 *
 */
$.AdminBSB.input = {
    activate: function () {
        //On focus event
        $('.form-control').focus(function () {
            $(this).parent().addClass('focused');
        });

        //On focusout event
        $('.form-control').focusout(function () {
            var $this = $(this);
            if ($this.parents('.form-group').hasClass('form-float')) {
                if ($this.val() == '') { $this.parents('.form-line').removeClass('focused'); }
            }
            else {
                $this.parents('.form-line').removeClass('focused');
            }
        });

        //On label click
        $('body').on('click', '.form-float .form-line .form-label', function () {
            $(this).parent().find('input').focus();
        });
    }
}
//==========================================================================================================================

/* Form - Select - Function ================================================================================================
 *  You can manage the 'select' of form elements
 *
 */
$.AdminBSB.select = {
    activate: function () {
        if ($.fn.selectpicker) { $('select:not(.ms)').selectpicker(); }
    }
}
//==========================================================================================================================

/* DropdownMenu - Function =================================================================================================
 *  You can manage the dropdown menu
 *
 */

$.AdminBSB.dropdownMenu = {
    activate: function () {
        var _this = this;

        $('.dropdown, .dropup, .btn-group').on({
            "show.bs.dropdown": function () {
                var dropdown = _this.dropdownEffect(this);
                _this.dropdownEffectStart(dropdown, dropdown.effectIn);
            },
            "shown.bs.dropdown": function () {
                var dropdown = _this.dropdownEffect(this);
                if (dropdown.effectIn && dropdown.effectOut) {
                    _this.dropdownEffectEnd(dropdown, function () { });
                }
            },
            "hide.bs.dropdown": function (e) {
                var dropdown = _this.dropdownEffect(this);
                if (dropdown.effectOut) {
                    e.preventDefault();
                    _this.dropdownEffectStart(dropdown, dropdown.effectOut);
                    _this.dropdownEffectEnd(dropdown, function () {
                        dropdown.dropdown.removeClass('open');
                    });
                }
            }
        });

        //Set Waves
        Waves.attach('.dropdown-menu li a', ['waves-block']);
        Waves.init();
    },
    dropdownEffect: function (target) {
        var effectIn = $.AdminBSB.options.dropdownMenu.effectIn, effectOut = $.AdminBSB.options.dropdownMenu.effectOut;
        var dropdown = $(target), dropdownMenu = $('.dropdown-menu', target);

        if (dropdown.size() > 0) {
            var udEffectIn = dropdown.data('effect-in');
            var udEffectOut = dropdown.data('effect-out');
            if (udEffectIn !== undefined) { effectIn = udEffectIn; }
            if (udEffectOut !== undefined) { effectOut = udEffectOut; }
        }

        return {
            target: target,
            dropdown: dropdown,
            dropdownMenu: dropdownMenu,
            effectIn: effectIn,
            effectOut: effectOut
        };
    },
    dropdownEffectStart: function (data, effectToStart) {
        if (effectToStart) {
            data.dropdown.addClass('dropdown-animating');
            data.dropdownMenu.addClass('animated dropdown-animated');
            data.dropdownMenu.addClass(effectToStart);
        }
    },
    dropdownEffectEnd: function (data, callback) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        data.dropdown.one(animationEnd, function () {
            data.dropdown.removeClass('dropdown-animating');
            data.dropdownMenu.removeClass('animated dropdown-animated');
            data.dropdownMenu.removeClass(data.effectIn);
            data.dropdownMenu.removeClass(data.effectOut);

            if (typeof callback == 'function') {
                callback();
            }
        });
    }
}
//==========================================================================================================================

/* Browser - Function ======================================================================================================
 *  You can manage browser
 *
 */
var edge = 'Microsoft Edge';
var ie10 = 'Internet Explorer 10';
var ie11 = 'Internet Explorer 11';
var opera = 'Opera';
var firefox = 'Mozilla Firefox';
var chrome = 'Google Chrome';
var safari = 'Safari';

$.AdminBSB.browser = {
    activate: function () {
        var _this = this;
        var className = _this.getClassName();

        if (className !== '') $('html').addClass(_this.getClassName());
    },
    getBrowser: function () {
        var userAgent = navigator.userAgent.toLowerCase();

        if (/edge/i.test(userAgent)) {
            return edge;
        } else if (/rv:11/i.test(userAgent)) {
            return ie11;
        } else if (/msie 10/i.test(userAgent)) {
            return ie10;
        } else if (/opr/i.test(userAgent)) {
            return opera;
        } else if (/chrome/i.test(userAgent)) {
            return chrome;
        } else if (/firefox/i.test(userAgent)) {
            return firefox;
        } else if (!!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)) {
            return safari;
        }

        return undefined;
    },
    getClassName: function () {
        var browser = this.getBrowser();

        if (browser === edge) {
            return 'edge';
        } else if (browser === ie11) {
            return 'ie11';
        } else if (browser === ie10) {
            return 'ie10';
        } else if (browser === opera) {
            return 'opera';
        } else if (browser === chrome) {
            return 'chrome';
        } else if (browser === firefox) {
            return 'firefox';
        } else if (browser === safari) {
            return 'safari';
        } else {
            return '';
        }
    }
}
//==========================================================================================================================

$(function () {
    $.AdminBSB.browser.activate();
    $.AdminBSB.leftSideBar.activate();
    $.AdminBSB.rightSideBar.activate();
    $.AdminBSB.navbar.activate();
    $.AdminBSB.dropdownMenu.activate();
    $.AdminBSB.input.activate();
    $.AdminBSB.select.activate();
    $.AdminBSB.search.activate();

    setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
});

$(function () {
    skinChanger();
    activateNotificationAndTasksScroll();

    setSkinListHeightAndScroll();
    setSettingListHeightAndScroll();
    $(window).resize(function () {
        setSkinListHeightAndScroll();
        setSettingListHeightAndScroll();
    });
});

//Skin changer
function skinChanger() {
    $('.right-sidebar .demo-choose-skin li').on('click', function () {
        var $body = $('body');
        var $this = $(this);

        var existTheme = $('.right-sidebar .demo-choose-skin li.active').data('theme');
        $('.right-sidebar .demo-choose-skin li').removeClass('active');
        $body.removeClass('theme-' + existTheme);
        $this.addClass('active');

        $body.addClass('theme-' + $this.data('theme'));
    });
}

//Skin tab content set height and show scroll
function setSkinListHeightAndScroll() {
    var height = $(window).height() - ($('.navbar').innerHeight() + $('.right-sidebar .nav-tabs').outerHeight());
    var $el = $('.demo-choose-skin');

    $el.slimScroll({ destroy: true }).height('auto');
    $el.parent().find('.slimScrollBar, .slimScrollRail').remove();

    $el.slimscroll({
        height: height + 'px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}

//Setting tab content set height and show scroll
function setSettingListHeightAndScroll() {
    var height = $(window).height() - ($('.navbar').innerHeight() + $('.right-sidebar .nav-tabs').outerHeight());
    var $el = $('.right-sidebar .demo-settings');

    $el.slimScroll({ destroy: true }).height('auto');
    $el.parent().find('.slimScrollBar, .slimScrollRail').remove();

    $el.slimscroll({
        height: height + 'px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}

//Activate notification and task dropdown on top right menu
function activateNotificationAndTasksScroll() {
    $('.navbar-right .dropdown-menu .body .menu').slimscroll({
        height: '254px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}

//Google Analiytics ======================================================================================

//========================================================================================================

/**
 * Fix for sidebar not hiding the overlay
 */

$(window).resize(function(){

    if ($(window).width() >= 1170) {

        $("body").removeClass("overlay-open");
        $(".overlay").css('display','none');

    }

});

/**
 * Appends the data type
 */
$('.type').click(function () {
    $(this).parent().parent().find('input[name="submit-type"]').val($(this).data('type'));
    $(this).closest('form').submit();
});

/**
 * Open the modal for request for modification
 **/

$(".request-modification-button").click(function () {
    $(this).parent().find(".request-modification-modal").modal('show');
});


$(".rfm-open-btn").click(function () {
    var form = $(this).closest('form');

    // Enable everything inside the form
    form.find('*').removeProp('disabled');
    form.find('select').selectpicker('refresh');

    // Update buttons
    form.find('.rfm-open-btn').addClass('hidden');
    form.find('.rfm-submit-btn').removeClass('hidden');
    form.find('.rfm-submit-btn2').removeClass('hidden');
    form.find('.rfm-close-btn').removeClass('hidden');

    /**
     * Reload CKEDITOR
     */
    // First destroy all instances
    for(name in CKEDITOR.instances)
    {
        CKEDITOR.instances[name].destroy();
    }
    // Second remove all elements
    var editorsToDestroy = $(".cke_editor_description");
    editorsToDestroy.each(function () {
        $(this).remove();
    });
    // Third init again all editors
    $('.richEditor').each(function(){
        $(this).attr('id', generateUniqueID());
        CKEDITOR.replace(this.id);
    });

    // .rfm-reason-section !!!
    var reasonHtml = '<div class="rfm-reason-section"><div class="alert alert-info">Now you can modify the records of the form. Once you finish modifying the records as per needs, add the reason below and submit your Request for modification.</div>\
        <div class="form-group"><b>Reason</b><div class="form-line">\
            <textarea class="form-control no-resize" name="reason" placeholder="Add your reason here" aria-required="true" aria-invalid="false"></textarea>\
        </div></div></div>';

    $(reasonHtml).insertBefore($(form).find('.project-buttons'));
});

function generateUniqueID() {
    randomNumber = Math.round(new Date().getTime() + (Math.random() * 100));
    return randomNumber;
}

$(".rfm-close-btn").click(function () {
    var form = $(this).closest('form');

    // Remove reason section
    form.find('.rfm-reason-section').remove();

    // Update buttons
    form.find('.rfm-open-btn').removeClass('hidden');
    form.find('.rfm-submit-btn').addClass('hidden');
    form.find('.rfm-submit-btn2').addClass('hidden');
    form.find('.rfm-close-btn').addClass('hidden');
});

$(".rfm-submit-btn").click(function () {
    var form = $(this).closest('form');
    var old_url = form.prop('action');
    var rfm_url = "/request-modification/store";
    form.prop('action', rfm_url);
    form.submit();

    // return;
    //
    // var form_values = form.serializeArray();
    //
    // var section_fields = $(this).data('fields').split(',');
    // var always_fields = ['project', 'section', 'position', 'reason'];
    //
    // // required fields (merge of specific section fields and 'global' ones)
    // var required_fields = section_fields.concat(always_fields);
    //
    // // existents_fields
    // var existents_fields = [];
    //
    // form_values = form_values.filter(function(item) {
    //     if ($.inArray(item.name, required_fields) !== -1) {
    //         existents_fields.push(item.name);
    //         return true;
    //     }
    // });
    //
    // // check if $existents_fields contains all the $required_fields.
    // $.each(required_fields, function(i, field_name){
    //     if ($.inArray(field_name, existents_fields) == -1) {
    //         alert('Field: "' + field_name + '" is missing !');
    //     }
    // });
    //
    // console.log(form_values);
    //
    // // var jsonSerialized = JSON.parse(form.serializeArray());
    // var jsonSerialized = JSON.stringify(form_values);
    //
    // // var jsonUnserialized = JSON.parse(jsonSerialized);
    // // console.log(jsonUnserialized);
    //
    // console.log(jsonSerialized);
});

// project KPI RFM
$(".rfm-kpi-open-btn").click(function () {

    // Update buttons
    $('.rfm-kpi-open-btn').addClass('hidden');
    $('.rfm-kpi-submit-btn').removeClass('hidden');
    $('.rfm-kpi-close-btn').removeClass('hidden');

    $('table').editableTableWidget();


    // .rfm-reason-section !!!
    var reasonHtml = '<div class="rfm-kpi-reason-section"><div class="alert alert-info">Now you can modify the records of the form. Once you finish modifying the records as per needs, add the reason below and submit your Request for modification.</div>\
        <div class="form-group"><b>Reason</b><div class="form-line">\
            <textarea class="form-control no-resize" name="reason" placeholder="Add your reason here" aria-required="true" aria-invalid="false"></textarea>\
        </div></div></div>';

    $(reasonHtml).insertBefore($(this).parent());
});

$(".rfm-kpi-close-btn").click(function () {
    // Remove reason section
    $('.rfm-kpi-reason-section').remove();

    // Update buttons
    $('.rfm-kpi-open-btn').removeClass('hidden');
    $('.rfm-kpi-submit-btn').addClass('hidden');
    $('.rfm-kpi-close-btn').addClass('hidden');
});

$(".rfm-kpi-submit-btn").click(function () {
    $(".rfm-kpi-submit-btn").addClass('disabled');
    $(".rfm-kpi-submit-btn").html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
    // var form = $(this).closest('form');
    // form.submit();
});



 /**
* Card Behaviour
*/
 $(document).ready(function() {
     $('.card-header').click(function () {

         // Get status of the box
         var headerElement = $('#card-header');
         var bodyElement = $('#card-body');

         var status = headerElement.data("status");

         if (!status) {

             // Card closed, we proceed to open
             bodyElement.removeClass("not-visible").addClass("is-visible");

             // Update the status of the card
             headerElement.data("status", 1);

             // Update the keyboard_arrow of the box
             $('#keyboard_arrow').html("keyboard_arrow_up");

         } else {

             // Card open, we proceed to close
             bodyElement.removeClass("is-visible").addClass("not-visible");

             // Update the status of the card
             headerElement.data("status", 0);

             // Update the keyboard_arrow of the box
             $('#keyboard_arrow').html("keyboard_arrow_down");

         }

     });
     });
// Custom plugins

(function ( $ ) {
    $.fn.zoom = function(selector) {
        _self = this;
        _self.hide();
        $(selector).click(function(){
            _self.show();
            _self.addClass('animate zoomIn');
            $('html, body').animate({
                scrollTop: _self.offset().top
            }, 1000);
        });

        return _self;
    };

}( jQuery ));


function laravelErrors(errors){
  var ul = "<ul style='margin: auto; width: 55%;'>";
  $.each(errors.responseJSON, function(index, field){
    $.each(field, function(index2, error){
      ul += '<li>' + error + '</li>';
    });
  });
  ul += '</ul>';

  return ul;

}

function removeFocusProjectTitle() {
    $("#project-name-editable").removeClass("text-transform-none");
    $("#project-name-save").addClass("hidden");
    $(".project-save-info").addClass("hidden");
    $("#project-name-edit").removeClass("hidden");
}

function saveProjectTitleAjax(){
    var project_name =  $("#project-name-editable").html();
    var project_id = $("#project-name-editable").data('id');
    $("#project-name-editable").blur();

    $.ajax({
        type: "POST",
        url: "/project/change-name",
        data: {"project_name":project_name,"project_id":project_id},
        success: function(data) {
            if (data.status){
                swal({
                    title: "Success!",
                    text: data.message,
                    type: "success",
                    html: true
                },function(isConfirm){
                    location.reload();
                });

                removeFocusProjectTitle();

            }else{
                swal({
                    title: "Oops!",
                    text: data.message,
                    type: "error",
                    html: true
                },
                function(isConfirm){
                    location.reload();
                });
            }

        },
        error: function () {
            swal({
                title: "Oops!",
                text: data.message,
                type: "error",
                html: true
            });
        }
    });
}


$("#project-name-edit").click(function () {
    $("#project-name-editable").addClass("text-transform-none");
    $("#project-name-editable").attr("tabindex",1).focus();
});

$("#project-name-editable").focusin(function () {
    $("#project-name-editable").removeClass("text-transform-none").addClass("text-transform-none");
    $("#project-name-edit").addClass("hidden");
    $("#project-name-save").removeClass("hidden");
    $(".project-save-info").removeClass("hidden");
});

$("#project-name-editable").focusout(function () {
    setTimeout(function(){
        removeFocusProjectTitle();
    }, 200);
});

$("#project-name-editable").on('keydown', function(e) {
    if(e.keyCode == 13)
    {
        e.preventDefault();
        removeFocusProjectTitle();
        saveProjectTitleAjax();
    }
});

$("#project-name-save").click(function () {
    var project_name =  $("#project-name-editable").html();

    if (project_name.length>0){

        saveProjectTitleAjax();

    }

});

$('.check-file-uploader-required').click(function() {

    $(this).parent().parent().find('input[name="submit-type"]').val($(this).data('type'));

    var fine_uploader = $(this).closest('.row').find('.fine-uploader');
    var num_uploads = fine_uploader.find('.qq-upload-list li').length;
    var required_message =  (($(this).data('required-message')) ? $(this).data('required-message') : 'A file is required.');

    if (num_uploads === 0) {
        if (fine_uploader.find('.fine-uploader-error').length === 0) {
            fine_uploader.find('.qq-uploader-selector').addClass('error');
            fine_uploader.append('<p class="fine-uploader-error">'+required_message+'</p>');
        }
    } else {
        $(this).closest('form').submit();
    }
});

// Temporary workaround for providing editor 'read-only' toggling functionality.
( function()
{
    var cancelEvent = function( evt )
    {
        evt.cancel();
    };

    CKEDITOR.editor.prototype.readOnly = function( isReadOnly )
    {
        // Turn off contentEditable.
        this.document.$.body.disabled = isReadOnly;
        CKEDITOR.env.ie ? this.document.$.body.contentEditable = !isReadOnly
            : this.document.$.designMode = isReadOnly ? "off" : "on";

        // Prevent key handling.
        this[ isReadOnly ? 'on' : 'removeListener' ]( 'key', cancelEvent, null, null, 0 );
        this[ isReadOnly ? 'on' : 'removeListener' ]( 'selectionChange', cancelEvent, null, null, 0 );

        // Disable all commands in wysiwyg mode.
        var command,
            commands = this._.commands,
            mode = this.mode;

        for ( var name in commands )
        {
            command = commands[ name ];
            isReadOnly ? command.disable() : command[ command.modes[ mode ] ? 'enable' : 'disable' ]();
            this[ isReadOnly ? 'on' : 'removeListener' ]( 'state', cancelEvent, null, null, 0 );
        }
    }
} )();
