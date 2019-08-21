<?php
$id = uniqid();
?>

<label class="table-switch switch-light switch-ios m-t-0 m-b-0"
       onclick="">
    <input type="checkbox"
           data-href="{{ \Charlotte\Administration\Helpers\Administration::route('quick_switch') }}"
           data-field="{{ $field }}"
           id="{{$id}}"
           name=""
            @if($model->$field) checked @endif
    >
    <span class="m-t-0 m-b-0">
      <a></a>
    </span>
</label>

<script>

    $('#{{$id}}').on('click', function () {
        let $this = $(this);
        var checkedValue = $('#{{$id}}:checked').val();
        let checked = 0;

        if (checkedValue == 'on') {
            checked = 1;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $this.data('href'),
            type: 'POST',
            data: {
                id: {{ $model->id }},
                class: '{{str_ireplace('\\','\\\\',get_class($model))}}',
                field: $this.data('field'),
                state: checked
            },
            success: function (result) {
                if (typeof result.errors !== 'undefined' && result.errors.length != 0) {
                    $.each(result.errors, function (index, value) {
                        $.toast({
                            text: value,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500
                        });
                    });
                }
            }
        });
    });
</script>

