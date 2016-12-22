<?php

namespace Distilleries\LayoutManager\Datatables;

use Distilleries\DatatableBuilder\EloquentDatatable;

class TemplateDatatable extends EloquentDatatable
{
    public function build()
    {
        $this
            ->add('id', null, trans('layout-manager::datatable.id'))
            ->add('libelle', null, trans('layout-manager::datatable.libelle'))
            ->add('css_class', null, trans('layout-manager::datatable.css_class'))
            ->add('html', null, trans('layout-manager::datatable.html'))
            ->add('plugins', null, trans('layout-manager::datatable.plugins'))
            ->add('toolbar', null, trans('layout-manager::datatable.toolbar'));

        $this->addDefaultAction();
    }
}
