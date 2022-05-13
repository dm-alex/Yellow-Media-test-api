<?php

namespace App\Http\Controllers\Api;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param array    $data
     * @param int|null $code
     * @param array    $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array $data = [], int $code = null, array $headers = [])
    {
        return response()->json(['data' => $data], $code ?? Response::HTTP_OK, $headers);
    }

    /**
     * @param array|null $messages
     * @param int|null   $code
     * @param array      $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function failure(array $messages = null, int $code = null, array $headers = [])
    {
        return response()->json(['errors' => $messages ?? 'Request Failed'], $code ?? Response::HTTP_BAD_REQUEST, $headers);
    }

    /**
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken(string $token){
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], Response::HTTP_OK);
    }
}
