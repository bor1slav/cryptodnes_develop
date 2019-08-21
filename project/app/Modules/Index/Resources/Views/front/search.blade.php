{{--/blog--}}
@extends('layouts.app')
@section('content')

    <div class="lastNewsContainer">
        <div class="container">
            <div class="headerContent">
                <h4 class="title">ТЪРСЕНЕ НА {{ mb_strtoupper($search_word) }}</h4>
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
                        <div id="custom-material-tabs" style="display:none">
                            <a data-slug="Няма значение" class="active" style="display: none;"></a>
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
                    @if ($blog_articles->isEmpty() && $analyzes_articles->isEmpty())
                    <div class="tabContentContainer">
                        <div class="custom-tab-content">
                            <div class="headerContent" style="border: none">
                                <h4 class="title">Няма намерени резултати</h4>
                                <div id="articles_container">
                                    <a class="article"
                                       href="javascript:void(0);" style="cursor: default">
                                        <div class="contentRight">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($blog_articles->isNotEmpty())
                        <div class="tabContentContainer">
                            <div class="custom-tab-content">
                                <div class="headerContent">
                                    <h4 class="title" style="font-size:28px;">Новини</h4>
                                    {{--                <a class="headerLink" href="">Виж всички <i class="fas fa-angle-right"></i></a>--}}
                                </div>
                                <div id="articles_container">
                                    @foreach($blog_articles as $article)
                                        <a class="article"
                                           href="{{ route('blog.view', ['article_slug' => $article->slug]) }}"
                                           title="{{ $article->title }}">
                                            <div class="contentLeft">
                                                <h4 class="title">{{ $article->title }}</h4>
                                                <div class="excerpt">
                                                    {!!  strip_description($article->description, 200)  !!}
                                                </div>
                                                <span class="infoBox">
                                                <span class="infoCol">
                                                <span class="icon"><i class="far fa-calendar"></i></span>
                                                {{ simple_uppercase_format($article->created_at) }}
                                            </span>
                                            <span class="infoCol">
                                                <span class="icon"><i class="far fa-clock"></i></span>
                                                <strong>{{$article->estimate_reading_time($article->description)}}. {{ trans('index::front.reading') }}</strong>
                                            </span>
                                        </span>
                                            </div>
                                            <div class="contentRight">
                                        <span class="imgContainer">
                                         @if (!empty($article->getFirstMedia()))
                                                <span class="image"
                                                      style="background-image: url({{ $article->getFirstMedia()->getUrl('thumb') }});"></span>
                                            @else
                                                <span class="image"
                                                      style="background-image: url({{ asset('images/pic_backup.jpg') }});"></span>
                                            @endif
                                        </span>
                                            </div>
                                        </a>
                                    @endforeach
                                    @if(!empty($analyzes_articles) && $analyzes_articles->isNotEmpty())
                                        <div class="headerContent" style="border-style: none;">
                                            <h4 class="title"
                                                style="margin-top:30px; font-size:28px;    border-bottom: 4px solid #f2f2f2;padding-bottom:38px;">
                                                Анализи</h4>
                                            {{--                <a class="headerLink" href="">Виж всички <i class="fas fa-angle-right"></i></a>--}}
                                        </div>
                                        @foreach($analyzes_articles as $article)
                                            <a class="article"
                                               href="{{ route('analyzes.view', ['category_slug' => $article->category->slug, 'article_slug' => $article->slug]) }}"
                                               title="{{ $article->title }}">
                                                <div class="contentLeft">
                                                    <h4 class="title">{{ $article->title }}</h4>
                                                    <div class="excerpt">
                                                        {!!  strip_description($article->description, 200)  !!}
                                                    </div>
                                                    <span class="infoBox">
                                                <span class="infoCol">
                                                <span class="icon"><i class="far fa-calendar"></i></span>
                                                {{ simple_uppercase_format($article->created_at) }}
                                            </span>
                                            <span class="infoCol">
                                                <span class="icon"><i class="far fa-clock"></i></span>
                                                <strong>{{$article->estimate_reading_time($article->description)}}. {{ trans('index::front.reading') }}</strong>
                                            </span>
                                        </span>
                                                </div>
                                                <div class="contentRight">
                                        <span class="imgContainer">
                                         @if (!empty($article->getFirstMedia()))
                                                <span class="image"
                                                      style="background-image: url({{ $article->getFirstMedia()->getUrl('thumb') }});"></span>
                                            @else
                                                <span class="image"
                                                      style="background-image: url({{ asset('images/pic_backup.jpg') }});"></span>
                                            @endif
                                        </span>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif

                                </div>
                                @if ($analyzes_articles->lastPage() > $analyzes_articles->lastPage())
                                    {{ $analyzes_articles->links('pagination.news_custom') }}
                                @else
                                    {{ $blog_articles->appends(['word' => $search_word])->links('pagination.news_custom')}}
                                @endif
                            </div>
                        </div>
                    @endif
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
    </div>

    </div>

@endsection