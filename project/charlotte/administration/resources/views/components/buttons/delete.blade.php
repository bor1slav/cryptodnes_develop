<?php
$elId = uniqid();
?>

<a class="m-l-10 m-r-10 action-btn"
   data-href="{{ $link }}" id="{{$elId}}" @if (!empty($attr['title'])) title="{{ $attr['title'] }}" @endif>
    <i class="fa  @if (!empty($attr['icon'])) {{$attr['icon']}} @endif @if (!empty($attr['color'])) {{$attr['color']}} @endif"></i>
</a>

<script>

    $('#{{$elId}}').on('click', function (e) {
        e.preventDefault();

        var $this = $(this);


        swal({
            title: "{{ trans('administration::admin.sure') }}",
            text: "{{ trans('administration::admin.no_recovery') }}",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "{{ trans('administration::admin.cancel') }}",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ trans('administration::admin.delete') }}",
            closeOnConfirm: false
        }, function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: $this.data('href'),
                type: 'DELETE',
                success: function (result) {

                    if (typeof result.errors !== 'undefined' && result.errors.length != 0) {
                        $.each(result.errors, function (index, value) {
                            $.toast({
                                // heading: 'Welcome to my Pixel admin',
                                text: value,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'error',
                                hideAfter: 3500
                            });


                        });
                    } else {
                        $('#dataTableBuilder').DataTable().draw();
                        swal("{{ trans('administration::admin.deleted') }}", "{{ trans('administration::admin.continue') }}", "success");
                    }

                }
            });

        });
    });
</script>