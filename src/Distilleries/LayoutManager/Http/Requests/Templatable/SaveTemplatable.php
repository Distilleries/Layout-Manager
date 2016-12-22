<?php

namespace Distilleries\LayoutManager\Http\Requests\Templatable;

use Distilleries\LayoutManager\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SaveTemplatable extends FormRequest
{
    /**
     * Validation rules for current request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'templatable_type' => 'required',
            'templatable_id'   => 'required|numeric',
        ];
    }
}
