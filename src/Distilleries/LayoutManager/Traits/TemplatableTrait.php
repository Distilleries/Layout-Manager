<?php

namespace Distilleries\LayoutManager\Traits;

trait TemplatableTrait
{
    public function templates()
    {
        return $this->morphToMany('Distilleries\LayoutManager\Template', 'templatable')->withPivot('html', 'category', 'libelle', 'order', 'status', 'id')->orderBy('order');
    }

    public function afterRenderingTemplate($html) {
        return $html;
    }

    public function getTemplateByClass($css_class, $index = 0, $noHeading = false) {
        $tpl = $this->templates->where('css_class', $css_class)->pluck('pivot.html')->toArray()[$index];
        if ($noHeading) {
            $tpl = preg_replace('/h[1-6]/', 'div', $tpl);
        }
        return $this->afterRenderingTemplate($tpl);
    }


    public function getTemplateByCategory($category, $index = 0, $noHeading = false) {
        $tpl = $this->templates->where('pivot.category', $category)->pluck('pivot.html')->toArray()[$index];
        if ($noHeading) {
            $tpl = preg_replace('/h[1-6]/', 'div', $tpl);
        }
        return $this->afterRenderingTemplate($tpl);
    }


    public function getTemplateByCategoryAndClass($category, $css_class, $index = 0, $noHeading = false) {
        $tpl = $this->templates->where('css_class', $css_class)->where('pivot.category', $category)->pluck('pivot.html')->toArray()[$index];
        if ($noHeading) {
            $tpl = preg_replace('/h[1-6]/', 'div', $tpl);
        }
        return $this->afterRenderingTemplate($tpl);
    }
}
