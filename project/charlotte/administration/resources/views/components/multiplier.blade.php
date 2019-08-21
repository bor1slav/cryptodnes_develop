@php
    if (!empty($options['value'])) {
        $value = $options['value'];
    } else {
        $value[] = null;
    }
    $ids = [];
    $required = false;
    if (!empty($options['attr']['required'])) {
        $required = true;
    }
@endphp
@if(!empty($options['translate']) && $options['translate'])
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $data)
        @php
            $value = array();

           if (!empty($options['model'])) {
               $translation = $options['model']->translate($locale);
           }
           if (!empty($translation)) {
               $value = $translation->$name;
           } else {
               $value[] = null;
           }
        @endphp
        @if (!empty($value))
            @foreach (array_values($value) as $key => $data)
                @php
                    $id = uniqid();
                    $options['attr']['id'] = $id;
                    $ids[] = $id;
                @endphp


                <div class="form-group language-{{$locale}} {{ @$options['class'] }}">
                    <label class="col-sm-12 multiplier_title_{{$id}}"><span
                                class="flag-icon flag-icon-{{$locale}}"></span>{{ $options['title'] }}@if ($required) *@endif
                    </label>
                    <div class="col-sm-12 m-b-20">
                        <div class="input-group multiplier_mini_parent_{{$id}}">
                            {!!  Form::text($locale . '[' .$name . '][]', $data, $options['attr']) !!}
                            @if($loop->first)
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="addInput('{{$id}}')"><i
                                            class="fa fa-plus"></i></button>
                             </span>
                            @endif
                            @if(!$loop->first)
                                <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="removeInput('{{$id}}')"><i class="fa fa-minus"></i></button>
                                    </span>
                            @endif
                        </div>
                        <span class="help-block">
                        <small>
                            @if (!empty($options['helper_box']))
                                {{ $options['helper_box'] }}
                            @endif
                        </small>
                    </span>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
@else
    @foreach ($value as $data)
        @php
            $id = uniqid();
            $options['attr']['id'] = $id;
            $ids[] = $id;
        @endphp
        <div class="form-group without-language {{ @$options['class'] }}">
            <label class="col-sm-12 multiplier_title_{{$id}}">{{ $options['title'] }}@if ($required) *@endif</label>
            <div class="col-sm-12 m-b-20">
                <div class="input-group multiplier_mini_parent_{{$id}}">
                    {!!  Form::text($name .'[]', $data, $options['attr']) !!}
                    @if($loop->first)
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="addInput('{{$id}}')"><i
                                            class="fa fa-plus"></i></button>
                             </span>
                    @endif
                    @if(!$loop->first)
                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="removeInput('{{$id}}')"><i class="fa fa-minus"></i></button>
                                    </span>
                    @endif
                </div>

                <span class="help-block">
            <small>
                @if (!empty($options['helper_box']))
                    {{ $options['helper_box'] }}
                @endif
            </small>
        </span>

            </div>
        </div>
    @endforeach
@endif

@section('js')

    <script>


        function addInput(id) {
            let multiplier_input = $('#' + id);
            let multiplier_title = $('.multiplier_title_' + id).html();
            let multiplier_mini_parent = $('.multiplier_mini_parent_' + id);
            let multiplier_parent = multiplier_input.parents('.form-group');
            let multiplier_button = $('.btn_' + id);
            let classes = '';



            $($(multiplier_parent).attr('class').split(' ')).each(function () {
                classes = classes + ' ' + this;
            });

            let new_id = (Math.random().toString(36).substr(2, 9));

            let html = `
                <div class="` + classes + `">
                            <label class="col-sm-12 multiplier_title_` + new_id + `">` + multiplier_title + `</label>
                            <div class="col-sm-12 m-b-20">
                                <div class="input-group multiplier_mini_parent_` + new_id + `">

                                    <input class="form-control" id="` + new_id + `" name="` + multiplier_input.attr('name') + `" type="text">

                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="removeInput('` + new_id + `')"><i class="fa fa-minus"></i></button>
                                    </span>
                        </div>
                    </div>
                </div>

                `;

            multiplier_parent.after(html);
            multiplier_button.remove();

        }

        function removeInput(id) {
            let multiplier_input = $('#' + id);
            let multiplier_parent = multiplier_input.parents('.form-group');

            multiplier_parent.remove();
        }

    </script>

@append

