<?php

namespace App\Modules\Analyzes\Forms;

use App\Modules\Coins\Models\Coin;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;

class AnalyzeCategoryForm extends AdminForm
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


//        $this->add('description', 'editor', [
//            'title' => trans('analyzes::admin.description'),
//            'translate' => true,
//            'model' => @$this->model
//        ]);


        AdministrationSeo::seoFields($this, [
            'slug' => ['required' => 'required'],
            'meta_description' => ['live-count' => 255, 'maxlength' => '255']
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

        $this->add('visible', 'switch', [
            'title' => trans('analyzes::admin.visible')
        ]);


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}