@php
    $choices = $options['choices'];
    $value = (!empty($options['value'])) ? $options['value'] : null;
    $ids = [];
   if (array_key_exists('required', $options['attr'])) {
         $options['attr']['class'] .= ' required';
     }
    $required = false;
    if (!empty($options['attr']['required'])) {
        $required = true;
    }
@endphp
{{--@if (!empty($options['empty_value']))--}}
{{--    @php--}}
{{--        $choices = array(null => $options['empty_value']) + $options['choices'];--}}
{{--    @endphp--}}
{{--@endif--}}

@if(!empty($options['translate']) && $options['translate'])
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $data)
        @php
            $id = uniqid();
            $options['attr']['id'] = $id;
            $ids[] = $id;
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
            <div class="col-sm-12 m-b-20 multiple-input-fields-container_{{$id}}">
                {!! Form::select($locale . '[' .$name . ']', $choices, array_search($value, $choices), $options['attr']) !!}
                <div class="choices-wrapper">
                    @if (!empty($value))
                        <input name="{{ $locale . '[' .$name . ']' }}[]" class="multiple-choices_{{$id}}" type="hidden"
                               value="{{ $value }}">
                    @endif
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
    @php
        $id = uniqid();
        $options['attr']['id'] = $id;
        $ids[] = $id;
    @endphp
    <div class="form-group without-language {{ @$options['class'] }}">
        <label class="col-sm-12">{{ $options['title'] }}@if ($required) *@endif</label>
        <div class="col-sm-12 m-b-20 multiple-input-fields-container_{{$id}}">
            {!! Form::select($name, $choices, $value, $options['attr']) !!}
            <div class="choices-wrapper">
                @if (!empty($value))
                    @foreach($value as $single_value)
                        <input name="{{ $name }}[]" class="multiple-choices_{{$id}}" type="hidden"
                               value="{{ $single_value }}">
                    @endforeach
                @endif
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



@section('js')

    @foreach($ids as $id)
        <script>
            document.getElementById('{{$id}}').addEventListener("change", getChoices);

            $(document).ready(function () {
                let choices = $('#{{$id}}').val();
                let selectName = $('#{{$id}}').attr('name');

                $(".multiple-input-fields-container_{{$id}} .choices-wrapper").empty();

                if (choices !== null) {
                    $.each(choices, function (index, item) {
                        if (item === "") {
                            return true;
                        }
                        let input = '<input name="' + selectName + '[]" type="hidden" class="multiple-choices_{{$id}}" value="' + item + '">';
                        $(".multiple-input-fields-container_{{$id}} .choices-wrapper").append(input);

                    });
                }
            });

            function getChoices() {
                let choices = $('#{{$id}}').val();
                let selectName = $('#{{$id}}').attr('name');

                $(".multiple-input-fields-container_{{$id}} .choices-wrapper").empty();

                $.each(choices, function (index, item) {
                    if (item === "") {
                        return true;
                    }
                    let input = '<input name="' + selectName + '[]" type="hidden" class="multiple-choices_{{$id}}" value="' + item + '">';
                    $(".multiple-input-fields-container_{{$id}} .choices-wrapper").append(input);

                });
            }
        </script>
    @endforeach
@append