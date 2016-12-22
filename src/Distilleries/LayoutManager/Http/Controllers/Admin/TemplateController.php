<?php

namespace Distilleries\LayoutManager\Http\Controllers\Admin;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Http\Controllers\Admin\Base\BaseComponent;
use Distilleries\LayoutManager\Datatables\TemplateDatatable;
use Distilleries\LayoutManager\Forms\TemplateForm;
use Distilleries\LayoutManager\Template;

class TemplateController extends BaseComponent
{
    /**
     * TemplateController constructor.
     *
     * @param \Distilleries\LayoutManager\Datatables\TemplateDatatable $datatable
     * @param \Distilleries\LayoutManager\Forms\TemplateForm $form
     * @param \Distilleries\LayoutManager\Template $model
     * @param \Distilleries\Expendable\Contracts\LayoutManagerContract $layoutManager
     */
    public function __construct(TemplateDatatable $datatable, TemplateForm $form, Template $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);

        $this->datatable = $datatable;
        $this->form = $form;
    }
}
