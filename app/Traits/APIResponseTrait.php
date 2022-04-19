<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait APIResponseTrait
{

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseSuccess(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? 'Successfully Done');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseStore(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? 'Successfully Saved');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseUpdate(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? 'Successfully Updated');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseDestroy(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? 'Successfully Deleted');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseRestore(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? 'Successfully Restored');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseBadRequest(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_BAD_REQUEST, $attributes, $message ?? 'Bad Request');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseUnauthorized(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_UNAUTHORIZED, $attributes, $message ?? 'Unauthorized');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseNotFound(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_NOT_FOUND, $attributes, $message ?? 'Not Found');
    }

    /**
     * @param array|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseInternalServerError(array $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, $attributes, $message ?? 'Internal Server Error');
    }

    /**
     * @param int $statusCode
     * @param array|null $attributes
     * @param string $message
     * @return JsonResponse
     */
    public function response(int $statusCode, ?array $attributes, string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $attributes
        ], $statusCode);
    }
}
