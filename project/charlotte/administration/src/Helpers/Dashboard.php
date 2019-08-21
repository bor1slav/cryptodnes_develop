<?php

namespace Charlotte\Administration\Helpers;


use Illuminate\Support\Facades\View;

class Dashboard {

    private $route;
    private $boxes = [];
    private $rendered_view;

    public function __construct() {
        $this->route = config('administration.views_prefix') . '::components.dashboard.';
    }

    public function colorBox($title, $value, $color = 'bg-danger', $class = 'col-lg-3 col-md-6 col-sm-12') {
        $this->boxes[] = view($this->route . 'color-box', compact('title','value', 'color', 'class'));
    }

    public function simpleBox($title, $value, $icon = 'icon-people', $color = 'text-info', $class = 'col-lg-3 col-md-6 col-sm-12') {
        $this->boxes[] = view($this->route . 'simple-box', compact('title','value','color', 'icon', 'class'));
    }

    public function linkBox($title, $value, $link,  $icon = 'fa-bug', $color = 'text-danger', $class = 'col-lg-3 col-md-6 col-sm-12') {
        $this->boxes[] = view($this->route . 'link-box', compact('title','value', 'link', 'color', 'icon', 'class'));
    }

    public function chartBox($title, $type, $labels, $dataset, $class = 'col-xl-12 col-lg-12 col-md-12 col-sm-12') {
        $this->boxes[] = view($this->route . 'line-chart', compact('title','type', 'labels', 'dataset', 'class'));
    }


    public function custom($html) {
        $this->boxes[] = view($this->route . 'custom', compact('html'));
    }

    public function generate() {
        foreach ($this->boxes as $box) {
            $this->rendered_view .= $box->render();
        }

        //Share if its called from controller
        View::share('boxes', $this->rendered_view);

        //return when generating all dashboards from modules
        return $this->rendered_view;
    }

}
