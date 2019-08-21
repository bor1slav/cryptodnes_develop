<!doctype html>
<html lang="{{ app()->getLocale('bg') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if(!empty($title)) {{ $title }} @endif</title>
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/add.css') }}">
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/style-dark.css') }}"
          id="style-dark"
          @if(!\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme) disabled @endif>
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/default-dark.css') }}"
          id="default-dark"
          @if(!\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme) disabled @endif>
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/style-light.css') }}"
          id="style-light"
          @if(\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme) disabled @endif>
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/default-light.css') }}"
          id="default-light"
          @if(\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme) disabled @endif>
    <script src="{{ asset(config('administration.file_prefix') . 'js/chart.js') }}"></script>

    <script>
        let defaultLight = document.getElementById('default-light');
        let styleLight = document.getElementById('style-light');
        let defaultDark = document.getElementById('default-dark');
        let styleDark = document.getElementById('style-dark');

        @if(\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme)

        defaultLight.disabled = true;
        styleLight.disabled = true;
        defaultDark.disabled = false;
        styleDark.disabled = false;

        @endif

        @if(!\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme)

        defaultLight.disabled = false;
        styleLight.disabled = false;
        defaultDark.disabled = true;
        styleDark.disabled = true;

        @endif
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset(config('administration.file_prefix') . 'js/html5shiv.js') }}"></script>
    <script src="{{ asset(config('administration.file_prefix') . 'js/respond.min.js') }}"></script>

    <![endif]-->
</head>
<body class="fix-header fix-sidebar">
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
    <!-- Top Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg" data-toggle="collapse"
               data-target=".navbar-collapse">
                <i class="ti-menu"></i>
            </a>
            <div class="top-left-part">
                <a class="logo" href="{{ \Charlotte\Administration\Helpers\Administration::route('index') }}">
                    <i class="ti-panel text-muted"></i>
                    <span class="hidden-xs">
                        @if(config('app.name') == '')
                            {{ trans('administration::admin.admin_panel') }}
                        @else
                            {{ config('app.name') }}
                        @endif
                    </span>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li>
                    <a class="open-close hidden-xs">
                        <i class="icon-arrow-left-circle ti-menu"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right m-r-15">
            {{--<li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
            {{--<i class="icon-bell"></i>--}}
            {{--<div class="notify">--}}
            {{--<span class="heartbit"></span>--}}
            {{--<span class="point"></span>--}}
            {{--</div>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu dropdown-tasks m-t-30">--}}
            {{--<li>--}}
            {{--<a href="#">--}}
            {{--<div>--}}
            {{--<p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>--}}
            {{--<div class="progress progress-striped active">--}}
            {{--<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</a>--}}
            {{--</li>--}}
            {{--<li class="divider"></li>--}}
            {{--<li>--}}
            {{--<a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--<!-- /.dropdown-tasks -->--}}
            {{--</li>--}}
            <!-- /.dropdown -->
                <li>
                    <a href="{{ url('/') }}" target="_blank">
                        <span class="hidden-xs p-r-20" style="font-weight: 500">
                            {{ trans('administration::admin.go_to_website') }}</span>
                        <i class="fa fa-external-link" style="font-size: 17px; transform: translateY(2px);"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <img src="{{ asset(config('administration.file_prefix') . 'images/user.png') }}" alt="user-img"
                             width="36" class="img-circle">
                        <b class="hidden-xs">{{ \Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->name }}</b>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="{{ \Charlotte\Administration\Helpers\Administration::route('admins.edit', \Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->id) }}" class="p-10">
                                <i class="ti-settings m-r-10"></i>
                                {{ trans('administration::admin.edit_profile') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ \Charlotte\Administration\Helpers\Administration::route('logout') }}"
                               class="p-10">
                                <i class="fa fa-power-off m-r-10"></i>
                                {{ trans('administration::admin.logout') }}
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <li class="right-side-toggle"><a><i class="ti-settings"></i></a></li>
                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>

    <!-- End Top Navigation -->
    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse slimscrollsidebar" style="overflow-y: auto; overflow-x: hidden">
            <ul class="nav" id="side-menu">
                <li class="hidden-sm hidden-md hidden-lg" style="width: 100vw;"></li>
                @include('administration::boxes.nav_links', ['items' => $menu->roots()])
            </ul>
        </div>
    </div>
    <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title" style="font-weight: 300;">@if(!empty($title)) {{ $title }} @endif</h4></div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    @if (Breadcrumbs::exists('administration'))
                        {{ Breadcrumbs::render('administration') }}
                    @endif
                </div>
                <!-- /.col-lg-12 -->
            </div>

        @yield('content')

        <!-- .right-sidebar -->
            <div class="right-sidebar">
                <div class="slimscrollright">
                    <div class="rpanel-title">
                        {{ trans('administration::admin.right_panel') }}
                        <span class="m-t-5">
                            <i class="ti-close right-side-toggle"></i>
                        </span>
                    </div>
                    <div class="r-panel-body">
                        <ul>
                            <li>
                                <h5 class="m-b-20 font-normal text-muted">
                                    {{ trans('administration::admin.curr_lang') }} :
                                    <span class="flag-icon flag-icon-{{ App::getLocale() }}"></span>
                                    <span style="text-transform: uppercase;">
                                        {{ App::getLocale() }}
                                    </span>
                                </h5>
                                <div class="dropdown lang-switch m-b-10">
                                    <button data-toggle="dropdown"
                                            role="button"
                                            aria-expanded="false"
                                            style="text-align: left">
                                        {{ trans('administration::admin.lang') }}
                                        <span class="caret pull-right vertical-middle"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-lang">
                                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $locale => $data)
                                            @if (in_array($locale, config('administration.admin_supported_locales')))
                                                <li>
                                                    <a href="{{ LaravelLocalization::getLocalizedURL($locale) }}">
                                                        <span class="flag-icon flag-icon-{{ $locale }}"></span>
                                                        {{ trans('administration::admin.'.$locale) }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                            </li>
                            <li>
                                <h5 class="m-b-20 font-normal text-muted">{{ trans('administration::admin.change_theme') }}</h5>
                                <div class="row p-b-10">
                                    <div class="col-xs-3 text-center p-t-10">
                                        {{ trans('administration::admin.light') }}
                                    </div>
                                    <div class="col-xs-6 text-left">
                                        <center>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="onoffswitch"
                                                       @if (\Charlotte\Administration\Helpers\Administration::getLoggedAdmin()->dark_theme) checked
                                                       @endif class="onoffswitch-checkbox" id="myonoffswitch"
                                                       data-url="{{ \Charlotte\Administration\Helpers\Administration::route('change_color') }}">
                                                <label id="onoffswitch1" class="onoffswitch-label" for="myonoffswitch">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </center>
                                    </div>
                                    <div class="col-xs-3 text-center p-t-10">
                                        {{ trans('administration::admin.dark') }}
                                    </div>
                                </div>
                            </li>
                            <li class="text-center">
                                <h1 id="curr-time"></h1>
                            </li>
                            <li class="text-center">
                                <div id="datepicker-inline"></div>
                            </li>
                            {{--<li>--}}
                            {{--<a href="#" class="p-t-10 p-b-10 text-muted schedule">--}}
                            {{--<i class="ti-calendar m-l-10 m-r-10"></i>--}}
                            {{--{{ trans('administration::admin.schedule') }}--}}
                            {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.right-sidebar -->
        </div>
        <!-- /.container-fluid -->
        <footer class="footer">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9">
                    <span>{{  date("Y") }} &copy; <a href="https://github.com/gogbog/administration"
                                                     style="color:#f75b36;">Charlotte Administration</a></span>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-right">
                    <span>{{ config('administration.package_version') }}</span>
                </div>
            </div>
        </footer>
    </div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<script src="{{ asset(config('administration.file_prefix') . 'js/jquery.min.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/jquery-ui.min.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/app.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/editor.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/data-table.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/drop.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/charlotte.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/datatable_reorder.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/summernote-image-attributes.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/summernote-cleaner.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/summernote-html.js') }}"></script>

@if (!empty($errors))
    <script>
        @foreach ($errors->all() as $error)
        $.toast({
            heading: '{{ trans('administration::admin.error') }}',
            text: '{{ $error }}',
            position: 'top-right',
            loaderBg: 'rgba(255,255,255,0.5)',
            icon: 'error',
            hideAfter: 5000,
            stack: 6
        });
        @endforeach
    </script>
@endif
@if (Session::has('success'))
    <script>
        @foreach (Session::get('success') as $success)
        $.toast({
            heading: '{{ trans('administration::admin.success') }}',
            text: '{{ $success }}',
            position: 'top-right',
            loaderBg: 'rgba(255,255,255,0.5)',
            icon: 'success',
            hideAfter: 5000,
            stack: 2
        });
        @endforeach
    </script>
@endif
@yield('js')
</body>
</html>