<?php

namespace App\Supports;

use Illuminate\Http\JsonResponse;

class ResponseSupport
{
    /**
     * @param bool $success
     * @param array $params
     * @param int $code
     * @return JsonResponse
     */
    public static function success(array $params = [], bool $success = true, int $code = 200): JsonResponse
    {
        $data = [
            'success' => $success,
            ...$params,
        ];

        return response()->json($data, $code);
    }

    /**
     * @param array $params
     * @param int $code
     * @return JsonResponse
     */
    public static function error(array $params = [], int $code = 400): JsonResponse
    {
        $data = [
            'success' => false,
            ...$params,
        ];

        return response()->json($data, $code);
    }
}
