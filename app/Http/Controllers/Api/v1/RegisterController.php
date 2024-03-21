<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserByEmailRequest;
use App\Services\RegisterService;
use App\Supports\ResponseSupport;
use App\Traits\ServerException;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use ServerException;

    /**
     * @param RegisterUserByEmailRequest $request
     * @param RegisterService $service
     * @return JsonResponse
     */
    public function registerByEmail(RegisterUserByEmailRequest $request, RegisterService $service): JsonResponse
    {
        try{
            $authData = $service->registerByEmail($request->validated());

            return ResponseSupport::success([
                'message' => __('response.'.'Registration completed successfully'),
                ...$authData
            ]);

        } catch (Exception $e) {
            return self::serverException($e->getMessage());
        }
    }
}
