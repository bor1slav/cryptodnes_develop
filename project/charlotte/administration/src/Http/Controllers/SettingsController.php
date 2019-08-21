<?php

namespace Charlotte\Administration\Http\Controllers;


use Charlotte\Administration\Forms\SettingsForm;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationForm;

use Charlotte\Administration\Models\Setting;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SettingsController extends BaseAdministrationController {
    public function index() {
        $setting = new Setting();
        $form = new AdministrationForm();
        $form->route(Administration::route('settings.store'));
        $form->model($setting->getFormModel());
        $form->form(SettingsForm::class);

        Administration::setTitle(trans('administration::admin.settings_menu'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('administration::admin.settings_menu'));
        });


        return $form->generate();
    }

    public function store(Request $request) {
        $data = $request->all();
        unset($data['_token']);


        //filter data add locales and all data to one array
        foreach ($data as $key => $value) {
            if (in_array($key, array_keys(LaravelLocalization::getSupportedLocales()))) {
                if (!is_array($value)) {
                    continue;
                }

                foreach ($data[$key] as $field_key => $field_value) {
                    $data[$key . '.' . $field_key] = $field_value;
                }

                unset($data[$key]);
            }
        }

        foreach ($data as $key => $value) {
            $setting = Setting::where('field', $key)->first();

            if (!$setting) {
                $setting = new Setting();
            }
            $setting->field = $key;
            $is_media = $value instanceof UploadedFile;

            if (!$is_media) {
                $setting->value = $value;
            }

            $setting->save();

            if ($is_media) {
                //delete all previous media
                $old_media = $setting->getMedia();
                foreach ($old_media as $image) {
                    $image->delete();
                }
                $file_name = uniqid() . '.' . $value->getClientOriginalExtension();
                $media = $setting->addMedia($value)->usingFileName($file_name)->usingName($file_name)->toMediaCollection();
                $setting->value = $media->getFullUrl();
                $setting->save();


            }
        }

        return redirect(Administration::route('settings'))->withSuccess([trans('administration::admin.settings_updated')]);
    }

}
