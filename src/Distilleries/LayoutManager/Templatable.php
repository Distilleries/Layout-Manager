<?php

namespace Distilleries\LayoutManager;

use Distilleries\Expendable\Models\BaseModel;
use Distilleries\Expendable\Models\StatusTrait;

/**
 * @property int $id
 * @property string $html
 * @property string $category
 * @property int $order
 * @property bool $status
 * @property int $template_id
 * @property int $templatable_id
 * @property string $templatable_type
 */
class Templatable extends BaseModel
{
    use StatusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'html',
        'category',
        'order',
        'status',
        'template_id',
        'templatable_id',
        'templatable_type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
        'status' => 'boolean',
        'template_id' => 'integer',
        'templatable_id' => 'integer',
    ];

    /**
     * Template relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
