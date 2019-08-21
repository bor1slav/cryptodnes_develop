<?php

namespace App\Modules\Coins;


use App\Modules\Coins\Http\Controllers\Admin\CoinsController;
use App\Modules\Coins\Models\Coin;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class  Administration implements Structure {

    public function dashboard() {
        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('coins::admin.coins_all'), Coin::count(), \Charlotte\Administration\Helpers\Administration::route('coins.index'), 'ti-server');


        return $dashboard->generate();
    }

    public function routes() {
        Route::resource('coins', CoinsController::class);
    }

    public function menu($menu) {
        $menu->add(trans('coins::admin.coins'), ['url' => \Charlotte\Administration\Helpers\Administration::route('coins.index'), 'icon' => 'ti-server']);
    }

    public function settings($module, $form, $form_model) {

        $form->add($module . '_title', 'text', [
            'title' => trans('index::admin.title'),
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