<?php

namespace App\Http\Controllers;

use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Coins\Models\Coin;
use App\Modules\Pages\Models\Page;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private static $CACHE_SECONDS = 86400;

    public function __construct()
    {
//        $menu_coins = Cache::remember('menu_coins', self::$CACHE_SECONDS, function () {
//            return Coin::active()->inMenu()->limit(10)->get();
//        });

        $blog_categories_in_menu = BlogCategory::active()->whereHas('articles')->orWhereHas('children')->reversed()->inMenu()->limit(10)->get();
        View::share('blog_categories_in_menu', $blog_categories_in_menu);


        $coins_cache = Coin::active()->with(['media'])->orderBy(DB::raw('ISNULL(market_cap), market_cap'), 'DESC')->limit(6)->get();

        View::share('menu_coins', $coins_cache);

        $coins_cache = Coin::active()->with(['media'])->orderBy(DB::raw('ISNULL(market_cap), market_cap'), 'DESC')->limit(5)->get();


        View::share('coins_cache', $coins_cache);

        $parent_categories = BlogCategory::active()->limit(10)->whereHas('articles')->reversed()->get();

        View::share('parent_categories', $parent_categories);


        $top_tags = BlogTag::active()->inIndex()->whereHas('tags')->get();

        View::share('tags_cache', $top_tags);

        $pages_cache = Page::active()->get();

        View::share('pages_cache', $pages_cache);


        if (empty(session()->get('viewed_blog_articles'))) {
            session()->put('viewed_blog_articles', []);
        }

        if (empty(session()->get('viewed_analyzes_articles'))) {
            session()->put('viewed_analyzes_articles', []);
        }


    }
}
