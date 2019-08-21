@php
    $page = 0;
    if (!empty($_GET['page']) && $_GET['page'] != 1) {
        $page = $_GET['page'] * 100;
    }
@endphp
@extends('layouts.coins_app')
@section('content')

    <section id="coins">
        <div class="container">
            <div class="col-md-12 text-center" style="margin-top: 30px">
                <div class="coinzilla" data-zone="C-395ce7f5212a47c712"></div>
                <script>
                    window.coinzilla_display = window.coinzilla_display || [];
                    var c_display_preferences = {};
                    c_display_preferences.zone = "395ce7f5212a47c712";
                    c_display_preferences.width = "728";
                    c_display_preferences.height = "90";
                    console.log(coinzilla_display);
                    console.log(c_display_preferences);
                    coinzilla_display.push(c_display_preferences);
                </script>
            </div>

            <h1>
                {{ trans('coins::front.top_100') }}
            </h1>

            <div class="coins-content">
                {{ $coins->links('pagination.coins') }}
                <table id="main-coins-table" class="table table-sm table-responsive-md coins-table {{ ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'true' ) ? 'table-dark' : '' }}">
                    <thead>
                        <tr>
                            <th scope="col" class="rank-header">#</th>
                            {{--<th scope="col">Icon</th>--}}
                            <th scope="col">{{ trans('coins::front.crypto') }}</th>
                            <th scope="col">{{ trans('coins::front.capitalization') }}</th>
                            <th scope="col">{{ trans('coins::front.price') }}</th>
                            <th scope="col">{{ trans('coins::front.24_volume') }}</th>
                            <th scope="col">{{ trans('coins::front.24_change') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($coins as $coin)
                            <tr class="coin-link" data-link="{{ route('coins.view', ['slug' => $coin->slug]) }}">
                                <th scope="row" class="rank">
                                    <a href="{{ route('coins.view', ['slug' => $coin->slug]) }}" title="{{ $coin->title }}" class="overlay"></a>
                                    {{ $page + $i }}
                                </th>
                                <td>
                                    <div class="coin-cell">
                                        <div class="icon">
                                            @if($coin->media->isNotEmpty())
                                                <img src="{{ $coin->getFirstMedia()->getUrl() }}" alt="Icon title" class="img-fluid">
                                            @else
{{--                                                <img src="{{ asset('images/nav-btc.png') }}" alt="Icon title" class="img-fluid">--}}
                                            @endif
                                        </div>
                                        <div class="text">
                                            {{ $coin->title }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="coin-cell">
                                        {{ $coin->market_cap ? '$' . beatify_number($coin->market_cap) : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="coin-cell">
                                        <a href="{{ route('coins.view', $coin->slug) }}" title="{{$coin->title}}">{{ $coin->current_price ? '$' . beatify_number($coin->current_price) : '-' }}</a>

                                    </div>
                                </td>
                                <td>
                                    <div class="coin-cell">
                                        @php
                                            $volume_24 = trim(substr(beatify_number($coin->volume_24h), 0, strpos(beatify_number($coin->volume_24h), ".")));
                                        @endphp
                                       <a href="{{ route('coins.view', $coin->slug) }}" title="{{$coin->title}}">{{ ($volume_24) ? '$' . $volume_24 : '-' }}</a>
                                    </div>
                                </td>
                                <td>
                                    @php
                                    $percantage = format_number(get_percentage_difference($coin->current_price, $coin->old_price_24h));
                                    @endphp
                                    <div class="coin-cell @if ($percantage > 0) rank-up @else rank-down @endif">
                                        {{ $percantage ? $percantage . '%': '-' }}
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{ $coins->links('pagination.coins_top') }}
                {{--{{ $coins->links('pagination.custom') }}--}}
            </div>

        </div>
    </section>

@endsection