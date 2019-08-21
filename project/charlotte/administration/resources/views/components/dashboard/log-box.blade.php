<div class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title">{{ trans('administration::admin.monthly_log') }}</h3>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 m-b-30">
                <i class="fa fa-bug text-danger m-r-15 visible-xs-inline-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" style="font-size: 2.5em"></i>
                <h1 class="text-danger counter visible-xs-inline-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">478
                                        {{--TOTAL COUNT--}}
                </h1>
                <p class="text-muted">{{ date("M / Y") }}</p>
                <a href="{{ route('administration.logs') }}" class="text-muted font-bold">
                    {{ trans('administration::admin.see_details') }}
                </a>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 p-b-10" style="overflow-x: auto">
                <div id="sales2" class="text-center"></div>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        let days = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1];
        let sparklineLogin = function() {
            $('#sales2').sparkline(days,{
                type: 'bar',
                height: '154',
                barWidth: '25',
                resize: true,
                barSpacing: '10',
                barColor: '#f75b36'
            });
        };

        let sparkResize;

        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 100);
        });

        sparklineLogin();
    </script>
@append
