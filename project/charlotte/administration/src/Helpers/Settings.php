<?php

namespace Charlotte\Administration\Helpers;

use Charlotte\Administration\Models\Setting;
use Illuminate\Support\Facades\App;

class Settings
{

    public static function get($field)
    {
        $data = Setting::where('field', $field)->first();

        if (empty($data)) {
            return null;
        }

        return $data->value;
    }

    public static function getTranslated($field, $locale = null)
    {
        $locale = (empty($locale)) ? App::getLocale() : $locale;

        $data = Setting::where('field', $locale . '.' . $field)->first();

        if (empty($data)) {
            return null;
        }

        return $data->value;
    }

    public static function getFile($field, $collection = '')
    {
        $data = Setting::where('field', $field)->first();

        if (empty($data)) {
            return null;
        }

        return $data->getFirstMedia()->getUrl($collection);
    }
}