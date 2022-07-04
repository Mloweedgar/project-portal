@extends('layouts.back')


@section('styles')
    <link href="{{ asset('back/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">

    @component('back/components.fine-upload-template-2',['image' => "/storage/logo"])
    @endcomponent

@endsection

@section('content')


    <div class="container-fluid">
        @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
            <div class="section-information">
                <a href="{{ route('documentation').'#general_settings' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
            </div>
    @endif

        <!-- Color Pickers -->
        <div class="row content-row">


            <div class="col-md-6">

                <div class="card card-shadow settings-card">
                    <div class="header">
                        <h2>{{ __("settings.styling") }}</h2>
                    </div>
                    <form class="form-theme" method="POST">
                        {{ csrf_field() }}
                        <div class="body">
                            <!-- Theme -->
                            <label for="theme">{{__('settings.theme')}}</label><i class="fa fa-info-circle m-l-10" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('settings.info_select_theme') }}"></i>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" name="theme" id="theme">
                                        <option disabled>{{ __("settings.select_theme") }}</option>
                                        @foreach($themes as $theme)
                                            <option value="{{ $theme->id }}" {{ $theme->active ? " selected " : ""}}>{{ $theme->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <button type="button" type="button" class="new-theme pull-left btn btn-primary waves-effect btn-block">{{ __("settings.create_theme") }}</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="activate-button" class="btn-activetheme btn btn-primary btn-block waves-effect" {{$activeTheme->active ? 'style=display:none;' : "" }}>{{ __("settings.active_theme") }}</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn-reset btn btn-primary btn-block waves-effect">{{ __("settings.restore_defaults") }}</button>
                                </div>
                            </div>
                            <!-- Theme settings -->
                            <label>{{__('settings.color')}}</label><i class="fa fa-info-circle m-l-10" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('settings.info_select_color') }}"></i>
                            <div class="form-group form-float">
                                <div class="input-group colorpicker">
                                    <div class="form-line label-on-top m-t-20">
                                        <input name="primary_color" id="primary_color" type="text" class="form-control disable-on-default" readonly value="{{ $activeTheme->getPrimaryColor() }}" required>
                                        <label class="form-label" for="primary_color">{{__('settings.primary_color')}}</label>
                                    </div>
                                    <span class="input-group-addon">
                                            <i></i>
                                    </span>
                                </div>
                                <div class="input-group colorpicker">
                                    <div class="form-line label-on-top m-t-20">
                                        <input name="secondary_color" id="secondary_color" type="text" class="form-control disable-on-default" readonly value="{{ $activeTheme->getSecondaryColor() }}" required>
                                        <label class="form-label" for="secondary_color">{{__('settings.secondary_color')}}</label>
                                    </div>
                                    <span class="input-group-addon">
                                            <i></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Title -->
                            <label>{{__('settings.title')}}</label><i class="fa fa-info-circle m-l-10" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('settings.info_select_title') }}"></i>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="title_font_family" id="title_font_family">
                                        @foreach($fonts as $font)
                                            <option value="{{ $font->name }}" {{ $activeTheme->getTitleFontFamily()==$font->name ? "selected" : "" }}> {{ $font->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="title_font_family">{{__('settings.font_family')}}</label>

                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="title_font_size" id="title_font_size">
                                        <option value="14px" {{ $activeTheme->getTitleFontSize()=="14px" ? "selected" : "" }}>14 px</option>
                                        <option value="16px" {{ $activeTheme->getTitleFontSize()=="16px" ? "selected" : "" }}>16 px</option>
                                        <option value="18px" {{ $activeTheme->getTitleFontSize()=="18px" ? "selected" : "" }}>18 px</option>
                                        <option value="20px" {{ $activeTheme->getTitleFontSize()=="20px" ? "selected" : "" }}>20 px</option>
                                        <option value="24px" {{ $activeTheme->getTitleFontSize()=="24px" ? "selected" : "" }}>24 px</option>
                                        <option value="28px" {{ $activeTheme->getTitleFontSize()=="28px" ? "selected" : "" }}>28 px</option>
                                        <option value="32px" {{ $activeTheme->getTitleFontSize()=="32px" ? "selected" : "" }}>32 px</option>
                                        <option value="36px" {{ $activeTheme->getTitleFontSize()=="36px" ? "selected" : "" }}>36 px</option>
                                        <option value="36px" {{ $activeTheme->getTitleFontSize()=="36px" ? "selected" : "" }}>36 px</option>
                                        <option value="40px" {{ $activeTheme->getTitleFontSize()=="40px" ? "selected" : "" }}>40 px</option>
                                        <option value="44px" {{ $activeTheme->getTitleFontSize()=="44px" ? "selected" : "" }}>44 px</option>
                                        <option value="48px" {{ $activeTheme->getTitleFontSize()=="48px" ? "selected" : "" }}>48 px</option>
                                        <option value="52px" {{ $activeTheme->getTitleFontSize()=="52px" ? "selected" : "" }}>52 px</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.font_size')}}</label>

                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="title_letter_spacing" id="title_letter_spacing">
                                        <option value="-1px" {{$activeTheme->getTitleLetterSpacing()=="-1px" ? "selected" : ""}}>{{__('settings.small')}}</option>
                                        <option value="0px" {{$activeTheme->getTitleLetterSpacing()=="0px" ? "selected" : ""}}>{{__('settings.normal')}}</option>
                                        <option value="1px" {{$activeTheme->getTitleLetterSpacing()=="1px" ? "selected" : ""}}>{{__('settings.big')}}</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.letter_spacing')}}</label>

                                </div>
                            </div>

                            <!-- Subtitle -->
                            <label>{{__('settings.subtitle')}}</label><i class="fa fa-info-circle m-l-10" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('settings.info_select_subtitle') }}"></i>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="subtitle_font_size" id="subtitle_font_size">
                                        <option value="14px" {{ $activeTheme->getSubTitleFontSize()=="14px" ? "selected" : "" }}>14 px</option>
                                        <option value="16px" {{ $activeTheme->getSubTitleFontSize()=="16px" ? "selected" : "" }}>16 px</option>
                                        <option value="18px" {{ $activeTheme->getSubTitleFontSize()=="18px" ? "selected" : "" }}>18 px</option>
                                        <option value="20px" {{ $activeTheme->getSubTitleFontSize()=="20px" ? "selected" : "" }}>20 px</option>
                                        <option value="24px" {{ $activeTheme->getSubTitleFontSize()=="24px" ? "selected" : "" }}>24 px</option>
                                        <option value="28px" {{ $activeTheme->getSubTitleFontSize()=="28px" ? "selected" : "" }}>28 px</option>
                                        <option value="32px" {{ $activeTheme->getSubTitleFontSize()=="32px" ? "selected" : "" }}>32 px</option>
                                        <option value="36px" {{ $activeTheme->getSubTitleFontSize()=="36px" ? "selected" : "" }}>36 px</option>
                                        <option value="40px" {{ $activeTheme->getSubTitleFontSize()=="40px" ? "selected" : "" }}>40 px</option>
                                        <option value="44px" {{ $activeTheme->getSubTitleFontSize()=="44px" ? "selected" : "" }}>44 px</option>
                                        <option value="48px" {{ $activeTheme->getSubTitleFontSize()=="48px" ? "selected" : "" }}>48 px</option>
                                        <option value="52px" {{ $activeTheme->getSubTitleFontSize()=="52px" ? "selected" : "" }}>52 px</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.font_size')}}</label>

                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="subtitle_letter_spacing" id="subtitle_letter_spacing">
                                        <option value="-1px" {{$activeTheme->getSubTitleLetterSpacing()=="-1px" ? "selected" : ""}}>{{__('settings.small')}}</option>
                                        <option value="0px" {{$activeTheme->getSubTitleLetterSpacing()=="0px" ? "selected" : ""}}>{{__('settings.normal')}}</option>
                                        <option value="1px" {{$activeTheme->getSubTitleLetterSpacing()=="1px" ? "selected" : ""}}>{{__('settings.big')}}</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.letter_spacing')}}</label>

                                </div>
                            </div>

                            <!-- Body -->
                            <label>{{__('settings.body')}}</label><i class="fa fa-info-circle m-l-10" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('settings.info_select_body') }}"></i>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="body_font_family" id="body_font_family">
                                        @foreach($fonts as $font)
                                            <option value="{{ $font->name }}" {{ $activeTheme->getBodyFontFamily()==$font->name ? "selected" : "" }}> {{ $font->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="title_font_family">{{__('settings.font_family')}}</label>

                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="body_font_size" id="body_font_size">
                                        <option value="14px" {{ $activeTheme->getBodyFontSize()=="14px" ? "selected" : "" }}>14 px</option>
                                        <option value="16px" {{ $activeTheme->getBodyFontSize()=="16px" ? "selected" : "" }}>16 px</option>
                                        <option value="18px" {{ $activeTheme->getBodyFontSize()=="18px" ? "selected" : "" }}>18 px</option>
                                        <option value="20px" {{ $activeTheme->getBodyFontSize()=="20px" ? "selected" : "" }}>20 px</option>
                                        <option value="24px" {{ $activeTheme->getBodyFontSize()=="24px" ? "selected" : "" }}>24 px</option>
                                        <option value="28px" {{ $activeTheme->getBodyFontSize()=="28px" ? "selected" : "" }}>28 px</option>
                                        <option value="32px" {{ $activeTheme->getBodyFontSize()=="32px" ? "selected" : "" }}>32 px</option>
                                        <option value="36px" {{ $activeTheme->getBodyFontSize()=="36px" ? "selected" : "" }}>36 px</option>
                                        <option value="40px" {{ $activeTheme->getBodyFontSize()=="40px" ? "selected" : "" }}>40 px</option>
                                        <option value="44px" {{ $activeTheme->getBodyFontSize()=="44px" ? "selected" : "" }}>44 px</option>
                                        <option value="48px" {{ $activeTheme->getBodyFontSize()=="48px" ? "selected" : "" }}>48 px</option>
                                        <option value="52px" {{ $activeTheme->getBodyFontSize()=="52px" ? "selected" : "" }}>52 px</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.font_size')}}</label>

                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="body_letter_spacing" id="body_letter_spacing">
                                        <option value="-1px" {{$activeTheme->getBodyLetterSpacing()=="-1px" ? "selected" : ""}}>{{__('settings.small')}}</option>
                                        <option value="0px" {{$activeTheme->getBodyLetterSpacing()=="0px" ? "selected" : ""}}>{{__('settings.normal')}}</option>
                                        <option value="1px" {{$activeTheme->getBodyLetterSpacing()=="1px" ? "selected" : ""}}>{{__('settings.big')}}</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.letter_spacing')}}</label>

                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="body_line_height" id="body_line_height">
                                        <option value="16px" {{$activeTheme->getLineHeight()=="16px" ? "selected" : ""}}>{{__('settings.small')}}</option>
                                        <option value="20px" {{$activeTheme->getLineHeight()=="20px" ? "selected" : ""}}>{{__('settings.normal')}}</option>
                                        <option value="24px" {{$activeTheme->getLineHeight()=="24px" ? "selected" : ""}}>{{__('settings.big')}}</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.line_height')}}</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line label-on-top m-t-20">
                                    <select class="form-control show-tick selectpicker disable-on-default" name="body_spacing_paragraphs" id="body_spacing_paragraphs">
                                        <option value="10px" {{$activeTheme->getBodySpacingParagraphs()=="10px" ? "selected" : ""}}>{{__('settings.small')}}</option>
                                        <option value="20px" {{$activeTheme->getBodySpacingParagraphs()=="20px" ? "selected" : ""}}>{{__('settings.normal')}}</option>
                                        <option value="30px" {{$activeTheme->getBodySpacingParagraphs()=="30px" ? "selected" : ""}}>{{__('settings.big')}}</option>
                                    </select>
                                    <label class="form-label" for="title_font_size">{{__('settings.spacing_for_paragraphs')}}</label>
                                </div>
                            </div>

                            <div class="row hide-on-default">
                                <div class="col-md-6">
                                    <button type="submit" formaction="/settings/theme/save" class="btn-savetheme pull-left btn btn-primary btn-block m-t-15 waves-effect">{{ __("settings.save_theme") }}</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" formaction="/settings/theme/delete" class="btn-deletetheme pull-right btn btn-primary btn-block m-t-15 waves-effect">{{ __("settings.delete_theme") }}</button>
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-shadow settings-card">
                            <div class="header">
                                <h2 class="inline-block">{{ __("settings.api_activation") }} </h2><i class="fa fa-info-circle m-l-10" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ __('settings.info_api') }}"></i>
                            </div>
                            <div class="body">
                                <div class="switch">
                                    <label><input class="api-activation" type="checkbox" {{ $api->value=="1" ? "checked" : "" }}><span class="lever switch-col-blue"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-shadow settings-card">
                            <div class="header">
                                <h2>{{ __("settings.database_backup") }}</h2>
                            </div>
                            <div class="body">
                                <form method="POST" action="/settings/db/backup">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary btn-block waves-effect"><i class="material-icons right top-0">file_download</i>{{__('settings.download_database')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-shadow settings-card">
                    <div class="header">
                        <h2 class="inline-block text-uppercase">{{ __("settings.currency") }} </h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="{{route('general-settings.currency-save')}}">
                            {{csrf_field()}}
                            <select class="form-control show-tick selectpicker" name="currency" id="currency" data-live-search="true" data-size="10">
                                @foreach($allCurrencies as $curr)
                                    <option value="{{$curr->iso}}" {{$curr->iso == $currency->value ? "selected" : ""}}>{{$curr->iso}} - {{$curr->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary waves-effect m-t-10">{{__('settings.save-currency')}}</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="settings-logo" >
                    <div class="card card-shadow settings-card">
                        <div class="header">
                            <h2>{{ __("settings.logo") }}</h2>
                        </div>
                        <div class="body">
                            <div class="logo-preview">
                                <div class="logo-preview-text">{{__('settings.actual-logo')}}</div>
                                <img src="{{route('application.logo')}}" id="actual-logo"/>
                            </div>
                                @component('components.uploader', [
                                      'projectAddress' => 0,
                                      'sectionAddress' => 'logo',
                                      'positionAddress' => 0
                                 ])@endcomponent
                        </div>
                    </div>
                </div>

                <div class="card card-shadow settings-card">
                    <div class="header">
                        <h2>{{ __("settings.navigation") }}</h2>
                    </div>
                    <div class="body">
                        <label>{{__('settings.edit_navigation')}}</label>
                        <div class="edit-navigation-default hidden">
                            <div class="input-group">
                                <input type="hidden" name="position" value="0">
                                <div class="form-line">
                                    <input type="text" name="name" class="form-control" placeholder="Item">
                                </div>
                                <span class="input-group-addon"><i class="material-icons">create</i></span>
                            </div>
                            <div class="clearfix">
                                <div class="input-group">
                                    <div class="form-line">
                                        <input type="url" name="link" class="form-control" placeholder="Item url">
                                    </div>
                                </div>
                                <button type="button" class="pull-right btn btn-primary m-l-15 m-t-15 waves-effect">{{__("messages.save")}}</button>
                            </div>
                        </div>

                        @foreach($navigationItems as $navigationItem)
                            <div class="edit-navigation-item">
                                <div class="input-group">
                                    <input type="hidden" name="id" value="{{$navigationItem->id}}">
                                    <input type="hidden" name="position" value="{{ $loop->iteration }}">
                                    <div class="form-line">
                                        <input type="text" name="name" class="form-control" placeholder="Item" value="{{$navigationItem->name}}">
                                    </div>
                                    <span class="input-group-addon"><i class="material-icons">create</i></span>
                                </div>
                                <div class="clearfix nav-hidden">
                                    <div class="input-group">
                                        <div class="form-line">
                                            <input type="text" name="link" class="form-control" placeholder="Item url" value="{{$navigationItem->link}}">
                                        </div>
                                    </div>
                                    <button type="button" class="save-nav nav-hidden pull-right btn btn-primary m-l-15 m-t-15 waves-effect">{{__("messages.save")}}</button>
                                    <button type="button" class="delete-nav nav-hidden pull-right btn btn-primary m-t-15 waves-effect">{{__("messages.delete_item")}}</button>
                                </div>
                            </div>
                        @endforeach

                        <div class="create-nav">
                            <button type="button" class="btn btn-primary btn-block m-t-15 waves-effect"><i class="material-icons top-0 right">add</i>{{__("messages.add_item")}}</button>
                        </div>
                    </div>
                </div>

                <div class="card card-shadow settings-card">
                    <div class="header">
                        <h2 class="inline-block text-uppercase">{{ __("settings.legal-documents") }} </h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="{{route('general-settings.publisher-save')}}">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-line label-on-top">
                                        <label class="form-label" for="publisher_name">Publisher name</label>
                                        <input id="publisher_name" name="publisher_name" type="text" class="form-control" value="{{ $publisher_name->value OR '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line label-on-top">
                                        <label class="form-label" for="publisher_scheme">Publisher scheme</label>
                                        <input id="publisher_scheme" name="publisher_scheme" type="text" class="form-control" value="{{ $publisher_scheme->value OR '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-line label-on-top m-t-20">
                                        <label class="form-label" for="publisher_uid">Publisher id</label>
                                        <input id="publisher_uid" name="publisher_uid" type="text" class="form-control" value="{{ $publisher_uid->value OR '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line label-on-top m-t-20">
                                        <label class="form-label" for="publisher_uri">Publisher uri</label>
                                        <input id="publisher_uri" name="publisher_uri" type="text" class="form-control" value="{{ $publisher_uri->value OR '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-line m-t-20">
                                        <label>License document <a href="http://opendefinition.org/licenses/"> <i class="fa fa-external-link"></i></a></label>
                                        @component('components.uploader', [
                                              'projectAddress' => 0,
                                              'sectionAddress' => 'license-document',
                                              'positionAddress' => 0
                                         ])@endcomponent
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line m-t-20">
                                        <label>Publication policy document <a href="http://standard.open-contracting.org/latest/en/implementation/publication_policy/"> <i class="fa fa-external-link"></i></a></label>
                                        @component('components.uploader', [
                                              'projectAddress' => 0,
                                              'sectionAddress' => 'publication-document',
                                              'positionAddress' => 0
                                         ])@endcomponent
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary waves-effect m-t-10">{{__('settings.save-legaldocs')}}</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- #END# File Upload | Drag & Drop OR With Click & Choose -->



@endsection

@section('scripts')

    @component('components.uploader-assets-settings')
    @endcomponent

    <script type="text/javascript" src="{{ asset('back/plugins/bootstrap-colorpicker/bootstrap-colorpicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('back/plugins/dropzone/dropzone.js') }}"></script>
    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>

    <script>
        $('#currency').val('{{$currency->value}}');

        //ColorPickers
        $(function () {
            $('.colorpicker').colorpicker(
                {
                    format: 'hex'
                }
            );
            $('[data-toggle="tooltip"]').tooltip({'container':'body'});
        });

        //Reset Button
        $(document).ready(function(){
            $('.btn-reset').click(function(){
                reloadThemeInfo($('select[name="theme"]').val());
            });

            @if(!$activeTheme->custom)
                disableThemeInputs();
            @endif

        });

        // New theme button

        $(document).ready(function(){
            $('.new-theme').click(function(){
                swal({
                        title: "{{ __('settings.create_theme') }}",
                        text: "{{ __('settings.create_theme_description') }}",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "Name",
                        showLoaderOnConfirm: true
                    },
                    function(inputValue){
                        if (inputValue === false) return false;

                        if (inputValue === "") {
                            swal.showInputError("{{__('settings.theme_not_empty')}}");
                            return false
                        }

                        $.ajax({
                            type: "POST",
                            url: '/settings/theme/new',
                            data: {'name': inputValue},
                            success: function(msg){
                                if(msg.response.status) {
                                    swal("{{__('messages.success')}}!", "{{ __('settings.create_theme_success') }}", "success");

                                    $('select[name="theme"]').append('<option value="'+msg.id+'">'+msg.name+'</option>');
                                    $('select[name="theme"]').val(msg.id);
                                    reloadThemeInfo(msg.id);

                                }else{
                                    swal("{{__('messages.error_oops')}}", "{{__('settings.create_theme_error')}}", "error");
                                }
                            },
                            error: function(msg){
                                swal("{{__('messages.error_oops')}}", "{{__('settings.create_theme_error')}}", "error");
                            }
                        });
                    });
            });

            //Update information of theme when change selector
            $('select[name="theme"]').change(function(){
                    reloadThemeInfo($(this).val())

                }
            );


            //Delete confirmation and submit
            $('.btn-deletetheme').click(function(e){
                e.preventDefault();
                swal({
                        title: "{{ __('messages.confirm_question') }}",
                        text: "{{ __('settings.delete_confirm_text') }}!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ __('settings.delete_confirm_button') }}",
                        closeOnConfirm: false
                    },
                    function(){
                        $('.form-theme').attr('action', "/settings/theme/delete").submit();
                    });
            });


        });

        //Reload the info of the theme
        function reloadThemeInfo(idTheme){
            $.ajax({
                type: "POST",
                url: '/settings/theme/get',
                data: {'id': idTheme},
                success: function(msg) {

                    if(msg.active){
                        $('.btn-activetheme').css('display', 'none');
                    }else{
                        $('.btn-activetheme').css('display', 'block');
                    }

                    if(msg.custom){
                        enableThemeInputs();
                    }else{
                        disableThemeInputs();
                    }

                    $.each(msg.themeSchema, function( index, value){
                        $('form *[name="'+value.name+'"]').val(value.css_rule).keyup();
                        $('.selectpicker[name="'+value.name+'"]').selectpicker('val', value.css_rule);

                    });
                },
                error: function(msg){
                    swal("{{__('messages.error_oops')}}", "{{__('settings.get_theme_error')}}", "error");
                }
            });
        };

        function disableThemeInputs(){
            $('.btn-savetheme').css('display','none');
            $('.btn-deletetheme').css('display','none');
            //$('.form-theme :input').prop('disabled', true);
            $('.disable-on-default').prop('disabled', true);
            $('.new-theme').prop('disabled', false);
            $('.btn-activetheme').prop('disabled', false);
            $('.form-theme *[name="_token"]').prop('disabled', false);
            $('.selectpicker').selectpicker('refresh');
            $('.hide-on-default').addClass('hidden');
        }

        function enableThemeInputs(){
            $('.btn-savetheme').css('display','block');
            $('.btn-deletetheme').css('display','block');
            $('.disable-on-default').prop('disabled', false);
            $('.selectpicker').selectpicker('refresh');
            $('.hide-on-default').removeClass('hidden');


        }


    </script>

    <script>
        //Navigation menu items

        $(document).ready(function(){

            //hide && show function
            $('.nav-hidden').toggle();

            $(document).on('click','.edit-navigation-item span', function(){

                var parent = $(this).parents('.edit-navigation-item');
                parent.find('.nav-hidden').toggle();

            });

            $(document).on('focus','.edit-navigation-item input[name="name"]', function(){

                var parent = $(this).parents('.edit-navigation-item');
                parent.find('.nav-hidden').toggle();

            });

            //save

            $('.save-nav').click(function(){

                var parent=$(this).parents('.edit-navigation-item');
                var id=parent.find('[name="id"]');
                var name=parent.find('[name="name"]');
                var link=parent.find('[name="link"]');
                var position=parent.find('[name="position"]');


                $.ajax({
                    type: "POST",
                    url: '/settings/nav/save',
                    data: {'id': id.val(), 'name': name.val(), 'link' : link.val(),'position': position.val()},
                    success: function(msg) {
                        if(msg.response.status) {
                            swal("{{__('messages.success')}}!", "{{ __('settings.save_nav_success') }}", "success");
                        }else{
                            swal("{{__('messages.error_oops')}}", "{{__('settings.save_nav_error')}}", "error");
                        }
                    },
                    error: function(msg){
                        swal("{{__('messages.error_oops')}}", "{{__('settings.save_nav_error')}}", "error");
                    }
                });
            });

            //delete
            $('.delete-nav').click(function(){

                var parent=$(this).parents('.edit-navigation-item');
                var id=parent.find('[name="id"]').val();

                $.ajax({
                    type: "POST",
                    url: '/settings/nav/delete',
                    data: {'id': id},
                    success: function(msg) {

                        if(msg.response.status) {
                            swal("{{__('messages.success')}}!", "{{ __('settings.delete_nav_success') }}", "success");
                            parent.remove();
                        }else{
                            swal("{{__('messages.error_oops')}}", "{{__('settings.delete_nav_error')}}", "error");
                        }

                    },
                    error: function(msg){
                        swal("{{__('messages.error_oops')}}", "{{__('settings.delete_nav_error')}}", "error");
                    }
                });

            });

            //add
            $('.create-nav button').click(function(){

                if($('.edit-navigation-default').length==1) {

                    $('.edit-navigation-item').last().after($('.edit-navigation-default').clone());
                    $('.edit-navigation-default').last().removeClass("hidden");
                }

            });

            $(document).on('click', '.edit-navigation-default button', function(){

                var parent=$(this).parents('.edit-navigation-default');
                var name=parent.find('[name="name"]').val();
                var link=parent.find('[name="link"]').val();
                var position=parent.find('[name="position"]').val();

                $.ajax({
                    type: "POST",
                    url: '/settings/nav/create',
                    data: {'name': name, 'link': link, 'position': position },
                    success: function(msg) {

                        if(msg.response.status) {
                            swal({
                                    title: "{{__('messages.success')}}!",
                                    text: "{{ __('settings.create_nav_success') }}",
                                    type: "success",
                                    html: true
                                },
                                function(isConfirm){
                                    location.reload();
                                });

                        }else{
                            swal("{{__('messages.error_oops')}}", "{{__('settings.create_nav_error')}}", "error");
                        }
                    },
                    error: function(msg){
                        swal("{{__('messages.error_oops')}}", "{{__('settings.delete_nav_error')}}", "error");
                    }
                });
            });


            $('.api-activation').change(function(){
                var api="0";

                if($(this).prop('checked')){
                    api="1";
                }

                $.ajax({
                    type: "POST",
                    url: '/settings/api',
                    data: {'api': api},
                    success: function(msg) {

                        if(msg.response.status) {
                            swal("{{__('messages.success')}}!", "{{ __('messages.save_success') }}", "success");
                        }else{
                            swal("{{__('messages.error_oops')}}", "{{__('messages.save_error')}}", "error");
                        }

                    },
                    error: function(msg){
                        swal("{{__('messages.error_oops')}}", "{{__('messages.save_error')}}", "error");
                    }
                });

            });

        });

        // Activate theme

        $("body").on("click","#activate-button",function () {
            $.ajax({
                url: '{{ route('general-settings/theme/active') }}',
                type: 'POST',
                data: { theme: $("select[name='theme']").val()},
                beforeSend: function() {
                    $('.page-loader-wrapper').show();
                },
                success: function(data){
                        swal({
                            title: "{{ __('settings.activate_theme_success') }}",
                            type: "success",
                            html: true
                        },function () {
                            location.reload();
                        });
                },
                error: function(data){
                    swal({
                        title: "{{ __('settings.activate_theme_error') }}",
                        type: "warning",
                        html: true
                    },function () {
                        location.reload();
                    });
                    laravelErrors(data);
                },
                complete: function() {
                    $('.page-loader-wrapper').fadeOut();

                }
            });        });

    </script>


    @if (count($errors) > 0)
        <script>
            //errors manage

            var errorsText="";
            @foreach ($errors->all() as $error)
                errorsText+="<p>{{ $error }}</p> ";
            @endforeach
            swal({
                title: "Oops!",
                text: errorsText,
                type: "error",
                html: true
            });
        </script>
    @endif

    @if(!empty(session('success')))
        <script>
            swal({
                title: "{{ __('messages.success') }}",
                text: "{{session('success')}}",
                type: "success",
                html: true
            });

        </script>
    @endif

@endsection
