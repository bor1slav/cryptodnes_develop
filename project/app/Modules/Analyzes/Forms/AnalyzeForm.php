<?php

namespace App\Modules\Analyzes\Forms;

use App\Modules\Analyzes\Models\AnalyzeCategory;
use Carbon\Carbon;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class AnalyzeForm extends AdminForm
{

    public function buildForm()
    {

        $this->add('title', 'text', [
            'title' => trans('analyzes::admin.title'),
            'translate' => true,
            'clone' => ['slug', 'meta_title'],
            'attr' => [
                'required' => 'required'
            ]
        ]);


        $this->add('description', 'editor', [
            'title' => trans('analyzes::admin.description'),
            'translate' => true,
//            'simple' => true
        ]);


        $this->add('mini_description', 'textarea', [
            'title' => trans('blog::admin.mini_description'),
            'translate' => true,
            'simple' => true
        ]);

        AdministrationSeo::seoFields($this, [
            'slug' => ['required' => 'required'],
            'meta_description' => ['live-count' => 255, 'maxlength' => '255']

        ]);


        $this->add('source', 'text', [
            'title' => trans('blog::admin.source'),
        ]);


        $categories = AnalyzeCategory::withTrashed()->get()->pluck('title', 'id')->toArray();

        $this->add('category_id', 'select', [
            'title' => trans('analyzes::admin.category'),
            'choices' => $categories,
            'empty_value' => trans('analyzes::admin.empty_value'),
            'value' => @$this->model->category_id,
            'attr' => [
                'required' => 'required'
            ]
        ]);

//        $articles = Analyze::withTrashed()->get()->pluck('title', 'id')->toArray();
//
//        $this->add('next_article_id', 'select', [
//            'title' => trans('blog::admin.next_article_id'),
//            'choices' => $articles,
//            'value' => @$this->model->next_article_id,
//            'empty_value' => trans('blog::admin.empty_value')
//        ]);


        $filename = null;

        if (!empty($this->model) && !empty($this->model->getFirstMedia())) {
            $filename = $this->model->getFirstMedia()->getFullUrl('big');
        }

        $this->add('file', 'file', [
            'title' => trans('blog::admin.file'),
            'value' => $filename
        ]);

        $this->add('picture_description', 'text', [
            'title' => trans('blog::admin.picture_description'),
            'translate' => true,
        ]);

        $this->add('created_at', 'datetime', [
            'title' => trans('blog::admin.created_at'),
            'value' => (empty($this->model)) ? Carbon::now() : $this->model->created_at
        ]);

        $this->add('visible', 'switch', [
            'title' => trans('analyzes::admin.visible'),
            'class' => 'col-md-1',
            'default_value' => 1
        ]);




//        $this->add('is_popular', 'switch', [
//            'title' => trans('blog::admin.is_popular'),
//            'helper_box' => trans('blog::admin.is_popular_helper'),
//            'class' => 'col-md-2'
//        ]);


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}