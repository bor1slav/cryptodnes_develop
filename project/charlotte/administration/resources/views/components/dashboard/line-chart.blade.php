@php
    $id = uniqid();
    $labels = json_encode($labels);
@endphp
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="white-box">
        <canvas id="chart_{{$id}}" width="100" height="20"></canvas>
    </div>
</div>

<script>

    var ctx = document.getElementById('chart_{{$id}}');
    var myChart = new Chart(ctx, {
        type: "{{ $type }}",
        data: {
            labels: {!! $labels !!},
            datasets:
                [
                    @foreach($dataset as $key => $data)
                    {
                        @php
                            $data = json_encode($data);
                            $pointBackgroundColor = ($key == key($dataset)) ? '#b31802' : '#F75B36';
                            $pointBorderColor = ($key == key($dataset)) ? '#b31802' : '#F75B36';
                            $backgroundColor = ($key == key($dataset)) ? 'rgba(0,0,0,0.3)' : 'rgba(255,255,255,0.1)';
                            $borderColor = ($key == key($dataset)) ? '#b31802' : '#F75B36';
                        @endphp
                        label: "{{$key}}",
                        data: {!! $data !!},
                        fill: true,
                        pointBorderWidth: 1, //point border width
                        pointHitRadius: 30, //radius detecting hover
                        pointBackgroundColor: '{{$pointBackgroundColor}}', //bg color of data point
                        pointBorderColor: '{{$pointBorderColor}}', // border color of data point
                        backgroundColor: '{{$backgroundColor}}', // fill color
                        borderColor: '{{$borderColor}}', // border color
                        borderWidth: 2, // border width
                        lineTension: 0.3 // smoothness of line
                    },
                    @endforeach
                ]
        },
        options: {
            // events: ['click'], // trigger tooltip on click instead of hover
            title: {
                display: true,
                text: '{{$title}}',
                fontSize: 20,
                fontColor: '#ccc',
            }, // title styles
            animation: {
                duration: 1500
            }, // animation of chart
            tooltips: {
                mode: 'index',
                axis: 'y'
            }, // display all data on y axis
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
