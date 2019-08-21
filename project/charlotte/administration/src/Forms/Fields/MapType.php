<?php
namespace Charlotte\Administration\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class MapType extends FormField
{
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'map';
    }

    public function getDefaults()
    {
        return [
//            'default_values' => [
//                'lng' => 23.319941,
//                'lat' => 42.698334,
//                'zoom' => 13,
//            ]
        ];
    }

}