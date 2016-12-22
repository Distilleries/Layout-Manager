<?php

namespace Distilleries\LayoutManager;

use Distilleries\Expendable\Models\BaseModel;

/**
 * @property int $id
 * @property string $html
 * @property string $libelle
 * @property string $toolbar
 * @property string $plugins
 * @property string $css_class
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Template extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'html',
        'libelle',
        'toolbar',
        'plugins',
        'css_class',
    ];

    /**
     * Get all of the owning likeable models.
     *
     * @return $this
     */
    public function projects()
    {
        return $this->morphedByMany('App\Project', 'templatable', 'content')->withPivot('html', 'category', 'order', 'status', 'id');
    }
}
