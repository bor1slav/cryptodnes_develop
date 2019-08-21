<?php

namespace Charlotte\Administration\Helpers;


use Charlotte\Administration\Forms\AdminForm;
use Illuminate\Support\Facades\View;


class AdministrationForm {

    private $model;
    private $route;
    private $form;
    private $additionalData;
    private $method;

    public function __construct() {
        $this->method = 'POST';
        $this->form = null;
    }


    public function form($form) {
        $this->form = $form;
    }

    public function model($model) {
        $this->model = $model;
    }

    public function route($route) {
        $this->route = $route;
    }

    public function method($method) {
        $this->method = $method;
    }

    public function generate() {
        $formbuilder = \App::make('laravel-form-builder');

        $url_method = [
            'url' => $this->route,
            'method' => $this->method,
            'model' => $this->model
        ];


        $form = $formbuilder->create($this->form, $url_method);

        View::share('form', $form);


        return view('administration::pages.empty-page');
    }
}