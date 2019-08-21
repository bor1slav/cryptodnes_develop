<?php

namespace App\Modules\Contacts;


use Charlotte\Administration\Interfaces\Structure;

class  Administration implements Structure
{

    public function dashboard()
    {
        // TODO: Implement dashboard() method.
    }

    public function routes()
    {
    }

    public function menu($menu)
    {
    }

    public function settings($module, $form, $form_model)
    {

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

        $form->add($module . '_email', 'text', [
            'title' => trans('contacts::admin.email'),
            'model' => $form_model
        ]);
    }
}