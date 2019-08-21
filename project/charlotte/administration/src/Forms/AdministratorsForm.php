<?php

namespace Charlotte\Administration\Forms;

use Kris\LaravelFormBuilder\Form;

class AdministratorsForm extends Form {

    public function buildForm() {
        $this->add('name', 'text', [
            'title' => trans('administration::admin.name'),
            'model' => @$this->model
        ]);

        $this->add('email', 'email', [
            'title' => trans('administration::admin.email'),
            'model' => @$this->model
        ]);


        if (empty($this->model)) {
            $this->add('password', 'password', [
                'title' => trans('administration::admin.password'),
            ]);
        }

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit'),
        ]);
    }
}