<?php

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Http\Requests\StoreFrontBlogCommentRequest;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogComment;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class BlogController extends Controller
{


    public function index($category_slug)
    {
        $category = BlogCategory::whereTranslation('slug', $category_slug)
            ->with([
                'descendants' => function ($sub_q) {
                    $sub_q->whereHas('articles')->active();
                },
                'ancestors'
            ])->first();


        $parent = false;

//        if ($category->ancestors->isEmpty()) {
//            $parent = true;
//        }

        if (empty($category)) {
            abort(404);
        }

        $popular_articles = Blog::active()->orderByDesc('views_count')->with(['media', 'categories'])->limit(5)->where('created_at', '>=', Carbon::now()->subDay(3))->get();

        if ($category->slug == 'novini') {
            $popular_articles = Blog::active()->whereHas('coin', function ($query) {
                $query->where('symbol', 'btc');
            })->reversed()->limit(5)->get();

        }

        $active_category = $category;
        if ($category->descendants->isNotEmpty()) {
            $active_category = $category->descendants->first();
        }

        if ($category->ancestors->isNotEmpty()) {
            $category = BlogCategory::where('id', $category->ancestors->first()->id)->with([
                'descendants' => function ($sub_q) {
                    $sub_q->whereHas('articles')->active();
                }
            ])->first();
        }

        $articles = Blog::active()->reversed()->with(['media'])->whereHas('categories', function ($query) use ($active_category) {
            $query->where('blog_categories_relations.category_id', $active_category->id);
        })->paginate(5);

        $meta_title = $active_category->title . ' Новини';
        SEOTools::setTitle($meta_title);
        SEOMeta::setDescription($active_category->meta_description);
        SEOMeta::addKeyword($active_category->meta_keywords);
        OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);


        if (Request::has('page')) {
            SEOMeta::setCanonical(route('blog.index', $category->slug));
        }


        return view('blog::front.index', compact('category', 'active_category', 'popular_articles', 'articles', 'parent'));
    }


    public function view($article_slug)
    {
        $article = Blog::whereTranslation('slug', $article_slug)
            ->with([
                'categories',
                'comments' => function ($q) {
                    $q->active()->where('parent_id', null);
                },
                'comments.children',
                'next',
                'tags'
            ])->first();

        if (empty($article)) {
            abort(404);
        }
        $viewed_articles = session()->get('viewed_blog_articles');
        if (!in_array($article->id, $viewed_articles)) {
            $article->views_count++;
            $article->save();
            $viewed_articles[] = $article->id;
            session()->put('viewed_blog_articles', $viewed_articles);
        }

        $popular_articles = Blog::active()->orderByDesc('views_count')->where('id', '!=', $article->id)->with(['media', 'categories'])->limit(5)->where('created_at', '>=', Carbon::now()->subDay(3))->get();

        $popular_articles_tags = null;
        if ($article->tags->isNotEmpty()) {
            $popular_articles_tags = Blog::active()->whereHas('tags', function ($tag_q) use ($article) {
                $tag_q->whereIn('tag_id', $article->tags->pluck('id'));
            })->orderByDesc('views_count')->where('id', '!=', $article->id)->limit(10)->get();
        }

        $category_for_random = $article->categories->first();
        if (empty($category_for_random)) {
            $category_for_random = BlogCategory::first();
        }
        $random_articles = Blog::active()->where('id', '!=', $article->id)->whereHas('categories', function ($cat_q) use ($category_for_random) {
            $cat_q->where('blog_categories_relations.category_id', $category_for_random->id);
        })->with('categories')->orderBy('id','DESC')->limit(4)->get();

        //if next() relation is not empty that's the next article
        //if the article has hot tags then take from them
        //if not take from the category
        $next_article = null;

        if (!empty($article->next)) {
            $next_article = $article->next;
        } else {
            if ($article->tags->isNotEmpty()) {
                $next_article = Blog::active()->with('categories')->whereHas('tags', function ($tag_q) use ($article) {
                    $tag_q->whereIn('blog_joined_tags.tag_id', $article->tags->pluck('id'));
                })->where('id', '!=', $article->id)->reversed()->first();
            } else {
                $next_article = Blog::with('categories')
                    ->whereHas('categories', function ($cat_q) use ($article) {
                        $cat_q->where('blog_categories_relations.category_id', $article->category_id);
                    })->active()->where('id', '!=', $article->id)->reversed()->first();
            }
        }

        $comments_count = BlogComment::where('article_id', $article->id)->count();

        SEOTools::setTitle($article->title);
        SEOTools::setDescription($article->meta_description);
        SEOMeta::addKeyword($article->meta_keywords);
        if (!empty($article->getFirstMedia())) {
            OpenGraph::addImage($article->getFirstMedia()->getFullUrl('big'), ['height' => 800, 'width' => 500]);

        }
        OpenGraph::setUrl(route('blog.view', ['article_slug' => $article->slug]));

        return view('blog::front.view', compact('article', 'popular_articles', 'random_articles', 'next_article', 'popular_articles_tags', 'comments_count'));
    }

    public function storeComment(StoreFrontBlogCommentRequest $request)
    {
        $article = Blog::where('id', $request->validated()['article_id'])->first();

        if (empty($article)) {
            return redirect()->back()->withErrors([trans('blog::front.failed_comment')]);
        }

        $comment = new BlogComment();
        $comment->fill($request->validated());
        $comment->save();


        return redirect()->route('blog.view', ['slug' => $article->slug, 'comment_id' => $comment->id])->withSuccess([trans('blog::front.success_comment')]);
    }

//    public function changeArticlesData(Request $request) {
//        $data = $request->all();
//        $articles = Blog::whereHas('category', function ($category_query) use ($data) {
//            $category_query->whereTranslation('slug', $data['category']);
//        })->paginate(self::$PER_PAGE);
//
//
//
//        $active_category = BlogCategory::whereTranslation('slug', $request['category'])->first();
//
//        $response = view('blog::boxes.articles_box', compact('articles', 'active_category'))->render();
//
//        return response()->json(['errors' => [],'data' => $response, 'page' => $request['page']]);
//    }
}
