@extends('layouts.app')
@section('content')

    <section id="coin-view">
        <div class="container">
            <div class="row no-gutters-sm">
                <div class="col-12 col-md-2">
                    <div class="side-wrapper">
                        <div class="coin-name">
                            @if (!empty($coin->getFirstMedia()))
                                <img src="{{ $coin->getFirstMedia()->getUrl() }}" alt="Icon title"
                                     class="img-fluid icon-logo">
                            @else
                                <img src="{{ asset('images/coin_backup.png') }}" alt="Icon title"
                                     class="img-fluid icon-logo">
                            @endif
                            <div class="right">
                                <h2 class="title">
                                    {{ $coin->title }}
                                </h2>
                                <div class="symbol">
                                    {{ strtoupper($coin->symbol) }}
                                </div>
                            </div>
                        </div>
                        <aside>
                            {{--                            <button type="button" class="basic-link add-to-favorites">--}}
                            {{--                                <i class="fas fa-star star"></i>--}}
                            {{--                                <span class="text">--}}
                            {{--                                Add to favourites--}}
                            {{--                                </span>--}}
                            {{--                            </button>--}}

                            @if (!empty($coin->homepage))
                                <div class="nav-section">
                                    <div class="list-title">
                                        Website
                                    </div>
                                    <ul class="nav-list">
                                        @foreach($coin->homepage as $website)
                                            <li>
                                                <a href="{{ $website }}" title="{{ $website }}" class="side-link">
                                                    {{ parse_url($website)['host'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty($coin->blockchain_sites))
                                <div class="nav-section">
                                    <div class="list-title">
                                        Explore
                                    </div>
                                    <ul class="nav-list">
                                        @foreach($coin->blockchain_sites as $website)
                                            <li>
                                                <a href="{{ $website }}" title="{{ $website }}" class="side-link">
                                                    {{ parse_url($website)['host'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </aside>
                    </div>
                </div>
                <div class="col-12 col-md-10">
                    <article class="coin-content">
                        <div class="header-table">
                            <table class="table table-sm table-responsive-sm coins-table-left">
                                <thead>
                                <tr scope="col">
                                    <th>
                                        <div class="coin-price">
                                            <div class="rank">${{ beatify_number($coin->current_price) }}</div>
                                            <div class="rank @if ($coin->price_change_percentage_24h > 0) rank-up @else rank-down @endif">
                                                (@if ($coin->price_change_percentage_24h > 0)
                                                    +@endif{{format_number($coin->price_change_percentage_24h)}}%)
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--                                <tr>--}}
                                {{--                                    <td class="rank">30.46 ETH--}}
                                {{--                                        <div class="rank-up">(+0.21%)</div>--}}
                                {{--                                    </td>--}}
                                {{--                                </tr>--}}
                                </tbody>
                            </table>
                            <table class="table table-sm table-responsive-sm coins-table-right">
                                <thead>
                                <tr>
                                    {{--<th scope="col">Icon</th>--}}
                                    <th scope="col">1h</th>
                                    <th scope="col">24h</th>
                                    <th scope="col">Week</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Year</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                                    <td class="rank @if ($coin->price_change_percentage_1h_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_1h_in_currency > 0)
                                            +@endif{{ format_number($coin->price_change_percentage_1h_in_currency) }}%
                                    </td>
                                    <td class="rank @if ($coin->price_change_percentage_24h_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_24h_in_currency > 0)
                                            +@endif{{ format_number($coin->price_change_percentage_24h_in_currency) }}%
                                    </td>
                                    <td class="rank @if ($coin->price_change_percentage_7d_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_7d_in_currency > 0)
                                            +@endif{{ format_number($coin->price_change_percentage_7d_in_currency) }}%
                                    </td>
                                    <td class="rank @if ($coin->price_change_percentage_30d_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_30d_in_currency > 0)
                                            +@endif{{ format_number($coin->price_change_percentage_30d_in_currency) }}%
                                    </td>
                                    <td class="rank @if ($coin->price_change_percentage_1y_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_1y_in_currency > 0)
                                            +@endif{{ format_number($coin->price_change_percentage_1y_in_currency) }}%
                                    </td>

                                </tr>
                                {{--                                <tr>--}}

                                {{--                                    <td class="rank rank-down">-0.03%</td>--}}
                                {{--                                    <td class="rank rank-up">+1.32%</td>--}}
                                {{--                                    <td class="rank rank-up">+5.06%</td>--}}
                                {{--                                    <td class="rank rank-up">+30.96%</td>--}}
                                {{--                                    <td class="rank rank-down">-35.74%</td>--}}
                                {{--                                </tr>--}}
                                </tbody>
                            </table>
                        </div>
                        <div class="content">
                            <div class="description">
                                {!! $coin->description !!}
                            </div>
                            {{--<div class="tags">
                                <button type="button"
                                        class="tag"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Tooltip on top">
                                    Segwit (12)
                                </button>
                                <span class="tag">
                                    Cryptocurrency (923)
                                </span>
                                <span class="tag">
                                    Proof Of Work (492)
                                </span>
                                <span class="tag">
                                    Payments (285)
                                </span>
                                <span class="tag">
                                    Sha256 (59)
                                </span>
                                <button type="button"
                                        data-toggle="modal"
                                        data-target="#suggest-tab-modal"
                                        class="basic-link suggest-tag-trigger">
                                    Suggest a tag
                                </button>
                            </div>--}}
                            <div class="coin-details">

                                <div class="detail">
                                    <div class="detail-head">
                                        Market Cap
                                        @if (!empty($coin->market_cap_rank))
                                            <div class="rank">
                                                Rank {{ $coin->market_cap_rank }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="detail-value">
                                        <div class="value">
                                            ${{ beatify_number($coin->market_cap) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <div class="detail-head">
                                        All Time High
                                        <button type="button"
                                                class="btn question-trigger"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-trigger="hover focus"
                                                title="ATH - 'All Time High'. In other words it's the highest price ever registered of particular coin, measured in USD.">
                                            <i class="far fa-question-circle" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="detail-value">
                                        <div class="value">
                                            ${{ $coin->ath }}
                                        </div>
                                        {{--                                        <div class="value">--}}
                                        {{--                                            17 Dec 2017--}}
                                        {{--                                        </div>--}}
                                        <div class="value faded">
                                            % to ATH ({{ format_number($coin->ath_change_percentage) }}%)
                                        </div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <div class="detail-head">
                                        Circulating Supply
                                    </div>
                                    <div class="detail-value">
                                        <div class="value">
                                            {{ beatify_number($coin->circulating_supply) }}
                                            @if (!empty($coin->total_supply))
                                                @php
                                                    $percentage = ($coin->circulating_supply * 100) / $coin->total_supply;
                                                @endphp
                                                    ({{ format_number($percentage) }}%)
                                            @endif

                                        </div>
                                        <div class="value faded">
                                            Total: 17 679 300
                                        </div>
                                        <div class="value faded">
                                            Max: @if (!empty($coin->total_supply)) {{ beatify_number($coin->total_supply) }} @else ∞ @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <div class="detail-head">
                                        Volume (24h)
                                        {{--                                        <div class="rank">--}}
                                        {{--                                            Rank 1--}}
                                        {{--                                        </div>--}}
                                    </div>
                                    <div class="detail-value">
                                        <div class="value">
                                            @php
                                                $volume_24 = substr(beatify_number($coin->volume_24h), 0, strpos(beatify_number($coin->volume_24h), "."));
                                            @endphp
                                            ${{ $volume_24}}
                                        </div>
                                        {{--                                        <div class="value">--}}
                                        {{--                                            1 896 068 BTC--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                                <div class="detail">
                                    <div class="detail-head">
                                        Vol / M Capt (24h)
                                    </div>
                                    <div class="detail-value">
                                        <div class="value">
                                            {{ get_percentage($coin->market_cap, $coin->volume_24h) }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <div class="detail-head">
                                        Updated At
                                    </div>
                                    <div class="detail-value">
                                        <div class="value">
                                            {{ date_with_hour($coin->updated_at)  }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{--<div class="modal fade" id="suggest-tab-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-head">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="fas fas-times"></span>
                    </button>
                </div>
                {!! Form::open(['url' => null, 'method' => 'post', 'files'=> true, 'id' => 'suggest-tag-form']) !!}
                <div class="modal-body">
                    <p>Thanks to the tags we can easy organize and display content from our over 1,5k coins.</p>
                    {!! Form::text('suggested_tag', null, ['class' => 'form-control', 'placeholder' => 'Enter suggested tag']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-confirm">Save changes</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>--}}

@endsection