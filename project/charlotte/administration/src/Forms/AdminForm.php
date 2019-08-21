<?php

namespace Charlotte\Administration\Forms;

use Kris\LaravelFormBuilder\Form;

class AdminForm extends Form
{
    /**
     * Create a new field and add it to the form.
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     * @param bool   $modify
     * @return $this
     */
    public function add($name, $type = 'text', array $options = [], $modify = false)
    {
        $this->formHelper->checkFieldName($name, get_class($this));

        if ($this->rebuilding && !$this->has($name)) {
            return $this;
        }

        $options['model'] = $this->getModel();

        $this->addField($this->makeField($name, $type, $options), $modify);

        return $this;
    }
}
