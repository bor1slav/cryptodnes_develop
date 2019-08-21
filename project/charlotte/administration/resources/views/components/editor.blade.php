@php
    $id = uniqid();
    $value = $options['value'];
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
                $value = $translation->$name;
            } else {
                $value = null;
            }
                  $options['attr']['style'] = 'z:index:-32131;position:absolute;';

            $options['attr']['class'] = 'description';
            $options['attr']['id'] = $id .'-' . $locale;

        @endphp
        <div class="form-group language-{{$locale}} {{ @$options['class'] }}">
            <label class="col-sm-12"><span class="flag-icon flag-icon-{{$locale}}"></span>{{ $options['title'] }}@if ($required) *@endif
            </label>
            <div class="col-sm-12 m-b-20">

                {!! Form::text($locale . '[' .$name . ']', $value, $options['attr']) !!}
                <div class="{{$id . '-' . $locale}}">@if(!empty($value)){!! $value !!}@endif</div>
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
        $options['attr']['style'] = 'z:index:-32131;position:absolute;';
             $options['attr']['class'] = 'description';
             $options['attr']['id'] = $id;
    @endphp
    <div class="form-group without-language {{ @$options['class'] }}">
        <label class="col-sm-12">{{ $options['title'] }}@if ($required) *@endif</label>
        <div class="col-sm-12 m-b-20">

            {!! Form::text($name, $value, $options['attr']) !!}
            <div class="{{$id}}">{!! $value !!}</div>
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
    @if(!empty($options['translate']) && $options['translate'])
        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $data)
            <script>
                $(document).ready(function () {
                    let id = '{{$id}}-{{$locale}}';
                    let desc = document.getElementById(id);


                    $('.' + id).summernote({
                        minHeight: 100,
                        height: 250,
                        popover: {
                            image: [
                                ['custom', ['imageAttributes']],
                                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                                ['remove', ['removeMedia']]
                            ],
                        },
                        imageAttributes:{
                            icon:'<i class="note-icon-pencil"/>',
                            removeEmpty:false, // true = remove attributes | false = leave empty if present
                            disableUpload: true // true = don't display Upload Options | Display Upload Options
                        },
                        cleaner:{
                            action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                            newline: '<br>', // Summernote's default is to use '<p><br></p>'
                            icon: '<i class="fa  fa-file-word-o"></i>',
                        },
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear', 'cleaner']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video', 'htmlPlugin']],
                            ['view', ['fullscreen', 'help']],
                        ],
                        @if(!empty($options['simple']) && $options['simple'] == true)
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear', 'cleaner']],
                            // ['fontname', ['fontname']],
                            // ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video', 'htmlPlugin']],
                            ['view', ['fullscreen', 'help']],
                        ],
                        @endif
                    });

                    $('.' + id).on('summernote.change', function (we, contents, $editable) {
                        desc.setAttribute('value', contents);
                    });

                })
            </script>
        @endforeach
    @else
        <script>
            $(document).ready(function () {
                let id = '{{$id}}';
                let desc = document.getElementById(id);



                $('.' + id).summernote({
                    minHeight: 100,
                    height: 250,
                    popover: {
                        image: [
                            ['custom', ['imageAttributes']],
                            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                    },
                    imageAttributes:{
                        icon:'<i class="note-icon-pencil"/>',
                        removeEmpty:false, // true = remove attributes | false = leave empty if present
                        disableUpload: true // true = don't display Upload Options | Display Upload Options
                    },
                    cleaner:{
                        action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                        newline: '<br>', // Summernote's default is to use '<p><br></p>'
                        icon: '<i class="fa  fa-file-word-o"></i>',
                    },
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear', 'cleaner']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video', 'htmlPlugin']],
                        ['view', ['fullscreen', 'help']],
                    ],
                    @if(!empty($options['simple']) && $options['simple'] == true)
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear', 'cleaner']],
                        // ['fontname', ['fontname']],
                        // ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video', 'htmlPlugin']],
                        ['view', ['fullscreen', 'help']],
                    ],
                    @endif
                });



                $('.' + id).on('summernote.change', function (we, contents, $editable) {
                    desc.setAttribute('value', contents);
                });


            })
        </script>
    @endif

@append