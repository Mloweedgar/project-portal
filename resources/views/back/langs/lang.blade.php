@extends('layouts.back')
<link href="{{ asset('back/css/views/langs.css') }}" rel="stylesheet">
@section('styles')
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="content-title">{{__("langs.title")}}</h1>


        <div class="row content-row">

            <div class="col-md-12">
                <form method="POST" action="{{ route('langs.active') }}">
                    {{ csrf_field() }}
                    <div class="form-inline">
                        <div class="form-group" >

                            <select class="selectpicker" name="lang" data-live-search="true">
                                @foreach($languages as $language)
                                    <option {{$language->active ? "selected" : ""}} value="{{ $language->id }}">{{ $language->iso }}
                                        - {{ $language->name }}</option>
                                @endforeach
                            </select>

                            <input type="submit"
                                    class="btn btn-large btn-primary waves-effect" value="{{ __('langs.active') }}">



                                <button type="button" class="btn btn-large btn-primary waves-effect" data-toggle="modal" data-target="#new-lang-modal">
                                    {{ __('langs.add') }}
                                </button>
                        </div>

                    </div>

                    <div class="form-group">
                        <select class="selectpicker select-section" name="section" data-live-search="true">
                            <option disabled selected> {{ __('langs.select_section') }} </option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ __('langs.'.$section->name) }}</option>
                            @endforeach
                        </select>

                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div id="show-translate"></div>
            </div>
        </div>

    </div>


    <div id="new-lang-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('langs.add') }}</h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                       <div class="form-line">
                           <select  class="selectpicker" data-live-search="true">
                               @foreach($newlangs as $newlang)
                                   <option value="{{$newlang->id}}">{{$newlang->iso}} - {{$newlang->name}}</option>
                                   @endforeach

                           </select>
                       </div>
                   </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="new-lang" class="btn btn-large btn-primary waves-effect pull-left"  >{{__('general.save')}}</button> <button type="button" class="btn btn-large btn-primary waves-effect"  data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>

    <script>
        $(document).ready(function () {



            $('select.select-section').on('change', function () {

                $("#show-translate").load("{{route('langs.edit')}}", {"section_id": $('[name="section"]').val(), "lang_id" : $('[name="lang"]').val()}, function(){
                    $('form button').click(function (e) {
                        e.preventDefault();

                        var self = $(this);
                        var validate = true;

                        $('.alert-danger').remove();

                        $('.has-attr').each(function (index, element) {

                            var emptyAttr = true;
                            var attr = $(element).data('attr');
                            attr = attr.split(", ");

                            for (var i = 0; i < attr.length; i++) {
                                if ($(element).val().indexOf(attr[i]) === -1 && $(element).val()) {
                                    emptyAttr = false;
                                    validate = false;
                                }
                            }

                            if (emptyAttr === false) {
                                $('html, body').animate({
                                    scrollTop: $(element).offset().top-($(window).height()/2)
                                }, 0);
                                $(element).parent('div').append("<p class='alert alert-danger'> {!! __('langs.required_parameter') !!} </p>");
                            }


                        });

                        if (validate) {
                            self.parent('form').submit();
                        }

                    });


                    $('.form-float').each(function(index, element){
                        var inputVal=$(this).find('input').val();

                        if(inputVal===undefined || inputVal===''){
                            $(element).find('.form-line').addClass('empty');
                            $(element).find('.form-line').removeClass('focused');
                        }else{
                            $(element).find('.form-line').addClass('focused');
                            $(element).find('.form-line').removeClass('empty');

                        }
                    });

                    $('.form-float input').on('focus', function(){
                        $(this).closest('.form-line').addClass('focused');
                    });

                    $('.form-float input').on('blur', function(){
                        var formLine = $(this).closest('.form-line');
                        var inputVal=$(this).val();


                        if(inputVal===undefined || inputVal===''){
                            formLine.removeClass('focused');
                            formLine.addClass('empty');

                        }else{
                            formLine.addClass('focused');
                            formLine.removeClass('empty');
                        }
                    });
                });


            });

            $('#new-lang').click(function(){


                $.ajax({
                    url: '{!! route('langs.new') !!}',
                    type: 'POST',
                    data: { 'id': $('#new-lang-modal select').val()},
                    success: function(result) {

                        $('#new-lang-modal').modal('toggle');
                        if(!result.status){
                            swal("{{__('messages.error_oops')}}", result.message, "error");
                        }else{
                            swal({
                                title: "{{trans('messages.success')}}",
                                text: "{{ trans('langs.saved') }}",
                                type: "success",
                                html: true
                            }, function(){
                                location.reload();
                            });



                        }


                    }
                });
            });


        });
    </script>
@endsection
