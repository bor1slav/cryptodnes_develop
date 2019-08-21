<?php

namespace App\Modules\Pages\Forms;

use App\Modules\Pages\Models\PagesType;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class PageForm extends AdminForm
{

    public function buildForm()
    {

        $this->add('title', 'text', [
            'title' => trans('pages::admin.title'),
            'translate' => true,
            'clone' => ['slug', 'meta_title'],
            'attr' => [
                'required' => 'required'
            ]
        ]);


        $this->add('description', 'editor', [
            'title' => trans('pages::admin.description'),
            'translate' => true,
            'simple' => true
        ]);


        AdministrationSeo::seoFields($this, [
            'slug' => ['required' => 'required'],
            'meta_description' => ['live-count' => 255, 'maxlength' => '255']
        ]);

        $types = PagesType::all()->pluck('title', 'id')->toArray();

        $this->add('type_id', 'select', [
            'title' => trans('pages::admin.type'),
            'choices' => $types,
            'value' => (!empty($this->model) && !empty($this->model->types)) ? @$this->model->types->pluck('id')->toArray() : null
        ]);

        $this->add('visible', 'switch', [
            'title' => trans('pages::admin.visible'),
            'default_value' => 1
        ]);


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}