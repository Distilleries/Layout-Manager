<?php

namespace Distilleries\LayoutManager\Http\Controllers\Api;

use Distilleries\Expendable\Helpers\UserUtils;
use Distilleries\LayoutManager\Http\Requests\Templatable\SaveTemplatable;
use Distilleries\LayoutManager\Templatable;

class TemplateController extends ApiController
{
    /**
     * Templatable model implementation.
     *
     * @var \App\Templatable
     */
    protected $model;

    /**
     * TemplateController constructor.
     *
     * @param \App\Templatable $model
     */
    public function __construct(Templatable $model)
    {
        $this->model = $model;
    }

    /**
     * @SWG\Post(
     *     path="/template/save",
     *     description="Get one project detail",
     *     operationId="postSave",
     *     tags={"Templatables"},
     *     @SWG\Parameter(
     *         name="templatables",
     *         description="Templatable list",
     *         required=false,
     *         type="string",
     *         in="formData"
     *     ),
     *     @SWG\Parameter(
     *         name="templatable_id",
     *         description="Templatable ID (polymorphic)",
     *         required=false,
     *         type="integer",
     *         in="formData"
     *     ),
     *     @SWG\Parameter(
     *         name="templatable_type",
     *         description="Templatable Type (polymorphic)",
     *         required=false,
     *         type="string",
     *         in="formData"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function postSave(SaveTemplatable $request)
    {
        $templatables = $request->get('templatables');
        $templatableId = $request->get('templatable_id');
        $templatableType = $request->get('templatable_type');

        if (! UserUtils::isBackendRole() or ! is_array($templatables) or ! $templatableId or ! $templatableType) {
            abort(404);
        }

        Templatable::where('templatable_id', '=', $templatableId)->where('templatable_type', '=', $templatableType)->delete();
        
        foreach($templatables as $template) {
            Templatable::create([
                'templatable_id' => $templatableId,
                'templatable_type' => $templatableType,
                'template_id' => $template['pivot']['template_id'],
                'category' => array_key_exists('category', $template['pivot']) ? $template['pivot']['category'] : '',
                'order' => $template['pivot']['order'],
                'html' => $template['pivot']['html'],
                'status' => true,
            ]);
        }

        // @TODO: Add a error handling with a popup to the user that cancel the form submittion in case of templatable error

        return $this->respondSuccessRequest([]);
    }
}
