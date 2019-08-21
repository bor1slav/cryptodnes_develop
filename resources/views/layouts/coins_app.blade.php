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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="{{ asset('css/all.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dark-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('css/dark-style.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fixedHeader.dataTables.css') }}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113949242-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-113949242-3');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2031429497127021');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=2031429497127021&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
</head>
@php
    $isDarkTheme = false;
    if ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'true' ) {
        $isDarkTheme = true;
    } else if ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'false' ) {
        $isDarkTheme = false;
    } else if ( empty($_COOKIE['darkTheme']) ) {
        $isDarkTheme = false;
        Cookie::make('darkTheme', $isDarkTheme);
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
                                    <a href="{{ route('tags.index', ['id' => $tag_cach->slug]) }}">{{ $tag_cach->title }}</a>
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
                    <a class="logoMobile" href="{{ route('index') }}"><img src=" {{ asset('images/logoM.svg') }}" alt=""></a>
                    @if (!empty($facebook))
                        <a class="social" href="{{ $facebook }}"
                           target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if (!empty($telegram))
                        <a class="social" href="{{ $telegram }}"
                           target="_blank"><i class="fab fa-telegram-plane"></i></a>
                    @endif
                    @if (!empty($twitter))
                        <a class="social" href="{{ $twitter }}"
                           target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if (!empty($instagram))
                        <a class="social" href="{{ $instagram }}"
                           target="_blank"><i class="fab fa-instagram"></i></a>
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
                        $check = $active_category->slug;
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
                                    <li><a href="{{ route('blog.index', $category->slug) }}">{{ $category->title }}</a></li>
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
                                    <li><a href="{{ route('coins.view', $coin->slug) }}">{{ $coin->title }}</a></li>
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
                            <a class="social" href="{{ $facebook }}"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if (!empty($instagram))
                            <a class="social" href="{{ $instagram }}"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if (!empty($telegram))
                            <a class="social" href="{{ $telegram }}"><i class="fab fa-telegram-plane"></i></a>
                        @endif
                        @if (!empty($twitter))
                            <a class="social" href="{{ $twitter }}"><i class="fab fa-twitter"></i></a>
                        @endif
					</span>
                <span class="terms">© 2018 CryptoDnes</span>
            </div>
        </div>
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
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5cea7c903bcf6145"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('js/dataTables.fixedHeader.js') }}"></script>
</html>
