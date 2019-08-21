<?php

namespace Charlotte\Administration\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class Administration {

    public static function getMiddlewares($additional_middlewares = []) {
        $middlewares = [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
//             \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
//            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
        ];

        return array_merge($middlewares, $additional_middlewares);
    }

    public static function getLoggedAdmin() {
        return Auth::guard(config('administration.guard'))->user();
    }

    public static function route($route, $parameters = []) {
        return route(config('administration.admin_prefix') . '.' . $route, $parameters);
    }

    public static function admin() {
        return Auth::guard(config('administration.guard'))->user();
    }

    public static function setTitle($title) {
        View::share('title', $title);
    }




}
