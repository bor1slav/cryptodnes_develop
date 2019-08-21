<?php

namespace App\Modules\Blog\Forms;

use App\Modules\Blog\Models\Blog;
use Kris\LaravelFormBuilder\Form;

class BlogCommentForm extends Form {

    public function buildForm() {

        $this->add('name', 'text', [
            'title' => trans('blog::admin.name'),
        ]);


        $this->add('comment', 'textarea', [
            'title' => trans('blog::admin.comment'),
        ]);


        $this->add('visible', 'switch', [
            'title' => trans('blog::admin.visible')
        ]);

        $articles = Blog::reversed()->get()->pluck('title', 'id')->toArray();

        $this->add('article_id', 'select', [
            'title' => trans('blog::admin.article_id'),
            'choices' => $articles,
            'value' => @$this->model->article_id
        ]);


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}