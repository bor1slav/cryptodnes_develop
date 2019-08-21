<?php

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class TagsController extends Controller {

    private static $PER_PAGE = 5;



    public function index($slug) {
        $tag = BlogTag::active()->whereTranslation('slug', $slug)->first();

        if (empty($tag)) {
            abort(404);
        }

        $articles = Blog::whereHas('tags', function ($tags_q) use ($tag) {
            $tags_q->where('tag_id', $tag->id);
        })->with(['media'])->active()->reversed()->paginate(self::$PER_PAGE);

        SEOTools::setTitle($tag->title);
        SEOMeta::setDescription($tag->meta_description);
        SEOMeta::addKeyword($tag->meta_keywords);
        OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);


        if (\Illuminate\Support\Facades\Request::has('page')) {
            SEOMeta::setCanonical(route('tags.index', $tag->slug));
        }
        return view('blog::front.tags', compact('tag', 'articles'));

    }

//    public function changeArticlesData(Request $request) {
//        $data = $request->all();
//
//        $articles = Blog::whereHas('tags', function ($tags_q) use ($data) {
//            $tags_q->where('tag_id', $data['category']);
//        })->paginate(self::$PER_PAGE);
//
//
//
//        $response = view('blog::boxes.tags_box', compact('articles'))->render();
//
//        return response()->json(['errors' => [],'data' => $response, 'page' => $request['page']]);
//    }
}
