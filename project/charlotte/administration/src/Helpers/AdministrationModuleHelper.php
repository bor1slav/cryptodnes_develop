<?php

namespace Charlotte\Administration\Helpers;

use Caffeinated\Modules\Facades\Module;

class AdministrationModuleHelper {


    public static function moduleDashboards() {
        $classes = self::moduleAdministrationClasses();
        $boxes = '';

        foreach ($classes as $class_name) {
            if (!class_exists($class_name)) {
                continue;
            }
            $class = new $class_name();

            if (!empty($class->dashboard())) {
                $boxes .= $class->dashboard();
            }
        }

        return $boxes;
    }

    public static function moduleRoutes() {
        $classes = self::moduleAdministrationClasses();

        foreach ($classes as $class_name) {
            if (!class_exists($class_name)) {
                continue;
            }
            $class = new $class_name();
            $class->routes();
        }
    }

    public static function moduleMenu($menu) {
        $classes = self::moduleAdministrationClasses();


        foreach ($classes as $class_name) {
            if (!class_exists($class_name)) {
                continue;
            }
            $class = new $class_name();
            $class->menu($menu);
        }
    }

    public static function moduleAdministrationClasses() {
        $modules_slugs = self::moduleSlugs();
        $administration_classes = [];

        foreach ($modules_slugs as $modules_slug) {
            $administration_classes[] = module_class($modules_slug, 'Administration');

        }

        return $administration_classes;
    }

    public static function moduleSlugs() {
        $modules = Module::enabled();
        $module_slugs = [];

        foreach ($modules as $module) {
            $module_slugs[] = $module['slug'];
        }

        return $module_slugs;
    }
}