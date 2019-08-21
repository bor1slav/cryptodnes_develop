@php
    $choices = $options['choices'];
    $value = (!empty($options['value'])) ? $options['value'] : null;
     if (array_key_exists('required', $options['attr'])) {
         $options['attr']['class'] .= ' required';
     }
     $required = false;
      if (!empty($options['attr']['required'])) {
          $required = true;
      }
@endphp
@if (!empty($options['empty_value']))
    @php
        $choices = array(null => $options['empty_value']) + $options['choices'];
    @endphp
@endif

@if(!empty($options['translate']) && $options['translate'])
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $data)
        @php

            if (!empty($options['model'])) {
                $translation = $options['model']->translate($locale);
            }
            if (!empty($translation)) {
                $value = $translation->$name;
            } else {
                $value = null;
            }
        @endphp
        <div class="form-group language-{{$locale}} {{ @$options['class'] }}">
            <label class="col-sm-12"><span class="flag-icon flag-icon-{{$locale}}"></span>{{ $options['title'] }}@if ($required) *@endif
            </label>
            <div class="col-sm-12 m-b-20">
                {!! Form::select($locale . '[' .$name . ']', $choices, $value, $options['attr']) !!}
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
        <label class="col-sm-12">{{ $options['title'] }}@if ($required) *@endif</label>
        <div class="col-sm-12 m-b-20">
            {!! Form::select($name, $choices, $value, $options['attr']) !!}
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

