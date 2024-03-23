<?php

namespace App\Http\Controllers\Api\v1\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/v1/register/email",
 *     summary="Register user by email",
 *     tags={"Register"},
 *
 *     @OA\RequestBody(
 *       @OA\JsonContent(
 *           allOf={
 *               @OA\Schema(
 *                  required={"email", "username", "password", "password_confirmation"},
 *                  @OA\Property(property="email", type="string", example="serg18@gmail.com"),
 *                  @OA\Property(property="username", type="string", example="serg18"),
 *                  @OA\Property(property="password", type="string", example="password"),
 *                  @OA\Property(property="password_confirmation", type="string", example="password"),
 *               )
 *           }
 *       )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Register successfully",
 *
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="success", type="boolean", example="true"),
 *                     @OA\Property(property="message", type="string", example="Registration completed successfully"),
 *                     @OA\Property(property="user", type="object",
 *                          @OA\Property(property="username", type="string", example="serg"),
 *                          @OA\Property(property="email", type="string", example="serg18@gmail.com"),
 *                      ),
 *                     @OA\Property(property="token_type", type="string", example="Bearer"),
 *                     @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLC..."),
 *                 )
 *             }
 *         )
 *     ),

 *     @OA\Response(
 *          response="422",
 *          description="Validation Errors",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="message", type="string", example="Validation Errors"),
 *                      @OA\Property(property="errors", type="array", @OA\Items(
 *                          oneOf={
 *                              @OA\Property(property="", type="string", example="The email field must be a valid email address"),
 *                          }
 *                      )),
 *                      @OA\Property(property="status", type="boolean", example="false"),
 *                  )
 *              }
 *          )
 *      ),
 * )
 */
class RegisterController extends Controller
{

}
