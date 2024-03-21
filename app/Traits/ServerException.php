<?php

namespace App\Traits;

use App\Supports\ResponseSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ServerException
{
    /**
     * @param $exception
     * @return JsonResponse
     */
    public static function serverException($exception): JsonResponse
    {
        Log::error($exception);
        return ResponseSupport::error([
            'message' => __('response.Something went wrong')
        ]);
    }
}
