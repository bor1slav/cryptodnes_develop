<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {!! SEO::generate() !!}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="{{ asset('css/dark-style.css') }}">--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"--}}
{{--          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"--}}
{{--          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/all.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dark-style.css') }}?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    {{--<link rel="stylesheet" href="{{ asset('css/dark-style.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}"/>
    @include('feed::links')

    <link rel="stylesheet alternate" id="dark-styles" title="Dark" href="{{ asset('css/dark-style.css') }}"
          disabled="true">
    <link rel="stylesheet" type="text/css" id="light-styles" title="Light" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/localization/messages_bg.js"></script>
{!! NoCaptcha::renderJs() !!}
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113949242-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-113949242-3');
    </script>

</head>
@php
    $isDarkTheme = true;
    if ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'true' ) {
        $isDarkTheme = true;
    } else if ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'false' ) {
        $isDarkTheme = false;
    } else if ( empty($_COOKIE['darkTheme']) ) {
        $isDarkTheme = true;
        Cookie::make('darkTheme', true);
    }
@endphp
<body class="{{ $isDarkTheme ? 'dark-mode' : null }}">

<header>
    <nav>
        <div class="container">
            <div class="leftNav">
                <a class="logoHolder" href="{{ route('index') }}" title="Index"><span class="logo"></span></a>
                @if ($tags_cache->isNotEmpty())
                    <div class="topArticles">
                        <span class="title">{{ trans('index::front.hot_topics') }}:</span>
                        <ul class="listArticles">
                            @foreach ($tags_cache as $tag_cach)
                                <li>
                                    <a href="{{ route('tags.index', ['id' => $tag_cach->slug]) }}"
                                       title="{{$tag_cach->title}}">{{ $tag_cach->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            @php
                $facebook = \Charlotte\Administration\Helpers\Settings::get('facebook');
                $instagram = \Charlotte\Administration\Helpers\Settings::get('instagram');
                $telegram = \Charlotte\Administration\Helpers\Settings::get('telegram');
                $twitter = \Charlotte\Administration\Helpers\Settings::get('twitter');
            @endphp
            <div class="rightNav">
                    <span class="searchHolder">
                        <div id="searchFormBtn"></div>
                                        <form class="formHolder" type="submit" action="{{ route('search') }}"
                                              method="get">

                        <span id="searchForm">
                            <input class="submitBtn" type="button" name="">
                            <input class="searchInput" type="text" placeholder="Търси" name="word">
                        </span>
                                                            </form>

                    </span>
                <div class="socialsHolder">
                    <a class="logoMobile" href="{{ route('index') }}"><img src=" {{ asset('images/logoM.svg') }}"
                                                                           alt=""></a>
                    @if (!empty($facebook))
                        <a class="social" href="{{ $facebook }}"
                           target="_blank" rel="nofollow"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if (!empty($telegram))
                        <a class="social" href="{{ $telegram }}"
                           target="_blank" rel="nofollow"><i class="fab fa-telegram-plane"></i></a>
                    @endif
                    @if (!empty($twitter))
                        <a class="social" href="{{ $twitter }}"
                           target="_blank" rel="nofollow"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if (!empty($instagram))
                        <a class="social" href="{{ $instagram }}"
                           target="_blank" rel="nofollow"><i class="fab fa-instagram"></i></a>
                    @endif
                    <a class="contactUsLink" href="{{ route('contacts.index') }}">СВЪРЖИ СЕ С НАС</a>
                </div>
                <div class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                    <label id="onoffswitch1" class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
                <span class="navBtn only-mobile" id="topMenu"><i class="fas fa-bars" aria-hidden="true"></i></span>
            </div>
        </div>
    </nav>
    <div class="menuContainer">
        <div class="container">
            <ul class="menu">
                @php
                    $check = \Request::route()->getName();
                    if ($check == 'blog.index') {
                        $check = \Request::segment(2);
                    }
                    if ($check == 'blog.view') {
                        $check = $article->categories->first()->slug;
                    }
                @endphp
                <li><a href="{{ route('index') }}" @if ($check == 'index') class="active" @endif
                       title="{{ trans('index::front.home') }}">{{ trans('index::front.home') }}</a></li>
                @php
                    $count = 1;
                @endphp
                @foreach ($blog_categories_in_menu as $blog_menu_category)
                    <li>
                        <a href="{{ route('blog.index', ['slug' => $blog_menu_category->slug]) }}" @if ($check == $blog_menu_category->slug) class="active" @endif
                           title="{{ $blog_menu_category->title }} новини">{{ $blog_menu_category->title }}</a>
                    </li>
                    @if($count == $blog_categories_in_menu->count() - 2)
                        <li><a @if ($check == 'analyzes.index' || $check == 'analyzes.view') class="active" @endif href="{{ route('analyzes.index') }}">АНАЛИЗИ</a></li>
                    @endif
                    @php
                        $count++;
                    @endphp
                @endforeach
                {{--                <li><a href="">КРИПТО СВЯТ</a></li>--}}
                {{--                <li><a href="">ФИНТЕК</a></li>--}}
                {{--                <li><a href="">МНЕНИЯ</a></li>--}}
                {{--                <li><a href="">СЪБИТИЯ</a></li>--}}
                <li><span class="yellowDot"></span><a @if ($check == 'coins.index' || $check == 'coins.view') class="active" @endif
                            href="{{ route('coins.index') }}">{{ trans('coins::front.coins_wiki') }}</a></li>
                {{--                <li><span class="yellowDot"></span><a href="">ПЕЧЕЛИ ОТ КРИПТО ИНВЕСТИЦИИ</a></li>--}}
            </ul>
            <span class="dateBox">
					<span class="date">{{ format_current_date_for_index(\Carbon\Carbon::now()) }}</span>
					<span class="only-mobile">
						<div class="onoffswitch2">
							<input type="checkbox" name="onoffswitch2" class="onoffswitch-checkbox2"
                                   id="myonoffswitch2">
							<label id="onoffswitch2" class="onoffswitch-label2" for="myonoffswitch2">
								<span class="onoffswitch-inner2"></span>
								<span class="onoffswitch-switch2"></span>
							</label>
						</div>
					</span>
				</span>
        </div>
    </div>
    <div class="cryptoCourseContainer">
        <div class="container">
            <ul class="cryptoList">
                @foreach ($menu_coins as $coin)
                    <li class="cryptoItem">
                        <a href="{{ route('coins.view', $coin->slug) }}" title="{{ $coin->title }} цена"
                           class="cryptoItemLink">
                            <span class="imgBox"><img src="{{ $coin->getFirstMediaUrl() }}" alt=""></span>
                            <span class="price">${{ beatify_number($coin->current_price) }}</span>
                            @if(!empty($coin->price_change_percentage_24h))
                                <span class="rate @if (get_percentage_difference($coin->current_price, $coin->old_price_24h) > 0) rate-up @else rate-down @endif">
							    <i class="fas @if (get_percentage_difference($coin->current_price, $coin->old_price_24h) > 0) fa-caret-up @else fa-caret-down @endif"></i>
                                {{ format_number(get_percentage_difference($coin->current_price, $coin->old_price_24h)) }}%
						    </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</header>
@yield('content')
<div id="scroll-to"></div>
<footer>
    <div class="container">
        <div class="leftCol">
            <div class="menusContainer">
                <div class="footerMenu">
						<span class="fmobileRow">
							<h4 class="title">Крипто Днес</h4>
							<i class="fas fa-chevron-down"></i>
						</span>
                    <span class="fmenuHolder">
							<span class="grayLineS yellow"></span>
							<ul class="menu">
                                @foreach($parent_categories as $category)
                                    <li><a href="{{ route('blog.index', $category->slug) }}"
                                           title="{{$category->title}} новини">{{ $category->title }}</a></li>
                                @endforeach
                                    @foreach($pages_cache as $page)
                                        <li><a href="{{ route('pages.view', $page->slug) }}">{{ $page->title }}</a></li>
                                    @endforeach
							</ul>
						</span>
                </div>
                <div class="footerMenu">
						<span class="fmobileRow">
							<h4 class="title">{{ trans('index::front.top_5') }}</h4>
							<i class="fas fa-chevron-down"></i>
						</span>
                    <span class="fmenuHolder">
							<span class="grayLineS yellow"></span>
							<ul class="menu">
                                @foreach($coins_cache as $coin)
                                    <li><a href="{{ route('coins.view', $coin->slug) }}"
                                           title="{{$coin->title}} цена">{{ $coin->title }}</a></li>
                                @endforeach
							</ul>
						</span>
                </div>
                {{--                <div class="footerMenu">--}}
                {{--						<span class="fmobileRow">--}}
                {{--							<h4 class="title">{{ trans('index::front.cryptowiki') }}</h4>--}}
                {{--							<i class="fas fa-chevron-down"></i>--}}
                {{--						</span>--}}
                {{--                    <span class="fmenuHolder">--}}
                {{--							<span class="grayLineS yellow"></span>--}}
                {{--							<ul class="menu">--}}
                {{--                                @foreach($pages_cache as $page)--}}
                {{--                                    <li><a href="{{ route('pages.view', $page->slug) }}">{{ $page->title }}</a></li>--}}
                {{--                                @endforeach--}}
                {{--							</ul>--}}
                {{--						</span>--}}
                {{--                </div>--}}
            </div>
        </div>
        <div class="rightCol">
            <div class="footerForm">
                <span class="title">{{ trans('index::front.subscribe_to_newsletter') }}</span>
                <span class="grayLineS"></span>
                <span class="myForm">
						<form>
                            <div class="footer-success-wrapper"></div>
                            <div class="footer-errors-wrapper"></div>
							<label for="email">{{ trans('index::front.your_email') }}</label>
							<span class="inputRow">
								<input id="footer_email" type="text" name="footer_email"
                                       placeholder="{{ trans('index::front.email') }}">
								<input id="footer_link" type="hidden" name="footer_link"
                                       value="{{ route('subscribers.store') }}">
								<button class="submitBtn" type="button"
                                        onclick="submit_subscriber('footer'); return false;"
                                        style="text-transform: uppercase;">{{ trans('index::front.subscribe') }}</button>
							</span>
						</form>
					</span>
            </div>
            <div class="socialsHolder">
					<span class="links">
                        @if (!empty($facebook))
                            <a class="social" href="{{ $facebook }}" rel="nofollow"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if (!empty($instagram))
                            <a class="social" href="{{ $instagram }}" rel="nofollow"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if (!empty($telegram))
                            <a class="social" href="{{ $telegram }}" rel="nofollow"><i class="fab fa-telegram-plane"></i></a>
                        @endif
                        @if (!empty($twitter))
                            <a class="social" href="{{ $twitter }}" rel="nofollow"><i class="fab fa-twitter"></i></a>
                        @endif
					</span>
                <span class="terms">© 2018 CryptoDnes</span>
            </div>
        </div>
    </div>
    <div id="myCookieConsent">
        <a id="cookieButton">Съгласен съм</a>
        <div>Ние събираме и обработваме вашите данни с цел осигуряване на по-доброто ви преживяване на нашия сайт.  За осигуряване на правата ви по GDPR, молим за вашето съгласие.</div>
    </div>
</footer>
<div class="to-top">
    <div class="up">
        <i class="fa fa-caret-up"></i>
    </div>
</div>
</body>
@yield('js')
<script async src="https://coinzillatag.com/lib/display.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('js/dataTables.fixedHeader.js') }}"></script>
</html>
