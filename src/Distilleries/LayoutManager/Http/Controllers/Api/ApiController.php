<?php

namespace Distilleries\LayoutManager\Http\Controllers\Api;

use Swagger\Annotations as SWG;
use Distilleries\Expendable\Models\Language;
use Illuminate\Contracts\Pagination\Paginator;
use Distilleries\Expendable\Http\Controllers\Front\Base\BaseController;

/**
 * @SWG\Swagger(
 *     produces={"application/json"},
 *     @SWG\Info(
 *         title="Layout manager",
 *         description="REST API",
 *         version="1.0",
 *         termsOfService="terms",
 *         @SWG\Contact(name="Jean-Francois Meinesz"),
 *         @SWG\License(name="proprietary")
 *     )
 * )
 */
class ApiController extends BaseController
{
    /**
     * Returned status code.
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Default DB limit.
     *
     * @var int
     */
    protected $limit = 15;

    /**
     * Status code getter.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Status code setter.
     *
     * @param int $statusCode
     * @return \Distilleries\LayoutManager\Http\Controllers\Api\ApiController $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Default success API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondSuccessRequest($message = 'Success!')
    {
        return $this->respondWithSuccess($message);
    }

    /**
     * Bad request API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondBadRequest($message = 'Bad Request!')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * Invalid request API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInvalidRequest($message = 'Invalid Request!')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * Not found API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Internal error API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * Return default success API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithSuccess($message)
    {
        return $this->respond([
            'success' => [
                'message' => $message,
                'code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * Return default error API response.
     *
     * @param mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * Return default API JSON response.
     *
     * @param mixed $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $header = [])
    {
        return response()->json($data, $this->getStatusCode(), $header);
    }
}
