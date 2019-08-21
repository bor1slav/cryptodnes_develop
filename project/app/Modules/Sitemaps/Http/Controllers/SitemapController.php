<?php

namespace App\Modules\Sitemaps\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Analyzes\Models\Analyze;
use App\Modules\Analyzes\Models\AnalyzeCategory;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Coins\Models\Coin;
use App\Modules\Pages\Models\Page;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Watson\Sitemap\Facades\Sitemap;

class SitemapController extends Controller
{


    public function index()
    {

        Sitemap::addSitemap(route('sitemaps.categories'));
        Sitemap::addSitemap(route('sitemaps.articles'));
        Sitemap::addSitemap(route('sitemaps.analyzes'));
        Sitemap::addSitemap(route('sitemaps.coins'));
        Sitemap::addSitemap(route('sitemaps.site'));

        // Return the sitemap to the client.
        return Sitemap::index();
    }

    public function categories()
    {
        $blog_categories = BlogCategory::active()->with(['translations'])->get();

        /** @var Blog $blog */
        foreach ($blog_categories as $model) {
            $translations = [];

            if (empty(trim($model->slug))) {
                continue;
            }


//            foreach ($model->translations as $locale) {
//
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('blog.view', ['slug' => $locale->slug]))
//                ];
//
//            }

            if (count($translations) == 0) {
                Sitemap::addTag(route('blog.index', $model->slug), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('blog.index', $model->slug), $model->updated_at, 'daily', '0.8', $translations);
            }


        }

        $analyze_cateogires = AnalyzeCategory::active()->with(['translations'])->get();

        /** @var Blog $blog */
        foreach ($analyze_cateogires as $model) {
            $translations = [];

            if (empty(trim($model->slug))) {
                continue;
            }


//            foreach ($model->translations as $locale) {
//
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('blog.view', ['slug' => $locale->slug]))
//                ];
//
//            }

            if (count($translations) == 0) {
                Sitemap::addTag(route('analyzes.index', $model->slug), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('analyzes.index', $model->slug), $model->updated_at, 'daily', '0.8', $translations);
            }


        }

        $tags = BlogTag::active()->with(['translations'])->get();

        /** @var Blog $blog */
        foreach ($tags as $model) {
            $translations = [];

            if (empty(trim($model->slug))) {
                continue;
            }


//            foreach ($model->translations as $locale) {
//
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('blog.view', ['slug' => $locale->slug]))
//                ];
//
//            }

            if (count($translations) == 0) {
                Sitemap::addTag(route('tags.index', $model->slug), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('tags.index', $model->slug), $model->updated_at, 'daily', '0.8', $translations);
            }


        }

        return Sitemap::render();
    }


    public function articles()
    {

        $articles = Blog::active()->with(['translations'])->get();

        /** @var Blog $blog */
        foreach ($articles as $model) {
            $translations = [];

            if (empty(trim($model->slug))) {
                continue;
            }


//            foreach ($model->translations as $locale) {
//
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('blog.view', ['slug' => $locale->slug]))
//                ];
//
//            }

            if (count($translations) == 0) {
                Sitemap::addTag(route('blog.view', $model->slug), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('blog.view', $model->slug), $model->updated_at, 'daily', '0.8', $translations);
            }


        }

        return Sitemap::render();
    }


    public function analyzes()
    {

        $articles = Analyze::active()->with(['category', 'translations'])->get();

        /** @var Analyze $blog */
        foreach ($articles as $model) {
            $translations = [];

            if (empty(trim($model->slug)) || empty($model->category)) {
                continue;
            }


//            foreach ($model->translations as $locale) {
//
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('blog.view', ['slug' => $locale->slug]))
//                ];
//
//            }

            if (count($translations) == 0) {
                Sitemap::addTag(route('analyzes.view', ['category_slug' => $model->category->slug, 'article_slug' => $model->slug]), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('analyzes.view', ['category_slug' => $model->category->slug, 'article_slug' => $model->slug]), $model->updated_at, 'daily', '0.8', $translations);
            }


        }

        return Sitemap::render();
    }


    public function coins()
    {

        $coins = Coin::active()->with(['translations'])->get();

        /** @var Blog $blog */
        foreach ($coins as $model) {
            $translations = [];

            if (empty(trim($model->slug))) {
                continue;
            }


//            foreach ($model->translations as $locale) {
//
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('shop.categories.index', ['slug' => $locale->slug]))
//                ];
//
//            }

            if (count($translations) == 0) {
                Sitemap::addTag(route('coins.view', $model->slug), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('coins.view', $model->slug), $model->updated_at, 'daily', '0.8', $translations);
            }


        }

        return Sitemap::render();
    }

    public function site()
    {


        Sitemap::addTag(route('index'), null, 'weekly');
        Sitemap::addTag(route('contacts.index'), null, 'weekly');


        $models = Page::active()->with(['translations'])->get();


        foreach ($models as $model) {
            $translations = [];


            if (empty(trim($model->slug))) {
                continue;
            }

//            foreach ($model->translations as $locale) {
//
//                if (empty($locale->slug) || !in_array($locale->locale, LaravelLocalization::getSupportedLocales())) {
//                    continue;
//                }
//
//                $translations[] = [
//                    $locale->locale => LaravelLocalization::getLocalizedURL($locale->locale, route('pages.show', ['slug' => $locale->slug]))
//                ];
//
//            }


            if (count($translations) == 0) {
                Sitemap::addTag(route('pages.view', $model->slug), $model->updated_at, 'daily', '0.8');
            } else {
                Sitemap::addTag(route('pages.view', $model->slug), $model->updated_at, 'daily', '0.8', $translations);

            }

        }


        return Sitemap::render();
    }


}
