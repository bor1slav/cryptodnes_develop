<?php

namespace App\Modules\Blog\Forms;

use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Coins\Models\Coin;
use Carbon\Carbon;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class BlogForm extends AdminForm
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


        $this->add('description', 'editor', [
            'title' => trans('blog::admin.description'),
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


        $categories_raw = BlogCategory::withTrashed()->where('parent_id', null)->get();
        $categories = [];

        foreach ($categories_raw as $raw_category) {

            if ($raw_category->descendants->isNotEmpty()) {
                $categories[$raw_category->title] = [];

                foreach ($raw_category->descendants as $sub_cat) {
                    $categories[$raw_category->title][$sub_cat->id] = '--- ' . $sub_cat->title;
                }
            } else {
                $categories[$raw_category->id] = $raw_category->title;
            }
        }


        $this->add('categories', 'multiple', [
            'title' => trans('blog::admin.category_id'),
            'choices' => $categories,
            'value' => (!empty($this->model) && !empty($this->model->categories)) ? $this->model->categories->pluck('id')->toArray() : null,
            'attr' => [
                'required' => 'required',
                'minlength' => '312',
            ],
        ]);


//        $articles = Blog::withTrashed()->get()->pluck('title', 'id')->toArray();
//
//        $this->add('next_article_id', 'select', [
//            'title' => trans('blog::admin.next_article_id'),
//            'choices' => $articles,
//            'value' => @$this->model->next_article_id,
//            'empty_value' => trans('blog::admin.empty_value'),
//            'attr' => [
//                'data-live-search' => 'true'
//            ]
//        ]);


        $tags = BlogTag::withTrashed()->get()->pluck('title', 'id')->toArray();

        $this->add('tags', 'multiple', [
            'title' => trans('blog::admin.tags'),
            'choices' => $tags,
            'value' => (!empty($this->model) && !empty($this->model->tags)) ? $this->model->tags->pluck('id')->toArray() : null,
        ]);


        $coins_raw = Coin::withTrashed()->get();
        $coins = array();

        foreach ($coins_raw as $coin) {
            $coins[$coin->id] = $coin->title . ' - (' . $coin->symbol . ')';
        }

        $this->add('coin_id', 'select', [
            'title' => trans('analyzes::admin.coin'),
            'choices' => $coins,
            'empty_value' => trans('analyzes::admin.empty_value'),
            'value' => @$this->model->coin_id,
            'attr' => [
                'data-live-search' => 'true'
            ]
        ]);

        $filename = null;

        if (!empty($this->model) && !empty($this->model->getFirstMedia())) {
            $filename = $this->model->getFirstMedia()->getFullUrl('big');
        }

        $this->add('file', 'file', [
            'title' => trans('blog::admin.file'),
            'value' => $filename,
            'attr' => [
                'required' => 'required'
            ]
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
            'title' => trans('blog::admin.visible'),
            'class' => 'col-md-1',
            'default_value' => 1
        ]);

//        $this->add('is_popular', 'switch', [
//            'title' => trans('blog::admin.is_popular'),
//            'helper_box' => trans('blog::admin.is_popular_helper'),
//            'class' => 'col-md-2'
//        ]);

        $this->add('in_index', 'switch', [
            'title' => trans('blog::admin.in_index'),
            'helper_box' => trans('blog::admin.in_index_helper'),
            'class' => 'col-md-2'
        ]);

        $this->add('main', 'switch', [
            'title' => trans('blog::admin.main'),
            'helper_box' => trans('blog::admin.main_index_helper'),
            'class' => 'col-md-2'
        ]);




        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}