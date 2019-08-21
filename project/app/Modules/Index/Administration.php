<?php

namespace App\Modules\Index;

use Charlotte\Administration\Interfaces\Structure;

class Administration implements Structure {

    public function dashboard() {
        // TODO: Implement dashboard() method.
    }

    public function routes() {
    }

    public function menu($menu) {
        // TODO: Implement menu() method.
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

        $form->add($module . '_banner', 'file', [
            'title' => trans('index::admin.banner'),
            'value' => @$form_model->index_banner,
        ]);
    }
}