<?php

namespace App\Http\Controllers\Api\v1\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/v1/user-data",
 *      summary="Get user data",
 *      tags={"Auth"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Response(
 *          response="200",
 *          description="Request successfully",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="success", type="boolean", example="true"),
 *                      @OA\Property(property="username", type="string", example="serg"),
 *                      @OA\Property(property="email", type="string", example="serg18@gmail.com"),
 *                  )
 *              }
 *          )
 *      ),
 *      @OA\Response(
 *          response="401",
 *          description="Auth error",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="success", type="boolean", example="false"),
 *                      @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                  )
 *              }
 *          )
 *      )
 *  )
 *
 * @OA\Post(
 *     path="/api/v1/auth/email",
 *     summary="Login user by email",
 *     tags={"Auth"},
 *
 *     @OA\RequestBody(
 *       @OA\JsonContent(
 *           allOf={
 *               @OA\Schema(
 *                  required={"email", "password"},
 *                  @OA\Property(property="email", type="string", example="serg18@gmail.com"),
 *                  @OA\Property(property="password", type="string", example="password"),
 *               )
 *           }
 *       )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Login successfully",
 *
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="success", type="boolean", example="true"),
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
 *          response="401",
 *          description="Wrong credentials",
 *
 *          @OA\JsonContent(
 *              @OA\Property(property="success", type="boolean", example=false),
 *              @OA\Property(property="errors", type="object",
 *                  @OA\Property(property="error", type="string", example="You cannot sign with those credentials")
 *              )
 *          )
 *      ),
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
 *
 * @OA\Post(
 *     path="/api/v1/logout",
 *     summary="Logout",
 *     tags={"Auth"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response="200",
 *         description="Logged out successfully",
 *
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="status", type="boolean", example="true"),
 *                     @OA\Property(property="message", type="string", example="Logged out successfully"),
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Auth error",
 *
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="success", type="boolean", example="false"),
 *                     @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                 )
 *             }
 *         )
 *     )
 * )
 */
class AuthController extends Controller
{

}
