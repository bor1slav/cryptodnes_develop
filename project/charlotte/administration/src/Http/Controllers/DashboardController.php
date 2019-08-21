<?php

namespace Charlotte\Administration\Http\Controllers;


use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationModuleHelper;

class DashboardController extends BaseAdministrationController {
    public function index() {
        $boxes = AdministrationModuleHelper::moduleDashboards();
        Administration::setTitle(trans('administration::admin.dashboard'));

        return view('administration::pages.empty-page', compact('boxes'));
    }

}
