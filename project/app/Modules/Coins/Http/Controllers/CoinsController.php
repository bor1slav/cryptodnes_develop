<?php

namespace App\Modules\Coins\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Models\Blog;
use App\Modules\Coins\Models\Coin;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Charlotte\Administration\Helpers\Settings;
use Illuminate\Support\Facades\DB;

class CoinsController extends Controller
{
    public function index()
    {

        $coins = Coin::active()->with(['media'])->orderBy(DB::raw('ISNULL(market_cap), market_cap'), 'DESC')->paginate(100);

        SEOTools::setTitle(Settings::getTranslated('coins_title'));
        SEOTools::setDescription(Settings::getTranslated('coins_meta_description'));
        SEOMeta::addKeyword(Settings::getTranslated('coins_meta_keywords'));
        SEOTools::addImages( asset('images/default_seo.jpg') );



        return view('coins::front.index', compact('coins'));
    }

    public function view($slug)
    {
        $coin = Coin::active()->with(['articles'])->whereTranslation('slug', $slug)->first();
        if (!$coin->current_price) {
            $coin->current_price = 1;
        }

        if (empty($coin)) {
            abort(404);
        }

        $meta_title = $coin->title . ' цена в реално време, графика, пазарна капитализация и други';
        $meta_description = 'Вижте цената на ' . $coin->title . ' в реално време, графика и друга информация за криптовалутата.';
        $meta_keywords = 'cryptodnes, криптовалути, ' . $coin->title . ', купи ' . $coin->title . ', продай, ' . $coin->title . ', ' . $coin->title . ' цена, ' . $coin->title . ' уебсайт, ' . $coin->title . ' пазарна капитализация';
        SEOTools::setTitle($meta_title);
        SEOTools::setDescription($meta_description);
        if (!empty($coin->getFirstMedia())) {
            OpenGraph::addImage($coin->getFirstMedia()->getFullUrl(), ['height' => 800, 'width' => 500]);

        } else {
            OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);

        }
        OpenGraph::setUrl(route('coins.view', $coin->slug));
        SEOMeta::setKeywords($meta_keywords);

        $popular_articles = Blog::active()->orderByDesc('views_count')->with(['media', 'categories'])->limit(5)->where('created_at', '>=', Carbon::now()->subDay(3))->get();

        $coin_to_compare = Coin::where('symbol', 'btc')->first();

        $random_articles = $coin->articles->take(5);

        if ($random_articles->isEmpty()) {
            $random_articles = Blog::active()->with('categories')->reversed()->limit(5)->get();
        }


        return view('coins::front.view', compact('coin', 'random_articles', 'popular_articles', 'coin_to_compare'));
    }
}
