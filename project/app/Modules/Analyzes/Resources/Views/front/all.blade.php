{{--/blog--}}
@extends('layouts.app')
@section('content')

    <div class="lastNewsContainer">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">АНАЛИЗИ</h4>
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
                <div class="newTabs">
                    <div class="tabLinks">
                        @if ($categories->isNotEmpty())
                            <div id="custom-material-tabs">
                                @foreach($categories as $sub_cat)

                                    @php
                                        $active = (empty($active_category) && $loop->first) ? true : false;
                                        $active = (!$active && !empty($active_category) && $active_category->id == $sub_cat->id) ? true : false;
                                    @endphp
                                    <a
                                            {{--                                            data-slug="{{$sub_cat->slug}}"--}}
                                            {{--                                       onclick="changeArticlesData('{{$sub_cat->slug}}', 1, true)"--}}
                                            href="{{ route('analyzes.index', $sub_cat->slug) }}"
                                            @if ($active) class="active" @endif>{{ $sub_cat->title }}</a>
                                @endforeach
                            </div>
                        @endif

                        <div class="bannerContainer">
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
                                @include('analyzes::boxes.analyzes_box', $articles)
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
                                       href="{{ route('blog.view', ['category_slug' => $popular_article->category->slug, 'article_slug' => $popular_article->slug]) }}">
                                        <div class="articleRow">
                                            <span class="number">{{ $loop->index }}</span>
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