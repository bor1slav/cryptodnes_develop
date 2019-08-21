<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">--}}
    <title>Admin panel</title>
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/add.css') }}">
    <link rel="stylesheet" href="{{ asset(config('administration.file_prefix') . 'css/style-light.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset(config('administration.file_prefix') . 'js/html5shiv.js') }}"></script>
    <script src="{{ asset(config('administration.file_prefix') . 'js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
    <div class="login-box">
        <div class="white-box" style="margin-bottom: 0;">
            <form class="form-horizontal form-material" id="loginform" method="post"
                  action="{{ route('administration.login') }}">
                {{ csrf_field() }}
                <h3 class="box-title m-b-20 text-center">{{ trans('administration::admin.admin_panel') }}</h3>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control p-l-10 p-r-10" name="email" type="email" required=""
                               placeholder="{{ trans('administration::admin.email') }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control p-l-10 p-r-10" name="password" type="password" required=""
                               placeholder="{{ trans('administration::admin.password') }}">
                    </div>
                </div>
                <div class="form-group text-center m-t-20 m-b-5">
                    <div class="col-xs-12">
                        <button class="btn log-btn btn-lg btn-block text-uppercase"
                                type="submit">{{ trans('administration::admin.login') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="{{ asset(config('administration.file_prefix') . 'js/jquery.min.js') }}"></script>
<script src="{{ asset(config('administration.file_prefix') . 'js/app.js') }}"></script>
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
</body>
</html>