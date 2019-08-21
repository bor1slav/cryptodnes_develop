@php
    $id = uniqid();
    $options['attr']['id'] = $id;
    $checked = ($options['checked']) ? 'checked' : null;
    $required = false;
    if (!empty($options['attr']['required'])) {
        $required = true;
    }
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
            $options['attr']['id'] = $id . '-' . $locale;

        @endphp
        <div class="form-group language-{{$locale}} {{ @$options['class'] }}">
            <div class="col-sm-12 m-b-20">
                <span class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block flag-icon flag-icon-{{$locale}}"></span>
                <div class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block checkbox checkbox-danger">
                    {{Form::hidden($locale . '[' .$name . ']',0)}}
                    {!!  Form::checkbox($locale . '[' .$name . ']', 1, $checked, $options['attr']) !!}
                    <label for="{{ $id }}-{{$locale}}">{{ $options['title'] }}@if ($required) *@endif</label>
                </div>
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
        <div class="col-sm-12 m-b-20">
            <div class="checkbox checkbox-danger">
                {{Form::hidden($name,0)}}
                {!!  Form::checkbox($name, 1, $checked, $options['attr']) !!}
                <label for="{{ $id }}">{{ $options['title'] }}@if ($required) *@endif</label>
            </div>
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