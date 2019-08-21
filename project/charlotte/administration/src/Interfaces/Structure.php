<?php

namespace Charlotte\Administration\Interfaces;

interface Structure {

    //Init all the needed functions

    public function dashboard();

    public function routes();

    public function menu($menu);

    public function settings($module, $form, $form_model);

}
