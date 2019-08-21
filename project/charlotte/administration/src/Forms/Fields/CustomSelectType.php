<?php

namespace Charlotte\Administration\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CustomSelectType extends FormField
{

    /**
     * The name of the property that holds the value.
     *
     * @var string
     */
    protected $valueProperty = 'selected';

    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'select';
    }

    /**
     * @inheritdoc
     */
    public function getDefaults()
    {
        return [
            'choices' => [],
            'empty_value' => null,
            'selected' => null,
            'attr' => [
                'class' => 'selectpicker',
                'data-style' => "form-control"
            ]
        ];
    }
}
