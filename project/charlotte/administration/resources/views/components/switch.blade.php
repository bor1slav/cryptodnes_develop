@php
    $value = (empty($options['value'])) ? $options['default_value'] : $options['value'];
    $checked = ($value) ? 'checked' : null;

@endphp


@if(!empty($options['translate']) && $options['translate'])
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $data)
        @php
            if (!empty($options['model'])) {
                $translation = $options['model']->translate($locale);
            }
            if (!empty($translation)) {
                $checked = ($translation->$name) ? 'checked' : null;
            }

        @endphp
        <div class="form-group language-{{$locale}}  {{ @$options['class'] }}">
            <label class="col-sm-12"><span class="flag-icon flag-icon-{{$locale}}"></span>{{ $options['title'] }}</label>
            <div class="col-sm-12 m-b-20">
                <label class="switch-light switch-ios" style="width: 60px" onclick="">
                    {{Form::hidden($locale . '[' .$name . ']',0)}}
                    {!!  Form::checkbox($locale . '[' .$name . ']', 1, $checked, $options['attr']) !!}
                    <span>
              <a></a>
            </span>
                </label>
                <span class="help-block with-errors"></span>
                <span class="help-block_custom">
            <small>
                @if (!empty($options['helper_box']))
                    {{ $options['helper_box'] }}
                @endif
            </small>
        </span>
            </div>
        </div>
    @endforeach
@else

    <div class="form-group without-language {{ @$options['class'] }}">
        <label class="col-sm-12">{{ $options['title'] }}</label>
        <div class="col-sm-12 m-b-20">
            <label class="switch-light switch-ios" style="width: 60px" onclick="">
                {{Form::hidden($name,0)}}
                {!!  Form::checkbox($name, 1, $checked, $options['attr']) !!}
                <span>
              <a></a>
            </span>
            </label>
            <span class="help-block with-errors"></span>
            <span class="help-block_custom">
            <small>
                @if (!empty($options['helper_box']))
                    {{ $options['helper_box'] }}
                @endif
            </small>
        </span>
        </div>
    </div>
@endif