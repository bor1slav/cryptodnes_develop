@php
    $required = false;
    if (!empty($options['attr']['required'])) {
        $required = true;
    }
@endphp
<div class="form-group {{ @$options['class'] }}">
    <label class="col-sm-12">{{ $options['title'] }}@if ($required) *@endif</label>
    <div class="col-sm-12 m-b-20">
        {!! Form::select($name, $options['choices'], @$options['selected'], $options['attr']) !!}
        <span class="help-block">
            <small>
                @if (!empty($options['helper_box']))
                    {{ $options['helper_box'] }}
                @endif
            </small>
        </span>
    </div>
</div>