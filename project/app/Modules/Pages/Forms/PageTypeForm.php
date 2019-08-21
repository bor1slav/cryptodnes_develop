<?php

namespace App\Modules\Pages\Forms;

use App\Modules\Analyzes\Models\AnalyzeCategory;
use App\Modules\Pages\Models\PagesType;
use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class PageTypeForm extends Form
{

    public function buildForm()
    {

        $this->add('title', 'text', [
            'title' => trans('pages::admin.title'),
        ]);


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}