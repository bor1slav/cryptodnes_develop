<?php

namespace App\Modules\Index\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Analyzes\Models\Analyze;
use App\Modules\Analyzes\Models\AnalyzeCategory;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Coins\Models\Coin;
use App\Modules\Subscribers\Models\Visitor;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Charlotte\Administration\Helpers\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $special_coin = Coin::where('api_key', 'bitcoin')
            ->with([
                'analyze' => function ($q) {
                    $q->whereHas('articles');
                },
                'analyze.articles' => function ($query) {
                    $query->orderBy('created_at', 'DESC');
                },
                'media'
            ])
            ->first();


        $coins = Coin::active()->orderBy(DB::raw('ISNULL(market_cap), market_cap'), 'DESC')->limit(100)->get();

        $most_winning_coin = $coins->sortByDesc('price_change_percentage_24h')->first();
        $most_losing_coin = $coins->sortBy('price_change_percentage_24h')->first();

        $blog_categories = BlogCategory::active()->reversed()
            ->inIndex()
            ->with([
                'articles',
                'articles.media',
                'descendants'
            ])
            ->get();


        foreach ($blog_categories as &$blog_category) {
            $articles = new Collection();
            if ($blog_category->descendants->isNotEmpty()) {
                foreach ($blog_category->descendants as $category_children) {
                    $articles = $articles->merge($category_children->articles);
                }
            } else {
                $articles = $blog_category->articles;
            }

            if ($articles->isEmpty()) {
                $coll_by_id = $blog_categories->keyBy('id');
                $blog_categories = $coll_by_id->forget($blog_category->id);

            }
            $blog_category->last_articles = $articles->take(4);
        }


        $popular_articles = Blog::active()->orderByDesc('views_count')->with(['media', 'categories'])->limit(5)->where('created_at', '>=', Carbon::now()->subDay(3))->get();
        $popular_analyzes = Analyze::active()->with(['category'])->orderByDesc('views_count')->with(['media', 'category'])->limit(5)->where('created_at', '>=', Carbon::now()->subDay(3))->get();
        $articles_in_index = Blog::active()->with('categories')->reversed()->inIndex()->where('main', 0)->limit(3)->get();
        $main_article = Blog::active()->isMain()->with('categories')->first();




        $analyzes_categories = AnalyzeCategory::active()->with(['coin', 'coin.media', 'latestArticle', 'articles'])->reversed()->get();

        foreach ($analyzes_categories as &$analyze_category) {
            $articles = new Collection();
            if ($analyze_category->descendants->isNotEmpty()) {
                foreach ($analyze_category->descendants as $category_children) {
                    $articles = $articles->merge($category_children->articles);
                }
            } else {
                $articles = $analyze_category->articles;
            }

            if ($articles->isEmpty()) {
                $coll_by_id = $blog_categories->keyBy('id');
                $blog_categories = $coll_by_id->forget($analyze_category->id);

            }
            $analyze_category->last_articles = $articles->take(3);
        }

        $visitors = Visitor::where('created_at', '>=', Carbon::now()->subDay())->count()*(config('web.magic_number'));

        $finteh_articles = Blog::active()->whereHas('categories', function ($query) {
            $query->whereHas('translations', function ($trans_q) {
                $trans_q->where('slug', 'finteh');
            });
        })->reversed()->limit(5)->get();

        $last_bitcoin_news = Blog::active()->whereHas('coin', function ($query) {
            $query->where('symbol', 'btc');
        })->reversed()->limit(5)->get();


        SEOTools::setTitle(Settings::getTranslated('index_title'));
        SEOTools::setDescription(Settings::getTranslated('index_meta_description'));
        SEOMeta::addKeyword(Settings::getTranslated('index_meta_keywords'));
        OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);



        if (empty(session('visitor'))) {
            $visitor = new Visitor();
            $visitor->ip = request()->ip();
            $visitor->save();

            session()->put(['visitor' => '1']);
        }


        return view('index::front.index', compact('main_article','visitors', 'special_coin', 'most_winning_coin', 'most_losing_coin', 'blog_categories', 'popular_articles', 'articles_in_index', 'finteh_articles', 'last_bitcoin_news', 'analyzes_categories', 'popular_analyzes'));
    }

    public function search(Request $request)
    {

        $search_word = $request->get('word');

        if (empty($search_word)) {
            return 404;
        }

        $blog_articles = Blog::active()->whereHas('translations', function ($trans_q) use ($search_word){
            $trans_q->where('title', 'LIKE', '%' . $search_word . '%');
        })->with(['categories'])->paginate(5);
        $analyzes_articles = Analyze::active()->whereHas('translations', function ($trans_q) use ($search_word){
            $trans_q->where('title', 'LIKE', '%' . $search_word . '%');
        })->with(['category'])->paginate(5);

        $popular_articles = Blog::active()->orderByDesc('views_count')->with(['media', 'categories'])->limit(5)->where('created_at', '>=', Carbon::now()->subDay(10))->get();


        return view('index::front.search', compact('blog_articles', 'analyzes_articles', 'search_word', 'popular_articles'));
    }
}
