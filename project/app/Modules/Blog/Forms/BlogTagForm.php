<?php

namespace App\Modules\Blog\Forms;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class BlogTagForm extends Form {

    public function buildForm() {

        $this->add('title', 'text', [
            'title' => trans('blog::admin.title'),
            'translate' => true,
            'model' => @$this->model,
            'clone' => ['slug', 'meta_title']
        ]);

        AdministrationSeo::seoFields($this, $this->model);


        $this->add('visible', 'switch', [
            'title' => trans('blog::admin.visible'),
            'default_value' => 1
        ]);


        $this->add('in_index', 'switch', [
            'title' => trans('blog::admin.in_index'),
            'helper_box' => trans('blog::admin.in_index_helper')
        ]);


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}