<?php

namespace App\Modules\Pages\Http\Controllers;

use App\Modules\Pages\Models\Page;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Charlotte\Administration\Helpers\Settings;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function view($slug) {
        $page = Page::active()->whereTranslation('slug', $slug)->with('types')->first();

        if (empty($page)) {
            abort(404);
        }

        SEOTools::setTitle($page->title);
        SEOTools::setDescription($page->meta_description);
        SEOMeta::addKeyword($page->meta_keywords);
        OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);

        return view('pages::front.view', compact('page'));
    }
}
