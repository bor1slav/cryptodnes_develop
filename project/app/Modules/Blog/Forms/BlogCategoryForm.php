<?php

namespace App\Modules\Blog\Forms;

use App\Modules\Blog\Models\BlogCategory;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class BlogCategoryForm extends AdminForm
{

    public function buildForm()
    {

        $this->add('title', 'text', [
            'title' => trans('blog::admin.title'),
            'translate' => true,
            'clone' => ['slug', 'meta_title'],
            'attr' => [
                'required' => 'required'
            ]
        ]);

        $this->add('description', 'textarea', [
            'title' => 'Кратко описание',
            'translate' => true,
            'simple' => true
        ]);


//       $this->add('description', 'editor', [
//           'title' => trans('blog::admin.description'),
//           'translate' => true,
//           'model' => @$this->model
//       ]);


        AdministrationSeo::seoFields($this, [
            'slug' => ['required' => 'required'],
            'meta_description' => ['live-count' => 255, 'maxlength' => '255']
        ]);

        $categories = BlogCategory::withTrashed()->where('parent_id', null)->get()->pluck('title', 'id')->toArray();

        if (!empty($this->model)) {
            unset($categories[$this->model->id]);
        }

        $this->add('parent_id', 'select', [
            'title' => trans('blog::admin.parent_id'),
            'choices' => $categories,
            'empty_value' => trans('blog::admin.empty_value'),
            'value' => @$this->model->parent_id
        ]);

        $this->add('visible', 'switch', [
            'title' => trans('blog::admin.visible'),
            'default_value' => 1
        ]);

        $this->add('in_menu', 'switch', [
            'title' => trans('blog::admin.in_menu')
        ]);

        $this->add('in_index', 'switch', [
            'title' => trans('blog::admin.in_index')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
