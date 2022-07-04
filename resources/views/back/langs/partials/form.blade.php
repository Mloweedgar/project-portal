

<div class="m-l-20 m-b-20">

    <h2>{{ $fieldName }}</h2>


    @foreach($fields as $field)

        @if(count($field->childrens()->get()) >0 )
            <div class="m-l-{{$partial*20}} m-b-20">
            @include('back.langs.partials.form', array('fields' => $field->childrens()->get(), 'fieldName' => $field->name, 'edit' => true, 'partial'=>$partial++, 'file' => $file,  'route' => $route.'.'.$field->name))
            </div>
        @else
                <div class="form-group form-float">
                    <div class="form-line  {{ !\Illuminate\Support\Facades\Lang::hasForLocale($route.'.'.$field->name, $lang->iso) ? "no-translate" : ""}}">

                        <input class="form-control {{$field->attribute ? 'has-attr' : ""}}"
                               type="text"
                               name="{{ $field->id }}"
                               value="{{\Illuminate\Support\Facades\Lang::hasForLocale($route.'.'.$field->name, $lang->iso) ? \Illuminate\Support\Facades\Lang::get($route.".".$field->name,[], $lang->iso) : ''}}"
                                {{$field->attribute ? 'data-attr='.$field->attribute.'' : ""}}>
                        <label class="form-label">{{ __($route.".".$field->name) }}</label>

                    </div>
                </div>

        @endif
    @endforeach
</div>