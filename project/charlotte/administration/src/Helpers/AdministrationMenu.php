<?php

namespace Charlotte\Administration\Helpers;


class AdministrationMenu {



    private $main_menu;
    private $sub_menus = [];

    public function addModule($menu) {
        $this->main_menu = $menu;
        return $this;
    }

    public function addItem($menu) {
        $this->sub_menus[] = $menu;
        return $this;
    }

    public function generate() {
        return view('administration::boxes.nav_links')->with(['main_menu' => $this->main_menu, 'sub_menus' => $this->sub_menus])->render();
    }

}