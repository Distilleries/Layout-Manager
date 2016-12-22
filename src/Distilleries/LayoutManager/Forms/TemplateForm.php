<?php

namespace Distilleries\LayoutManager\Forms;

use Distilleries\FormBuilder\FormValidator;

class TemplateForm extends FormValidator
{
    public static $rules = [];

    public static $rules_update = null;

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('libelle', 'text', [
                'validation' => 'required',
            ])
            ->add('css_class', 'text')
            ->add('html', 'tinymce', [
                'validation' => 'required',
            ])
            ->add('plugins', 'text')
            ->add('toolbar', 'text', [
                'default_value' => $this->model->toolbar ?: 'insertfile undo redo | bold italic | bullist numlist | link',
            ]);

        $this->addDefaultActions();
    }
}
