{{--/blog--}}
@extends('layouts.app')
@section('content')

    <div class="lastNewsContainer">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">{{ $tag->title }}</h4>
                {{--                <a class="headerLink" href="">Виж всички <i class="fas fa-angle-right"></i></a>--}}
            <!-- Coinzilla Banner 728x90 -->
                <div class="topBannerHolder">
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
            <div class="lastNewsRow">

                <div class="w-100 text-center d-desktop-none pt-3">
                    <!-- Coinzilla Banner 300x250 -->
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
                <div class="newTabs">
                    <div class="tabLinks">
                        <div id="custom-material-tabs" style="display:none">
                            <a data-slug="{{$tag->id}}" class="active" style="display: none;"></a>
                        </div>
                        <div class="bannerContainer" style="margin-top:0px">
                            <a href="{{ route('contacts.index') }}" class="title">{{ trans('index::front.advertise_here') }}</a>
                            <div class="bannerHolder">
                                <!-- Coinzilla Banner 160x600 -->
                                <div class="coinzilla" data-zone="C-1415ce7f5212dc43181"></div>
                                <script>
                                    window.coinzilla_display = window.coinzilla_display || [];
                                    var c_display_preferences = {};
                                    c_display_preferences.zone = "1415ce7f5212dc43181";
                                    c_display_preferences.width = "160";
                                    c_display_preferences.height = "600";
                                    coinzilla_display.push(c_display_preferences);
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="tabContentContainer">
                        <div class="custom-tab-content">
                            <div id="articles_container">
                                @include('blog::boxes.tags_box', $articles)
                            </div>
{{--                            <div class="loader" style="display:none; text-align: center;">--}}
{{--                                <img src="{{ asset('images/banana_dance.gif') }}" style="width: 40px;margin-top:20px;">--}}
{{--                            </div>--}}
{{--                            <span style="display: none;" class="page_number">1</span>--}}
                            {{ $articles->links('pagination.news_custom') }}
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
                                       href="{{ route('blog.view', ['article_slug' => $popular_article->slug]) }}" title="{{ $popular_article->title }}">
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

@endsection