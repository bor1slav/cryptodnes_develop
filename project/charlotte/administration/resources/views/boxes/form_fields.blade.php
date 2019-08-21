@php
    $translate = false;
    $boxes = false;
    $fields = $form->getFields();
    foreach ($fields as $field) {
        $field_options = $field->getOptions();
        if (!empty($field_options['translate']) && $field_options['translate']) {
            $translate = true;
        }
    }
@endphp


<div class="col-sm-12 m-t-20">
    @if ($translate)
        <ul class="lang-separator m-b-10">
            @foreach(LaravelLocalization::getLocalesOrder() as $locale => $data)
                <li class="lang-button" data-filter="language-{{$locale}}">
                    <span class="flag-icon flag-icon-{{$locale}}"></span>
                    {{$locale}}
                </li>
            @endforeach
        </ul>
    @endif
    <div class="white-box">
        <div class="row">
          {!! form($form, ['data-toggle' => 'validator']) !!}
        </div>
    </div>
</div>




@section('js')

    <script>
        $(document).ready(function () {
            $(".lang-separator li").click(function () {

                let category = $(this).attr('data-filter');
                $('.lang-separator li').removeClass('active');
                $(this).addClass('active');
                if (category === '') {
                    $('.form-group:hidden').show().removeClass('hidden');
                    $('.modal-body .form-group').show().removeClass('hidden');
                }
                else {
                    $('.form-group').each(function () {
                        if (!$(this).hasClass(category) && !$(this).hasClass('without-language')) {
                            $(this).hide().addClass('hidden');
                        } else {
                            $(this).show().removeClass('hidden');
                        }
                    });
                    $('.modal-body .form-group').show().removeClass('hidden');
                }
                return false
            });
            $(".lang-separator li:first").trigger("click").addClass('active');
        });


    </script>

@append