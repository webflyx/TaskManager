<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthEmailRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Supports\ResponseSupport;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Login user by Email
     *
     * @param AuthEmailRequest $request
     * @param AuthService $service
     * @return JsonResponse
     */
    public function loginByEmail(AuthEmailRequest $request, AuthService $service): JsonResponse
    {
        try {
            $token = $service->loginByEmail($request->validated());

            return ResponseSupport::success([
                'user' => new UserResource(auth()->user()),
                'token_type' => 'Bearer',
                'token' => $token
            ]);

        } catch (AuthException $e) {
            return ResponseSupport::error(
                [
                    'message' => __('response.' . $e->getMessage()),
                ], 401);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.Something went wrong')
            ]);
        }
    }

    /**
     * Logout user
     *
     * @param AuthService $service
     * @return JsonResponse
     */
    public function logout(AuthService $service): JsonResponse
    {
        try {
            $service->logout();
            return ResponseSupport::success([
                'message' => __('response.' . 'Logged out successfully')
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.Something went wrong')
            ]);
        }
    }
}
