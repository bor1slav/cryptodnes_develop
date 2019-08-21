<?php
namespace Charlotte\Administration\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class MultipleType extends FormField
{
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'multiple';
    }

    protected function getDefaults()
    {
        return [
            'attr' => [
                'class' => 'selectpicker',
                'data-style' => "form-control",
                'multiple'
            ],
        ];
    }

}