<?php

namespace Distilleries\LayoutManager\Forms;

use App\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class TemplatableForm extends FormValidator
{
    public static $rules = [];

    public static $rules_update = null;

    public function buildForm()
    {
        $options =  [
            'templatable' => $this->model,
            'categories' => [],
            'custom-tags' => [],
        ];
        if (array_get($this->formOptions, 'categories')) {
            $options['categories'] = $this->formOptions['categories'];
        }
        if (array_get($this->formOptions, 'templates')) {
            $options['templates'] = $this->formOptions['templates'];
        }
        if (array_get($this->formOptions, 'disableAdd')) {
            $options['disableAdd'] = $this->formOptions['disableAdd'];
        }
        if (array_get($this->formOptions, 'custom-tags')) {
            $options['custom-tags'] = $this->formOptions['custom-tags'];
        }
        $this
            ->add('templates', 'template', $options);
    }
}
