<?php

namespace App\Modules\Subscribers;


use App\Modules\Subscribers\Http\Controllers\Admin\SubscribersController;
use App\Modules\Subscribers\Models\Subscriber;
use Charlotte\Administration\Helpers\Dashboard;
use Charlotte\Administration\Interfaces\Structure;
use Illuminate\Support\Facades\Route;

class  Administration implements Structure
{

    public function dashboard()
    {
        $dashboard = new Dashboard();

        $dashboard->linkBox(trans('subscribers::admin.module_name'), Subscriber::count(), \Charlotte\Administration\Helpers\Administration::route('subscribers.index'), 'ti-headphone-alt','text-warning');


        return $dashboard->generate();
    }

    public function routes()
    {
        Route::resource('subscribers', SubscribersController::class);
    }

    public function menu($menu)
    {
        $menu->add(trans('subscribers::admin.module_name'), ['url' => \Charlotte\Administration\Helpers\Administration::route('subscribers.index'), 'icon' => 'ti-headphone-alt']);
    }

    public function settings($module, $form, $form_model)
    {
        $form->add($module . '_title', 'text', [
            'title' => trans('subscribers::admin.title'),
            'translate' => true,
            'model' => $form_model
        ]);
    }
}