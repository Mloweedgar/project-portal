
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="header"
                     @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                    <h2>{{ __('langs.'.$file->name) }}</h2>
                </div>
                <div id="card-body"
                     class="body card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (!empty($flag))
                        <div class="alert alert-danger">
                            Message: {{$flag["message"]}}
                        </div>
                    @endif


                                <form action="{{ route('langs.update') }}" method="POST">
                                    {{ csrf_field() }}
                                <input type="hidden" value="{{ $lang->id }}" name="lang">
                                <input type="hidden" value="{{ $file->id }}" name="section">


                                    @foreach($langFields as $field)

                                        @if(count($field->childrens()->get()) >0 )

                                            @include('back.langs.partials.form', array('fields' => $field->childrens()->get(), 'fieldName' => $field->name, 'edit' => true, 'partial' => 1, 'file' => $file->name, 'route' => $file->path.$file->name.'.'.$field->name))


                                        @else
                                        <div class="form-group form-float">
                                            <div class="form-line  {{ !\Illuminate\Support\Facades\Lang::hasForLocale($file->path.$file->name.'.'.$field->name, $lang->iso) ? "no-translate" : ""}}">

                                                    <input class="form-control {{$field->attribute ? 'has-attr' : ""}}"
                                                           type="text"
                                                           name="{{ $field->id }}"
                                                           value="{{\Illuminate\Support\Facades\Lang::hasForLocale($file->path.$file->name.'.'.$field->name, $lang->iso) ? \Illuminate\Support\Facades\Lang::get($file->path.$file->name.".".$field->name,[], $lang->iso) : ''}}"
                                                            {{$field->attribute ? 'data-attr='.$field->attribute.'' : ""}}>
                                                    <label class="form-label">{{ __($file->path.$file->name.".".$field->name) }}</label>

                                            </div>
                                        </div>
                                        @endif

                                    @endforeach

                                    <button class="btn btn-large btn-primary waves-effect"
                                            type="submit">{{__("messages.save")}}</button>

                                </form>





                    </div>
                </div>
            </div>
        </div>


