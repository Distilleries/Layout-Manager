<?php

namespace Distilleries\LayoutManager\Traits;

trait TemplatableTrait
{
    public function templates()
    {
        return $this->morphToMany('App\Template', 'templatable')->withPivot('html', 'category', 'order', 'status', 'id')->orderBy('order');
    }
}
