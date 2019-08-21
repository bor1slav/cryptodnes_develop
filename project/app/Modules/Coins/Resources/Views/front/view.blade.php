@extends('layouts.coins_app')
@section('content')

    <section id="coin-view">
        <div class="container">
            <div class="row no-gutters-sm">
                <div class="col-12">
                    <div class="row align-items-center py-4 no-gutters-sm">
                        <div class="col-12">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-12">
                                    <nav class="breadcrumb" aria-label="breadcrumb">
                                        <a href="{{ route('index') }}">{{ trans('index::front.home') }}</a>
                                        <a href="{{ route('coins.index') }}">{{ mb_strtoupper(trans('coins::front.coins_wiki')) }}</a>
                                        <a href="{{ route('coins.view', $coin->slug) }}">{{ $coin->title }}</a>
                                    </nav>
                                </div>
                                <div class="col-lg-9 col-12 text-right">
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
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="row align-items-center pb-md-0 pb-3 no-gutters-sm">
                                <div class="col-md-12 col-8 px-0 text-left">
                                    <div class="coin-info">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-12 col-3 pl-md-4 pr-md-0 pl-0">
                                                @if($coin->media->isNotEmpty())
                                                    <img src="{{ $coin->getFirstMedia()->getUrl() }}" alt="{{ $coin->title }} иконка"
                                                         class="coin-icon">
                                                @else
{{--                                                    <img src="{{ asset('images/nav-btc.png') }}" alt="Icon title"--}}
{{--                                                         class="coin-icon">--}}
                                                @endif
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-9 pl-0 pl-md-2">
                                                <h1 class="coin-title">{{ $coin->title }} <span
                                                            class="coin-shorthand">{{ strtoupper($coin->symbol) }}</span>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 px-0 text-right">
                                    <div class="coin-rank-container d-block d-md-none text-right pb-1">
                                        <i class="fas fa-trophy d-inline"></i>
                                        @if (!empty($coin->market_cap_rank))
                                            <div class="rank d-inline-block">
                                                {{ trans('coins::front.rank') }} {{ $coin->market_cap_rank }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 text-md-left text-center">
                            @if (!empty($coin->buy_link))
                                <a href="{{ $coin->buy_link }}" target="_blank" class="buy-coin">
                                    <button>
                                        {{ trans('coins::front.buy') }} {{ $coin->title }}
                                    </button>
                                </a>
                            @endif
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="row justify-content-end align-items-center coin-calculator py-3">

                                <span class="col-md-4 col-12 calculate-label text-md-right text-left pb-md-0 pb-2 pl-0"
                                      style="font-size: 12px;">{{ $coin->title }} {{ trans('coins::front.coin_calculator') }}
                                    :</span>

                                <div class="input-group coin-value col-md-3 col-10 px-0">
                                    <input type="text"
                                           name="coin-qty"
                                           class="form-control"
                                           placeholder="{{ trans('coins::front.coin_qty') }}"
                                           aria-label="{{ trans('coins::front.coin_qty') }}"
                                           aria-describedby="addon-wrapping"
                                           min="1"
                                           value="1">
                                </div>

                                <i class="fas fa-exchange-alt col-md-1 col-2 text-center py-3 px-md-3 px-0 pr-1"></i>

                                <div class="input-group col-md-4 col-12 coin-value-calculated pr-md-3 px-0">
                                    <input type="text"
                                           name="coin-result"
                                           class="form-control"
                                           placeholder="{{ trans('coins::front.calculated_value') }}"
                                           aria-label="{{ trans('coins::front.calculated_value') }}"
                                           data-value="{{ $coin->current_price_bgn }}"
                                           value="{{ beatify_number($coin->current_price_bgn) }}">
                                    <div class="input-group-append flex-nowrap">
                                        <button class="btn btn-outline-secondary dropdown-toggle currency-selected"
                                                type="button"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                value="">
                                            BGN
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right currency-dropdown text-right">
                                            <a class="dropdown-item" href="#" id="currency_bg"
                                               data-curr-price="{{ $coin->current_price_bgn }}">BGN</a>
                                            <a class="dropdown-item" href="#" id="currency_us"
                                               data-curr-price="{{ $coin->current_price }}">USD</a>
                                            <a class="dropdown-item" href="#" id="currency_eu"
                                               data-curr-price="{{ $coin->current_price_euro }}">EUR</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="coin-rank-container d-none d-md-block">
                                <i class="fas fa-trophy d-inline"></i>
                                @if (!empty($coin->market_cap_rank))
                                    <div class="rank d-inline-block">
                                        {{ trans('coins::front.rank') }} {{ $coin->market_cap_rank }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <article class="coin-content">
                                <div class="header-table">
                                    <table class="table table-sm table-responsive-sm coins-table-right mb-0">
                                        <thead>
                                        <tr>
                                            {{--<th scope="col">Icon</th>--}}
                                            <th scope="col" class="text-md-left text-center">
                                                <span class="d-md-inline d-none">
                                                    {{ $coin->title }}  {{ trans('coins::front.value_in') }}
                                                </span> USD:
                                            </th>
                                            <th scope="col" class="text-md-left text-center">
                                                <span class="d-md-inline d-none">
                                                    {{ $coin->title }}  {{ trans('coins::front.value_in') }}
                                                </span> EUR:
                                            </th>
                                            <th scope="col" class="text-md-left text-center">
                                                <span class="d-md-inline d-none">
                                                    {{ $coin->title }}  {{ trans('coins::front.value_in') }}
                                                </span> BGN:
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>

                                            {{--                                            <td class="rank @if ($coin->price_change_percentage_1h_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_1h_in_currency > 0)--}}
                                            {{--                                                    +@endif{{ format_number($coin->price_change_percentage_1h_in_currency) }}%--}}
                                            {{--                                            </td>--}}
                                            {{--                                            <td class="rank @if ($coin->price_change_percentage_24h_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_24h_in_currency > 0)--}}
                                            {{--                                                    +@endif{{ format_number($coin->price_change_percentage_24h_in_currency) }}%--}}
                                            {{--                                            </td>--}}
                                            {{--                                            <td class="rank @if ($coin->price_change_percentage_7d_in_currency > 0) rank-up @else rank-down @endif">@if ($coin->price_change_percentage_7d_in_currency > 0)--}}
                                            {{--                                                    +@endif{{ format_number($coin->price_change_percentage_7d_in_currency) }}%--}}
                                            {{--                                            </td>--}}

                                            <td class="text-md-left text-center">
                                                <p class="coin-price d-md-inline d-block">
                                                    ${{ beatify_number($coin->current_price) }}</p>
                                                <p class="percent d-md-inline d-block @if (get_percentage_difference($coin->current_price, $coin->old_price_24h) > 0) rise @else drop @endif">
                                                    (@if (get_percentage_difference($coin->current_price, $coin->old_price_24h) > 0)
                                                        +@endif{{ format_number(get_percentage_difference($coin->current_price, $coin->old_price_24h)) }}%)</p>
                                                <p class="d-none" id="current_price_usd">{{ $coin->current_price }}</p>
                                            </td>
                                            <td class="text-md-left text-center">
                                                <p class="coin-price d-md-inline d-block">
                                                    €{{ beatify_number($coin->current_price_euro) }}</p>
                                                <p class="percent d-md-inline d-block @if (get_percentage_difference($coin->current_price_euro, $coin->old_price_24h_euro) > 0) rise @else drop @endif">
                                                    (@if (get_percentage_difference($coin->current_price_euro, $coin->old_price_24h_euro) > 0)
                                                        +@endif{{format_number(get_percentage_difference($coin->current_price_euro, $coin->old_price_24h_euro))}}%)</p>
                                            </td>
                                            <td class="text-md-left text-center">
                                                <p class="coin-price d-md-inline d-block">{{ beatify_number($coin->current_price_bgn) }}
                                                    BGN</p>
                                                <p class="percent d-md-inline d-block @if (get_percentage_difference($coin->current_price_bgn, $coin->old_price_24h_bgn) > 0) rise @else drop @endif">
                                                    (@if (get_percentage_difference($coin->current_price_bgn, $coin->old_price_24h_bgn) > 0)
                                                        +@endif{{ format_number(get_percentage_difference($coin->current_price_bgn, $coin->old_price_24h_bgn)) }}%)</p>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if (!empty($coin_to_compare))
                                    <p class="coin-stat px-md-3 px-0 pt-2 text-md-left text-center">
                                        @if ($coin_to_compare->current_price == 0)
                                            {{ 1 }}
                                        @elseif ($coin->current_price / $coin_to_compare->current_price != 1)
                                            {{ number_format($coin->current_price / $coin_to_compare->current_price, 8) }}
                                        @else
                                            {{ 1 }}
                                        @endif
                                        BTC <span
                                                class="percentage @if (get_percentage_difference($coin_to_compare->current_price, $coin_to_compare->old_price_24h) > 0) rise @else drop @endif"> (@if (get_percentage_difference($coin_to_compare->current_price, $coin_to_compare->old_price_24h) > 0)
                                                +@endif{{ format_number(get_percentage_difference($coin_to_compare->current_price, $coin_to_compare->old_price_24h)) }}%)</span>
                                    </p>
                                @endif
                                <div class="fb-share-container text-md-left text-center">
                                    {{--                                    <a class="fb-share"--}}
                                    {{--                                       href="https://google.com"--}}
                                    {{--                                       data-title="tova e link">--}}
                                    {{--                                        <i class="fa fa-share pl-0 pr-1"></i>--}}
                                    {{--                                        {{ trans('coins::front.share_fb') }}--}}
                                    {{--                                    </a>--}}
                                    <div class="addthis_inline_share_toolbox"></div>

                                </div>

                                {{--                                <div class="fb-share-button"--}}
                                {{--                                     data-href="https://developers.facebook.com/docs/plugins/"--}}
                                {{--                                     data-layout="button"--}}
                                {{--                                     data-size="small"--}}
                                {{--                                     style="opacity: 0;">--}}
                                {{--                                    <a target="_blank"--}}
                                {{--                                       href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"--}}
                                {{--                                       class="fb-xfbml-parse-ignore">--}}
                                {{--                                        Share</a>--}}
                                {{--                                </div>--}}

                                <div class="content">
                                    <div class="coin-details">

                                        <div class="detail">
                                            <div class="detail-head">
                                                {{ trans('coins::front.market_cap') }}
                                            </div>
                                            <div class="detail-value">
                                                <div class="value">
                                                    ${{ beatify_number($coin->market_cap) }}
                                                </div>
                                                <div class="value faded">
                                                    @if ($coin->current_price != 0)
                                                        {{beatify_number(round($coin->market_cap / $coin->current_price))}}
                                                    @else
                                                        {{ 1 }}
                                                    @endif
                                                        {{ strtoupper($coin->symbol) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="detail-head">
                                                {{ trans('coins::front.all_time_high') }}
                                                <button type="button"
                                                        class="btn question-trigger"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-trigger="hover focus"
                                                        title="ATH - 'All Time High'. С други думи това е най-високата цена, регистрирана някога за определения coin, измерена в щатски долари.">
                                                    <i class="far fa-question-circle" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="detail-value">
                                                <div class="value">
                                                    ${{ beatify_number($coin->ath) }}
                                                </div>
                                                {{--                                        <div class="value">--}}
                                                {{--                                            17 Dec 2017--}}
                                                {{--                                        </div>--}}
                                                <div class="value faded">
                                                    {{ trans('coins::front.to_ath') }}
                                                    ({{ format_number(($coin->ath - $coin->current_price) / $coin->current_price * 100) }}%)
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                        <div class="detail">--}}
                                        {{--                                            <div class="detail-head">--}}
                                        {{--                                                Circulating Supply--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="detail-value">--}}
                                        {{--                                                <div class="value">--}}
                                        {{--                                                    {{ beatify_number($coin->circulating_supply) }}--}}
                                        {{--                                                    @if (!empty($coin->total_supply))--}}
                                        {{--                                                        @php--}}
                                        {{--                                                            $percentage = ($coin->circulating_supply * 100) / $coin->total_supply;--}}
                                        {{--                                                        @endphp--}}
                                        {{--                                                            ({{ format_number($percentage) }}%)--}}
                                        {{--                                                    @endif--}}

                                        {{--                                                </div>--}}
                                        {{--                                                <div class="value faded">--}}
                                        {{--                                                    Total: 17 679 300--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="value faded">--}}
                                        {{--                                                    Max: @if (!empty($coin->total_supply)) {{ beatify_number($coin->total_supply) }} @else--}}
                                        {{--                                                        ∞ @endif--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="detail">
                                            <div class="detail-head">
                                                {{ trans('coins::front.volume_24') }}
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
                                                <div class="value faded">
                                                    {{beatify_number(round($coin->volume_24h / $coin->current_price))}} {{ strtoupper($coin->symbol) }}

                                                </div>
                                                {{--                                        <div class="value">--}}
                                                {{--                                            1 896 068 BTC--}}
                                                {{--                                        </div>--}}
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="detail-head">
                                                {{ trans('coins::front.coins_in_circulation') }}
                                            </div>
                                            <div class="detail-value">
                                                <div class="value">
                                                    {{beatify_number($coin->circulating_supply) }} {{ strtoupper($coin->symbol) }}
                                                </div>
                                                <div class="value faded">
                                                    {{ trans('coins::front.max') }}
                                                    : @if (!empty($coin->total_supply)) {{ beatify_number($coin->total_supply) }} @else
                                                        ∞ @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                        <div class="detail">--}}
                                        {{--                                            <div class="detail-head">--}}
                                        {{--                                                Updated At--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="detail-value">--}}
                                        {{--                                                <div class="value">--}}
                                        {{--                                                    {{ date_with_hour($coin->updated_at)  }}--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            @if (!empty(strip_tags($coin->description)))
                <div class="coin-description">
                    <h2>Какво е {{ $coin->title }}</h2>
                    {!! $coin->description !!}
                </div>
            @endif
            <div class="d-md-none d-block web-redirects pb-4">
                @if (!empty($coin->homepage))
                    <div class="nav-section">
                        <div class="list-title">
                            {{ trans('coins::front.website') }}
                        </div>
                        <ul class="nav-list">
                            @foreach($coin->homepage as $website)
                                <li>
                                    @if(isset(parse_url($website)['host']))
                                        <a href="{{ $website }}" title="{{ $website }}" class="side-link">
                                            {{ parse_url($website)['host'] }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (!empty($coin->blockchain_sites))
                    <div class="nav-section">
                        <div class="list-title">
                            {{ trans('coins::front.explore') }}
                        </div>
                        <ul class="nav-list">
                            @foreach($coin->blockchain_sites as $website)
                                <li>
                                    @if(isset(parse_url($website)['host']))
                                        <a href="{{ $website }}" title="{{ $website }}" class="side-link">
                                            {{ parse_url($website)['host'] }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            @if (!empty($coin->graph_data))
                <div class="coin-live-price" style="margin-bottom: -10px;">
                    <h2 class="trade-title">{{ $coin->title }} {{ trans('coins::front.real_time_price') }}</h2>
                    <!-- TradingView Widget BEGIN -->
                    <span class="d-none trade-view-coin" data-coin="{{ $coin->graph_data }}"></span>

                    <div class="tradingview-widget-container">
                        <div id="tradingview"></div>
                        <div class="tradingview-widget-copyright">
                            <a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/"
                               rel="noopener"
                               target="_blank">
                            </a>
                        </div>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            @endif
            @if (!empty($coin->articles))
                <div class="moreNewsContainer">
                    {{--<div class="minicontainer" style="width: unset">--}}
                    {{--<span class="topTitle">Още Bitcoin новини</span>--}}
                    {{--</div>--}}
                    <div class="minicontainer" style="width: unset">
                        <div class="leftBlock">
                            <h2 style="margin-top: 0px;"
                                class="topTitle">
                                @if ($coin->articles->isNotEmpty()){{ $coin->title }}@else Крипто @endif Новини</h2>
                            <div class="w-100 text-center d-desktop-none" style="transform: translateY(15px)">
                                <!-- Coinzilla Banner 300x250 -->
                                <div class="coinzilla" data-zone="C-7735ce7f52125b0c500"></div>
                                <script>
                                    window.coinzilla_display = window.coinzilla_display || [];
                                    var c_display_preferences = {};
                                    c_display_preferences.zone = "7735ce7f52125b0c500";
                                    c_display_preferences.width = "300";
                                    c_display_preferences.height = "250";
                                    coinzilla_display.push(c_display_preferences);
                                </script>
                            </div>

                            @foreach($random_articles as $random_article)
                                <a class="article"
                                   href="{{ route('blog.view', ['article_slug' => $random_article->slug]) }}" title="{{$random_article->title}}"
                                   style="width: unset; max-width: 95%;">
                                    <div class="contentLeft">
                                        {{--<h4 class="trade-title">{{ $random_article->title }}</h4>--}}
                                        <h4 class="title">{{ $random_article->title }}</h4>
                                        <div class="excerpt">
                                            {!! strip_description($random_article->description, 200) !!}
                                        </div>
                                        <span class="infoBox">
							<span class="infoCol">
								<span class="icon"><i class="far fa-calendar"></i></span>
                                {{ simple_uppercase_format($random_article->created_at) }}
							</span>
							<span class="infoCol">
								<span class="icon"><i class="far fa-clock"></i></span>
								<strong>{{$random_article->estimate_reading_time($random_article->description)}}
                                    . {{ trans('index::front.reading') }}</strong>
							</span>
						</span>
                                    </div>
                                    <div class="contentRight">
                                        @if	(!empty($random_article->getFirstMedia()))
                                            <span class="imgContainer">
							        <span class="image"
                                          style="background-image: url({{ $random_article->getFirstMedia()->getUrl('thumb') }});"></span>
						        </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        @if (!empty($popular_articles) && $popular_articles->isNotEmpty())
                            <div class="lastestNewsList">
                                <div class="coinzilla" data-zone="C-7735ce7f52125b0c500"></div>
                                <script>
                                    window.coinzilla_display = window.coinzilla_display || [];
                                    var c_display_preferences = {};
                                    c_display_preferences.zone = "7735ce7f52125b0c500";
                                    c_display_preferences.width = "300";
                                    c_display_preferences.height = "250";
                                    coinzilla_display.push(c_display_preferences);
                                </script>
                                <span class="heading" style="margin-top: 20px;">{{ trans('index::front.popular_news') }}</span>
                                <ul class="latestNewsList">
                                    @foreach($popular_articles as $popular_article)
                                        <li>
                                            <a class="article"
                                               href="{{ route('blog.view', ['article_slug' => $popular_article->slug]) }}" title="{{$popular_article->title}}">
                                                <div class="articleRow">
                                                    <span class="number">{{ $loop->index + 1}}</span>
                                                    <span class="content">
										<h4 class="title">{{ $popular_article->title }}</h4>
										<span class="infoBox">
											<span class="infoCol">
												<span class="icon"><i class="far fa-calendar"></i></span>
                                                {{ simple_uppercase_format($popular_article->created_at) }}
											</span>
											<span class="infoCol">
												<span class="icon"><i class="far fa-clock"></i></span>
												<strong>{{$popular_article->estimate_reading_time($popular_article->description)}}
                                                    . {{ trans('index::front.reading') }}</strong>
											</span>
										</span>
									</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
