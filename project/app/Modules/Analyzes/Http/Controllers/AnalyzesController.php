<?php

namespace App\Modules\Analyzes\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Analyzes\Http\Requests\StoreFrontAnalyzeComment;
use App\Modules\Analyzes\Models\Analyze;
use App\Modules\Analyzes\Models\AnalyzeCategory;
use App\Modules\Analyzes\Models\AnalyzeComment;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Charlotte\Administration\Helpers\Settings;
use Illuminate\Support\Facades\Request;

class AnalyzesController extends Controller
{


    public function index($slug = null)
    {
        $categories = AnalyzeCategory::active()->reversed()->get();

        if (!empty($slug))
            $category = AnalyzeCategory::active()->with(['articles' => function ($articles_q) {
                $articles_q->with(['media'])->paginate(5);
            }])->whereTranslation('slug', $slug)->first();
        else {
            $category = $categories->first();
        }


        $active_category = $category;

        $articles = Analyze::active()->reversed()->with(['media', 'category'])->distinct();

        if (!empty($active_category)) {
            $articles = $articles->whereHas('category', function ($query) use ($active_category) {
                $query->whereTranslation('slug', $active_category->slug);
            });
        }

        $articles = $articles->paginate(5);


        $meta_title = (!empty($active_category)) ? $active_category->title : Settings::get('analyzes_title');
        $meta_desc = (!empty($active_category)) ? $active_category->meta_description : Settings::get('analyzes_meta_description');
        $meta_keywords = (!empty($active_category)) ? $active_category->meta_keywords : Settings::get('analyzes_meta_keywords');

        SEOTools::setTitle($meta_title);
        SEOMeta::setDescription($meta_desc);
        SEOMeta::addKeyword($meta_keywords);
        OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);


        if (Request::has('page')) {
            if (!empty($category)) {
                SEOMeta::setCanonical(route('analyzes.index', $category->slug));
            } else {
                SEOMeta::setCanonical(route('analyzes.index'));

            }
        }

        return view('analyzes::front.all', compact('categories', 'category', 'articles', 'active_category'));
    }

    public function view($category_slug, $article_slug)
    {
        $article = Analyze::whereTranslation('slug', $article_slug)
            ->with([
                'category',
                'comments' => function ($q) {
                    $q->active()->where('parent_id', null);
                },
                'comments.children',
            ])->first();


        if (empty($article)) {
            abort(404);
        }

        $viewed_articles = session()->get('viewed_analyzes_articles');
        if (!in_array($article->id, $viewed_articles)) {
            $article->views_count++;
            $article->save();
            $viewed_articles[] = $article->id;
            session()->put('viewed_analyzes_articles', $viewed_articles);
        }

        $popular_articles = Analyze::active()->orderByDesc('views_count')->where('id', '!=', $article->id)->limit(5)->where('created_at', '>=', Carbon::now()->subDay(3))->get();


        $random_articles = Analyze::active()->where('id', '!=', $article->id)->whereHas('category', function ($cat_q) use ($article) {
            $cat_q->where('id', $article->category_id);
        })->with('category')->inRandomOrder()->limit(4)->get();

        $comments_count = AnalyzeComment::where('article_id', $article->id)->count();


        SEOTools::setTitle($article->title);
        SEOTools::setDescription($article->meta_description);
        SEOMeta::addKeyword($article->meta_keywords);
        if (!empty($article->getFirstMedia())) {
//            SEOTools::addImages($article->getFirstMedia()->getFullUrl('big'));
            OpenGraph::addImage($article->getFirstMedia()->getFullUrl('big'), ['height' => 800, 'width' => 500]);
        }
        OpenGraph::setUrl(route('analyzes.view', ['category_slug' => $article->category->slug, 'article_slug' => $article->slug]));

        return view('analyzes::front.view', compact('article', 'random_articles', 'popular_articles', 'comments_count'));
    }

    public function storeComment(StoreFrontAnalyzeComment $request)
    {
        $article = Analyze::where('id', $request->validated()['article_id'])->with(['category'])->first();

        if (empty($article)) {
            return redirect()->back()->withErrors([trans('blog::front.failed_comment')]);
        }

        $comment = new AnalyzeComment();
        $comment->fill($request->validated());
        $comment->save();

        return redirect()->route('analyzes.view', ['category_slug' => $article->category->slug, 'slug' => $article->slug, 'comment_id' => $comment->id])->withSuccess([trans('blog::front.success_comment')]);
    }

//    public function changeArticlesData(Request $request)
//    {
//        $data = $request->all();
//        $articles = Analyze::whereHas('category', function ($category_query) use ($data) {
//            $category_query->whereTranslation('slug', $data['category']);
//        })->paginate(self::$PER_PAGE);
//
//
//        $category = AnalyzeCategory::whereTranslation('slug', $request['category'])->first();
//
//        $response = view('analyzes::boxes.analyzes_box', compact('articles', 'category'))->render();
//
//        return response()->json(['errors' => [], 'data' => $response, 'page' => $request['page']]);
//    }
}
