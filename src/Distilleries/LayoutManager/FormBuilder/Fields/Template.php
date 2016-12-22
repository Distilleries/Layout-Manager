<?php

namespace Distilleries\LayoutManager\FormBuilder\Fields;

use Distilleries\FormBuilder\Fields\FormFieldsView;

class Template extends FormFieldsView
{
    /**
     * Return template internal name.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'template';
    }

    /**
     * Return default field values.
     *
     * @return array
     */
    protected function getDefaults()
    {
        return [
            'templates' => \Distilleries\LayoutManager\Template::all(),
        ];
    }
}
