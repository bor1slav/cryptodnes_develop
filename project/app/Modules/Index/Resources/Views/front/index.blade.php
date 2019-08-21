@extends('layouts.app')
@section('content')

    <div class="articleContainer">
        <div class="container">
            <div class="leftSide">
                @if(!empty($special_coin) && !empty($special_coin->analyze))
                    <a href="{{ route('analyzes.view', ['category' => $special_coin->analyze->slug, 'article_slug' => $special_coin->analyze->articles->first()->slug]) }}"
                       title="{{$special_coin->analyze->articles->first()->title}}"
                       class="cryptoCurrency">
                        @if (!empty($special_coin->getFirstMedia()))
                            <span class="imgContainer"><img src="{{ $special_coin->getFirstMediaUrl() }}" alt=""></span>
                        @else
                            {{--                            <span class="imgContainer"><img src="{{ asset('images/coin_backup.png') }}" alt=""></span>--}}

                        @endif
                        <span class="text">{{ $special_coin->analyze->title }}</span>
                        @if(!empty($special_coin->analyze->articles))
                            {{--                            <a href="" class="textS">fsafas</a>--}}
                            <span href="index.blade.php"
               x                   class="linkS">{!! format_current_date_for_last_blog($special_coin->analyze->articles->first()->created_at) !!}</span>
                        @endif
                        <span class="orangeLine"></span>
                    </a>
                @endif
                <span class="statisticContainer">
					<span class="statistic">
						@if(!empty($most_winning_coin))
                            <span class="single">
                            <a href="{{ route('coins.view', $most_winning_coin->slug) }}"
                               title="{{$most_winning_coin->title}}">
                                <span class="rowStatic">
                                    <span class="leftCol">
                                        <span class="textL">{{ trans('index::front.most_winning') }}</span>
                                        <span class="textS">{{ simple_date_format(\Carbon\Carbon::now()) }}</span>
                                    </span>
                                    <span class="rightCol">
                                        <span class="ellipseGreen"><img src="{{ asset('images/chevrons-up.svg') }}"
                                                                        alt=""></span>
                                    </span>
                                </span>

							<span class="rowStatic">
								<span class="leftCol">
									<span class="textL">{{ $most_winning_coin->title }}</span>
									<span class="textS">${{ $most_winning_coin->current_price }}</span>
								</span>
								<span class="rightCol">
									<span class="colorText greenText">{{format_number($most_winning_coin->price_change_percentage_24h)}}%</span>
								</span>
							</span>
                                  </a>
						</span>
                        @endif
                        @if(!empty($most_losing_coin))
                            <span class="single">
                            <a href="{{ route('coins.view', $most_losing_coin->slug) }}"
                               title="{{$most_losing_coin->title}}">
							<span class="rowStatic">
								<span class="leftCol">
									<span class="textL">{{ trans('index::front.most_losing') }}</span>
									<span class="textS">{{ simple_date_format(\Carbon\Carbon::now()) }}</span>
								</span>
								<span class="rightCol">
									<span class="ellipseRed"><img src="{{ asset('images/chevrons-down.svg') }}" alt=""></span>
								</span>
							</span>
							<span class="rowStatic">
								<span class="leftCol">
									<span class="textL">{{ $most_losing_coin->title }}</span>
									<span class="textS">${{ $most_losing_coin->current_price }}</span>
								</span>
								<span class="rightCol">
									<span class="colorText redText">{{ format_number($most_losing_coin->price_change_percentage_24h)}}%</span>
								</span>
							</span>
                            </a>
						</span>
                        @endif
					</span>
				</span>
            </div>
            <div class="centerSide">
                @if(!empty($main_article))
                    <a href="{{  route('blog.view', ['article_slug' => $main_article->slug]) }}"
                       title="{{$main_article->title}}">
                    <span class="article only-desktop">
                    <span class="articleImg">
                        @if (!empty($main_article->getFirstMedia()))
                            <img src="{{ $main_article->getFirstMedia()->getUrl('index') }}"
                                 alt="@if (!empty($main_article->picture_description)){{ $main_article->picture_description }}@else{{ $main_article->title }} @endif">
                        @else
                            {{--                            <img src="{{ asset('images/article_backup.jpg') }}" alt="@if (!empty($article->description)) {{ optimize_meta_description($article->meta_description) }} @else {{ $article->title }}">--}}
                        @endif
					</span>
					<h2 class="title">{{ $main_article->title }}</h2>
					<span class="infoBox">
						<span class="infoCol">
							<span class="icon"><i class="far fa-calendar"></i></span>
							{{ simple_uppercase_format($main_article->created_at) }}
						</span>
						<span class="infoCol">
							<span class="icon"><i class="far fa-clock"></i></span>

							<strong>{{ $main_article->estimate_reading_time($articles_in_index->first()->description) }}. {{ trans('index::front.reading') }}</strong>
						</span>
					</span>
				</span>
                    </a>

                @endif
                <div id="bs-carousel" class="carousel slide only-mobile" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        @for ($i = 0; $i < $articles_in_index->count(); $i++)
                            <li data-target="#bs-carousel" data-slide-to="{{ $i }}"
                                @if ($i == 0) class="active" @endif></li>
                        @endfor
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        @php
                            if (!empty($main_article)) {
                            $articles_in_index->prepend($main_article);
                            }
                        @endphp
                        @foreach($articles_in_index as $article_in_index_mobile)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <a href="{{  route('blog.view', ['article_slug' => $article_in_index_mobile->slug]) }}"
                                class="article">
                                <span class="articleImg">
                                     @if (!empty($article_in_index_mobile->getFirstMedia()))
                                        <img src="{{ $article_in_index_mobile->getFirstMedia()->getUrl('index') }}"
                                             alt="@if (!empty($article_in_index_mobile->picture_description)) {{ $article_in_index_mobile->picture_description }} @else {{ $article_in_index_mobile->title }} @endif">
                                    @else
                                        {{--                                        <img src="{{ asset('images/article_backup.jpg') }}" alt="title">--}}
                                    @endif
								</span>
                                <h2 class="title">{{ $article_in_index_mobile->title }}</h2>
                                <span class="infoBox">
									<span class="infoCol">
										<span class="icon"><i class="far fa-calendar"></i></span>
										{{ simple_uppercase_format($article_in_index_mobile->created_at) }}
									</span>
									<span class="infoCol">
										<span class="icon"><i class="far fa-clock"></i></span>
										<strong>{{$article_in_index_mobile->estimate_reading_time($article_in_index_mobile->description)}}. {{ trans('index::front.reading') }}</strong>
									</span>
								</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="rightSide">
                <div class="topContent">
                    <span class="personCounter"><span class="counter strong custom-counter"
                                                      data-count="{{ $visitors }}">0</span><br
                                style="clear: both;"/><span
                                class="small">{{ trans('index::front.readers_today') }}</span></span>
                    <span class="imgContainer">
						<canvas id="canvas-id"></canvas>
					</span>
                </div>
                <div class="articlesList">
                    @foreach($articles_in_index as $article_in_index_desktop)
                        @if ($loop->first)
                            @php
                            continue;
                            @endphp
                            @endif
                        <a class="article"
                           href="{{  route('blog.view', [ 'article_slug' => $article_in_index_desktop->slug]) }}"
                           title="{{$article_in_index_desktop->title}}">
                            <h3 class="title">{{ $article_in_index_desktop->title }}</h3>
                            <span class="infoBox">
							<span class="infoCol">
								<span class="icon"><i class="far fa-calendar"></i></span>
								{{ simple_uppercase_format($article_in_index_desktop->created_at) }}
							</span>
							<span class="infoCol">
								<span class="icon"><i class="far fa-clock"></i></span>
								<strong>{{$article_in_index_desktop->estimate_reading_time($article_in_index_desktop->description)}}. {{ trans('index::front.reading') }}</strong>
							</span>
						</span>
                        </a>
                        @if (!$loop->last)
                            <div class="clearfix"></div>
                            <span class="grayLine"></span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="w-100 text-center pt-4">
            <!-- Coinzilla Banner 728x90 -->
            <div class="coinzilla" data-zone="C-395ce7f5212a47c712"></div>
            <script>
                window.coinzilla_display = window.coinzilla_display || [];
                var c_display_preferences = {};
                c_display_preferences.zone = "395ce7f5212a47c712";
                c_display_preferences.width = "728";
                c_display_preferences.height = "90";
                coinzilla_display.push(c_display_preferences);
            </script>
        </div>
    </div>

    <div class="lastNewsContainer" style="margin-top: 15px">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">{{ trans('index::front.last_news') }}</h4>
                {{--                <a class="headerLink" href="">{{ trans('index::front.view_all') }} <i--}}
                {{--                            class="fas fa-angle-right"></i></a>--}}
            </div>
            <div class="lastNewsRow">
                <div class="newTabs">
                    <span id="mobileMatTitle"></span>
                    <div class="tabLinks">
                        <div id="material-tabs">
                            @foreach($blog_categories as $blog_category)
                                <a id="tab{{$blog_category->id}}-tab" href="#tab{{$blog_category->id}}"
                                   @if ($loop->first) class="active" @endif>{{$blog_category->title}}</a>
                            @endforeach
                        </div>
                        <div class="bannerContainer">
                            <a href="{{ route('contacts.index') }}"
                               class="title">{{ trans('index::front.advertise_here') }}</a>
                            <div class="bannerHolder">
                                <!-- Coinzilla Banner 160x600 -->
                                <script async src="https://coinzillatag.com/lib/display.js"></script>
                                <div class="coinzilla" data-zone="C-1415ce7f5212dc43181"></div>
                                <script>
                                    window.coinzilla_display = window.coinzilla_display || [];
                                    var c_display_preferences = {};
                                    c_display_preferences.zone = "1415ce7f5212dc43181";
                                    c_display_preferences.width = "160";
                                    c_display_preferences.height = "600";
                                    coinzilla_display.push(c_display_preferences);
                                </script>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tabContentContainer">
                        <div class="tab-content">
                            @foreach($blog_categories as $blog_category)
                                <div id="tab{{ $blog_category->id }}">
                                    @foreach($blog_category->last_articles as $last_article)
                                        <a class="article"
                                           href="{{ route('blog.view', ['article_slug' => $last_article->slug]) }}"
                                           title="{{$last_article->title}}">
                                            <div class="contentLeft">
                                                <h4 class="title">{{ $last_article->title }}</h4>
                                                <div class="excerpt">
                                                    {!!  strip_description($last_article->description, 200)  !!}
                                                </div>
                                                <span class="infoBox">
											<span class="infoCol">
												<span class="icon"><i class="far fa-calendar"></i></span>
												{{ simple_uppercase_format($last_article->created_at) }}
											</span>
											<span class="infoCol">
												<span class="icon"><i class="far fa-clock"></i></span>
												<strong>{!! $last_article->estimate_reading_time($last_article->description)!!}. {{ trans('index::front.reading') }}</strong>
												<strong></strong>
											</span>
										</span>
                                            </div>
                                            <div class="contentRight">
                                                @if (!empty($last_article->getFirstMedia()))
                                                    <span class="imgContainer">
											            <span class="image"
                                                              style="background-image: url({{ $last_article->getFirstMedia()->getUrl('thumb') }});"></span>
										            </span>
                                                @else
                                                    {{--                                                    <span class="imgContainer">--}}
                                                    {{--											            <span class="image"--}}
                                                    {{--                                                              style="background-image: url({{ asset('images/pic_backup.jpg') }});"></span>--}}
                                                    {{--										            </span>--}}
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if (!empty($popular_articles) && $popular_articles->isNotEmpty())
                    <div class="lastestNewsList">
                        <span class="heading">{{ trans('index::front.popular_news') }}</span>
                        <ul class="latestNewsList">
                            @foreach($popular_articles as $popular_article)
                                <li>
                                    <a class="article"
                                       href="{{ route('blog.view', ['article_slug' => $popular_article->slug]) }}"
                                       title="{{$popular_article->title}}">
                                        <div class="articleRow">
                                            <span class="number">{{ $loop->index + 1 }}</span>
                                            <span class="content">
										<h4 class="title">{{ $popular_article->title }}</h4>
										<span class="infoBox">
											<span class="infoCol">
												<span class="icon"><i class="far fa-calendar"></i></span>
                                                {{ simple_uppercase_format($popular_article->created_at) }}
											</span>
											<span class="infoCol">
												<span class="icon"><i class="far fa-clock"></i></span>
												<strong>{{$popular_article->estimate_reading_time($popular_article->description)}}. {{ trans('index::front.reading') }}</strong>
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
    </div>


    <div class="indexContainer" style="margin-top:60px;">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">{{ trans('index::front.analyzes') }}</h4>
                {{--                <a class="headerLink" href="{{ route('coins.index') }}">{{ trans('index::front.view_all') }} <i--}}
                {{--                            class="fas fa-angle-right"></i></a>--}}
            </div>
            <div class="indexSlider owl-carousel">
                @foreach($analyzes_categories as $analyze_category)
                    <a href="{{ route('analyzes.index', ['slug' => $analyze_category->slug]) }}"
                       title="{{$analyze_category->title}}"
                       class="cryptoCurrency">
                        <span class="imgContainer">
                        @if (!empty($analyze_category->coin) && !empty($analyze_category->coin->getFirstMedia()))
                                <img src="{{ $analyze_category->coin->getFirstMedia()->getUrl() }}" alt=""></span>
                        @else
                            <img src="{{ asset('images/coin_backup.png') }}" alt=""></span>
                        @endif
                        <span class="text">{{ $analyze_category->title }}</span>
                        <span class="textS">
                            @if(!empty($analyze_category->latestArticle->created_at))
                                {{ format_current_date_for_last_blog($analyze_category->latestArticle->created_at) }}
                            @endif
                        </span>
                        <span class="orangeLine"></span>
                        <span class="buttonBox">
                            <span class="read-more">{{ trans('index::front.read_more') }} <i
                                        class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="lastNewsContainer" style="margin-top: 15px">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">{{ trans('index::front.last_analyzes') }}</h4>
                {{--                <a class="headerLink" href="">{{ trans('index::front.view_all') }} <i--}}
                {{--                            class="fas fa-angle-right"></i></a>--}}
            </div>
            <div class="lastNewsRow">
                <div class="newTabs">
                    <span id="mobileMatTitle"></span>
                    <div class="tabLinks">
                        <div id="material-tabs" data-analyze="material-tabs-2">
                            @foreach($analyzes_categories as $last_analyze_category)
                                <a id="tab{{$last_analyze_category->id}}-tab" href="#tab_analyze_{{$last_analyze_category->id}}"
                                   @if ($loop->first) class="active" @endif>{{$last_analyze_category->title}}</a>
                            @endforeach
                        </div>
{{--                        <div class="bannerContainer">--}}
{{--                            <a href="{{ route('contacts.index') }}"--}}
{{--                               class="title">{{ trans('index::front.advertise_here') }}</a>--}}
{{--                            <div class="bannerHolder">--}}
{{--                                <!-- Coinzilla Banner 160x600 -->--}}
{{--                                <script async src="https://coinzillatag.com/lib/display.js"></script>--}}
{{--                                <div class="coinzilla" data-zone="C-1415ce7f5212dc43181"></div>--}}
{{--                                <script>--}}
{{--                                    window.coinzilla_display = window.coinzilla_display || [];--}}
{{--                                    var c_display_preferences = {};--}}
{{--                                    c_display_preferences.zone = "1415ce7f5212dc43181";--}}
{{--                                    c_display_preferences.width = "160";--}}
{{--                                    c_display_preferences.height = "600";--}}
{{--                                    coinzilla_display.push(c_display_preferences);--}}
{{--                                </script>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="tabContentContainer">
                        <div class="tab-content">
                            @foreach($analyzes_categories as $last_analyze_category)
                                <div id="tab_analyze_{{ $last_analyze_category->id }}">
                                    @foreach($last_analyze_category->last_articles as $last_analyze)
                                        <a class="article"
                                           href="{{ route('analyzes.view', ['category_slug' => $last_analyze_category->slug, 'article_slug' => $last_analyze->slug]) }}"
                                           title="{{$last_article->title}}">
                                            <div class="contentLeft">
                                                <h4 class="title">{{ $last_analyze->title }}</h4>
                                                <div class="excerpt">
                                                    {!!  strip_description($last_analyze->description, 200)  !!}
                                                </div>
                                                <span class="infoBox">
											<span class="infoCol">
												<span class="icon"><i class="far fa-calendar"></i></span>
												{{ simple_uppercase_format($last_analyze->created_at) }}
											</span>
											<span class="infoCol">
												<span class="icon"><i class="far fa-clock"></i></span>
												<strong>{!! $last_analyze->estimate_reading_time($last_analyze->description)!!}. {{ trans('index::front.reading') }}</strong>
												<strong></strong>
											</span>
										</span>
                                            </div>
                                            <div class="contentRight">
                                                @if (!empty($last_analyze->getFirstMedia()))
                                                    <span class="imgContainer">
											            <span class="image"
                                                              style="background-image: url({{ $last_analyze->getFirstMedia()->getUrl('thumb') }});"></span>
										            </span>
                                                @else
                                                    {{--                                                    <span class="imgContainer">--}}
                                                    {{--											            <span class="image"--}}
                                                    {{--                                                              style="background-image: url({{ asset('images/pic_backup.jpg') }});"></span>--}}
                                                    {{--										            </span>--}}
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if (!empty($popular_analyzes) && $popular_analyzes->isNotEmpty())
                    <div class="lastestNewsList">
                        <span class="heading">{{ trans('index::front.popular_analyzes') }}</span>
                        <ul class="latestNewsList">
                            @foreach($popular_analyzes as $popular_analyze)
                                <li>
                                    <a class="article"
                                       href="{{ route('analyzes.view', ['category_slug' => $popular_analyze->category->slug, 'article_slug' => $popular_analyze->slug]) }}"
                                       title="{{$popular_analyze->title}}">
                                        <div class="articleRow">
                                            <span class="number">{{ $loop->index + 1 }}</span>
                                            <span class="content">
										<h4 class="title">{{ $popular_analyze->title }}</h4>
										<span class="infoBox">
											<span class="infoCol">
												<span class="icon"><i class="far fa-calendar"></i></span>
                                                {{ simple_uppercase_format($popular_analyze->created_at) }}
											</span>
											<span class="infoCol">
												<span class="icon"><i class="far fa-clock"></i></span>
												<strong>{{$popular_analyze->estimate_reading_time($popular_analyze->description)}}. {{ trans('index::front.reading') }}</strong>
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
    </div>
    <div class="lastNewsContainer">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">ФИНТЕХ НОВИНИ</h4>
                {{--                <a class="headerLink" href="">Виж всички <i class="fas fa-angle-right"></i></a>--}}
            </div>
            <div class="w-100 text-center pt-3 d-desktop-none">
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
            <div class="lastNewsRow">
                <div class="newTabs pt-0">
{{--                    <div class="tabLinks">--}}
                        {{--                        <div class="bannerContainer" style="margin-top:0px">--}}
                        {{--                            <span class="title">{{ trans('index::front.advertise_here') }}</span>--}}
                        {{--                            <div class="bannerHolder">--}}
                        {{--                                @php--}}
                        {{--                                    $banner = \Charlotte\Administration\Helpers\Settings::getFile('index_banner', 'long_ad');--}}
                        {{--                                @endphp--}}
                        {{--                                <a href="">--}}
                        {{--                                    @if (!empty($banner))--}}
                        {{--                                        <img src="{{ $banner }}"--}}
                        {{--                                             alt="">--}}
                        {{--                                    @else--}}
                        {{--                                        <img src="{{ asset('images/banner_backup.jpg') }}"--}}
                        {{--                                             alt="">--}}
                        {{--                                    @endif--}}
                        {{--                                </a>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
{{--                    </div>--}}
                    <div class="tabContentContainer" style="padding-left: 0;">
                        <div class="custom-tab-content">
                            <div id="articles_container">
                                @include('blog::boxes.articles_box', ['articles' => $finteh_articles])
                            </div>
                            {{--                            <div class="loader" style="display:none; text-align: center;">--}}
                            {{--                                <img src="{{ asset('images/banana_dance.gif') }}" style="width: 40px;margin-top:20px;">--}}
                            {{--                            </div>--}}
                            {{--                            <span style="display: none;" class="page_number">1</span>--}}
                        </div>
                    </div>
                </div>
                @if (!empty($last_bitcoin_news) && $last_bitcoin_news->isNotEmpty())
                    <div class="lastestNewsList">
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
                        <span class="heading" style="margin-top: 20px;">Биткойн Новини</span>
                        <ul class="latestNewsList">
                            @foreach($last_bitcoin_news as $popular_article)
                                <li>
                                    <a class="article"
                                       href="{{ route('blog.view', ['article_slug' => $popular_article->slug]) }}"
                                       title="{{ $popular_article->title }}">
                                        <div class="articleRow">
                                            <span class="number">{{ $loop->index + 1 }}</span>
                                            <span class="content">
										<h4 class="title">{{ $popular_article->title }}</h4>
										<span class="infoBox">
											<span class="infoCol">
												<span class="icon"><i class="far fa-calendar"></i></span>
                                                {{ simple_uppercase_format($popular_article->created_at) }}
											</span>
											<span class="infoCol">
												<span class="icon"><i class="far fa-clock"></i></span>
												<strong>{{$popular_article->estimate_reading_time($popular_article->description)}}. {{ trans('index::front.reading') }}</strong>
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
    </div>
    <div class="indexContainer">

        <div class="formContainer" style="margin-top: 30px;">
            <div class="container">
{{--                <div class="col-md-12 text-center" style="margin-bottom:10px">--}}
{{--                    <div class="coinzilla" data-zone="C-395ce7f5212a47c712"></div>--}}
{{--                    <script>--}}
{{--                        window.coinzilla_display = window.coinzilla_display || [];--}}
{{--                        var c_display_preferences = {};--}}
{{--                        c_display_preferences.zone = "395ce7f5212a47c712";--}}
{{--                        c_display_preferences.width = "728";--}}
{{--                        c_display_preferences.height = "90";--}}
{{--                        console.log(coinzilla_display);--}}
{{--                        console.log(c_display_preferences);--}}
{{--                        coinzilla_display.push(c_display_preferences);--}}
{{--                    </script>--}}
{{--                    <script async src="https://coinzillatag.com/lib/display.js"></script>--}}
{{--                </div>--}}
                <span class="title">{{ trans('index::front.subscribe_to_crypto') }}</span>
                <span class="grayLineS"></span>
                <span class="subtitle">{{ trans('index::front.first_crypto_news') }}</span>
                <span class="indexForm">
				<form>
                       <div class="index-success-wrapper"></div>
                       <div class="index-errors-wrapper"></div>
					<label for="email">{{ trans('index::front.your_email') }}</label>
					<span class="inputRow">
						<input id="index_email" type="text" name="footer_email"
                               placeholder="{{ trans('index::front.email') }}">
								<input id="index_link" type="hidden" name="index_link"
                                       value="{{ route('subscribers.store') }}">
							<button class="submitBtn" type="button"
                                    onclick="submit_subscriber('index'); return false;"
                                    style="text-transform: uppercase;">{{ trans('index::front.subscribe') }}</button>
					</span>
				</form>
			</span>
            </div>
        </div>
    </div>
@endsection
