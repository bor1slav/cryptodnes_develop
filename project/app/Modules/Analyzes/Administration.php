<?php

namespace App\Modules\Analyzes;

use App\Modules\Analyzes\Http\Controllers\Admin\AnalyzesCategoriesController;
use App\Modules\Analyzes\Http\Controllers\Admin\AnalyzesController;
use App\Modules\Analyzes\Models\Analyze;
use App\Modules\Blog\Models\Blog;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure {

    public function dashboard() {
        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('analyzes::admin.module_name'), Analyze::count(), \Charlotte\Administration\Helpers\Administration::route('analyzes.index'), 'ti-bar-chart', 'text-success');


        return $dashboard->generate();
    }

    public function routes() {
        Route::resource('analyzes', AnalyzesController::class);
        Route::resource('analyzes_categories', AnalyzesCategoriesController::class);
    }

    public function menu($menu) {
        $menu->add(trans('analyzes::admin.module_name'), ['icon' => 'ti-bar-chart'])->nickname('analyzes_module');

        $menu->get('analyzes_module')->add(trans('analyzes::admin.categories'))->nickname('analyzes_categories');
        $menu->get('analyzes_categories')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('analyzes_categories.create')]);
        $menu->get('analyzes_categories')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('analyzes_categories.index')]);

        $menu->get('analyzes_module')->add(trans('analyzes::admin.articles'))->nickname('articles');
        $menu->get('articles')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('analyzes.create')]);
        $menu->get('articles')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('analyzes.index')]);



    }

    public function settings($module, $form, $form_model) {
        $form->add($module . '_title', 'text', [
            'title' => trans('analyzes::admin.title'),
            'translate' => true,
            'model' => $form_model
        ]);

        $form->add($module . '_meta_description', 'text', [
            'title' => trans('index::admin.meta_description'),
            'translate' => true,
            'model' => $form_model

        ]);

        $form->add($module . '_meta_keywords', 'text', [
            'title' => trans('index::admin.meta_keywords'),
            'translate' => true,
            'model' => $form_model

        ]);
    }
}