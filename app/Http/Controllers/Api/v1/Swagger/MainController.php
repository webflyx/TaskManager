<?php

namespace App\Http\Controllers\Api\v1\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Task Manager API Documentation",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/v1/"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer"
 *     )
 * )
 */

class MainController extends Controller
{
    //
}
