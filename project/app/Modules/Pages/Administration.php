<?php

namespace App\Modules\Pages;

use App\Modules\Pages\Http\Controllers\Admin\PagesController;
use App\Modules\Pages\Http\Controllers\Admin\PagesTypesController;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class Administration implements Structure
{

    public function dashboard()
    {
        // TODO: Implement dashboard() method.
    }

    public function routes()
    {
        Route::resource('pages', PagesController::class);
        Route::resource('pages_types', PagesTypesController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('pages::admin.module_name'), ['icon' => 'ti-book'])->nickname('pages_module');

        $menu->get('pages_module')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('pages.create')]);
        $menu->get('pages_module')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('pages.index')]);

        $menu->get('pages_module')->add(trans('pages::admin.types'))->nickname('pages_types');
        $menu->get('pages_types')->add(trans('administration::admin.add'), ['url' => \Charlotte\Administration\Helpers\Administration::route('pages_types.create')]);
        $menu->get('pages_types')->add(trans('administration::admin.view_all'), ['url' => \Charlotte\Administration\Helpers\Administration::route('pages_types.index')]);


    }

    public function settings($module, $form, $form_model)
    {
        $form->add($module . '_title', 'text', [
            'title' => trans('analyzes::admin.title'),
            'translate' => true,
            'model' => $form_model
        ]);
    }
}