<?php

namespace App\Modules\Coins\Forms;

use App\Modules\Blog\Models\BlogCategory;
use Charlotte\Administration\Forms\AdminForm;
use Charlotte\Administration\Helpers\AdministrationSeo;
use Kris\LaravelFormBuilder\Form;

class CoinForm extends AdminForm {

    public function buildForm() {

        $this->add('title', 'text', [
            'title' => trans('blog::admin.title'),
            'translate' => true,
            'clone' => ['slug', 'meta_title']
        ]);


        $this->add('description', 'editor', [
            'title' => trans('blog::admin.description'),
            'translate' => true,
            'simple' => true
        ]);


        AdministrationSeo::seoFields($this, $this->model);

        $this->add('buy_link', 'text', [
            'title' => trans('coins::admin.buy_link'),
        ]);

        $this->add('graph_data', 'text', [
            'title' => trans('coins::admin.graph_data'),
        ]);

        $this->add('statistics_box', 'box', [
            'title' => trans('coins::admin.statistics')
        ]);

        $this->add('current_price', 'text', [
            'title' => trans('coins::admin.current_price'),
            'class' => 'col-md-3'
        ]);

        $this->add('market_cap', 'text', [
            'title' => trans('coins::admin.market_cap'),
            'class' => 'col-md-3'
        ]);

        $this->add('market_cap_rank', 'text', [
            'title' => trans('coins::admin.market_cap_rank'),
            'class' => 'col-md-3'
        ]);

        $this->add('total_volume', 'text', [
            'title' => trans('coins::admin.total_volume'),
            'class' => 'col-md-3'
        ]);

        $this->add('high_24h', 'text', [
            'title' => trans('coins::admin.high_24h'),
            'class' => 'col-md-3'
        ]);

        $this->add('low_24h', 'text', [
            'title' => trans('coins::admin.low_24h'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_24h', 'text', [
            'title' => trans('coins::admin.price_change_24h'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_percentage_24h', 'text', [
            'title' => trans('coins::admin.price_change_percentage_24h'),
            'class' => 'col-md-3'
        ]);

        $this->add('market_cap_change_24h', 'text', [
            'title' => trans('coins::admin.market_cap_change_24h'),
            'class' => 'col-md-3'
        ]);

        $this->add('market_cap_change_percentage_24h', 'text', [
            'title' => trans('coins::admin.market_cap_change_percentage_24h'),
            'class' => 'col-md-3'
        ]);


        $this->add('circulating_supply', 'text', [
            'title' => trans('coins::admin.circulating_supply'),
            'class' => 'col-md-3'
        ]);

        $this->add('total_supply', 'text', [
            'title' => trans('coins::admin.total_supply'),
            'class' => 'col-md-3'
        ]);

        $this->add('ath', 'text', [
            'title' => trans('coins::admin.ath'),
            'class' => 'col-md-3'
        ]);

        $this->add('ath_change_percentage', 'text', [
            'title' => trans('coins::admin.ath_change_percentage'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_percentage_1h_in_currency', 'text', [
            'title' => trans('coins::admin.price_change_percentage_1h_in_currency'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_percentage_24h_in_currency', 'text', [
            'title' => trans('coins::admin.price_change_percentage_24h_in_currency'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_percentage_7d_in_currency', 'text', [
            'title' => trans('coins::admin.price_change_percentage_7d_in_currency'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_percentage_30d_in_currency', 'text', [
            'title' => trans('coins::admin.price_change_percentage_30d_in_currency'),
            'class' => 'col-md-3'
        ]);

        $this->add('price_change_percentage_1y_in_currency', 'text', [
            'title' => trans('coins::admin.price_change_percentage_1y_in_currency'),
            'class' => 'col-md-3'
        ]);

        $this->add('visible', 'switch', [
            'title' => trans('coins::admin.visible')
        ]);

        $this->add('in_menu', 'switch', [
            'title' => trans('coins::admin.in_menu')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}