<?php

namespace App\Modules\Blog;

use App\Modules\Blog\Http\Controllers\Admin\BlogCategoryController;
use App\Modules\Blog\Http\Controllers\Admin\BlogCommentsController;
use App\Modules\Blog\Http\Controllers\Admin\BlogController;
use App\Modules\Blog\Http\Controllers\Admin\BlogTagsController;
use App\Modules\Blog\Models\Blog;
use App\Modules\Coins\Models\Coin;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard() {
        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('blog::admin.module_name'), Blog::count(), \Charlotte\Administration\Helpers\Administration::route('blog.index'), 'ti-comments', 'text-info');


        return $dashboard->generate();
    }

    public function routes() {
        Route::resource('blog_categories', BlogCategoryController::class);
        Route::resource('blog_tags', BlogTagsController::class);
        Route::resource('blog', BlogController::class);
        Route::resource('blog_comments', BlogCommentsController::class);
    }

    public function menu($menu) {
        $menu->add(trans('blog::admin.module_name'), ['icon' => 'ti-comments'])->nickname('blog_module');

        $menu->get('blog_module')->add(trans('blog::admin.categories'))->nickname('categories');
        $menu->get('categories')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog_categories.create')]);
        $menu->get('categories')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog_categories.index')]);

        $menu->get('blog_module')->add(trans('blog::admin.articles'))->nickname('blog');
        $menu->get('blog')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog.create')]);
        $menu->get('blog')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog.index')]);

        $menu->get('blog_module')->add(trans('blog::admin.tags'))->nickname('tags');
        $menu->get('tags')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog_tags.create')]);
        $menu->get('tags')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog_tags.index')]);

        $menu->get('blog_module')->add(trans('blog::admin.comments'), ['url' => \Charlotte\Administration\Helpers\Administration::route('blog_comments.index')]);

    }

    public function settings($module, $form, $form_model) {
        $form->add($module . '_title', 'text', [
            'title' => trans('blog::admin.title'),
            'translate' => true,
            'model' => $form_model
        ]);
    }
}