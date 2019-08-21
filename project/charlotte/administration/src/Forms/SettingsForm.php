<?php

namespace Charlotte\Administration\Forms;

use Caffeinated\Modules\Facades\Module;

class SettingsForm extends AdminForm
{
    public function buildForm()
    {

        $modules = Module::enabled();
        $module_slugs = [];


        foreach ($modules as $module) {
            $module_slugs[] = $module['slug'];
        }


        if (!empty(config('administration.settings_default_fields'))) {
            foreach (config('administration.settings_default_fields') as $key => $value) {
                $this->add($key, $value['type'], [
                    'title' => trans($value['title']),
                    'translate' => (!empty($value['translate'])) ? (bool) $value['translate'] : false,
                    'value' => (!empty($value['value'])) ? $value['value'] : null,
                    'choices' => (!empty($value['choices'])) ? $value['choices'] : null,
                ]);
            }
        }

        foreach ($module_slugs as $module_slug) {
            $administration_class = module_class($module_slug, 'Administration');

            if (!class_exists($administration_class)) {
                continue;
            }

            $class = new $administration_class();

            $this->add('box_' . $module_slug, 'box', [
                'title' => trans($module_slug . "::admin.module_name")
            ]);
            $class->settings($module_slug, $this, $this->model);
        }


        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
