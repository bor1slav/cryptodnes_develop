@extends('layouts.app')
@section('content')

    <div class="singleArticle">
        <div class="minicontainer">
			<span class="breadcrumbs">
				<a href="{{ route('index') }}">{{ trans('index::front.home') }}</a>
                @if (!empty($article->categories->first()->ancestors))
                    @foreach($article->categories->first()->ancestors as $parent_category)
                        <a href="
                        @if(!empty($parent_category->slug))
                            {{ route('blog.index', $parent_category->slug) }}
                        @endif"
                        >{{ $parent_category->title }}</a>
                    @endforeach
                @endif

                <a href="
                @if(!empty($article->categories->first()->slug))
                    {{ route('blog.index', $article->categories->first()->slug) }}
                @endif">{{ $article->categories->first()->title }}</a>
			</span>
            <h1 class="title">{{ $article->title }}</h1>
            <span class="infoBox">
				<span class="infoCol">
					<span class="icon"><i class="far fa-calendar"></i></span>
                    {{ simple_uppercase_format($article->created_at) }}
				</span>
				<span class="infoCol">
					<span class="icon"><i class="far fa-clock"></i></span>
					<strong>{{$article->estimate_reading_time($article->description)}}
                        . {{ trans('index::front.reading') }}</strong>
				</span>
			</span>
            <div class="col-12" style="margin-top: 24px; margin-bottom: 0px; padding: 0px">
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
            <div class="shareContainer">
                <span class="shareText">СПОДЕЛИ:</span>
                <span class="iconsBox">
							<a class="fb-share" href="" rel="nofollow"><i class="fab fa-facebook-f"></i></a>
                    @if(!empty($article->slug))
							<a href="https://twitter.com/intent/tweet?text={{ trans('blog::front.twitter_share_msg', ['title' => $article->title, 'url' => route('blog.view', ['article_slug' => $article->slug])]) }}" rel="nofollow">
                                <i class="fab fa-twitter"></i>
                            </a>
                    @endif
{{--                            {{ dd(Request::url()) }}--}}
                            <a href="https://telegram.me/share/url?url={{ Request::url() }}&text={{ $article->meta_title }}" target="_blank" rel="nofollow"><i class="fab fa-telegram-plane"></i></a>
						</span>
                <span class="counter">
                        <span class="textL facebook_shares">0</span>
                        <span class="textM">СПОДЕЛЯНИЯ</span>
                        </span>
            </div>
            <span class="imgContainer">
                    @if (!empty($article->getFirstMedia()))
                    <img src="{{ $article->getFirstMedia()->getUrl('big') }}" alt="@if (!empty($article->picture_description)) {{ $article->picture_description }} @else {{ $article->title }} @endif">
                @else
{{--                    <img src="{{ asset('images/article_big_backup.jpg') }}" alt="">--}}
                @endif
			</span>
            @if (!empty($article->picture_description))
                <span class="imgExcerpt">{{ $article->picture_description }}</span>
            @endif
            @if (!empty($article->source))
                <span class="imgsubExcerpt">Източник: {{ $article->source }}</span>
            @endif

            {{--            <span class="imgsubExcerpt">Източник: Unsplash</span>--}}
            <div class="descriptionContainer mt-3">
                <div class="description">
                    @if (!empty($article->mini_description))
                        <p class="textStrong">{{ $article->mini_description }}</p>
                    @endif
                        <script src="https://coinzillatag.com/lib/wdnative.js"></script>
                        <script>var c_widget = czilla_widget || [];var c_widget_preferences = {}; c_widget_preferences.zone = "5205ce7f521377a2998"; c_widget_preferences.article = true; c_widget.push(c_widget_preferences);</script>
                        <div id="c_widget_5205ce7f521377a2998" style="margin-bottom:40px;"></div>
{{--                    <!-- Coinzilla Banner 300x250 -->--}}
{{--                        <div class="coinzilla" data-zone="C-7735ce7f52125b0c500"></div>--}}
{{--                        <script>--}}
{{--                            window.coinzilla_display = window.coinzilla_display || [];--}}
{{--                            var c_display_preferences = {};--}}
{{--                            c_display_preferences.zone = "7735ce7f52125b0c500";--}}
{{--                            c_display_preferences.width = "300";--}}
{{--                            c_display_preferences.height = "250";--}}
{{--                            coinzilla_display.push(c_display_preferences);--}}
{{--                        </script>--}}
                    {!! $article->description !!}
                    <div class="shareContainer">
                        <span class="shareText">СПОДЕЛИ:</span>
                        <span class="iconsBox">
							<a class="fb-share" href="" rel="nofollow"><i class="fab fa-facebook-f"></i></a>
							<a href="https://twitter.com/intent/tweet?text=@if(!empty($article->slug)){{ trans('blog::front.twitter_share_msg', ['title' => $article->title, 'url' => route('blog.view', ['article_slug' => $article->slug])]) }} @endif" rel="nofollow">
                                <i class="fab fa-twitter"></i>
                            </a>
{{--                            {{ dd(Request::url()) }}--}}
                            <a href="https://telegram.me/share/url?url={{ Request::url() }}&text={{ $article->meta_title }}"  target="_blank" rel="nofollow"><i class="fab fa-telegram-plane"></i></a>
						</span>
                        <span class="counter">
                        <span class="textL facebook_shares">0</span>
                        <span class="textM">СПОДЕЛЯНИЯ</span>
                        </span>
                    </div>
                    <span class="lineGray"></span>
                    @if (!empty($next_article))
                        <a class="anotherArticle"
                           href="@if(!empty($next_article->slug))
                            {{ route('blog.view', ['article_slug' => $next_article->slug]) }}" title="{{ $next_article->title }}
                            @endif">{{ trans('blog::front.read_more') }} {{ $next_article->title }}</a>
                    @endif
                </div>
                @if (!empty($popular_articles))
                    <div class="lastestNewsList">
                        <span class="heading">{{ trans('index::front.popular_news') }}</span>
                        <ul class="latestNewsList">
                            @foreach($popular_articles as $popular_article)
                                <li>
                                    <a class="article"
                                       href="@if(!empty($popular_article->slug))
                                        {{ route('blog.view', ['article_slug' => $popular_article->slug]) }}@endif" title="{{ $popular_article->title }}">
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

    <div class="commentsContainer">
        <div class="minicontainer">
            <div class="topRow">
                <span class="title">Коментари <span
                            class="comment_count">({{ $comments_count }})</span></span>
                {{--                <button type="button" class="addComment">ДОБАВИ КОМЕНТАР</button>--}}
            </div>
            @if ($article->comments->isNotEmpty())
                <div class="commentsBox">
                    @foreach($article->comments as $comment)
                        <span class="singleComment">
                        @include('blog::front.comment', ['comment' => $comment])
                    </span>
                    @endforeach
                </div>
            @endif
            <div class="formContainer">
                {!! Form::open(['url' => route('blog.store_comment'), 'method' => 'post', 'files'=> false, 'id' => 'post-new-comment']) !!}
                {{--{{ csrf_field() }}--}}
                <span class="title">{{ trans('blog::front.opinion') }}</span>
                <div class="form-group">
                    <textarea name="comment" placeholder="{{ trans('blog::front.opinion') }}" required="required"
                              class="form-control"></textarea>
                </div>
                <div class="formRow d-flex align-items-center justify-content-center">
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <div class="form-group first">
                        <input type="text" name="name" placeholder="{{ trans('blog::front.name') }}" required="required"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="{{ trans('blog::front.email') }}"
                               required="required" class="form-control">
                    </div>
                    @if ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'true' )
                        <div class="form-field col-md-12" style="margin: 0 auto; padding-left: 0px; margin-top:26px; margin-bottom:10px">
                            {!! NoCaptcha::display(['data-theme' => 'dark', 'style' => 'margin: 0 auto;']) !!}
                        </div>
                    @else
                        <div class="form-field col-md-12" style="margin: 0 auto; padding-left: 0px; margin-top:26px;margin-bottom:10px">
                            {!! NoCaptcha::display(['data-theme' => 'light', 'style' => 'margin: 0 auto;', 'required']) !!}
                        </div>
                    @endif
                </div>


                <span class="submitBtn">
						<button type="submit">{{ trans('blog::front.add_comment') }}</button>
					</span>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="moreNewsContainer">
        <div class="minicontainer">
            <span class="topTitle">Още {{$article->categories->first()->title}} новини</span>
        </div>
        <div class="minicontainer">
            <div class="leftBlock">
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
                    <a class="article" href="@if(!empty($random_article->slug)){{ route('blog.view', $random_article->slug) }}@endif" title="{{ $random_article->title }}">
                        <div class="contentLeft">
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
                    <span class="heading" style="margin-top:20px">{{ trans('index::front.popular_news') }}</span>
                    <ul class="latestNewsList">
                        @foreach($popular_articles as $popular_article)
                            <li>
                                <a class="article"
                                   href="@if(empty(!$popular_article->slug)){{ route('blog.view', ['article_slug' => $popular_article->slug]) }}@endif" title="{{ $popular_article->title }}">
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


    <div class="formContainer" style="margin-top: 30px;">
    <div class="container">
{{--            <div class="col-md-12 text-center" style="margin-bottom:10px">--}}
{{--                <div class="coinzilla" data-zone="C-395ce7f5212a47c712"></div>--}}
{{--                <script>--}}
{{--                    window.coinzilla_display = window.coinzilla_display || [];--}}
{{--                    var c_display_preferences = {};--}}
{{--                    c_display_preferences.zone = "395ce7f5212a47c712";--}}
{{--                    c_display_preferences.width = "728";--}}
{{--                    c_display_preferences.height = "90";--}}
{{--                    console.log(coinzilla_display);--}}
{{--                    console.log(c_display_preferences);--}}
{{--                    coinzilla_display.push(c_display_preferences);--}}
{{--                </script>--}}
{{--                <script async src="https://coinzillatag.com/lib/display.js"></script>--}}
{{--            </div>--}}
            <span class="title">{{ trans('index::front.subscribe_to_crypto') }}</span>
            <span class="grayLineS"></span>
            <span class="subtitle">{{ trans('index::front.first_crypto_news') }}</span>
            <div class="indexForm">
                <form>
                    <label for="email">{{ trans('index::front.your_email') }}</label>
                    <span class="inputRow">
						<input id="index_email" type="text" name="footer_email" required="required"
                               placeholder="{{ trans('index::front.email') }}">
                        <input id="index_link" type="hidden" name="index_link" value="{{ route('subscribers.store') }}"
                               required="required">
							<button class="submitBtn" type="button"
                                    onclick="submit_subscriber('index'); return false;"
                                    style="text-transform: uppercase;">
                                {{ trans('index::front.subscribe') }}
                            </button>
					</span>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="post-comment-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-head">
                    <h5 class="modal-title">Изкажете мнение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="fas fas-times"></span>
                    </button>
                </div>
                {!! Form::open(['url' => route('blog.store_comment'), 'method' => 'post', 'files'=> true, 'id' => 'post-comment-form']) !!}
                <div class="for_hidden">

                </div>
                <div class="modal-body">
                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Добави коментар', 'required' => 'required']) !!}
                    <div class="formRow">
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <input type="text" class="form-control" name="name" required="required"
                               placeholder="{{ trans('blog::front.name') }}">
                        <input type="text" class="form-control" name="email" required="required"
                               placeholder="{{ trans('blog::front.email') }}">
                    </div>
                        <div class="form-field col-md-12" style="margin: 0 auto; padding-left: 0px; margin-top:26px; margin-bottom:20px">
                            {!! NoCaptcha::display(['data-theme' => 'light', 'style' => 'margin: 0 auto;', 'required']) !!}
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-confirm">Добави коментар</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Отказ</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>window.twttr = (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                t = window.twttr || {};
            if (d.getElementById(id)) return t;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);

            t._e = [];
            t.ready = function (f) {
                t._e.push(f);
            };

            return t;
        }(document, "script", "twitter-wjs"));</script>
@endsection
@section('js')
    <script>
        // split('#')[0] : Remove hash params from URL
        const url = encodeURIComponent(window.location.href.split('#')[0]);
        //facebook_shares
        let shares_box = $(".facebook_shares");

        $.ajax({
            url: '//graph.facebook.com/?id=' + url + '&fields=engagement&access_token=446589842758725|3F_l5uYzRnovu7_k4ciOyguujFA',
            dataType: 'jsonp',
            timeout: 5000,
            success: function (obj) {
                let count = 0;

                if (typeof obj.engagement.share_count !== 'undefined') {
                    count = obj.engagement.share_count;
                }
                shares_box.html(count);
            },
            error: function () {
                // do something
            }
        });
    </script>
@endsection
