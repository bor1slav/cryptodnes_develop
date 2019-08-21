<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive p-t-20 p-b-20">
            {!! $table->table() !!}
        </div>
    </div>
</div>
@section('js')
    {!! $table->scripts() !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#dataTableBuilder').DataTable();
            table.on( 'row-reorder', function ( e, diff, edit ) {
                var positions = [];
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = table.row( diff[i].node ).data();
                    positions[rowData.id] = {
                        id:rowData.id,
                        old_position: diff[i].oldPosition,
                        new_position: diff[i].newPosition

                    };
                }

                // filter the array
                // positions = positions.filter(function (el) {
                //     return el != null;
                // });

                $.ajax({
                    url     : '{{ \Charlotte\Administration\Helpers\Administration::route('quick_reorder') }}',
                    type    : 'POST',
                    data    : {
                        position_ids : positions,
                        class: '{{str_ireplace('\\','\\\\',$model)}}',

                    },
                    dataType: 'json',
                    success : function ( json )
                    {
                        $('#dataTableBuilder').DataTable().ajax.reload(); // now refresh datatable
                        $.each(json, function (key, msg) {
                            // handle json response
                        });
                    }
                });
            });

        });
    </script>
@append