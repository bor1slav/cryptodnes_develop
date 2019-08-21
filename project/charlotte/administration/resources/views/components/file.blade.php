@php
    $value = null;
    $collection = (!empty($options['collection'])) ? $options['collection'] : 'default';
    if (!empty($options['model']) && $options['model']->getMedia($collection)->isNotEmpty()) {
        $value = $options['model']->getFirstMedia($collection)->file_name;
    }

    if (!empty($options['value'])) {
        $value = $options['value'];
    }
    if (!empty($options['attr']['class'])) {
        unset($options['attr']['class']);
    }
    $required = false;
    if (!empty($options['attr']['required'])) {
        $required = true;
    }

      if (!empty($value)) {
        unset($options['attr']['required']);
    }
@endphp


<div class="form-group without-language {{ @$options['class'] }}">
    <label class="col-sm-12">{{ $options['title'] }}@if ($required) *@endif</label>
    <div class="col-sm-12 m-b-20">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput" style="overflow: auto">
                <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">
                        {{ trans('administration::admin.select_file') }}
                </span>
                    <span class="fileinput-exists">
                        {{ trans('administration::admin.change') }}
                </span>
                {!!  Form::file($name, $options['attr'])  !!}

            </span>
            <a href="#"
               class="input-group-addon btn btn-default fileinput-exists"
               data-dismiss="fileinput">
                {{ trans('administration::admin.remove') }}
            </a>
        </div>
        <span class="help-block_custom">
            <small>
                @if (!empty($options['helper_box']))
                    {{ $options['helper_box'] }}
                @endif
            </small>
        </span>
        <span class="help-block with-errors"></span>
        <span class="help-block_custom">
            <small>
                @if (!empty($value))
                    <a href="{{ $value }}" target="_blank">
                        {{ $value }}
                    </a>
                @endif
            </small>
        </span>
    </div>
</div>
